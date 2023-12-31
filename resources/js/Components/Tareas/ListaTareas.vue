<script setup>
import { onMounted, onUpdated, ref } from 'vue';
import Sortable from 'sortablejs';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import FlechaArriba from '../FlechaArriba.vue';
import FlechaAbajo from '../FlechaAbajo.vue'

const tareas = ref()
const modalEditarTarea = ref(false)
const nombreTarea = ref()
const descripcionTarea = ref()
const table = ref(false)
const fechaMayor = ref(false)

const props = defineProps({
    id: {
        type: Number,
        default: false,
        required: true
    }
});

const form = useForm({
    id: '',
    nombre: '',
    estado: '',
    descripcion: ''
});

const toggleModal = (id, nombre, descripcion) => {
    modalEditarTarea.value = !modalEditarTarea.value;
    nombreTarea.value = nombre;
    descripcionTarea.value = descripcion;
    form.id = id;
    form.nombre = nombre;
    form.descripcion = descripcion;
};

const consultar = async () => {
    const { data } = await axios.post('/consultartareas', {
        proyecto_id: props.id
    })
    if (data.length > 0) {
        tareas.value = data
        table.value = true
    }
}

onUpdated(async () => {
    if (table.value && tareas.value.length > 0) {
        await sort()
    }
})

const actualizarTarea = async () => {
    if (form.estado == "") {
        alert("Defina el estado de la tarea")
    }
    else {
        const { data } = await axios.put('/actualizartarea', {
            id: form.id,
            nombre: form.nombre,
            descripcion: form.descripcion,
            estado: form.estado
        })
        if (data == 'SUCCESS') {
            location.reload();
        }
    }
}

const sort = async () => {
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
}

const eliminarTarea = async () => {
    const { data } = await axios.delete('/eliminartarea/' + form.id)
    if (data == 'SUCCESS') {
        location.reload();
    }
}

const ordenarFecha = async (orden) => {
    fechaMayor.value = !fechaMayor.value
    const { data } = await axios.post('/ordentareas', {
        orden
    })
    tareas.value = data;
}

onMounted(() => {
    consultar();
})

</script>

<template>
    <div class="py-2" v-if="tareas">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a title="Ordenar por fecha" class="p-2 flex" @click="ordenarFecha('ASC')" v-if="fechaMayor">
                    <FlechaArriba /> Ordenar por fecja de creacion de mayor a menor
                </a>
                <a title="Ordenar por fecha" class="p-2 flex" @click="ordenarFecha('DESC')" v-else>
                    <FlechaAbajo /> Ordenar por fecja de creacion de menor a mayor
                </a>
                <div class="p-2 flex">
                    <div>
                        <span class="text-xl px-2 flex items-center">Por hacer </span>
                        <ul id="todo" v-for="tareas in tareas">
                            <div class="item">
                                <div class="bg-slate-200 p-2 m-2 rounded-lg" v-if="tareas.estado == 'todo'">
                                    <span class="text-lg">{{ tareas.nombre }}</span>
                                    <div>{{ tareas.descripcion }}</div>
                                    <div class="text-sm">Fecha de creacion</div>
                                    <div class="text-sm text-slate-700">{{ tareas.created_at }}</div>
                                    <div><button @click="toggleModal(tareas.id, tareas.nombre, tareas.descripcion)"
                                            class="text-sm bg-slate-400 p-1 rounded-lg">Editar</button></div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div>
                        <span class="text-xl px-2">En progreso</span>
                        <ul id="progress" v-for="tareas in tareas">
                            <div class="item">
                                <div class="bg-slate-200 p-2 m-2 rounded-lg" v-if="tareas.estado == 'progress'">
                                    <span class="text-lg">{{ tareas.nombre }}</span>
                                    <div>{{ tareas.descripcion }}</div>
                                    <div><button @click="toggleModal(tareas.id, tareas.nombre, tareas.descripcion)"
                                            class="text-sm bg-slate-400 p-1 rounded-lg">Editar</button></div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div>
                        <span class="text-xl px-2">En revision</span>
                        <ul id="progress" v-for="tareas in tareas">
                            <div class="item">
                                <div class="bg-slate-200 p-2 m-2 rounded-lg" v-if="tareas.estado == 'review'">
                                    <span class="text-lg">{{ tareas.nombre }}</span>
                                    <div>{{ tareas.descripcion }}</div>
                                    <div><button @click="toggleModal(tareas.id, tareas.nombre, tareas.descripcion)"
                                            class="text-sm bg-slate-400 p-1 rounded-lg">Editar</button></div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div>
                        <span class="text-xl px-2">Completada</span>
                        <ul id="progress" v-for="tareas in tareas">
                            <div class="item">
                                <div class="bg-slate-200 p-2 m-2 rounded-lg" v-if="tareas.estado == 'completed'">
                                    <span class="text-lg">{{ tareas.nombre }}</span>
                                    <div>{{ tareas.descripcion }}</div>
                                    <div><button @click="toggleModal(tareas.id, tareas.nombre, tareas.descripcion)"
                                            class="text-sm bg-slate-400 p-1 rounded-lg">Editar</button></div>
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
                <TextInput id="nombre" type="text" class="mt-1 block w-full" v-model="form.nombre"
                    :defaultValue="nombreTarea" required autofocus autocomplete="nombre" />
                <InputError class="mt-2" :message="form.errors.nombre" />
            </div>
            <div>
                <InputLabel for="descripcion" value="Descripcion" />
                <TextInput id="nombre" type="text" class="mt-1 block w-full" v-model="form.descripcion"
                    :defaultValue="descripcionTarea" required autofocus autocomplete="descripcion" />
                <InputError class="mt-2" :message="form.errors.descripcion" />
            </div>
            <div>
                <InputLabel for="estado" value="Estado" />
                <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    v-model="form.estado" required>
                    <option value="todo">Por hacer</option>
                    <option value="progress">En progreso</option>
                    <option value="review">En revision</option>
                    <option value="completed">Completada</option>
                </select>
            </div>
            <div class="my-2">
                <button @click="actualizarTarea" class="bg-green-500 text-white p-2 rounded-md mr-2">Actualizar
                    tarea</button>
                <button @click="eliminarTarea" class="bg-red-500 text-white p-2 rounded-md">Eliminar tarea</button>
            </div>
        </div>
    </Modal>
</template>
