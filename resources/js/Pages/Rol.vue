<script setup>

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4">
            <div class="">
                <label for="nombre_rol">Nombre de rol</label>
                <input type="text" class="input" name="nombre_rol" id="nombre_rol" required>
            </div>
        </div>
    </form-layout>
</template>

<style scoped>

</style>
