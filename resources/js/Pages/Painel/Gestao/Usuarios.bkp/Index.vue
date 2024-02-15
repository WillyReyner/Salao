<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm} from '@inertiajs/vue3';
import { ref } from 'vue';
import { Dialog, Notify } from 'quasar'
import TableUsuarios from '@/Components/Pages/TableUsuarios.vue';
import { Icon } from '@iconify/vue';

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
    roles:[],
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
                    message: "Não foi possível remover esse usuário.",
                    color: "negative"
                })
            }
        })
    })
}


</script>

<template>
    <Head title="Usuários" />
    
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex  md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">Controle de Usuários</h4>
                    <Link :href="route('painel.gestao.usuarios.create')">
                        <PrimaryButton class="tw-text-white tw-bg-blue-500 tw-items-center">
                            <Icon icon="icon-park-outline:add" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" /> 
                            ADICIONAR USUÁRIO
                        </PrimaryButton>
                    </Link>
                </div>
                <TableUsuarios :usuarios="props.usuarios"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
