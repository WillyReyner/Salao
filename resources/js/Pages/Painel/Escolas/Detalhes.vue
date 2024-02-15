<template>
    <Head title="Unidades" />
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div
                class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
                <div
                    class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">Atualizar Unidade</h4>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nome" value="Nome" required />
                        <q-input outlined id="nome" type="text" required autofocus autocomplete="nome"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.nome" />
                        <InputError class="tw-mt-2" :message="form.errors.nome" />
                    </div>
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="situacao" value="Situação" required />
                        <q-select outlined :options="opcoesStatus" v-model="form.situacao" id="situacao"
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                        <InputError class="tw-mt-2" :message="form.errors.situacao" />
                    </div>
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="rede" value="Rede" required />
                        <q-select outlined :options="opcoesRede" v-model="form.rede" id="rede"
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                        <InputError class="tw-mt-2" :message="form.errors.rede" />
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="municipio_id" value="Municipio" required />
                        <q-select outlined stack-label map-options emit-value :options="municipiosList"
                            v-model="form.municipio_id" id="municipio_id"
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                        <InputError class="tw-mt-2" :message="form.errors.municipio_id" />
                    </div>
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="contato" value="Contato" required />
                        <input id="contato" type="text" required autofocus autocomplete="contato"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.contato" />
                        <InputError class="tw-mt-2" :message="form.errors.contato" />
                    </div>
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="ficha" value="Ficha" required />
                        <input id="ficha" type="text" required autofocus autocomplete="ficha"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.ficha" />
                        <InputError class="tw-mt-2" :message="form.errors.ficha" />
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="user_id" value="Responsáveis" required />
                        <q-select name="user_id" outlined multiple stack-label map-options emit-value
                            :options="responsaveisList" v-model="form.user_id"
                            input-class="tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            label="Responsáveis pela Escola" :error-message="form.errors.user_id"
                            :error="!!form.errors.user_id">
                            <template v-slot:prepend>
                                <Icon icon="ph:chalkboard-teacher-light" />
                            </template>
                        </q-select>
                        <InputError class="tw-mt-2" :message="form.errors.user_id" />
                    </div>
                    <div disabled class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="endereco_completo" value="Endereço Completo" required />
                        <q-input outlined id="endereco_completo" type="text" required autofocus
                            autocomplete="endereco_completo"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.endereco_completo" />
                        <InputError class="tw-mt-2" :message="form.errors.endereco_completo" />
                    </div>
                </div>
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.escolas')"
                        class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                    VOLTAR
                    </Link>
                    <Link :href="route('painel.escolas.editar', form.id) " class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
                        EDITAR
                    </Link>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { Notify } from 'quasar';

const props = defineProps({
    escola: {
        type: Object,
        default: {}
    },
    municipios: {
        type: Array,
        default: []
    },
    usuarios: {
        type: Array,
        default: []
    }
})

const form = useForm({
    id: props.escola.id,
    nome: props.escola.nome,
    situacao: props.escola.situacao,
    rede: props.escola.rede,
    ficha: props.escola.ficha,
    endereco_completo: props.escola.endereco_completo,
    contato: props.escola.contato,
    municipio_id: props.escola.municipio_id,
    user_id: props.escola.user_id ? [props.escola.user_id] : [],
})

const opcoesRede = ['COTEC', 'EFG', 'GOIAS TEC', 'JUVENTUDE']
const opcoesStatus = ['Ativo', 'Bloqueado', 'Inativo']
const responsaveisList = props.usuarios.map(resp => ({ label: resp.name, value: resp.id }))
const municipiosList = props.municipios.map(muni => ({ label: muni.nome, value: muni.id }))

function update() {
    
    router.post(route('painel.escolas.update', form.id), {
        _method: 'patch',
        ...form
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Dados da unidade/escolas foram atualizados com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível atualizar os dados da unidade/escola.",
                color: "negative",
            })
        }
    })
}
</script>