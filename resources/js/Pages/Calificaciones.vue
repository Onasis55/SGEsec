<script setup lang="ts">

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 form">
            <div class="">
                <label for="valor">
                    Calificación
                </label>
                <input type="text" id="valor" name="valor">
            </div>
        </div>
    </form-layout>
</template>

<style scoped>
.form div input,select,textarea {
    @apply input;
}
</style>
