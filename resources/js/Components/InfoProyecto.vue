<script setup>
import { onMounted, ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

const modalCrearTarea = ref(false)

const props = defineProps({
    id: {
        type: Number,
        default: false,
        required: true
    }
});


const form = useForm({
    id: props.id,
    nombre: '',
    estado: '',
    descripcion: ''
});

const toggleModal = () => {
    modalCrearTarea.value = !modalCrearTarea.value;
};

onMounted(()=>{
})

const crearTarea = async() =>{
    console.log(form);
    if (form.nombre != '' && form.estado != '') {
        const { data } = await axios.post('/creartarea',{
            proyecto_id: form.id,
            nombre: form.nombre,
            estado: form.estado,
            descripcion: form.descripcion
        })
        if (data=='SUCCESS') {
            location.reload();
        }
    }
}

</script>

<template>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <button @click="toggleModal" class="bg-green-400 text-white rounded-md p-1 m-2">+ Crear tarea</button>
            </div>
        </div>
    </div>
    <Modal :show="modalCrearTarea" @close="toggleModal">
        <div class="m-2">
            <h3>Crear tarea</h3>
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
                    <InputError class="mt-2" :message="form.errors.nombre" />
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
                    <InputLabel for="estado" value="Estado" />
                    <select
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.estado"
                        required
                    >
                        <option value=""></option>
                        <option value="todo">Por hacer</option>
                        <option value="progress">En progreso</option>
                        <option value="review">En revision</option>
                        <option value="completed">Completada</option>
                    </select>
                </div>
                <div class="my-2">
                    <button @click="crearTarea" class="bg-green-500 text-white p-2 rounded-md">Crear tarea</button>
                </div>
            </form>
        </div>
    </Modal>
</template>
