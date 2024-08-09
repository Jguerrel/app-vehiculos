<script setup>
import Layout from "@/Layouts/Layout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import Toolbar from "primevue/toolbar";
import { Head } from "@inertiajs/inertia-vue3";
import CreateModal from "@/Pages/ExpenseAccount/components/CreateModal.vue";
import EditModal from "@/Pages/ExpenseAccount/components/EditModal.vue";
import {
    filter,
    openCreateModal,
    openEditModal,
    selected,
    editModel,
    deleteModel,
} from "./modules/index";

defineProps({ data: Array });
</script>
<template>
    <Head title="Listado de gastos adicionales" />

    <Layout>
        <!-- create modal -->
        <CreateModal :show="openCreateModal" @close="openCreateModal = false" />

        <!-- edit modal -->
        <EditModal
            :show="openEditModal"
            :selected="selected"
            @close="openEditModal = false"
        />

        <div class="py-12 mx-auto">
            <div class="bg-white p-7 rounded-md">
                <div class="w-full pb-5">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="text-gray-900 text-2xl font-bold">
                            Gastos adicionales
                        </h3>
                    </div>
                </div>
                <div class="w-full py-5">
                    <Toolbar class="mb-4">
                        <template #start>
                            <div
                                class="flex flex-col md:flex-row md:justify-start gap-8"
                            >
                                <button
                                    class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded uppercase"
                                    @click.stop="openCreateModal = true"
                                >
                                    <i class="fas fa-plus"></i>
                                    Agregar Nuevo
                                </button>
                            </div>
                        </template>
                    </Toolbar>
                    <DataTable
                        :value="data"
                        :paginator="true"
                        :rows="10"
                        :filters="filter"
                        :rowsPerPageOptions="[10, 20, 50]"
                        paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
                        currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords}"
                        responsiveLayout="scroll"
                        dataKey="id"
                    >
                        <!-- filtros -->
                        <template #header>
                            <div
                                class="flex flex-col md:flex-row justify-start gap-5"
                            >
                                <div class="flex flex-col">
                                    <span class="p-input-icon-left">
                                        <i class="pi pi-search" />
                                        <InputText
                                            v-model="filter['global'].value"
                                            placeholder="Búsqueda..."
                                            class="w-52 h-[38px]"
                                        />
                                    </span>
                                </div>
                            </div>
                        </template>
                        <!-- /filtros -->

                        <!-- columnas -->
                        <Column
                            field="account_number"
                            header="Nº de cuenta"
                            :sortable="true"
                        ></Column>
                        <Column
                            field="account_name"
                            header="Nombre de la cuenta"
                            :sortable="true"
                        ></Column>
                        <Column
                            field="created_at_formatted"
                            header="Fecha"
                            :sortable="true"
                        />
                        <Column style="min-width: 15rem">
                            <template #body="{ data }">
                                <div
                                    class="flex justify-center items-center gap-3"
                                >
                                    <button
                                        type="button"
                                        class="inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                                        @click.stop="editModel(data)"
                                    >
                                        <i class="pi pi-pencil" />
                                    </button>
                                    <button
                                        type="button"
                                        class="inline-block px-6 py-2 border-2 border-red-600 text-red-600 font-medium text-xs leading-tight uppercase rounded-full hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out"
                                        @click.stop="deleteModel(data)"
                                    >
                                        <i class="pi pi-trash" />
                                    </button>
                                </div>
                            </template>
                        </Column>
                        <!-- /columnas -->
                    </DataTable>
                </div>
            </div>
        </div>
    </Layout>
</template>
