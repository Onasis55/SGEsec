<script setup lang="ts">

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 form gap-4">
            <div class="">
                <label for="nivel">
                    Nivel de la materia
                </label>
                <input type="text" id="nivel" name="nivel">
            </div>
            <div class="">
                <label for="nombre">
                    Nombre de la materia
                </label>
                <input type="text" id="nombre" name="nombre">
            </div>
            <div class="">
                <label for="clave">
                    Clave de la materia
                </label>
                <input type="text" id="clave" name="clave">
            </div>
            <div class="">
                <label for="descripcion">
                    Descripcion de la materia
                </label>
                <input type="text" id="descripcion" name="descripcion">
            </div>
        </div>
    </form-layout>
</template>

<style scoped>
.form div input,select,textarea {
    @apply input;
}
</style>
