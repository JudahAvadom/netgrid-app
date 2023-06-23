<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted } from 'vue';
import InfoProyecto from "@/Components/InfoProyecto.vue";
import ListaTareas from '@/Components/Tareas/ListaTareas.vue'

var param = window.location.href.split('?').pop();
var id = param.split('=')[1]
console.log(id);

onMounted(() => {
})
</script>

<template>
    <Head title="Proyecto" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ver proyecto</h2>
        </template>
        <InfoProyecto :id=id />
        <ListaTareas :id=id />
    </AuthenticatedLayout>
</template>
