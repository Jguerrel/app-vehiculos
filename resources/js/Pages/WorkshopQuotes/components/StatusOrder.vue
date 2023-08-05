<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import ButtonDownloadQuotation from "./ButtonDownloadQuotation.vue";
import ButtonDownloadInvoice from "./ButtonDownloadInvoice.vue";
import ButtonAddInvoice from "./ButtonAddInvoice.vue";
import AddInvoiceModal from "./AddInvoiceModal.vue";
import ButtonEditQuotation from "./ButtonEditQuotation.vue";
import useStatusOrder from "@/Pages/WorkshopQuotes/modules/useStatusOrder";
import ButtonEditInvoice from "./ButtonEditInvoice.vue";
import EditInvoiceModal from "./EditInvoiceModal.vue";
import TooltipButton from "./TooltipButton.vue";

const props = defineProps({
    status: Number,
    id: Number,
    order: Object,
});

const {
    showModalInvoice,
    showEditModalInvoice,
    quotation_id,
    startRepair,
    finishRepair,
    openModal,
    openEditModalInvoice,
} = useStatusOrder(props);
</script>
<template>
    <AddInvoiceModal
        :show="showModalInvoice"
        :quotation_id="quotation_id"
        :chassis_number="order.vehicle?.chassis_number"
        @close="showModalInvoice = false"
    />
    <EditInvoiceModal
        :show="showEditModalInvoice"
        :quotation="order.quotation"
        :chassis_number="order.vehicle?.chassis_number"
        @close="showEditModalInvoice = false"
    />

    <div class="text-center">
        <!-- por cotizar - abierta -->
        <div v-if="status === $page.props.status.repair_order.open">
            <Link
                :href="route('workshop_quotes.createQuote', id)"
                class="hover:no-underline bg-blue-100 px-3 py-2 hover:bg-blue-300 text-blue-600 hover:text-blue-900 rounded-lg text-xs font-bold"
            >
                <i class="fas fa-arrow-right"></i>
                Cotizar ahora
            </Link>
        </div>

        <!-- cotizada -->
        <div v-if="status === $page.props.status.repair_order.quoted">
            <p class="pb-2 mb-2 border-b-2 text-blue-800 text-sm font-semibold">
                Reparación cotizada
            </p>

            <div class="flex justify-center items-stretch gap-1">
                <ButtonDownloadQuotation :id="order.quotation.id" />
                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal(order.quotation.id)"
                    v-if="!order.quotation.invoice_path"
                />
                <ButtonEditQuotation :id="order.quotation.id" />
                <ButtonEditInvoice
                    :quotation="order.quotation"
                    @openEditModalInvoice="
                        openEditModalInvoice(order.quotation.id)
                    "
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- aprobada -->
        <div v-if="status === $page.props.status.repair_order.approved">
            <p class="pb-2 mb-2 border-b-2 text-blue-800 text-sm font-semibold">
                Cotización aprobada
            </p>

            <div class="flex justify-center items-stretch gap-1">
                <button
                    class="hover:no-underline bg-purple-200 hover:bg-purple-300 text-purple-600 hover:text-purple-900 inline-flex items-center justify-center gap-2 px-3 py-2 w-full group relative"
                    @click="startRepair()"
                >
                    <i class="fas fa-arrow-right"></i>
                    <TooltipButton text="Iniciar reparación" />
                </button>
                <ButtonDownloadQuotation :id="order.quotation.id" />
                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal(order.quotation.id)"
                    v-if="!order.quotation.invoice_path"
                />
                <ButtonEditQuotation :id="order.quotation.id" />
                <ButtonEditInvoice
                    :quotation="order.quotation"
                    @openEditModalInvoice="
                        openEditModalInvoice(order.quotation.id)
                    "
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- en repación -->
        <div v-if="status === $page.props.status.repair_order.in_repair">
            <p class="pb-2 mb-2 border-b-2 text-blue-800 text-sm font-semibold">
                En reparación
            </p>

            <div class="flex justify-center items-stretch gap-1">
                <button
                    class="hover:no-underline bg-teal-200 hover:bg-teal-300 text-teal-600 hover:text-teal-900 inline-flex items-center justify-center gap-2 px-3 py-2 w-full group relative"
                    @click="finishRepair()"
                >
                    <i class="fas fa-arrow-right"></i>
                    <TooltipButton text="Finalizar reparación" />
                </button>
                <ButtonDownloadQuotation :id="order.quotation.id" />
                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />
                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal(order.quotation.id)"
                    v-if="!order.quotation.invoice_path"
                />
                <ButtonEditQuotation :id="order.quotation.id" />
                <ButtonEditInvoice
                    :quotation="order.quotation"
                    @openEditModalInvoice="
                        openEditModalInvoice(order.quotation.id)
                    "
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- orden cancelada -->
        <div v-if="status === $page.props.status.repair_order.cancelLed">
            Orden cancelada
        </div>

        <!-- vehiculo reparado -->
        <div v-if="status === $page.props.status.repair_order.repaired">
            <p
                class="pb-2 mb-2 border-b-2 text-green-800 text-sm font-semibold"
            >
                Vehiculo reparado
            </p>

            <div class="flex justify-center items-stretch gap-1">
                <ButtonDownloadQuotation :id="order.quotation.id" />
                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />

                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal(order.quotation.id)"
                    v-if="!order.quotation.invoice_path"
                />
                <ButtonEditInvoice
                    :quotation="order.quotation"
                    @openEditModalInvoice="
                        openEditModalInvoice(order.quotation.id)
                    "
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>

        <!-- caso finalizado -->
        <div v-if="status === $page.props.status.repair_order.finalized">
            <p
                class="pb-2 mb-2 border-b-2 text-green-800 text-sm font-semibold"
            >
                <i class="fas fa-check text-green-600"></i>
                Caso finalizado
            </p>

            <div class="flex justify-center items-stretch gap-1">
                <ButtonDownloadQuotation :id="order.quotation.id" />
                <ButtonDownloadInvoice
                    :invoice="order.quotation.invoice_path"
                    v-if="order.quotation.invoice_path"
                />

                <ButtonAddInvoice
                    :quotation="order.quotation"
                    @openModalInvoice="openModal(order.quotation.id)"
                    v-if="!order.quotation.invoice_path"
                />
                <ButtonEditInvoice
                    :quotation="order.quotation"
                    @openEditModalInvoice="
                        openEditModalInvoice(order.quotation.id)
                    "
                    v-if="order.quotation.invoice_path"
                />
            </div>
        </div>
    </div>
</template>
