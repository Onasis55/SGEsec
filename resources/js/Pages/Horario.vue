<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import {ref, shallowRef} from "vue";
import axios from 'axios';

interface Props {
    niveles: number[],
    grupos: { id: number, clave: string }[]
}

interface Materia {
    id: number,
    clave: string,
    nombre: string,
    hora_inicial: string,
    hora_final: string,
    profesor: string,
    profesor_id: number
}

const materias = shallowRef<Materia[][]>([])
const nivel = ref<number | null>(null)
const grupoSeleccionado = ref<number | null>(null)
const mensaje = ref<string>('')

defineProps<Props>()

const cargarMaterias = async () => {
    try {
        if(!nivel.value){
            alert('Tienes que seleccionar un nivel')
            return
        }
        const {data} = await axios.post('/horario/cargar/materias/' +  nivel.value)
        materias.value = data.materias
        mensaje.value = ''
    } catch (e) {
        alert('Hubo errores al cargar las materias')
    }
}

const guardarHorarioCompleto = async () => {
    if (!grupoSeleccionado.value) {
        alert('Debe seleccionar un grupo')
        return
    }
    if (materias.value.length === 0) {
        alert('No hay materias cargadas para guardar')
        return
    }

    const materiasParaGuardar = materias.value.flatMap((diaMaterias, diaIndex) =>
        diaMaterias.map(m => ({
            id: m.id,
            hora_ini: m.hora_inicial,
            hora_fin: m.hora_final,
            dia_semana: diaIndex,
        }))
    );

    try {
        await axios.post('/horario/guardar-completo', {
            grupo_id: grupoSeleccionado.value,
            materias: materiasParaGuardar,
        });
        mensaje.value = 'Horario completo guardado correctamente.';
    } catch (error) {
        alert('Error al guardar el horario completo');
    }
}

</script>

<template>
    <app-layout title="horarios">
        <div class="container mx-auto py-5">
            <div class="flex justify-between space-x-4 mb-4">
                <div style="flex-shrink: 0; width: 12rem">
                    <label for="nivel">Nivel</label>
                    <select v-model="nivel" class="input w-full" name="nivel" id="nivel">
                        <option disabled value="">Seleccione un nivel</option>
                        <option v-for="n of niveles" :key="n" :value="n">{{ n }}</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button @click.prevent="cargarMaterias" class="px-4 py-2 rounded bg-emerald-950 text-white">
                        Cargar Materias
                    </button>
                </div>
            </div>

            <div class="flex space-x-4 mb-4">
                <div style="flex-shrink: 0; width: 12rem">
                    <label for="grupo">Grupo</label>
                    <select v-model="grupoSeleccionado" class="input w-full" name="grupo" id="grupo">
                        <option disabled value="">Seleccione un grupo</option>
                        <option v-for="g of grupos" :key="g.id" :value="g.id">{{ g.clave }}</option>
                    </select>
                </div>
                <div class="flex items-center space-x-4">
                    <button @click.prevent="guardarHorarioCompleto" class="px-4 py-2 rounded bg-blue-600 text-white">
                        Guardar Horario Completo
                    </button>
                    <span class="text-green-600 font-semibold" v-if="mensaje">{{ mensaje }}</span>
                </div>
            </div>

            <div class="grid grid-cols-5 rounded border shadow mt-4 overflow-hidden">
                <div class="px-4 py-2 bg-emerald-950 text-white">Lunes</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Martes</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Miércoles</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Jueves</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Viernes</div>
                <div v-for="(day, index) of materias" :key="index">
                    <div v-for="m of day" :key="m.id" class="px-4 py-2 bg-white border">
                        <h2 class="font-semibold">{{ m.nombre }}</h2>
                        <div class="text-stone-500">{{ m.hora_inicial }} - {{ m.hora_final }}</div>
                        <div>{{ m.profesor }}</div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
