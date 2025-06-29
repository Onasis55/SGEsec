<template>
    <app-layout>
        <!-- Modal de éxito -->
        <div v-if="showSuccessDialog" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg p-6 max-w-sm w-full shadow-lg text-center">
                <h2 class="text-xl font-bold mb-4">Transacción Exitosa</h2>
                <p>El usuario fue creado correctamente.</p>
                <button
                    @click="onDialogClose"
                    class="mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none"
                >
                    Aceptar
                </button>
            </div>
        </div>

        <div class="container mx-auto mt-4 px-10">
            <transition appear>
                <div v-if="showError" class="px-4 py-2 bg-red-500 text-white rounded my-4">
                    <h5 class="text-xl font-semibold">
                        <i class="bi bi-bug"></i>
                        Error
                    </h5>
                    {{ errorMessage }}
                </div>
            </transition>

            <form @submit.prevent="submitForm" class="p-4 rounded bg-white shadow">
                <div>
                    <label>Tipo de usuario</label>
                    <select v-model="form.tipoUsuario" @change="onTipoUsuarioChange" class="input">
                        <option value="">Seleccione</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="profesor">Profesor</option>
                    </select>
                </div>

                <!-- Campos para Profesor -->
                <div v-if="form.tipoUsuario === 'profesor'" class="mt-4 space-y-2">
                    <label>Nombre</label>
                    <input v-model="form.nombre" type="text" required class="input" />

                    <label>Apellido Paterno</label>
                    <input v-model="form.apellido_paterno" type="text" required class="input" />

                    <label>Apellido Materno</label>
                    <input v-model="form.apellido_materno" type="text" required class="input" />

                    <label>CURP</label>
                    <input v-model="form.curp" type="text" maxlength="18" required class="input" />

                    <label>Contraseña</label>
                    <input v-model="form.password" type="password" class="input" />

                    <label class="inline-flex items-center mt-2">
                        <input type="checkbox" v-model="form.esTitular" class="mr-2" />
                        Profesor Titular
                    </label>
                </div>

                <!-- Campos para Estudiante -->
                <div v-if="form.tipoUsuario === 'estudiante'" class="mt-4 space-y-4">
                    <h3 class="font-semibold">Datos del Padre o Tutor</h3>
                    <label>Nombre</label>
                    <input v-model="form.padre.nombre" type="text" required class="input" />

                    <label>Apellido Paterno</label>
                    <input v-model="form.padre.apellido_paterno" type="text" required class="input" />

                    <label>Apellido Materno</label>
                    <input v-model="form.padre.apellido_materno" type="text" required class="input" />

                    <label>CURP</label>
                    <input v-model="form.padre.curp" type="text" maxlength="18" required class="input" />

                    <label>Contraseña</label>
                    <input v-model="form.padre.password" type="password" class="input" />

                    <h3 class="font-semibold mt-4">Datos del Estudiante</h3>
                    <label>Nombre</label>
                    <input v-model="form.estudiante.nombre" type="text" required class="input" />

                    <label>Apellido Paterno</label>
                    <input v-model="form.estudiante.apellido_paterno" type="text" required class="input" />

                    <label>Apellido Materno</label>
                    <input v-model="form.estudiante.apellido_materno" type="text" required class="input" />

                    <label>CURP</label>
                    <input v-model="form.estudiante.curp" type="text" maxlength="18" required class="input" />

                    <label>Contraseña</label>
                    <input v-model="form.estudiante.password" type="password" class="input" />
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn" :disabled="loading">
                        Procesar
                    </button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
    components: {
        AppLayout,
    },
    data() {
        return {
            form: {
                tipoUsuario: '',
                nombre: '',
                apellido_paterno: '',
                apellido_materno: '',
                curp: '',
                password: '',
                esTitular: false,
                padre: {
                    nombre: '',
                    apellido_paterno: '',
                    apellido_materno: '',
                    curp: '',
                    password: '',
                },
                estudiante: {
                    nombre: '',
                    apellido_paterno: '',
                    apellido_materno: '',
                    curp: '',
                    password: '',
                },
            },
            loading: false,
            showSuccessDialog: false,
            showError: false,
            errorMessage: '',
        };
    },
    methods: {
        onTipoUsuarioChange() {
            this.resetForm();
        },
        resetForm() {
            this.form.nombre = '';
            this.form.apellido_paterno = '';
            this.form.apellido_materno = '';
            this.form.curp = '';
            this.form.password = '';
            this.form.esTitular = false;
            this.form.padre = {
                nombre: '',
                apellido_paterno: '',
                apellido_materno: '',
                curp: '',
                password: '',
            };
            this.form.estudiante = {
                nombre: '',
                apellido_paterno: '',
                apellido_materno: '',
                curp: '',
                password: '',
            };
            this.showError = false;
            this.errorMessage = '';
        },
        async submitForm() {
            this.loading = true;
            this.showError = false;
            this.errorMessage = '';
            try {
                if (this.form.tipoUsuario === 'profesor') {
                    const payload = {
                        nombre: this.form.nombre,
                        apellido_paterno: this.form.apellido_paterno,
                        apellido_materno: this.form.apellido_materno,
                        curp: this.form.curp,
                        password: this.form.password,
                        es_titular: this.form.esTitular,
                    };
                    await axios.post('/users/store-profesor', payload);
                } else if (this.form.tipoUsuario === 'estudiante') {
                    const payload = {
                        padre: {
                            nombre: this.form.padre.nombre,
                            apellido_paterno: this.form.padre.apellido_paterno,
                            apellido_materno: this.form.padre.apellido_materno,
                            curp: this.form.padre.curp,
                            password: this.form.padre.password,
                        },
                        estudiante: {
                            nombre: this.form.estudiante.nombre,
                            apellido_paterno: this.form.estudiante.apellido_paterno,
                            apellido_materno: this.form.estudiante.apellido_materno,
                            curp: this.form.estudiante.curp,
                            password: this.form.estudiante.password,
                        },
                    };
                    await axios.post('/users/store-estudiante', payload);
                } else {
                    this.showError = true;
                    this.errorMessage = 'Seleccione un tipo de usuario';
                    this.loading = false;
                    return;
                }
                this.showSuccessDialog = true;
            } catch (error) {
                this.showError = true;
                this.errorMessage = error.response?.data?.message || error.message || 'Error desconocido';
            } finally {
                this.loading = false;
            }
        },
        onDialogClose() {
            this.showSuccessDialog = false;
            Inertia.visit('/users'); // Cambia la ruta según tu configuración
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
