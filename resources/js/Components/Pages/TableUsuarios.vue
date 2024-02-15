<script setup>
import {Link, useForm} from '@inertiajs/vue3'
import { Dialog, Notify } from 'quasar'
import {ref} from 'vue'


const props = defineProps({
    usuarios: {
        type: Array,
        default: [],
    },
});

const usuarioData = ref({});

const showInfoModal = ref(false)

function openInfoModal(data = []){
    showInfoModal.value = true
    usuarioData.value = data
}

const form = useForm({
    id: '',
    name: '',
    roles: [],
    permissions: [],
})

function confirmRemoving(data){
    Dialog.create({
        title: '<h5>Confirmação</h5>',
        message: `<p>Você deseja realmente remover o usuário <b>${data.name}</b>?</p>`,
        cancel: true,
        persistent: true,
        html: true
    }).onOk(() => {
        form.delete(route('painel.gestao.usuarios.destroy', data.id), {
            preserveScroll: true,
            onSuccess: (res) => {
                showModal.value = false
                Notify.create({
                    message: "Usuário removido com sucesso.",
                    color: "secondary"
                })
            },
            onError: (err) => {
                Notify.create({
                    message: "Não foi possível remover esse Usuário.",
                    color: "negative"
                })
            }
        })
    })
}

</script>

<template>

    <q-dialog v-model="showInfoModal">
        <q-card style="min-width: 40vw; max-width: 90vw;">
            <q-card-section>
            <div class="tw-text-2xl">Informações do Usuário</div>
            </q-card-section>
            <q-card-section class="q-pt-none">
                <div class="tw-flex tw-flex-col tw-gap-2">
                    <p>Nome: {{ usuarioData.name }}</p>
                    

                    <ul v-if="usuarioData.roles.length">
                        <h6>Grupos: </h6>
                        <li v-for="role, key of usuarioData.roles" :key="key">
                            {{ role.id }} - {{ role.name }}
                        </li>
                    </ul>

                    <ul v-if="usuarioData.permissions.length">
                        <h6>Permissões: </h6>
                        <li v-for="perm, key of usuarioData.permissions" :key="key">
                            {{ perm.id }} - {{ perm.name }}
                        </li>
                    </ul>
                    
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn label="Fechar" color="dark" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
        
<div class="tw-antialiased tw-font-sans">
    <div class="tw-container tw-mx-auto">
        <div class="tw-py-8">
        
            <div class="-tw-mx-4 sm:-tw-mx-8 tw-px-4 sm:tw-px-8 tw-py-4 tw-overflow-x-auto">
                <div class="tw-inline-block tw-min-w-full tw-shadow tw-rounded-lg tw-overflow-hidden">
                    <table class="tw-min-w-full tw-leading-normal">
                        <thead>
                            <tr>
                                <th
                                    class="tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider">
                                    Nome
                                </th>
                                <th
                                    class="tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider">
                                    Grupo(s)
                                </th>
                                <th
                                    class="tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider">
                                    Adicionado em
                                </th>
                                <th
                                    class="tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="usuario, key of props.usuarios" :key="key">
                                <td class="tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm">
                                    <div class="tw-flex tw-items-center">
                                        <div class="tw-flex-shrink-0 tw-w-10 tw-h-10">
                                            <img class="tw-w-full tw-h-full tw-rounded-full"
                                                src="https://t3.ftcdn.net/jpg/05/16/27/58/360_F_516275801_f3Fsp17x6HQK0xQgDQEELoTuERO4SsWV.jpg"
                                                alt="" />
                                        </div>
                                        <div class="tw-ml-3">
                                            <p class="tw-text-gray-900 tw-whitespace-no-wrap tw-items-center">
                                                {{ usuario.name }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm">
                                    <p class="tw-text-gray-900 tw-whitespace-no-wrap">{{ usuario.roles.map(role => role.name).toString() }}</p>
                                </td>
                                <td class="tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm">
                                    <p class="tw-text-gray-900 tw-whitespace-no-wrap">
                                        {{ usuario.created_at}}
                                    </p>
                                </td>
                                <td class="tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm">
                                    <span
                                        class="tw-relative tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-green-900 tw-leading-tight">
                                        <span aria-hidden
                                            class="tw-absolute tw-inset-0 tw-bg-green-200 tw-opacity-50 tw-rounded-full"></span>
                                        <span class="tw-relative">Ativo</span>
                                    </span>
                                </td>
                                <td class="tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm">
                                    <span @click="openInfoModal(usuario)"
                                        class="tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-gray-900 tw-leading-tight">
                                        <span aria-hidden
                                            class="tw-absolute tw-inset-0 tw-bg-slate-200 tw-opacity-50 tw-rounded-full"></span>
                                        <span class="tw-relative">Detalhar</span>
                                    </span>
                                    <Link :href="route('painel.gestao.usuarios.editar', usuario.id)"
                                        class="tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-blue-900 tw-leading-tight">
                                        <span aria-hidden class="tw-absolute tw-inset-0 tw-bg-blue-200 tw-opacity-50 tw-rounded-full"></span>
                                        <span class="tw-relative">Editar</span>
                                    </Link>
                                    <span @click="confirmRemoving(usuario)"
                                        class="tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-red-900 tw-leading-tight">
                                        <span aria-hidden
                                            class="tw-absolute tw-inset-0 tw-bg-red-200 tw-opacity-50 tw-rounded-full"></span>
                                        <span class="tw-relative">Deletar</span>
                                    </span>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</template>