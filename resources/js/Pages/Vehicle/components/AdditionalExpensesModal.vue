<script setup>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Swal from "sweetalert2";
import { useForm } from "@inertiajs/inertia-vue3";
import { watch, ref, computed } from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "5xl",
    },
    vehicle: {
        type: Object,
        default: {},
    },
    additionalExpenses: {
        type: Array,
        default: [],
    },
    suppliers: {
        type: Array,
        default: [],
    },
});

const emit = defineEmits(["close"]);

const form = useForm({
    vehicle_id: null,
    additional_expense_account_id: null,
    supplier: null,
    amount: 0,
});

const orders = ref([]);
const expenses = ref([]);
const showSupplier = ref(false);
const total = computed(() =>
    expenses.value.reduce((prev, cur) => {
        const amount = parseFloat(cur.amount);
        return parseFloat(prev + amount);
    }, 0)
);

/**
 * Reset form
 */
const resetForm = () => {
    form.additional_expense_account_id = null;
    form.supplier = null;
    form.amount = 0;
    showSupplier.value = false;
};

/**
 * agregar gasto adicional
 */
const addAdditionalExpense = () => {
    if (!form.additional_expense_account_id || !form.amount) {
        return Swal.fire({
            icon: "error",
            title: "Aviso",
            text: "Debe rellenar todos los campos antes de agregar el gasto",
        });
    }

    if (showSupplier.value && !form.supplier) {
        return Swal.fire({
            icon: "error",
            title: "Aviso",
            text: "Debe seleccionar un proveedor",
        });
    }

    form.post(route("vehicle.add_additional_expense"), {
        onError: (error) => console.log(error),
        onSuccess: (resp) => {
            emit("close");

            Swal.fire({
                icon: "success",
                title: "Gasto agregado",
                text: "El gasto adicional fue agregado con éxito",
            });
        },
    });
};

/**
 * Verificar la selección del gasto adicional
 */
const verifyExpense = () => {
    const isMovement = form.additional_expense_account_id === 1;

    if (isMovement) {
        return (showSupplier.value = true);
    }

    showSupplier.value = false;
};

watch(
    () => props.show,
    (value) => {
        if (value) {
            resetForm();
            expenses.value = [];
            form.vehicle_id = props.vehicle.id;
            orders.value = props.vehicle.repair_orders;
            expenses.value = props.vehicle.additional_expenses;
        }
    }
);
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <div class="p-4 overflow-y-auto h-[460px] md:h-full">
            <header class="flex justify-between items-center pb-3">
                <h3 class="font-semibold text-xl">Gastos adicionales</h3>
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition ease-in-out duration-150"
                >
                    <i class="fa fa-times"></i>
                </PrimaryButton>
            </header>
            <main>
                <section class="py-3">
                    <div>
                        <h5 class="uppercase text-zinc-900 font-bold pb-2">
                            Nº Chasis:
                            <span class="font-light">
                                {{ vehicle.chassis_number }}
                            </span>
                        </h5>
                    </div>
                    <article class="">
                        <div class="flex justify-between w-full gap-5">
                            <div class="flex flex-col py-2 w-full">
                                <InputLabel
                                    for="expense"
                                    value="Seleccione gasto adicional"
                                />
                                <select
                                    v-model="form.additional_expense_account_id"
                                    id="expense"
                                    required
                                    class="rounded border border-gray-300 w-full"
                                    @change="verifyExpense"
                                >
                                    <option
                                        :value="expense.id"
                                        v-for="expense in additionalExpenses"
                                        :key="expense.id"
                                    >
                                        {{
                                            expense.account_number +
                                            " - " +
                                            expense.account_name
                                        }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-between w-full gap-5">
                            <div class="flex flex-col py-2 w-full">
                                <InputLabel for="amount" value="Monto" />
                                <TextInput
                                    id="amount"
                                    type="number"
                                    class="block w-full"
                                    v-model="form.amount"
                                    required
                                />
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.amount"
                                />
                            </div>
                            <div
                                class="flex flex-col py-2 w-full"
                                v-if="showSupplier"
                            >
                                <InputLabel for="supplier" value="Proveedor" />
                                <select
                                    v-model="form.supplier"
                                    id="supplier"
                                    required
                                    class="rounded border border-gray-300 w-full"
                                >
                                    <option
                                        :value="sup.val"
                                        v-for="sup in suppliers"
                                        :key="sup.val"
                                    >
                                        {{ sup.name }}
                                    </option>
                                </select>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.supplier"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end py-2">
                            <PrimaryButton
                                @click.stop="addAdditionalExpense"
                                type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-800 hover:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-900 transition ease-in-out duration-150 active:bg-purple-900"
                                :disabled="form.processing"
                            >
                                Agregar gasto
                            </PrimaryButton>
                        </div>
                    </article>

                    <div
                        class="py-2 relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <h3 class="text-lg font-semibold">Gatos</h3>
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500 table-auto"
                        >
                            <thead class="text-gray-700 uppercase bg-gray-100">
                                <th class="p-1">Gasto adicional</th>
                                <th class="p-1">Monto</th>
                                <th class="p-1">Proveedor</th>
                                <th class="p-1">Fecha</th>
                            </thead>
                            <tbody>
                                <tr v-for="exp in expenses" :key="exp.id">
                                    <td class="p-1">
                                        {{ exp.full_expense_name }}
                                    </td>
                                    <td class="p-1">$ {{ exp.amount }}</td>
                                    <td class="p-1">
                                        {{ exp.supplier_name }}
                                    </td>
                                    <td class="p-1">
                                        {{ exp.created_at_formatted }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="font-semibold text-gray-900">
                                    <th class="p-1">Total</th>
                                    <td class="p-1">$ {{ total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </main>
            <footer class="flex justify-end items-center pt-5 gap-3">
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-800 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition ease-in-out duration-150"
                    :disabled="form.processing"
                >
                    Cerrar
                </PrimaryButton>
            </footer>
        </div>
    </Modal>
</template>
