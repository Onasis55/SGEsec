<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center px-4 py-2 bg-[#1B2D26] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#407D5A] focus:bg-[#407D5A] active:bg-[#15211E] focus:outline-none focus:ring-2 focus:ring-[#79BA7B] focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
