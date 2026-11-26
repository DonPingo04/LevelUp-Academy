<script setup>
import { ref } from 'vue'

defineProps({
    usuario: {
        type: Object,
        required: true
    },
    logo: {
        type: Image
    },
    mostrarFooter: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['cerrar-sesion', 'navegar']);

const menuAbierto = ref(false);
const submenus = ref({
    personas: false,
    academico: false,
    configuracion: false
})

function toggleSubmenu(clave) {
    submenus.value[clave] = !submenus.value[clave];
}

function seleccionarSeccion(seccion) {
    menuAbierto.value = false;
    emit('navegar', seccion);
}
</script>

<template>
    <div class="layout-shell min-vh-100 d-flex flex-column text-white">
        <header class="topbar d-flex align-items-center justify-content-between px-3 px-lg-4">
            <div class="d-flex align-items-center gap-3">
                <button
                type="button"
                class="btn btn-link text-white p1 d-lg-none border-0"
                ></button>
            </div>
        </header>
    </div>
</template>