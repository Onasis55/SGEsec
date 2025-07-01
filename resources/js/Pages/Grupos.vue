<script setup>

import FormLayout from "@/Layouts/FormLayout.vue";
</script>

<template>
    <form-layout>
        <div class="grid grid-cols-4 gap-5">
            <div class="">
                <label for="clave">Nombre clave del grupo</label>
                <input type="text" class="input" name="clave" id="clave" required>
            </div>
        </div>
    </form-layout>
</template>

<style scoped>

</style>
