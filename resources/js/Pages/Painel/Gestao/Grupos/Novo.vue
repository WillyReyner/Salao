<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router} from '@inertiajs/vue3';
import { Notify } from 'quasar';

const props = defineProps({
    permissions: {
        type: Array,
        default: [],
    }
});

const form = useForm({
    id: '',
    name: '',
    permissions: [],
})

function store(){
    
    form.post(route('painel.gestao.grupos.store'), {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            showModal.value = false
            Notify.create({
                message: "Grupo registrado com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível registrar o grupo.",
                color: "negative"
            })
        }
    })
}

</script>

<template>
    <Head title="Grupos" />
    
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">Cadastrar Grupo</h4>
                    <span @click="store()" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-gray-600 focus:tw-bg-gray-600 active:tw-bg-gray-600 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
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

                                    
                                    <div class="tw-py-2 tw-px-1 tw-flex tw-flex-1 tw-justify-around">

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
