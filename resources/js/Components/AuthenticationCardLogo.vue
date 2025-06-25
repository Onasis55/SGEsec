<script setup>
import { Link } from '@inertiajs/vue3';
import logo from '../../assets/logoimportante.jpg'
</script>

<template>
    <Link :href="'/'">
        <img :src="logo" alt="galloepico" class="w-[100px] h-[100px] mx-0 my-0" >
    </Link>
</template>
