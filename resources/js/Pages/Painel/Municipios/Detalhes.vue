<template>
    <Head title="Municipios" />
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
                <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class="tw-font-title tw-font-semibold">Visualizar Município</h4>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nome" value="Nome" />
                        <q-input
                            disable
                            outlined
                            id="nome" 
                            type="text" 
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.nome"
                        />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="uf" value="UF"/>
                        <q-input 
                            disable
                            outlined
                            id="uf" 
                            type="text" 
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.uf"
                        />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="situacao" value="Situação"/>
                        <q-input
                            disable
                            outlined
                            id="situacao" 
                            type="text" 
                            disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.situacao"
                        />
                    </div>
                    </div>
                </div>
                <br/>
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.municipios')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                        VOLTAR
                    </Link>
                    <Link :href="route('painel.municipios.editar', form.id)" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
                        EDITAR
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router, Link} from '@inertiajs/vue3';
import { Notify, Dialog } from 'quasar';
import { ref } from 'vue'
import { Icon } from '@iconify/vue'
import InputLabel from '@/Components/Pages/InputLabel.vue';

const props = defineProps({
    municipio: {
        type: Object,
        default: {}
    }
})

const form = useForm({
    id: props.municipio.id,
    nome: props.municipio.nome,
    uf: props.municipio.uf,
    situacao: props.municipio.situacao
})

</script>
