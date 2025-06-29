<script setup lang="ts">

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 form">
            <div class="">
                <label for="hora_inicio">
                    Hora de inicio
                </label>
                <input type="text" id="hora_inicio" name="hora_inicio">
            </div>
            <div class="">
                <label for="hora_fin">
                    Hora de fin
                </label>
                <input type="text" id="hora_fin" name="hora_fin">
            </div>

        </div>
    </form-layout>
</template>

<style scoped>
.form div input,select,textarea {
    @apply input;
}
</style>
