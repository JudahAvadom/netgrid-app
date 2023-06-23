<script setup>
import { onMounted, ref } from 'vue';
// import Sortable from 'sortablejs';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';

const tareas = ref()
const modalEditarTarea = ref(false)
const nombreTarea = ref()
const descripcionTarea = ref()

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

const toggleModal = (nombre,descripcion) => {
    modalEditarTarea.value = !modalEditarTarea.value;
    nombreTarea.value = nombre;
    descripcionTarea.value = descripcion;
};

const consultar = async () => {
    const { data } = await axios.post('/consultartareas', {
        proyecto_id: props.id
    })
    if (data.length > 0) {
        tareas.value = data
        // sort()
    }
}

const actualizarTarea = ()=>{
    axios.put('/actualizartarea')
}

/*const sort = async () => {
    try {
        var el = document.getElementById('todo');
        var progress = document.getElementById('progress');
        new Sortable(el, {
            draggable: ".item",
            group: 'shared',
            animation: 150
        });
        new Sortable(progress, {
            draggable: ".item",
            group: 'shared',
            animation: 150
        });
    } catch (error) {
    }
}*/

onMounted(() => {
    consultar();
})

</script>

<template>
    <div class="py-2" v-if="tareas">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 flex">
                    <div>
                        <span class="text-xl px-2">Por hacer</span>
                        <ul id="todo" v-for="tareas in tareas">
                            <div class="item">
                                <div class="bg-slate-200 p-2 m-2 rounded-lg" v-if="tareas.estado == 'todo'">
                                    <span class="text-lg">{{ tareas.nombre }}</span>
                                    <div>{{ tareas.descripcion }}</div>
                                    <div><button @click="toggleModal(tareas.nombre, tareas.descripcion)" class="text-sm bg-slate-400 p-1 rounded-lg">Editar</button></div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div>
                        <span class="text-xl px-2">En progreso</span>
                        <ul id="progress">
                            <div class="item">
                                <div class="bg-slate-200 p-2 m-2 rounded-lg" v-if="tareas.estado == 'En progreso'">
                                    <span class="text-lg">{{ tareas.nombre }}</span>
                                    <div>descripcion</div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal :show="modalEditarTarea" @close="toggleModal">
        <div class="p-2" v-if="nombreTarea">
            <h3>Editar tarea</h3>
            <div>
                <InputLabel for="nombre" value="Nombre" />
                <TextInput
                    id="nombre"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.nombre"
                    :value="nombreTarea"
                    required autofocus
                    autocomplete="nombre"
                />
                <InputError class="mt-2" :message="form.errors.nombre" />
            </div>
            <div>
                <InputLabel for="descripcion" value="Descripcion" />
                <TextInput
                    id="nombre"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.descripcion"
                    :value="descripcionTarea"
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
                    <option value="todo">Por hacer</option>
                    <option value="progress">En progreso</option>
                </select>
            </div>
            <div class="my-2">
                <button @click="actualizarTarea" class="bg-green-500 text-white p-2 rounded-md">Actualizar tarea</button>
            </div>
        </div>
    </Modal>
</template>
