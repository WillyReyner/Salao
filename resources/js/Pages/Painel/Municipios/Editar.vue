
<template>
    <Head title="Municipios" />
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div
                class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
                <div
                    class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class="tw-font-title tw-font-semibold">Atualizar Município</h4>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nome" value="Uf" required />
                        <q-select id="uf" :options="opcaoUf" map-options emit-value outlined required autofocus
                            autocomplete="uf"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.uf" @blur="buscarEnderecoPorCEP" />
                        <InputError class="tw-mt-2" :message="form.errors.nome" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="uf" value="Municipio" required />
                        <q-select id="nome" map-options emit-value outlined required autofocus autocomplete="nome"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.nome" :options="opcoesMunicipios" />
                        <InputError class="tw-mt-2" :message="form.errors.nome" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="situacao" value="Situação" required />
                        <q-select :options="opcaoStatus" outlined v-model="form.situacao" id="situacao"
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                        <InputError class="tw-mt-2" :message="form.errors.situacao" />
                    </div>
                </div>
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.municipios')"
                        class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                    VOLTAR
                    </Link>
                    <span @click="update()"
                        class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
                        <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
                        Salvar
                    </span>
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
import { ref } from 'vue';

const props = defineProps({
    municipio: {
        type: Object,
        default: {}
    },
})

const opcoesMunicipios = ref([]);

const opcaoStatus = ['Ativo', 'Bloqueado', 'Inativo']
const form = useForm({
    id: props.municipio.id,
    nome: props.municipio.nome,
    uf: props.municipio.uf,
    situacao: props.municipio.situacao,
})

function validateForm() {
    const requiredFields = ['nome', 'situacao', 'uf'];

    requiredFields.forEach(field => {
        if (!form[field]) {
            form.errors[field] = `${capitalizeFirstLetter(field)} é obrigatório`;
        } else {
            form.errors[field] = null;
        }
    });
}

function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

const opcaoUf = [
    { label: "Rondônia", value: "11" },
    { label: "Acre", value: "12" },
    { label: "Amazonas", value: "13" },
    { label: "Roraima", value: "14" },
    { label: "Pará", value: "15" },
    { label: "Amapá", value: "16" },
    { label: "Tocantins", value: "17" },
    { label: "Maranhão", value: "21" },
    { label: "Piauí", value: "22" },
    { label: "Ceará", value: "23" },
    { label: "Rio Grande do Norte", value: "24" },
    { label: "Paraíba", value: "25" },
    { label: "Pernambuco", value: "26" },
    { label: "Alagoas", value: "27" },
    { label: "Sergipe", value: "28" },
    { label: "Bahia", value: "29" },
    { label: "Minas Gerais", value: "31" },
    { label: "Espírito Santo", value: "32" },
    { label: "Rio de Janeiro", value: "33" },
    { label: "São Paulo", value: "35" },
    { label: "Paraná", value: "41" },
    { label: "Santa Catarina", value: "42" },
    { label: "Rio Grande do Sul", value: "43" },
    { label: "Mato Grosso do Sul", value: "50" },
    { label: "Mato Grosso", value: "51" },
    { label: "Goiás", value: "52" },
    { label: "Distrito Federal", value: "53" }
]

async function buscarEnderecoPorCEP() {
    const uf = form.uf;

    if (uf.length === 2) { 
        try {
            const response = await axios.get(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`);
            const municipios = response.data;

            if (Array.isArray(municipios)) {
                
                const nomesMunicipios = municipios.map((municipio) => municipio.nome);

                
                opcoesMunicipios.value = nomesMunicipios;
            } else {
                console.error('Nenhum município encontrado para esta UF.');
            }
        } catch (error) {
            console.error('Erro ao buscar municípios:', error);
        }
    }
}

function update() {

    validateForm();

    router.post(route('painel.municipios.update', form.id), {
        _method: 'patch',
        ...form
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Dados do municipio atualizados com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível atualizar os dados do municipio.",
                color: "negative"
            })
        }
    })
}


</script>

