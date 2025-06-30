<template>
    <app-layout>
        <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gray-200">
            <div class="max-w-lg w-full bg-white p-8 rounded shadow">
                <h2 class="text-2xl font-semibold mb-6 text-center">Editar Usuario</h2>

                <div class="mb-4 font-semibold text-center">
                    Tipo de usuario: {{ tipoUsuarioTexto }}
                </div>

                <transition appear>
                    <div v-if="showError" class="px-4 py-2 bg-red-500 text-white rounded mb-4">
                        <h5 class="text-xl font-semibold flex items-center gap-2">
                            <i class="bi bi-bug"></i>
                            Error
                        </h5>
                        {{ errorMessage }}
                    </div>
                </transition>

                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label class="block font-medium mb-1">Nombre</label>
                        <input v-model="form.name" type="text" required class="input" />
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Apellido Paterno</label>
                        <input v-model="form.apellido_paterno" type="text" required class="input" />
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Apellido Materno</label>
                        <input v-model="form.apellido_materno" type="text" required class="input" />
                    </div>

                    <div>
                        <label class="block font-medium mb-1">CURP</label>
                        <input v-model="form.curp" type="text" maxlength="18" required class="input" />
                    </div>

                    <div v-if="esProfesor" class="flex items-center space-x-2">
                        <input type="checkbox" v-model="form.esTitular" id="esTitular" class="form-checkbox" />
                        <label for="esTitular" class="select-none">Profesor Titular</label>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button
                            type="button"
                            @click="goBack"
                            class="btn bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded"
                        >
                            Regresar
                        </button>

                        <button type="submit" class="btn" :disabled="loading">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </app-layout>
</template>

<script>
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        AppLayout,
    },
    props: {
        item: {
            type: Object,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
        backurl: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            form: {
                name: '',
                apellido_paterno: '',
                apellido_materno: '',
                curp: '',
                esTitular: false,
            },
            loading: false,
            showError: false,
            errorMessage: '',
        };
    },
    computed: {
        esProfesor() {
            return this.item.rol_id === 2 || this.item.rol_id === 5;
        },
        tipoUsuarioTexto() {
            switch (this.item.rol_id) {
                case 1:
                    return 'Administrador';
                case 2:
                    return 'Profesor Titular';
                case 5:
                    return 'Profesor Sustituto';
                case 4:
                    return 'Estudiante';
                case 3:
                    return 'Tutor';
                default:
                    return 'Desconocido';
            }
        },
    },
    mounted() {
        this.cargarDatos();
    },
    methods: {
        goBack() {
            Inertia.visit(this.backurl);
        },
        cargarDatos() {
            this.form.name = this.item.name || '';
            this.form.apellido_paterno = this.item.apellido_paterno || '';
            this.form.apellido_materno = this.item.apellido_materno || '';
            this.form.curp = this.item.curp || '';
            this.form.esTitular = this.item.rol_id === 2; // true si titular, false si sustituto
        },
        async submitForm() {
            this.loading = true;
            this.showError = false;
            this.errorMessage = '';
            try {
                const payload = {
                    name: this.form.name,
                    apellido_paterno: this.form.apellido_paterno,
                    apellido_materno: this.form.apellido_materno,
                    curp: this.form.curp,
                    rol_id: this.item.rol_id, // Enviar siempre rol_id original
                };

                if (this.esProfesor) {
                    payload.rol_id = this.form.esTitular ? 2 : 5;
                }

                await axios.put(this.url, payload);

                Inertia.visit(this.backurl);
            } catch (error) {
                this.showError = true;
                this.errorMessage = error.response?.data?.message || error.message || 'Error desconocido';
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
}

.btn {
    background-color: #2563eb;
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 0.25rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:disabled {
    background-color: #93c5fd;
    cursor: not-allowed;
}

.btn:hover:not(:disabled) {
    background-color: #1d4ed8;
}
</style>
