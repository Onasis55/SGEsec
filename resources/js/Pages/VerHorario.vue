<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';

const horario = ref(null);
const materia = ref(null);
const error = ref('');

onMounted(async () => {
    try {
        const response = await axios.get('/estudiante/horario');
        horario.value = response.data.horario;
        materia.value = response.data.materia;
    } catch (e) {
        error.value = e.response?.data?.error || 'Error al cargar el horario';
    }
});
</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Horario del Estudiante</h1>
        <div v-if="error" class="text-red-600">{{ error }}</div>
        <div v-else-if="horario && materia">
            <p><strong>Materia:</strong> {{ materia.nombre }}</p>
            <p><strong>Horario:</strong> {{ horario.hora_ini }} - {{ horario.hora_fin }}</p>
            <!-- Puedes agregar más detalles aquí -->
        </div>
        <div v-else>
            <p>No hay horario asignado.</p>
        </div>
    </div>
</template>
