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
  <!-- Dashboard dinámico según el rol tras iniciar sesión -->
  <div v-if="usuarioAutenticado" class="min-vh-100 bg-light">
    <nav class="navbar navbar-dark bg-dark px-3 px-md-4">
      <span class="navbar-brand mb-0 fw-semibold">
        LOGO
        <span class="badge bg-primary ms-2 text-uppercase">{{ rolUsuario || 'sin rol' }}</span>
      </span>
      <button @click="cerrarSesion" class="btn btn-outline-light btn-sm rounded-pill px-3">
        Cerrar sesión
      </button>
    </nav>

    <main class="container py-4">
      <component :is="dashboardActual" :usuario="usuarioAutenticado" />
    </main>
  </div>

  <!-- Pantalla de Login adaptada a Escritorio, Tablet y Móvil -->
  <main v-else class="login-bg d-flex align-items-center justify-content-center p-3 p-sm-4">
    <section class="login-card shadow-lg">
      <div class="logo-texto">LOGO</div>

      <form @submit.prevent="iniciarSesion" novalidate class="login-form">
        <div class="campo-grupo">
          <label for="usuario" class="etiqueta">Usuario:</label>
          <input
            id="usuario"
            v-model="usuarioInput"
            type="text"
            class="form-control input-pildora"
            autocomplete="username"
            required
          />
        </div>

        <div class="campo-grupo">
          <label for="password" class="etiqueta">Contraseña:</label>
          <input
            id="password"
            v-model="password"
            type="password"
            class="form-control input-pildora"
            autocomplete="current-password"
            required
          />
        </div>

        <div v-if="error" class="alert alert-danger py-2 px-3 rounded-4 small text-center mt-2 mb-0" role="alert">
          {{ error }}
        </div>

        <div class="d-flex justify-content-center mt-4">
          <button
            type="submit"
            class="btn btn-iniciar d-inline-flex align-items-center justify-content-center gap-2"
            :disabled="cargando || !formularioValido"
          >
            <span
              v-if="cargando"
              class="spinner-border spinner-border-sm"
              aria-hidden="true"
            ></span>
            {{ cargando ? 'Entrando...' : 'Iniciar sesión' }}
          </button>
        </div>
      </form>
    </section>
  </main>
</template>

<style scoped>
.login-bg {
  min-height: 100dvh;
  width: 100%;
  background: linear-gradient(155deg, #0047ff 0%, #0038d4 52%, #00238a 100%);
}

/* Escritorio / Tablet */
.login-card {
  width: 100%;
  max-width: 560px;
  background-color: #063832;
  border-radius: 36px;
  padding: 2.75rem 3rem 2.5rem;
  color: #ffffff;
}

.logo-texto {
  text-align: center;
  font-size: 2.25rem;
  font-weight: 400;
  letter-spacing: 0.04em;
  margin-bottom: 1.75rem;
  color: #ffffff;
}

.login-form {
  max-width: 340px;
  margin: 0 auto;
}

.campo-grupo {
  margin-bottom: 1.15rem;
}

.etiqueta {
  display: block;
  font-size: 0.95rem;
  color: #f3f4f6;
  margin-bottom: 0.4rem;
  padding-left: 0.35rem;
}

.input-pildora {
  height: 44px;
  border-radius: 999px;
  border: none;
  background-color: #ffffff;
  color: #111827;
  padding: 0.5rem 1.1rem;
  font-size: 0.95rem;
}

.input-pildora:focus {
  box-shadow: 0 0 0 3px rgba(173, 162, 232, 0.55);
}

.btn-iniciar {
  min-width: 190px;
  height: 40px;
  padding: 0 1.75rem;
  border-radius: 999px;
  border: none;
  background-color: #aba0e5;
  color: #111827;
  font-size: 0.95rem;
  font-weight: 500;
  transition: transform 0.15s ease, background-color 0.15s ease;
}

.btn-iniciar:hover:not(:disabled) {
  background-color: #988bd9;
  transform: translateY(-1px);
}

.btn-iniciar:disabled {
  background-color: #8c82c4;
  color: rgba(17, 24, 39, 0.65);
  cursor: not-allowed;
}

/* Ajuste móvil similar a "Login Movil" */
@media (max-width: 575.98px) {
  .login-card {
    max-width: 240px;
    border-radius: 28px;
    padding: 2rem 1.25rem 1.85rem;
  }

  .logo-texto {
    font-size: 1.4rem;
    margin-bottom: 1.25rem;
  }

  .login-form {
    max-width: 100%;
  }

  .etiqueta {
    font-size: 0.8rem;
    margin-bottom: 0.25rem;
    padding-left: 0.15rem;
  }

  .input-pildora {
    height: 30px;
    font-size: 0.8rem;
    padding: 0.25rem 0.75rem;
  }

  .btn-iniciar {
    min-width: 120px;
    height: 28px;
    padding: 0 1rem;
    font-size: 0.75rem;
  }
}
</style>