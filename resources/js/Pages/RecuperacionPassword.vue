<template>
    <div class="min-h-screen flex items-center justify-center p-4 bg-emerald-950">
        <div class="bg-gray-200 rounded-xl shadow-2xl p-8 w-full max-w-md">
            <!-- Paso 1: Selección de tipo de usuario -->
            <div v-if="currentStep === 'userType'" class="text-center">
                <div class="mb-6">
                    <div class="w-16 h-16 bg-emerald-950 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-emerald-900 mb-2">Recuperación de Contraseña</h1>
                    <p class="text-emerald-700">Selecciona tu tipo de usuario</p>
                </div>

                <div class="space-y-3">
                    <button
                        @click="selectUserType('estudiante')"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Estudiante
                    </button>

                    <button
                        @click="selectUserType('profesor')"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Profesor
                    </button>

                    <button
                        @click="selectUserType('tutor')"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Tutor
                    </button>
                </div>
            </div>

            <!-- Paso 2: Mensaje para estudiante/profesor -->
            <div v-if="currentStep === 'studentProfessorMessage'" class="text-center">
                <div class="mb-6">
                    <div class="w-16 h-16 bg-emerald-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-emerald-900 mb-4">Información Importante</h2>
                </div>

                <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 mb-6">
                    <p class="text-emerald-800 leading-relaxed">
                        ¡Lo sentimos! Para reestablecer tu contraseña, por favor acude al
                        <strong>Departamento de Gestión Escolar</strong> dentro de un horario hábil
                        para proseguir con tu proceso.
                    </p>
                </div>

                <button
                    @click="goToLogin"
                    class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200"
                >
                    Regresar
                </button>
            </div>

            <!-- Paso 3: Formulario para tutor -->
            <div v-if="currentStep === 'tutorForm'" class="text-center">
                <div class="mb-6">
                    <div class="w-16 h-16 bg-emerald-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-emerald-900 mb-2">Recuperación para Tutor</h2>
                    <p class="text-emerald-700 mb-6">Ingresa tu correo electrónico</p>
                </div>

                <div class="mb-6">
                    <input
                        v-model="email"
                        type="email"
                        placeholder="correo@ejemplo.com"
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-transparent"
                        required
                    >
                </div>

                <div class="space-y-3">
                    <button
                        @click="sendRecoveryEmail"
                        :disabled="!email"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 disabled:cursor-not-allowed text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200"
                    >
                        Enviar
                    </button>

                    <button
                        @click="goToLogin"
                        class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200"
                    >
                        Regresar
                    </button>
                </div>
            </div>

            <!-- Paso 4: Mensaje de confirmación para tutor -->
            <div v-if="currentStep === 'tutorConfirmation'" class="text-center">
                <div class="mb-6">
                    <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-emerald-900 mb-4">¡Solicitud Enviada!</h2>
                </div>

                <div class="bg-emerald-50 border-l-4 border-emerald-600 p-4 mb-6">
                    <p class="text-emerald-800 leading-relaxed">
                        En breve te haremos llegar información sobre tu cuenta y el proceso para
                        recuperar acceso a ella a través de este correo electrónico.
                        <strong>¡Gracias por su paciencia y atención!</strong>
                    </p>
                </div>

                <button
                    @click="goToLogin"
                    class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200"
                >
                    Regresar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'

export default {
    name: 'PasswordRecovery',
    setup() {
        const currentStep = ref('userType')
        const selectedUserType = ref('')
        const email = ref('')

        const selectUserType = (userType) => {
            selectedUserType.value = userType

            if (userType === 'estudiante' || userType === 'profesor') {
                currentStep.value = 'studentProfessorMessage'
            } else if (userType === 'tutor') {
                currentStep.value = 'tutorForm'
            }
        }

        const sendRecoveryEmail = () => {
            if (email.value) {
                currentStep.value = 'tutorConfirmation'
            }
        }

        const goToLogin = () => {
            // Navegación usando Vue Router
            // this.$router.push('/login')

            // O usando window.location
            window.location.href = '/login'
        }

        return {
            currentStep,
            selectedUserType,
            email,
            selectUserType,
            sendRecoveryEmail,
            goToLogin
        }
    }
}
</script>

<style scoped>

</style>
