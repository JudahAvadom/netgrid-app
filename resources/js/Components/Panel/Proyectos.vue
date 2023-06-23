<script setup>
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const proyectos = ref(null)

const consultarProyectos = async()=>{
    const {data} = await axios.get('/consultarproyecto');
    console.log(data);
    proyectos.value = data;
}

const eliminarProyecto = async(id) =>{
    const {data} = await axios.delete(`/eliminarproyecto/${id}`)
    console.log(data);
    if (data == 'SUCCESS') {
        location.reload()
    }
}

onMounted(()=>{
    consultarProyectos()
})
</script>

<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg my-2" v-if="proyectos">
        <div class="p-2">
            <h3>Tareas asignadas</h3>
            <table>
                <thead>
                    <tr>
                        <td class="font-medium px-2">Nombre</td>
                        <td class="font-medium px-2">Descripcion</td>
                        <td class="font-medium px-2">Fecha de inicio</td>
                        <td class="font-medium px-2">Fecha de finalizacion</td>
                        <td class="font-medium px-2"></td>
                        <td class="font-medium px-2"></td>
                    </tr>
                </thead>
                <tbody v-for="proyectos in proyectos">
                    <tr>
                        <td class="px-2">{{ proyectos.nombre }}</td>
                        <td class="px-2">{{ proyectos.descripcion }}</td>
                        <td class="px-2">{{ proyectos.fecha_inicio }}</td>
                        <td class="px-2">{{ proyectos.fecha_finalizacion }}</td>
                        <td class="px-2">
                            <Link
                                :href="route(`proyecto`,`id=${proyectos.id}`)"
                                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                            >
                                <button class="bg-green-500 text-white p-2 rounded-md">Ver</button>
                            </Link>
                        </td>
                        <td>
                            <button @click="eliminarProyecto(proyectos.id )" class="bg-red-500 text-white p-2 rounded-md">Eliminar</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
