<script setup>
import { ref, computed } from 'vue'
import AdminDashboard from './components/AdminDashboard.vue'
import ProfesorDashboard from './ProfesorDashboard.vue';
import AlumnoDashboard from './AlumnoDashboard.vue';
import FamiliarDashboard from './FamiliarDashboard.vue';

const API_URL = 'http://127.0.0.1:8000/api';

const username = ref('');
const password = ref('');
const recordar = ref(false);
const mostrarPassword = ref(false);

const cargando = ref(false);
const error = ref('');
const usuario = ref(null)

const formularioValido = computed(() => {
    return password.value.length >= 8;
})

const rolUsuario = computed(() => {
    return (usuario.value?.rol || '').toString().trim().toLowerCase();
})

const dashBoardActual = computed(() => {
    switch (rolUsuario) {
        case 'secretaria':
            return AdminDashboard
        case 'profesor':
            return ProfesorDashboard
        case 'alumno':
            return AlumnoDashboard
        case 'familiar':
            return FamiliarDashboard
    }
});

function obtenerToken() {
    return localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
}

async function iniciarSesion() {
    error.value = '';
    if (!formularioValido.value) {
        error.value = 'Datos incorrectos, intentalo de nuevo.';
        return;
    }

    cargando.value = true;


    try {
        const respuesta = await fetch(`${API_URL}/login`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                username: username.value.trim(),
                password: password.value
            })
        });

        const datos = await respuesta.json();

        if (!respuesta.ok) {
            const mensajeValidacion = datos.errors
                ? Object.values(datos.errors).flat().join(' ')
                : null;
            throw new Error(mensajeValidacion || datos.message || 'Credenciales incorrectas');
        }

        if (datos.token) {
            const storage = recordar.value ? localStorage : sessionStorage;
            storage.setItem('auth_token', datos.token);
        }
        usuario.value = datos.user || null;
    }
    catch (err) {
        error.value = err.message || 'No se pudo conectar con Laravel'
    }
    finally {
        cargando.value = false;
    }
}

async function cerrarSesion() {
    const token = obtenerToken();

    try {
        if (token) {
            await fetch(`${API_URL}/logout`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
        }
    }
    finally {
        localStorage.removeItem('auth_token');
        sessionStorage.removeItem('auth_token');
        usuario.value = null;
        password.value = '';
    }
}
</script>
<template>
    <div v-if="usuario !== null">
        <{{ dashBoardActual }} />
    </div>
    <div v-else>
        <form action="post" class="login-wrapper">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
            <label for="password">Contraseña:</label>
            <input v-model="password" :type="mostrarPassword ? 'text' : 'password'" name="password" id="password">
            <input type="submit" value="Enviar">
        </form>
    </div>
</template>