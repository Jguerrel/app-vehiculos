<script setup>
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { manageError } from "@/Utils/Common/common";
import { watch, ref } from "vue";

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
});

const emit = defineEmits(["close"]);

const form = useForm({
    repair_order_id: null,
    additional_expense_account_id: null,
    supplier: null,
    amount: 0,
});

const orders = ref([]);
const showSupplier = ref(false);

/**
 * Finalizar el caso y actualizar el status del vehiculo
 */
// const finalizedCase = () => {
//     form.post(route("workshop_quotes.finalizedCase"), {
//         onError: (error) => manageError(),
//         onSuccess: (resp) => emit("close"),
//         onFinish: () => (loading.value = false),
//     });
// };

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
            console.log(props.vehicle);
            orders.value = props.vehicle.repair_orders;
        }
    }
);
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <div class="p-4">
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
                    <div class="flex flex-col py-2">
                        <InputLabel
                            for="order"
                            value="Seleccione una order de reparación"
                        />
                        <select
                            v-model="form.repair_order_id"
                            id="order"
                            required
                            class="rounded"
                        >
                            <option
                                :value="order.id"
                                v-for="order in orders"
                                :key="order.id"
                            >
                                {{
                                    "000" +
                                    order.id +
                                    " - " +
                                    order.workshop?.name
                                }}
                            </option>
                        </select>
                    </div>
                    <div class="flex flex-col py-2">
                        <InputLabel
                            for="expense"
                            value="Agregar gasto adicional"
                        />
                        <select
                            v-model="form.additional_expense_account_id"
                            id="expense"
                            required
                            class="rounded"
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
                    <div class="flex flex-col py-2">
                        <InputLabel for="amount" value="Monto" />
                        <TextInput
                            id="amount"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.amount"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.amount"
                        />
                    </div>
                    <div class="flex flex-col py-2" v-if="showSupplier">
                        <InputLabel for="supplier" value="Proveedor" />
                        <select
                            v-model="form.supplier"
                            id="supplier"
                            required
                            class="rounded"
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
                        <InputError
                            class="mt-2"
                            :message="form.errors.supplier"
                        />
                    </div>
                </section>
            </main>
            <footer class="flex justify-end items-center pt-5 gap-3">
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150"
                >
                    Cerrar
                </PrimaryButton>
                <PrimaryButton
                    @click.stop=""
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-800 hover:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-900 transition ease-in-out duration-150"
                >
                    Agregar gasto
                </PrimaryButton>
            </footer>
        </div>
    </Modal>
</template>
