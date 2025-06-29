<script setup lang="ts">

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 form">
            <div class="">
                <label for="hora_ini">
                    Hora de inicio
                </label>
                <input type="time" id="hora_ini" name="hora_ini">
            </div>
            <div class="">
                <label for="hora_fin">
                    Hora de fin
                </label>
                <input type="time" id="hora_fin" name="hora_fin">
            </div>

        </div>
    </form-layout>
</template>

<style scoped>
.form div input,select,textarea {
    @apply input;
}
</style>
