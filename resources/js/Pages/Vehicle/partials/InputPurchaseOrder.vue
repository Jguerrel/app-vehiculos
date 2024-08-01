<script setup>
import InputText from "primevue/inputtext";
import { computed } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { manageError } from "@/Utils/Common/common";

const p = defineProps({
    order: {
        type: Object,
        default: {},
    },
});

const emit = defineEmits(["closepurchaseorder", "orderaddsuccess"]);

const form = useForm({
    order_number_warranty: null,
    order_number_expenses: null,
    quotation_id: null,
    order_id: null,
});

// verificar si lleno algunas de las Nº de orden de compra
const hasAnyVal = computed(
    () => form.order_number_expenses || form.order_number_warranty
);

// verificar si ambos Nº de compra están llenos
const hasAllNumbers = computed(
    () => form.order_number_expenses && form.order_number_warranty
);

// verificar si es necesario solicitar Nº de compra de garantia
const hasWarrantyOrder = computed(() =>
    p.order.subcategories?.some((sub) => sub?.pivot?.warranty)
);

// verificar si es necesario solicitar Nº de compra de gastos
const hasExpensesOrder = computed(() =>
    p.order.subcategories?.some((sub) => sub?.pivot?.dock)
);

// verificar si ambos Nº de compra son requeridos
const hasWarrantyAndExpenses = computed(
    () => hasWarrantyOrder.value && hasExpensesOrder.value
);

/**
 * Aprobar o no la cotización
 */
const approveOrder = (order) => {
    form.quotation_id = order.quotation?.id;
    form.order_id = order.id;

    if (hasWarrantyAndExpenses.value) {
        if (!hasAllNumbers.value) {
            manageError({
                text: "Debe ingresar ambos números de orden de compra (garantia y gastos)",
            });
            return;
        }
    }

    // enviar formulario
    form.post(route("workshop_quotes.approveQuotation"), {
        onError: (error) => {
            manageError();
            console.log(error);
        },
        onSuccess: (resp) => emit("orderaddsuccess"),
    });
};
</script>
<template>
    <article class="border border-gray-300 p-3 rounded-lg w-auto">
        <div class="flex flex-col md:flex-row justify-between gap-3">
            <!-- garantia -->
            <div class="w-full" v-if="hasWarrantyOrder">
                <label
                    :for="'order_number_warranty' + order.id"
                    class="font-bold text-gray-900 text-sm"
                >
                    Nº orden de compra de garantia
                </label>
                <InputText
                    v-model="form.order_number_warranty"
                    :id="'order_number_warranty' + order.id"
                    class="w-full"
                />
            </div>
            <!-- /garantia -->

            <!-- gastos o muelles -->
            <div class="w-full" v-if="hasExpensesOrder">
                <label
                    :for="'order_number_expenses' + order.id"
                    class="font-bold text-gray-900 text-sm"
                >
                    Nº orden de compra de gastos
                </label>
                <InputText
                    v-model="form.order_number_expenses"
                    :id="'order_number_expenses' + order.id"
                    class="w-full"
                />
            </div>
            <!-- /gastos o muelles -->
        </div>

        <!-- botonera -->
        <div class="py-3 flex gap-3 justify-end">
            <button
                type="button"
                class="inline-flex items-center text-gray-900 bg-blue-400 hover:bg-blue-800 hover:text-white px-4 py-2 rounded-md transition ease-in-out duration-150"
                :class="{
                    'opacity-50 cursor-not-allowed':
                        !hasAnyVal || form.processing,
                }"
                @click.stop="approveOrder(order)"
                :disabled="!hasAnyVal || form.processing"
            >
                <span class="font-medium text-sm"> Aprobar cotización </span>
            </button>
            <button
                type="button"
                class="inline-flex items-center text-gray-900 bg-red-400 hover:bg-red-800 hover:text-white px-4 py-2 rounded-md transition ease-in-out duration-150"
                @click.stop="$emit('closepurchaseorder')"
                :disabled="form.processing"
            >
                <span class="font-medium text-sm"> Volver y cancelar </span>
            </button>
        </div>
        <!-- /botonera -->
    </article>
</template>
