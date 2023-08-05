<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Swal from "sweetalert2";
import ButtonDownloadInvoice from "./ButtonDownloadInvoice.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "3xl",
    },
    chassis_number: {
        type: String,
        default: "",
        description: "Número de chasis del vehiculo",
    },
    quotation: {
        type: Object,
        default: {},
        description: "objeto de la cotización realizada",
    },
});

// variables reactivas
const loading = ref(false);

// eventos
const emit = defineEmits(["close"]);

// formulario - datos
const form = useForm({
    quotation_id: "",
    invoice_number: "",
    invoice: "",
    path: "",
});

/**
 * validar y cargar la factura
 *
 * @param {*} e     evento
 */
const validateAndLoadInvoice = (e) => {
    const file = e.target.files[0];
    const allowedExtensions = /(\.pdf|\.txt|\.csv|\.docx|\.doc|\.xls|\.xlsx)$/i;

    if (!allowedExtensions.exec(file.name)) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Solo se permiten archivos pdf, txt, csv, docx, doc, xls, xlsx",
        });

        // limpiar el input y el form
        e.target.value = "";
        form.reset("invoice", null);
        form.path = props.quotation.invoice_path;

        return;
    }

    form.invoice = file;
    form.path = "";
};

/**
 * actualizar la factura
 */
const updateInvoice = () => {
    loading.value = true;

    form.post(route("workshop_quotes.updateInvoice"), {
        onSuccess: () => {
            loading.value = false;
            clearForm();
            emit("close");
        },
        onError: () => {
            loading.value = false;
            manageError();
        },
    });
};

const clearForm = () => {
    form.reset("invoice_number", null);
    form.reset("invoice", null);
    form.reset("path", null);
};

// cuando este activo la modal
watch(
    () => props.show,
    (value) => {
        if (value) {
            form.quotation_id = props.quotation.id;
            form.invoice_number = props.quotation.invoice_number;
            form.path = props.quotation.invoice_path;
        }
    }
);
</script>
<template>
    <Modal :show="show" :max-width="maxWidth">
        <div class="p-4">
            <div class="flex justify-between items-center">
                <h3 class="text-gray-900 text-xl font-bold pb-3">
                    Actualizar datos de facturación
                </h3>
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-3 rounded-full text-sm font-medium text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 transition ease-in-out duration-150"
                >
                    <i class="fa fa-times"></i>
                </PrimaryButton>
            </div>
            <div class="w-full">
                <div class="py-5 flex flex-col gap-5">
                    <div class="">
                        <InputLabel
                            for="invoice_number"
                            value="Nº de chasis"
                            class="font-bold text-lg"
                        />
                        <span class="text-blue-900">
                            {{ props.chassis_number }}
                        </span>
                    </div>
                    <div class="">
                        <InputLabel
                            for="invoice_number"
                            value="Nº de factura"
                            class="font-bold text-lg"
                        />
                        <TextInput
                            id="invoice_number"
                            type="text"
                            class="mt-1 block w-full border-gray-200 border"
                            v-model="form.invoice_number"
                            required
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.invoice_number"
                        />
                    </div>
                    <div class="flex flex-col gap-3">
                        <InputLabel
                            for="invoice"
                            value="Cargar factura"
                            class="font-bold text-lg"
                        />
                        <div
                            v-if="form.path && !form.invoice"
                            class="flex flex-col gap-1"
                        >
                            <label for="">
                                Factura actual: {{ form.path }}
                            </label>
                            <ButtonDownloadInvoice
                                :invoice="form.path"
                                class="w-12"
                            />
                        </div>
                        <label class="block border rounded">
                            <span class="sr-only"> Cargar factura </span>
                            <input
                                type="file"
                                @change="validateAndLoadInvoice($event)"
                                id="invoice"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-200 file:text-blue-700 hover:file:bg-blue-300"
                                required
                            />
                            <span class="text-sm text-orange-600">
                                si carga una nueva factura, la anterior será
                                eliminada
                            </span>
                        </label>
                        <InputError
                            class="mt-2"
                            :message="form.errors.invoice"
                        />
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-5 gap-3">
                <PrimaryButton
                    @click.stop="updateInvoice"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-900 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition ease-in-out duration-150"
                >
                    Actualizar datos
                </PrimaryButton>
                <PrimaryButton
                    @click="$emit('close')"
                    type="button"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-900 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-900 transition ease-in-out duration-150"
                >
                    Cerrar
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
