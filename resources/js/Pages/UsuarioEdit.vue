<template>
    <app-layout>
        <loading v-model:show="loading" :success="success" @continue="done" />
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
                    <select v-model="form.tipoUsuario" @change="onTipoUsuarioChange" class="input" disabled>
                        <option value="">Seleccione</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="profesor">Profesor</option>
                    </select>
                </div>

                <!-- Campos para Profesor -->
                <div v-if="form.tipoUsuario === 'profesor'" class="mt-4 space-y-2">
                    <label>Nombre</label>
                    <input v-model="form.name" type="text" required class="input" />

                    <label>Apellido Paterno</label>
                    <input v-model="form.apellido_paterno" type="text" required class="input" />

                    <label>Apellido Materno</label>
                    <input v-model="form.apellido_materno" type="text" required class="input" />

                    <label>CURP</label>
                    <input v-model="form.curp" type="text" maxlength="18" required class="input" disabled />

                    <label>Contraseña (dejar vacío para no cambiar)</label>
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
                    <input v-model="form.padre.name" type="text" required class="input" />

                    <label>Apellido Paterno</label>
                    <input v-model="form.padre.apellido_paterno" type="text" required class="input" />

                    <label>Apellido Materno</label>
                    <input v-model="form.padre.apellido_materno" type="text" required class="input" />

                    <label>CURP</label>
                    <input v-model="form.padre.curp" type="text" maxlength="18" required class="input" disabled />

                    <label>Contraseña (dejar vacío para no cambiar)</label>
                    <input v-model="form.padre.password" type="password" class="input" />

                    <h3 class="font-semibold mt-4">Datos del Estudiante</h3>
                    <label>Nombre</label>
                    <input v-model="form.estudiante.name" type="text" required class="input" />

                    <label>Apellido Paterno</label>
                    <input v-model="form.estudiante.apellido_paterno" type="text" required class="input" />

                    <label>Apellido Materno</label>
                    <input v-model="form.estudiante.apellido_materno" type="text" required class="input" />

                    <label>CURP</label>
                    <input v-model="form.estudiante.curp" type="text" maxlength="18" required class="input" disabled />

                    <label>Contraseña (dejar vacío para no cambiar)</label>
                    <input v-model="form.estudiante.password" type="password" class="input" />
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn" :disabled="loading">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
import axios from 'axios';
import Loading from '@/Components/Loading.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        Loading,
        AppLayout,
    },
    props: {
        item: Object,
        url: String,
        method: String,
        backurl: String,
    },
    data() {
        return {
            form: {
                tipoUsuario: '',
                name: '',
                apellido_paterno: '',
                apellido_materno: '',
                curp: '',
                password: '',
                esTitular: false,
                padre: {
                    name: '',
                    apellido_paterno: '',
                    apellido_materno: '',
                    curp: '',
                    password: '',
                },
                estudiante: {
                    name: '',
                    apellido_paterno: '',
                    apellido_materno: '',
                    curp: '',
                    password: '',
                },
            },
            loading: false,
            success: false,
            showError: false,
            errorMessage: '',
        };
    },
    mounted() {
        this.loadForm();
    },
    methods: {
        loadForm() {
            if (this.item.rol_id === 2) {
                this.form.tipoUsuario = 'profesor';
                this.form.esTitular = true;
                this.form.name = this.item.name;
                this.form.apellido_paterno = this.item.apellido_paterno;
                this.form.apellido_materno = this.item.apellido_materno;
                this.form.curp = this.item.curp;
            } else if (this.item.rol_id === 5) {
                this.form.tipoUsuario = 'profesor';
                this.form.esTitular = false;
                this.form.name = this.item.name;
                this.form.apellido_paterno = this.item.apellido_paterno;
                this.form.apellido_materno = this.item.apellido_materno;
                this.form.curp = this.item.curp;
            } else if (this.item.rol_id === 4) {
                this.form.tipoUsuario = 'estudiante';
                this.form.estudiante.name = this.item.name;
                this.form.estudiante.apellido_paterno = this.item.apellido_paterno;
                this.form.estudiante.apellido_materno = this.item.apellido_materno;
                this.form.estudiante.curp = this.item.curp;
                // Aquí deberías cargar datos del padre si están disponibles
            }
        },
        onTipoUsuarioChange() {
            // No permitir cambiar tipo en edición
        },
        async submitForm() {
            this.loading = true;
            this.showError = false;
            this.errorMessage = '';
            try {
                let payload = {};
                if (this.form.tipoUsuario === 'profesor') {
                    payload = {
                        name: this.form.name,
                        apellido_paterno: this.form.apellido_paterno,
                        apellido_materno: this.form.apellido_materno,
                        curp: this.form.curp,
                        password: this.form.password || undefined,
                        rol_id: this.form.esTitular ? 2 : 5,
                    };
                    await axios.put(this.url, payload);
                } else if (this.form.tipoUsuario === 'estudiante') {
                    payload = {
                        padre: {
                            name: this.form.padre.name,
                            apellido_paterno: this.form.padre.apellido_paterno,
                            apellido_materno: this.form.padre.apellido_materno,
                            curp: this.form.padre.curp,
                            password: this.form.padre.password || undefined,
                        },
                        estudiante: {
                            name: this.form.estudiante.name,
                            apellido_paterno: this.form.estudiante.apellido_paterno,
                            apellido_materno: this.form.estudiante.apellido_materno,
                            curp: this.form.estudiante.curp,
                            password: this.form.estudiante.password || undefined,
                        },
                    };
                    await axios.put(this.url, payload);
                }
                this.success = true;
                this.loading = false;
                Inertia.visit(this.backurl);
            } catch (error) {
                this.loading = false;
                this.success = false;
                this.showError = true;
                this.errorMessage = error.response?.data?.message || error.message || 'Error desconocido';
            }
        },
        done() {
            Inertia.visit(this.backurl);
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
