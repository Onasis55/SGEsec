<script setup>

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 gap-5">
            <div class="">
                <label for="nombre">Nombre de rol</label>
                <input type="text" class="input" name="nombre" id="nombre" required>
            </div>
            <div class="">
                <label for="clave">Clave de rol</label>
                <input type="text" class="input" name="clave" id="clave" required>
            </div>
            <div class="">
                <label for="descripcion">Descripcion</label>
                <input type="text" class="input" name="descripcion" id="descripcion" required>
            </div>
        </div>
    </form-layout>
</template>

<style scoped>

</style>
