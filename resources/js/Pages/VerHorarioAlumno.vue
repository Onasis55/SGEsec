<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from "@/Layouts/AppLayout.vue";

function regresar() {
    window.location.href = '/tutor/dashboard';
}
interface HorarioItem {
    id: number;
    dia_semana: number; // 0=lunes ... 4=viernes
    hora_ini: string;
    hora_fin: string;
    materia: {
        id: number;
        nombre: string;
        clave: string;
    };
}

const horarioPorDia = ref<HorarioItem[][]>([[], [], [], [], []]);
const error = ref('');
const nombreEstudiante = ref('');

onMounted(async () => {
    try {
        const response = await axios.get('/tutor/horario-alumno');
        const items: HorarioItem[] = response.data.horarioItems;
        nombreEstudiante.value = response.data.estudiante.nombre;

        horarioPorDia.value = [[], [], [], [], []];

        items.forEach(item => {
            if (item.dia_semana >= 0 && item.dia_semana <= 4) {
                horarioPorDia.value[item.dia_semana].push(item);
            }
        });

        horarioPorDia.value.forEach(dia => {
            dia.sort((a, b) => a.hora_ini.localeCompare(b.hora_ini));
        });

    } catch (e) {
        error.value = e.response?.data?.error || 'Error al cargar el horario';
    }
});
</script>

<template>
    <app-layout>
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Horario del alumno: {{ nombreEstudiante }}</h1>
            <div v-if="error" class="text-red-600">{{ error }}</div>
            <div v-else>
                <div class="grid grid-cols-5 rounded border shadow mt-4 overflow-hidden">
                    <div class="px-4 py-2 bg-emerald-950 text-white font-semibold">Lunes</div>
                    <div class="px-4 py-2 bg-emerald-950 text-white font-semibold">Martes</div>
                    <div class="px-4 py-2 bg-emerald-950 text-white font-semibold">Miércoles</div>
                    <div class="px-4 py-2 bg-emerald-950 text-white font-semibold">Jueves</div>
                    <div class="px-4 py-2 bg-emerald-950 text-white font-semibold">Viernes</div>

                    <div v-for="(dia, index) in horarioPorDia" :key="index" class="bg-white border">
                        <div v-if="dia.length === 0" class="text-gray-500 p-2">No hay clases</div>
                        <div v-for="item in dia" :key="item.id" class="border-b last:border-b-0 p-2 hover:bg-gray-100">
                            <h2 class="font-semibold">{{ item.materia.nombre }}</h2>
                            <div class="text-stone-500">{{ item.hora_ini }} - {{ item.hora_fin }}</div>
                            <div class="text-sm text-gray-600">Clave: {{ item.materia.clave }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed bottom-4 right-4">
            <button
                @click="regresar"
                class="px-10 py-5 text-white bg-emerald-950 rounded-md hover:bg-emerald-800 transition duration-300"
            >
                regresar
            </button>
        </div>
    </app-layout>
</template>
