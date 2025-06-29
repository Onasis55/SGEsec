<template>
    <app-layout>
        <div class="container mx-auto mt-4 px-10">
            <h2 class="text-xl font-bold mb-4">Confirmar eliminación de usuario</h2>
            <p>¿Estás seguro que deseas eliminar al usuario <strong>{{ item.name }}</strong>?</p>

            <form @submit.prevent="submitDelete" class="mt-4">
                <button type="submit" class="btn btn-danger" :disabled="loading">
                    Eliminar
                </button>
                <button type="button" class="btn btn-secondary ml-2" @click="cancel">
                    Cancelar
                </button>
            </form>

            <div v-if="errorMessage" class="mt-4 text-red-600">{{ errorMessage }}</div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

export default {
    components: { AppLayout },
    props: {
        item: Object,
        url: String,
        method: String,
        backurl: String,
    },
    data() {
        return {
            loading: false,
            errorMessage: '',
        };
    },
    methods: {
        async submitDelete() {
            this.loading = true;
            this.errorMessage = '';
            try {
                await axios.delete(this.url);
                Inertia.visit(this.backurl);
            } catch (error) {
                this.errorMessage = error.response?.data?.message || error.message || 'Error desconocido';
            } finally {
                this.loading = false;
            }
        },
        cancel() {
            Inertia.visit(this.backurl);
        },
    },
};
</script>

<style scoped>
.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.btn-danger {
    background-color: #dc2626;
    color: white;
}
.btn-danger:disabled {
    background-color: #fca5a5;
    cursor: not-allowed;
}
.btn-danger:hover:not(:disabled) {
    background-color: #b91c1c;
}
.btn-secondary {
    background-color: #6b7280;
    color: white;
}
.btn-secondary:hover {
    background-color: #4b5563;
}
</style>
