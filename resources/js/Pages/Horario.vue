<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import {ref, shallowRef} from "vue";
import Materias from "@/Pages/Materias.vue";

interface Props {
    niveles: number[]
}

interface Materia {
    id: number,
    clave: string,
    nombre: string,
    hora_inicial: number,
    hora_final: number,
    profesor: string
    profesor_id: number
}

const materias = shallowRef<Materia[][]>([])
defineProps<Props>()


const nivel = ref<number>()


const cargarMaterias = async () => {
    try {
        if(!nivel.value){
            alert('tienes que selecionar un nivel')
        }
        const {data} = await axios.post('/horario/cargar/materias/' +  nivel.value)
        materias.value = data.materias
    } catch (e) {
        alert('hubo errores al cargar la materias')
    }
}

</script>

<template>
    <app-layout title="horarios">
        <div class="container mx-auto py-5">
            <div class="flex justify-between">
                <div class="" style="flex-shrink: 0; width: 12rem">
                    <label for="nivel">Nivel</label>
                    <select v-model="nivel" class="input w-full" name="nivel" id="nivel">
                        <option v-for="n of niveles" :value="n">{{ n }}</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button @click.prevent="cargarMaterias" class="px-4 py-2 rounded bg-emerald-950 text-white">
                        Cargar Materias
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-5 rounded border shadow mt-4 overflow-hidden">
                <div class="px-4 py-2 bg-emerald-950 text-white">Lunes</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Martes</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Miercoles</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Jueves</div>
                <div class="px-4 py-2 bg-emerald-950 text-white">Viernes</div>
                <div v-for="day of materias">
                    <div v-for="m of day" class="px-4 py-2 bg-white border">
                        <h2 class="font-semibold">{{ m.nombre }}</h2>
                        <div class="text-stone-500">{{ m.hora_inicial }} - {{ m.hora_final  }}</div>
                        <div>{{ m?.profesor }}</div>
                    </div>
                </div>
            </div>
            <small class="text-stone-400">Made by pedrito :D</small>
        </div>
    </app-layout>
</template>

<style scoped>

</style>
