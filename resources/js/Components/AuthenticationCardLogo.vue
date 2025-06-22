<script setup>
import { Link } from '@inertiajs/vue3';
import logo from '../../assets/logoimportante.jpg'
</script>

<template>
    <Link :href="'/'">
        <img :src="logo" alt="galloepico">
    </Link>
</template>
