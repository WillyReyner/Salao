<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm} from '@inertiajs/vue3';
import { ref } from 'vue';
import { Dialog, Notify } from 'quasar'
import { Icon } from '@iconify/vue';

const props = defineProps({
    roles: {
        type: Array,
        default: [],
    },
    permissions: {
        type: Array,
        default: [],
    }
});

const roleData = ref({});

const showInfoModal = ref(false)

function openInfoModal(data = []){
    showInfoModal.value = true
    roleData.value = data
}

const form = useForm({
    id: '',
    name: '',
    permissions: [],
})

function confirmRemoving(data){
    Dialog.create({
        title: '<h5>Confirmação</h5>',
        message: `<p>Você deseja realmente remover o grupo <b>${data.name}</b>?</p>`,
        cancel: true,
        persistent: true,
        html: true
    }).onOk(() => {
        form.delete(route('painel.gestao.grupos.destroy', data.id), {
            preserveScroll: true,
            onSuccess: (res) => {
                showModal.value = false
                Notify.create({
                    message: "Grupo removido com sucesso.",
                    color: "secondary"
                })
            },
            onError: (err) => {
                Notify.create({
                    message: "Não foi possível remover esse grupo.",
                    color: "negative"
                })
            }
        })
    })
}


</script>

<template>
    <Head title="Grupos" />
    
    <AuthenticatedLayout>

        <q-dialog v-model="showInfoModal">
            <q-card style="min-width: 40vw; max-width: 90vw;">
                <q-card-section>
                <div class="tw-text-2xl">Informações do Grupo</div>
                </q-card-section>
                <q-card-section class="q-pt-none">
                    <div class="tw-flex tw-flex-col tw-gap-2">
                        <p>Nome: {{ roleData.name }}</p>
                        
                        <ul v-if="roleData.permissions.length">
                            <h6>Permissões: </h6>
                            <li v-for="perm, key of roleData.permissions" :key="key">
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

        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">Controle de Usuários</h4>
                    <Link :href="route('painel.gestao.grupos.create')">
                        <PrimaryButton class="tw-text-white tw-bg-blue-500 tw-items-center">
                            <Icon icon="icon-park-outline:add" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" /> 
                            ADICIONAR GRUPO
                        </PrimaryButton>
                    </Link>
                </div>
            
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
                            Ações
                            </th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role, index of props.roles" :key="index">
                            <td class="tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm">
                                <div class="tw-flex tw-items-center">
                                    <div class="tw-ml-3">
                                        <p class="tw-text-gray-900 tw-whitespace-no-wrap tw-items-center">
                                            {{ role.name }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm">
                                <span @click="openInfoModal(role)"
                                    class="tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-gray-900 tw-leading-tight">
                                    <span aria-hidden
                                        class="tw-absolute tw-inset-0 tw-bg-slate-200 tw-opacity-50 tw-rounded-full"></span>
                                    <span class="tw-relative">Detalhar</span>
                                </span>
                                <Link :href="route('painel.gestao.grupos.editar', role.id)"
                                    class="tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-blue-900 tw-leading-tight">
                                    <span aria-hidden class="tw-absolute tw-inset-0 tw-bg-blue-200 tw-opacity-50 tw-rounded-full"></span>
                                    <span class="tw-relative">Editar</span>
                                </Link>
                                <span @click="confirmRemoving(role)"
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
</AuthenticatedLayout>
</template>
