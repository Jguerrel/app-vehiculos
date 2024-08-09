<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";
import Form from "@/Pages/ExpenseAccount/partials/Form.vue";
import { watch } from "vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    selected: {
        type: Object,
        default: {},
    },
});

const emit = defineEmits(["close"]);

const form = useForm({
    id: null,
    account_number: "",
    account_name: "",
});

const submit = () => {
    form.post(route("expense_account.update", form.id), {
        onSuccess: () => {
            form.reset();
            emit("close");
            Swal.fire({
                icon: "success",
                title: "Gasto adicional actualizado",
                text: "Gasto adicional actualizado con éxito",
            });
        },
        onError: (error) => console.log(error),
    });
};

watch(
    () => props.show,
    (value) => {
        if (value) {
            form.id = props.selected?.id;
            form.account_name = props.selected?.account_name;
            form.account_number = props.selected?.account_number;
        }
    }
);
</script>
<template>
    <Modal :show="show">
        <div class="p-4">
            <div class="flex justify-between items-center">
                <h3 class="text-gray-900 text-xl font-bold pb-3">
                    Actualizar gasto adicional
                </h3>
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center pl-2 pr-3 rounded-full text-sm font-medium text-gray-800 bg-gray-400 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition ease-in-out duration-150"
                >
                    <i class="fa fa-times"></i>
                </PrimaryButton>
            </div>
            <form @submit.prevent="submit">
                <Form
                    :form="form"
                    @update:accountNumber="form.account_number = $event"
                    @update:accountName="form.account_name = $event"
                />
                <div class="flex justify-end pt-5 gap-3">
                    <PrimaryButton
                        @click="$emit('close')"
                        type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-gray-800 bg-gray-300 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition ease-in-out duration-150"
                        :disabled="form.processing"
                    >
                        Cerrar
                    </PrimaryButton>
                    <PrimaryButton
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition ease-in-out duration-150"
                        :disabled="form.processing"
                    >
                        Actualizar gasto
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
