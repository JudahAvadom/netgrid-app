<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import axios from 'axios';

const modalCreateProject = ref(false)

const toggleModal = () => {
    modalCreateProject.value = !modalCreateProject.value;
};

const form = useForm({
    nombre: '',
    descripcion: '',
    fecha_inicio: '',
    fecha_finalizacion: ''
});

const createProject = async()=>{
    if (form.name === '') {
        console.log(form.nombre);
        alert("Por favor, rellene todos los campos")
    }
    else {
        await axios.post('/crearprojecto',{form})
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel de Control</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2">
                        <button @click="toggleModal" class="bg-green-400 p-1 rounded-lg text-white">+ Crear
                            proyecto</button>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="modalCreateProject" @close="toggleModal">
            <div class="m-2 flex flex-col">
                <span class="text-2xl">Crear tarea</span>
                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="nombre" value="Nombre" />

                        <TextInput
                            id="nombre"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.nombre"
                            required autofocus
                            autocomplete="nombre"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    <div>
                        <InputLabel for="descripcion" value="Descripcion" />

                        <TextInput
                            id="descripcion"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.descripcion"
                            required autofocus
                            autocomplete="descripcion"
                        />

                        <InputError class="mt-2" :message="form.errors.descripcion" />
                    </div>
                    <div>
                        <InputLabel for="fecha_inicio" value="Fecha de inicio" />

                        <TextInput
                            id="fecha_inicio"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.fecha_inicio"
                            required autofocus
                            autocomplete="fecha_inicio"
                        />

                        <InputError class="mt-2" :message="form.errors.fecha_inicio" />
                    </div>
                    <div>
                        <InputLabel for="fecha_inicio" value="Fecha de inicio" />

                        <TextInput
                            id="fecha_inicio"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.fecha_inicio"
                            required autofocus
                            autocomplete="fecha_inicio"
                        />

                        <InputError class="mt-2" :message="form.errors.fecha_inicio" />
                    </div>
                    <div>
                        <InputLabel for="fecha_finalizacion" value="Fecha de finalizacion" />

                        <TextInput
                            id="fecha_finalizacion"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.fecha_finalizacion"
                            required autofocus
                            autocomplete="fecha_finalizacion"
                        />

                        <InputError class="mt-2" :message="form.errors.fecha_finalizacion" />
                    </div>
                    <div>
                        <button @click="createProject" class="bg-green-500 rounded-lg text-white m-2 p-2">Crear</button>
                    </div>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
