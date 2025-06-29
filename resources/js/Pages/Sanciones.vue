<script setup lang="ts">

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 form">
            <div class="">
                <label for="tipo">
                    Tipo de sanción
                </label>
                <input type="text" id="tipo" name="tipo">
            </div>
        </div>
    </form-layout>
</template>

<style scoped>
.form div input,select,textarea {
    @apply input;
}
</style>
