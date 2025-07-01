<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

function recuperar() {
    window.location.href = '/recuperacion';
}

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    cuenta: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="bg-black">

    </div>
    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo/>
        </template>
        <div class="block font-extrabold text-center text-gray-100 text-4xl">
            Iniciar sesión
        </div>
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" >
            <div class="mt-3">
                <InputLabel for="cuenta" value="Usuario" />
                <TextInput
                    id="cuenta"
                    v-model="form.cuenta"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.cuenta" />
            </div>

            <div class="mt-10">
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" @click="recuperar" :href="route('password.recovery_request')" class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#79BA7B]">
                    Olvidaste tu contraseña?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Ingresar
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
