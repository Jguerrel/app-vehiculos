<script setup>
import TooltipButton from "./TooltipButton.vue";

const props = defineProps({
    quotation: {
        type: Object,
        default: {},
    },
});
</script>
<template>
    <button
        class="rounded bg-orange-200 hover:bg-orange-300 inline-flex items-center justify-center gap-2 px-3 py-2 w-full group relative"
        type="button"
        @click="$emit('openEditModalInvoice', quotation.id)"
    >
        <i class="fas fa-edit text-orange-800"></i>
        <TooltipButton text="Editar Factura" />
    </button>
</template>
