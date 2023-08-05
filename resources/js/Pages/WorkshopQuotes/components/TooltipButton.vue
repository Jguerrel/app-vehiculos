<script setup>
defineProps({ text: String });
</script>
<template>
    <span
        class="group-hover:opacity-100 transition-opacity bg-gray-800 px-2 py-1 text-xs text-gray-100 rounded-md absolute left-1/2 -translate-x-1/2 -translate-y-8 opacity-0 m-4 mx-auto"
    >
        {{ text }}
    </span>
</template>
