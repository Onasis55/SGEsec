<template>
    <app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-2xl shadow-lg my-10">
        <h2 class="text-2xl font-bold mb-4">Reportes</h2>
        <form @submit.prevent="handleSubmit" class="space-y-4">


            <div>
                <label for="componente" class="block text-sm font-medium text-gray-700">Seleccione el tipo de reporte</label>
                <select v-model="form.componente" id="componente" class="mt-1 block w-full rounded-full border-gray-300 shadow-sm focus:ring-emerald-600 focus:border-emerald-400">
                    <option disabled value="">Selecciona una opción</option>
                    <option value="Conductas">Conducta</option>
                    <option value="Inasistencias">Inasistencia</option>
                </select>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-emerald-600 text-white rounded-full hover:bg-emerald-900">Acceder</button>
        </form>

        <div class="mt-6">
            <component :is="selectedComponent" />
        </div>
    </div>
    </app-layout>
</template>

<script>
import Conductas from './Conductas.vue';
import Inasistencias from './Horarios.vue';
import {Inertia} from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    data() {
        return {
            form: {

                componente: '',
            }
        }
    },
    computed: {
        selectedComponent() {
            if (this.form.componente === 'Conductas') return 'Conductas';
            if (this.form.componente === 'Inasistencias') return 'Inasistencias';
            return null;
        }
    },
    components: {
        AppLayout,
        Conductas,
        Inasistencias
    },
    methods: {
        handleSubmit() {
            console.log(`Accediendo a ${this.form.componente} como ${this.form.nombre}`);
        },
        goBack() {
            Inertia.visit('/profesor/reportes');
        }
    }
}
</script>

<style scoped>
/* Opcional: mejora estética */
</style>
