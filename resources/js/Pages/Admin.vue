<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useForm } from '@inertiajs/vue3';

const lista = ref()
const modalEditar = ref(false)
const idUsuario = ref()

const form = useForm({
    role: '',
});

const listaUsuarios = async () => {
    const { data } = await axios.get('/listausuarios')
    lista.value = data
    console.log(lista.value);
}

const eliminarUsuario = async(id) => {
    const {data} = await axios.post('/editarusuario',{
        id
    })
    if (data=='SUCCESS') {
        location.reload();
    }
}

const actualizarUsuario = async() => {
    if (form.role != '') {
        const {data} = await axios.post('/editarusuario',{
            id:idUsuario.value,
            role:form.role
        })
        if (data=='SUCCESS') {
            location.reload();
        }
    }
}

const toggleModal = (id) => {
    idUsuario.value = id
    modalEditar.value = !modalEditar.value
}

onMounted(() => {
    listaUsuarios()
})
</script>

<template>
    <Head title="Panel de administracion" />
    <AuthenticatedLayout>
        <div class="py-2" v-if="lista">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-2 flex flex-col">
                        <h3>Tareas asignadas</h3>
                        <table>
                            <thead>
                                <tr>
                                    <td class="font-medium px-2">Nombre</td>
                                    <td class="font-medium px-2">Correo</td>
                                    <td class="font-medium px-2">Rol</td>
                                    <td class="font-medium px-2"></td>
                                    <td class="font-medium px-2"></td>
                                </tr>
                            </thead>
                            <tbody v-for="lista in lista">
                                <tr>
                                    <td class="px-2">{{ lista.name }}</td>
                                    <td class="px-2">{{ lista.email }}</td>
                                    <td class="px-2">{{ lista.role }}</td>
                                    <td>
                                        <button @click="toggleModal(lista.id )" class="bg-green-500 text-white p-2 rounded-md">Modificar</button>
                                    </td>
                                    <td>
                                        <button @click="eliminarUsuario(lista.id )" class="bg-red-500 text-white p-2 rounded-md">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="modalEditar" @close="toggleModal">
            <div class="p-2" v-if="idUsuario">
                <h3>Editar usuario</h3>
                <div>
                    <InputLabel for="rol" value="Rol" />
                   <select
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.role"
                        required
                    >
                        <option value=""></option>
                        <option value="admin">Administrador</option>
                        <option value="users">Empleado</option>
                    </select>
                </div>
                <div class="my-2">
                    <button @click="actualizarUsuario" class="bg-green-500 text-white p-2 rounded-md mr-2">Aceptar</button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
