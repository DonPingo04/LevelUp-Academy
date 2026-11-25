<script setup>
    import {ref, computed} from 'vue'

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

    function obtenerToken(){
        return localStorage.getItem('auth_token') || sessionStorage.getItem('auth_token');
    }

    async function iniciarSesion() {
        error.value = '';
        if(!formularioValido.value){
            error.value = 'Datos incorrectos, intentalo de nuevo.';
            return;
        }

        cargando.value = true;


        try{
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

            if(!respuesta.ok){
                const mensajeValidacion = datos.errors
                ? Object.values(datos.errors).flat().join(' ')
                : null;
                throw new Error(mensajeValidacion || datos.message || 'Credenciales incorrectas');
            }

            if (datos.token){
                const storage = recordar.value ? localStorage : sessionStorage;
                storage.setItem('auth_token', datos.token);
            }
            usuario.value = datos.user || null;
        }
        catch(err){
            error.value = err.message || 'No se pudo conectar con Laravel'
        }
        finally{
            cargando.value = false;
        }
    }

</script>
<template>
    
</template>