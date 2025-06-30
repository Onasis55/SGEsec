<template>
    <app-layout>
        <div class="min-h-screen flex items-center justify-center px-4 py-12 bg-gray-200">
            <div class="max-w-lg w-full bg-white p-8 rounded shadow">
                <h2 class="text-2xl font-semibold mb-6 text-center">Crear Usuario</h2>

                <!-- Notificación de éxito -->
                <div
                    v-if="showSuccessNotification"
                    class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50"
                >
                    {{ successMessage }}
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
                        <label class="block font-medium mb-1">Tipo de usuario</label>
                        <select v-model="form.tipoUsuario" @change="resetForm" class="input" required>
                            <option value="">Seleccione</option>
                            <option value="estudiante">Estudiante</option>
                            <option value="profesor">Profesor</option>
                        </select>
                    </div>

                    <div v-if="form.tipoUsuario === 'profesor'" class="space-y-4">
                        <div>
                            <label class="block font-medium mb-1">Nombre</label>
                            <input v-model.trim="form.nombre" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Apellido Paterno</label>
                            <input v-model.trim="form.apellido_paterno" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Apellido Materno</label>
                            <input v-model.trim="form.apellido_materno" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">CURP</label>
                            <input v-model.trim="form.curp" type="text" maxlength="18" minlength="18" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Contraseña</label>
                            <input v-model="form.password" type="password" minlength="6" class="input" />
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" v-model="form.esTitular" id="esTitular" class="form-checkbox" />
                            <label for="esTitular" class="select-none">Profesor Titular</label>
                        </div>
                    </div>

                    <div v-if="form.tipoUsuario === 'estudiante'" class="space-y-6">
                        <h3 class="font-semibold border-b pb-2">Datos del Padre o Tutor</h3>

                        <div>
                            <label class="block font-medium mb-1">Nombre</label>
                            <input v-model.trim="form.padre.nombre" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Apellido Paterno</label>
                            <input v-model.trim="form.padre.apellido_paterno" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Apellido Materno</label>
                            <input v-model.trim="form.padre.apellido_materno" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">CURP</label>
                            <input v-model.trim="form.padre.curp" type="text" maxlength="18" minlength="18" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Contraseña</label>
                            <input v-model="form.padre.password" type="password" minlength="6" class="input" />
                        </div>

                        <h3 class="font-semibold border-b pb-2 mt-6">Datos del Estudiante</h3>

                        <div>
                            <label class="block font-medium mb-1">Nombre</label>
                            <input v-model.trim="form.estudiante.nombre" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Apellido Paterno</label>
                            <input v-model.trim="form.estudiante.apellido_paterno" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Apellido Materno</label>
                            <input v-model.trim="form.estudiante.apellido_materno" type="text" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">CURP</label>
                            <input v-model.trim="form.estudiante.curp" type="text" maxlength="18" minlength="18" required class="input" />
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Contraseña</label>
                            <input v-model="form.estudiante.password" type="password" minlength="6" class="input" />
                        </div>
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
                            Procesar
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
            showError: false,
            errorMessage: '',
            showSuccessNotification: false,
            successMessage: '',
        };
    },
    methods: {
        goBack() {
            Inertia.visit('/administrador/users');
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

            if (!this.form.tipoUsuario) {
                this.showError = true;
                this.errorMessage = 'Seleccione un tipo de usuario';
                this.loading = false;
                return;
            }

            if (this.form.tipoUsuario === 'profesor') {
                if (!this.form.nombre || !this.form.apellido_paterno || !this.form.apellido_materno) {
                    this.showError = true;
                    this.errorMessage = 'Complete todos los campos de nombre y apellidos del profesor';
                    this.loading = false;
                    return;
                }
                if (!this.form.curp || this.form.curp.length !== 18) {
                    this.showError = true;
                    this.errorMessage = 'CURP debe tener exactamente 18 caracteres';
                    this.loading = false;
                    return;
                }
                if (this.form.password && this.form.password.length < 6) {
                    this.showError = true;
                    this.errorMessage = 'La contraseña debe tener al menos 6 caracteres';
                    this.loading = false;
                    return;
                }
            } else if (this.form.tipoUsuario === 'estudiante') {
                const padre = this.form.padre;
                if (!padre.nombre || !padre.apellido_paterno || !padre.apellido_materno) {
                    this.showError = true;
                    this.errorMessage = 'Complete todos los campos de nombre y apellidos del padre/tutor';
                    this.loading = false;
                    return;
                }
                if (!padre.curp || padre.curp.length !== 18) {
                    this.showError = true;
                    this.errorMessage = 'CURP del padre/tutor debe tener exactamente 18 caracteres';
                    this.loading = false;
                    return;
                }
                if (padre.password && padre.password.length < 6) {
                    this.showError = true;
                    this.errorMessage = 'La contraseña del padre/tutor debe tener al menos 6 caracteres';
                    this.loading = false;
                    return;
                }

                const estudiante = this.form.estudiante;
                if (!estudiante.nombre || !estudiante.apellido_paterno || !estudiante.apellido_materno) {
                    this.showError = true;
                    this.errorMessage = 'Complete todos los campos de nombre y apellidos del estudiante';
                    this.loading = false;
                    return;
                }
                if (!estudiante.curp || estudiante.curp.length !== 18) {
                    this.showError = true;
                    this.errorMessage = 'CURP del estudiante debe tener exactamente 18 caracteres';
                    this.loading = false;
                    return;
                }
                if (estudiante.password && estudiante.password.length < 6) {
                    this.showError = true;
                    this.errorMessage = 'La contraseña del estudiante debe tener al menos 6 caracteres';
                    this.loading = false;
                    return;
                }
            }

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
                    await axios.post('/administrador/users/store-profesor', payload);
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
                    await axios.post('/administrador/users/store-estudiante', payload);
                }

                this.successMessage = 'Usuario creado exitosamente';
                this.showSuccessNotification = true;

                setTimeout(() => {
                    this.showSuccessNotification = false;
                    this.goBack();
                }, 2000);
            } catch (error) {
                this.showError = true;
                if (error.response && error.response.status === 422) {
                    this.errorMessage = Object.values(error.response.data.errors).flat().join(' ');
                } else {
                    this.errorMessage = error.response?.data?.message || error.message || 'Error desconocido';
                }
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
