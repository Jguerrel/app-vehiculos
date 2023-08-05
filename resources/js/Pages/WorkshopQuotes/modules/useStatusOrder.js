/**
 * Gestiona el estado de la orden de trabajo
 *
 * @autor  Luis Annunziato: luisannunziato@gmail.com
 * @link https://luisan.dev
 */

import Swal from "sweetalert2/dist/sweetalert2";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import { manageError } from "@/Utils/Common/common";

export default function useStatusOrder(props) {
    const showModalInvoice = ref(false);
    const showEditModalInvoice = ref(false);
    const quotation_id = ref(0);

    /**
     * Abrir modal para agregar factura
     */
    const openModal = (id) => {
        showModalInvoice.value = true;
        quotation_id.value = id;
    };

    /**
     * Abrir modal para editar factura
     */
    const openEditModalInvoice = (id) => {
        showEditModalInvoice.value = true;
        quotation_id.value = id;
    };

    /**
     * Iniciar reparación
     */
    const startRepair = () => {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "¡Sí, iniciar reparación!",
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                const form = useForm({ order_id: props.id });

                form.post(route("workshop_quotes.startRepair"), {
                    onSuccess: () => {
                        Swal.fire(
                            "¡Reparación iniciada!",
                            "La reparación ha sido iniciada.",
                            "success"
                        );
                    },
                    onError: () => manageError(),
                });
            }
        });
    };

    /**
     * Finalizar reparación
     */
    const finishRepair = () => {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "¡No podrás revertir esto!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "¡Sí, finalizar reparación!",
            cancelButtonText: "No, Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                const form = useForm({ order_id: props.id });

                form.post(route("workshop_quotes.finishRepair"), {
                    onSuccess: () => {
                        Swal.fire(
                            "¡Reparación Finalizada!",
                            "La reparación ha sido finalizada. se le notificará al usuario.",
                            "success"
                        );
                    },
                    onError: () => manageError(),
                });
            }
        });
    };

    return {
        showModalInvoice,
        showEditModalInvoice,
        quotation_id,
        openModal,
        openEditModalInvoice,
        startRepair,
        finishRepair,
    };
}
