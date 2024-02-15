
<template>
	<Head title="Editais" />
	<AuthenticatedLayout>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div
				class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
				<div
					class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class=" tw-font-title tw-font-semibold">
						Nome Completo do Inscrito
					</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						Dados do Estudante
					</p>
				</div>
				<!-- Linha 01 -->
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="nome_completo" value="Nome Completo" required />
						<q-input
							id="nome_completo"
							disable
							map-options 
							emit-value 
							v-model="form.nome_completo" 
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.nome_completo" />
					</div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="cpf" value="CPF" required />
						<q-input
							id="cpf"
							disable
							map-options 
							emit-value 
							v-model="form.cpf"
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.cpf" />
					</div>
				</div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="data_nascimento" value="Data Nascimento" required />
						<q-input
							disable
							id="data_nascimento" 
							type="date" 
							required 
							autofocus 
							autocomplete="data_nascimento"
							class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							v-model="form.data_nascimento" />
						<InputError class="tw-mt-2" :message="form.errors.dt_fim_edital" />
					</div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="email" value="E-mail" required />
						<q-input
							id="email"
							disable
							map-options 
							emit-value 
							v-model="form.email" 
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.email" />
					</div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="telefone" value="Telefone" required />
						<q-input
							id="telefone"
							disable
							map-options 
							emit-value 
							v-model="form.telefone" 
							
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.telefone" />
					</div>
				</div>
				<div
                    class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
                        Turmas Selecionadas
                    </p>
                </div>
				<TurmaInInscricoes :turmas="turmas" :disabled="true" />
				<div class="tw-flex tw-justify-end tw-gap-2">
					<Link :href="route('painel.inscricoes')"
						class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
					VOLTAR
					</Link>
					<!-- <span @click="update()"
						class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center">
						<Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
						Salvar
					</span> -->
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
import { computed, ref } from 'vue'
import { Icon } from '@iconify/vue'
import InputLabel from '@/Components/Pages/InputLabel.vue';
import InputError from '@/Components/Pages/InputError.vue';
import TurmaInInscricoes from '@/Components/Selecao/TurmaInInscricao.vue'

const props = defineProps({
    inscricoes: {
        type: Object,
        default: {}
    },
    turmas: {
        type: Array,
        default: {}
    }
})

const form = useForm({
    id: props.inscricoes.id,
    nome_completo: props.inscricoes.nome_completo,
    cpf: props.inscricoes.cpf,
    email: props.inscricoes.email,
    tipo: props.inscricoes.tipo,
    rede: props.inscricoes.rede,
    raca: props.inscricoes.raca,
    sexo: props.inscricoes.sexo,
    telefone: props.inscricoes.telefone,
    telefone_alternativo: props.inscricoes.telefone_alternativo,
    cep: props.inscricoes.cep,
    municipio: props.inscricoes.municipio,
    estado: props.inscricoes.estado,
    logradouro: props.inscricoes.logradouro,
    numero: props.inscricoes.numero,
    complemento: props.inscricoes.complemento,
    bairro: props.inscricoes.bairro,
    data_nascimento: props.inscricoes.data_nascimento ? props.inscricoes.data_nascimento.split(' ')[0] : '',
    nome_mae: props.inscricoes.nome_mae,
    escolaridade: props.inscricoes.escolaridade,
    origem_escolar: props.inscricoes.origem_escolar,
    programa_social: props.inscricoes.programa_social,
    nis_pis: props.inscricoes.nis_pis,
    outro_programa_social: props.inscricoes.outro_programa_social,
    deficiencia: props.inscricoes.deficiencia,
    como_conheceu: props.inscricoes.como_conheceu,
    outro_como_conheceu: props.inscricoes.outro_como_conheceu,
    situacao: props.inscricoes.situacao,
    turma_id: props.inscricoes.turma_id,
});

</script>
