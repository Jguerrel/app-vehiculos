/**
 * Gestión de funcionalidades para el index de gastos adicionales
 */

import { ref } from "vue";
import { FilterMatchMode } from "primevue/api";
import { useForm } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";

export const filter = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
export const openCreateModal = ref(false);
export const openEditModal = ref(false);
export const selected = ref({});

export const editModel = (model) => {
    selected.value = model;
    openEditModal.value = true;
};

/**
 * Verifica y elimina un gasto adicional
 * @param {*} model el gasto a eliminar
 */
export const deleteModel = (model) => {
    Swal.fire({
        title: "¿Estas seguro que quieres eliminar este gasto adicional?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, estoy seguro.",
        cancelButtonText: "No, volver.",
        reverseButtons: false,
    }).then((result) => {
        if (result.isConfirmed) {
            const form = useForm({
                id: model.id,
                _method: "DELETE",
            });

            form.delete(route("expense_account.destroy", form.id), {
                onError: (error) => console.log(error),
                onSuccess: (resp) => {
                    if (resp.props?.flash?.error) {
                        return Swal.fire({
                            icon: "error",
                            title: "No se pudo eliminar",
                            text: resp.props?.flash?.error,
                        });
                    }

                    Swal.fire({
                        icon: "success",
                        title: "Gasto adicional eliminado",
                        text: "Gasto adicional eliminado con éxito",
                    });
                },
            });
        }
    });
};
