<template>
  <AppLayout>
    <div class="min-h-[80vh] flex items-center justify-center px-4">
      <div class="grid grid-cols-4 gap-6 w-full max-w-7xl">
        <button
            @click="goTo('/administrador/users')"
            class="bg-teal-950 hover:bg-emerald-900 text-white font-bold py-8 px-6 rounded-lg text-2xl shadow-lg transition duration-300"
        >
          Usuarios
        </button>

        <button
            @click="goTo('/administrador/calificaciones')"
            class="bg-teal-950 hover:bg-emerald-900 text-white font-bold py-8 px-6 rounded-lg text-2xl shadow-lg transition duration-300"
        >
          Calificaciones
        </button>

        <button
            @click="goTo('/administrador/reportes')"
            class="bg-teal-950 hover:bg-emerald-900 text-white font-bold py-8 px-6 rounded-lg text-2xl shadow-lg transition duration-300"
        >
          Reportes
        </button>

        <button
            @click="goTo('/administrador/horario/nuevo')"
            class="bg-teal-950 hover:bg-emerald-900 text-white font-bold py-8 px-6 rounded-lg text-2xl shadow-lg transition duration-300"
        >
          Horarios
        </button>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

export default {
  components: {
    AppLayout,
  },
  methods: {
    goTo(route) {
      Inertia.visit(route);
    },
  },
};
</script>

<style scoped>
/* Puedes ajustar estilos si quieres */
</style>
