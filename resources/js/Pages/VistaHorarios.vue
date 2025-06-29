<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
</script>

<template>
<app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#1F3D2F]">
        <main class="">
            <aside class="w-[50px] float-left h-screen">

            </aside>
            <div class="w-[200px] float-left h-screen">
                <ul class="flex flex-col text-center mx-1 my-10 bg-[#2D553E] rounded px-6 py-1 border-[3px] border-[#79BA7B]">
                    <li class="text-2xl py-4"><a href="a">Ejemplo1</a></li>
                    <li class="text-2xl py-4"><a href="a">Ejemplo2</a></li>
                    <li class="text-2xl py-4"><a href="a">Elemplo3</a></li>
                </ul>
            </div>
            <article class="w-[1000px] float-left">
                <div class="flex flex-col text-center mx-1 my-10 bg-[#2D553E] rounded px-6 py-1 border-[3px] border-[#79BA7B]">

                    <table>
                        <thead>
                        <th>
                        </th>
                        <th>L</th>
                        <th>M</th>
                        <th>M</th>
                        <th>J</th>
                        <th>V</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>8:00</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                        </tr>
                        <tr>
                            <td>9:30</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                        </tr>
                        <tr>
                            <td>11:00</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                        </tr>
                        <tr>
                            <td>12:30</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                        </tr>
                        <tr>
                            <td>14:00</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                            <td>TEXTOEJEMPLO</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </article>
            <aside class="w-[50px] float-left h-screen">

            </aside>
        </main>

    </div>
    <div class="h-56 float-left bg-[#1b1b18] w-full">

    </div>
</app-layout>
</template>

<style scoped>
    th{
        width: 40rem;
        height: 10px;
        color: #DDDDDD;
    }
    td{
        height: 50px;
        color: #DDDDDD;
    }
    a{
        color: #DDDDDD;
    }


</style>
