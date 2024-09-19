<script setup>
// import InputText from "primevue/inputtext";
import { computed, onMounted, ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { manageError } from "@/Utils/Common/common";
import Swal from "sweetalert2";
import axios from "axios";
import Spinner from "@/Components/Spinner.vue";

const p = defineProps({
    order: {
        type: Object,
        default: {},
    },
});

const emit = defineEmits(["closepurchaseorder", "createOrderSuccess"]);

const form = useForm({
    type: null,
    quotation_id: null,
    order_id: null,
    workshop_id: null,
    vehicle_id: null,
    user_id: null,
    items: [],
});

// loader
const loading = ref(false);
const loadingWarranty = ref(false);
const loadingExpenses = ref(false);
const statusWarranty = ref(null);
const statusExpenses = ref(null);

// verificar si es necesario solicitar Nº de compra de garantia
const hasWarrantyOrder = computed(() =>
    p.order.subcategories?.some((sub) => sub?.pivot?.warranty)
);

// verificar si es necesario solicitar Nº de compra de gastos
const hasExpensesOrder = computed(() =>
    p.order.subcategories?.some((sub) => sub?.pivot?.dock)
);

// verificar si ya tienes un numero de garantia
const hasWarrantyNumber = computed(
    () => p.order.purchase_order?.order_number_warranty
);

// verificar si ya tienes un numero de gastos
const hasExpensesNumber = computed(
    () => p.order.purchase_order?.order_number_expenses
);

/**
 * Devuelve el status de una orden de compra
 *
 * @param number Número de orden de compra
 * @param type  Tipo de item (Garantia o Gasto)
 */
const getStatus = (number, type) => {
    const data = {
        vehicle_id: p.order.vehicle_id,
        numordencompra: number,
    };

    statusWarranty.value = "---";
    statusExpenses.value = "---";

    if (type === "Garantia") loadingWarranty.value = true;
    if (type === "Gasto") loadingExpenses.value = true;
    axios
        .post(route("reparaciones.consultaordencompra"), data)
        .then((resp) => {
            if (resp.status === 200) {
                if (type === "Garantia")
                    statusWarranty.value = resp.data.estado;
                if (type === "Gasto") statusExpenses.value = resp.data.estado;
            }
        })
        .catch((error) => {
            manageError();
            console.log(error);
            loadingWarranty.value = false;
            loadingExpenses.value = false;
        })
        .finally(() => {
            loadingWarranty.value = false;
            loadingExpenses.value = false;
        });
};

/**
 * Aprobar orden e compra
 */
const approveOrder = (type) => {
    form.items = [];

    // cagar solo los items del tipo seleccionado
    p.order.subcategories.forEach((sub) => {
        if (type === "Garantia" && sub.pivot.warranty) {
            form.items.push(sub);
        } else if (type === "Muelle" && sub.pivot.dock) {
            form.items.push(sub);
        }
    });

    const data = {
        type: type,
        quotation_id: p.order.quotation?.id,
        order_id: p.order.id,
        workshop_id: p.order.workshop_id,
        vehicle_id: p.order.vehicle_id,
        user_id: p.order.user_id,
        items: form.items,
    };

    Swal.fire({
        title: "¿Estas seguro de aprobar la cotización?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, estoy seguro.",
        cancelButtonText: "No, volver.",
        reverseButtons: false,
    }).then((result) => {
        if (result.isConfirmed) {
            loading.value = true;
            axios
                .post(route("reparaciones.createPurchaseOrder"), data)
                .then((resp) => {
                    if (resp.status === 200) {
                        emit("createOrderSuccess");
                        Swal.fire({
                            icon: "success",
                            title: "Orden de compra aprobada",
                            text: "Se ha aprobado la orden de compra correctamente",
                        });

                        // reload
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        manageError();
                    }
                })
                .catch((error) => {
                    manageError();
                    console.log(error);
                    loading.value = false;
                })
                .finally(() => {
                    loading.value = false;
                });
        }
    });
};

onMounted(() => {
    if (
        hasWarrantyOrder.value &&
        p.order.purchase_order?.order_number_warranty
    ) {
        getStatus(p.order.purchase_order?.order_number_warranty, "Garantia");
    }

    if (
        hasExpensesOrder.value &&
        p.order.purchase_order?.order_number_expenses
    ) {
        getStatus(p.order.purchase_order?.order_number_expenses, "Gasto");
    }
});
</script>
<template>
    <article class="border p-3 rounded-lg w-auto">
        <div
            class="flex flex-col md:flex-row justify-between gap-3 w-auto md:w-[500px]"
        >
            <!-- garantia -->
            <div class="w-full flex flex-col gap-1" v-if="hasWarrantyOrder">
                <p class="font-bold text-gray-900 text-sm">
                    Orden de compra de garantia
                </p>
                <button
                    v-if="!hasWarrantyNumber"
                    type="button"
                    class="inline-flex items-center text-gray-900 bg-green-400 hover:bg-green-600 hover:text-white px-4 py-2 rounded-md transition ease-in-out duration-150 w-40"
                    @click.stop="approveOrder('Garantia')"
                    :disabled="loading"
                    :class="{ 'opacity-50': loading }"
                >
                    <span class="font-medium text-sm mx-auto flex gap-1">
                        <i class="fas fa-spin fa-pulse" v-if="loading"></i>
                        Aprobar garantia
                    </span>
                </button>
                <p v-else class="text-gray-900 text-sm flex flex-col gap-2">
                    <span>
                        Nº de garantia:
                        {{ order.purchase_order?.order_number_warranty }}
                    </span>
                    <span class="font-semibold text-blue-700 flex gap-3">
                        Status:
                        {{ statusWarranty }}
                        <Spinner :show="loadingWarranty" />
                    </span>
                </p>
            </div>
            <!-- /garantia -->

            <!-- gastos o muelles -->
            <div class="w-full flex flex-col gap-1" v-if="hasExpensesOrder">
                <p class="font-bold text-gray-900 text-sm">
                    Orden de compra de gastos
                </p>
                <button
                    v-if="!hasExpensesNumber"
                    type="button"
                    class="inline-flex items-center text-gray-900 bg-green-400 hover:bg-green-600 hover:text-white px-4 py-2 rounded-md transition ease-in-out duration-150 w-40"
                    @click.stop="approveOrder('Muelle')"
                    :disabled="loading"
                    :class="{ 'opacity-50': loading }"
                >
                    <span class="font-medium text-sm mx-auto flex gap-1">
                        <i class="fas fa-spin fa-pulse" v-if="loading"></i>
                        Aprobar gastos
                    </span>
                </button>
                <p v-else class="text-gray-900 text-sm flex flex-col gap-2">
                    <span>
                        Nº de gastos:
                        {{ order.purchase_order?.order_number_expenses }}
                    </span>

                    <span class="font-semibold text-blue-700 flex gap-3">
                        Status:
                        {{ statusExpenses }}
                        <Spinner :show="loadingExpenses" />
                    </span>
                </p>
            </div>
            <!-- /gastos o muelles -->
        </div>

        <!-- botonera -->
        <div class="py-1 flex gap-3 justify-end items-center">
            <Spinner :show="loading" />
        </div>
        <!-- /botonera -->
    </article>
</template>
