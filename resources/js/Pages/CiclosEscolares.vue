<script setup lang="ts">

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 form">
            <div class="">
                <label for="ciclo">
                    Ciclo escolar
                </label>
                <input type="text" id="ciclo" name="ciclo">
            </div>
            <div class="">
                <label for="fecha_ini">
                    Inicio del ciclo escolar
                </label>
                <input type="text" id="fecha_ini" name="fecha_ini">
            </div>
            <div class="">
                <label for="fecha_fin">
                    Fin del ciclo escolar
                </label>
                <input type="text" id="fecha_fin" name="fecha_fin">
            </div>

        </div>
    </form-layout>
</template>

<style scoped>
.form div input,select,textarea{
    @apply input;
}
</style>

