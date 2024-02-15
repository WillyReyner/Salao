<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router} from '@inertiajs/vue3';
import { Notify } from 'quasar';

const props = defineProps({
    usuario: {
        type: Object,
        default: {},
    },
    roles: {
        type: Array,
        default: [],
    },
    permissions: {
        type: Array,
        default: [],
    }
});

const form = useForm({
    id: props.usuario.id,
    name: props.usuario.name,
    email: props.usuario.email,
    password: '',
    roles: props.usuario.roles.map(role => role.name) || [],
    permissions: props.usuario.permissions.map(perm => perm.name)|| [],
})


function update(){
    router.post(route('painel.gestao.usuarios.update', form.id), {
        _method: 'patch',
        ...form
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            showModal.value = false
            Notify.create({
                message: "Dados do usuário atualizados com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível atualizar os dados do usuário.",
                color: "negative"
            })
        }
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
                    <span @click="update()" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-gray-600 focus:tw-bg-gray-600 active:tw-bg-gray-600 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
                        <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" /> 
                        Salvar
                    </span>
                </div>
                <div class="tw-antialiased tw-font-sans">
                    <div class="tw-container tw-mx-auto">
                        <div class="tw-py-8">
                            <div class="-tw-mx-4 sm:-tw-mx-8 tw-px-4 sm:tw-px-8 tw-py-4 tw-overflow-x-auto">
                                <div class="tw-inline-block tw-min-w-full tw-shadow tw-rounded-lg tw-overflow-hidden">


                                    <q-input outlined stack-label v-model="form.name" label="Nome" 
                                        :error-message="form.errors.name"
                                        :error="!!form.errors.name"
                                    />
                                    <div class="tw-flex tw-flex-1 tw-flex-col tw-gap-2 lg:tw-flex-row">

                                        <q-input class="tw-flex tw-flex-1" outlined stack-label v-model="form.email" label="Email" 
                                            :error-message="form.errors.email"
                                            :error="!!form.errors.email"
                                        />
                                        <q-input class="tw-flex tw-flex-1" outlined type="password" stack-label v-model="form.password" label="Senha" 
                                            :error-message="form.errors.password"
                                            :error="!!form.errors.password"
                                        />
                                    </div>

                                    <div class="tw-py-2 tw-px-1 tw-flex tw-flex-1 tw-flex-col">
                                        <h5>Grupos de Acesso:</h5>
                                        <div class="q-gutter-sm">
                                            <q-checkbox :indeterminate-value="false" v-for="role, key of props.roles" v-model="form.roles" :val="role.name" :label="role.name" color="teal" />
                                        </div>
                                    </div>
                                    
                                    <div class="tw-py-2 tw-px-1 tw-flex tw-flex-1 tw-flex-col">
                                        <h5>Permissões extras: </h5>
                                        <div class="q-gutter-sm">
                                            <q-checkbox :indeterminate-value="false" v-for="perm, key of props.permissions" v-model="form.permissions" :val="perm.name" :label="perm.name" color="teal" />
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
