<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link} from '@inertiajs/vue3';
import { Notify } from 'quasar';

const props = defineProps({
    Tag: {
        type: Object,
        default: {}
    },
})

const form = useForm({
    id: props.Tag.id,
    nome: props.Tag.nome,
})

function validateForm() {
  const fieldLabels = {
    nome: 'Nome da Escola',
  };

  const requiredFields = Object.keys(fieldLabels);

  requiredFields.forEach(field => {
    if (!form[field]) {
      form.errors[field] = `O campo ${fieldLabels[field]} é obrigatório`;
    } else {
      form.errors[field] = null;
    }
  });
}

function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function update(){

    validateForm()
    
    router.post(route('painel.tags.update', form.id), {
        _method: 'patch',
        ...form
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Dados da Tag atualizados com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível atualizar os dados da Tag.",
                color: "negative"
            })
        }
    })
}
</script>
<template>
    <Head title="Tipo de Arquivo" />
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
                <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">Atualizar Tipos de Arquivo</h4>    
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nome" value="Nome" required/>
                        <input id="nome" type="text" required autofocus autocomplete="nome"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.nome" />
                        <InputError class="tw-mt-2" :message="form.errors.nome" />
                    </div>
                </div>
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.tags')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                        VOLTAR
                    </Link>
                    <span @click="update()" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
                        <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" /> 
                        Salvar
                    </span>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
