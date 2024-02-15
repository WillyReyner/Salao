<template>
    <Head title="Editais" />

    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div
                class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
                        style="border-bottom: 2px solid #ccc">DADOS PESSOAIS</p>
                </div>
                <!-- Começa aqui --> <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"> 
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="cpf" value="Cpf" required/>
                        <q-input
                            id="cpf"
                            mask="###.###.###-##"
                            outlined
                            v-model="form.cpf"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.cpf" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nome" value="Nome Completo" required/>
                        <q-input
                            id="nome"
                            outlined
                            v-model="form.nome"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.nome" />
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="email" value="Email" required/>
                        <q-select
                            id="email"
                            outlined
                            v-model="form.email"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.email" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="municipios_id" value="Nome da Mãe" required/>
                        <q-select
                            id="municipios_id"
                            outlined
                            map-options
                            emit-value
                            v-model="form.municipios_id" 
                            :options="opcoesMunicipio"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                    <InputError class="tw-mt-2" :message="form.errors.municipios_id" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="dt_nascimento" value="Data de Nascimento" required/>
                        <q-input
                            type="date"
                            id="dt_nascimento"
                            outlined
                            v-model="form.dt_nascimento" 
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                    <InputError class="tw-mt-2" :message="form.errors.dt_nascimento" />
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="telefone" value="Telefone" required/>
                        <q-input
                            id="telefone"
                            mask="(##) # ####-####"
                            outlined
                            v-model="form.telefone"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.telefone" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="telefone_alternativo" value="Telefone Alternativo" required/>
                        <q-input
                            id="telefone_alternativo"
                            mask="(##) # ####-####"
                            outlined
                            v-model="form.telefone_alternativo"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.telefone_alternativo" />
                    </div>
                </div>

                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">ENDEREÇO</p>
                </div>

                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex-none tw-w-34 tw-flex-col">
                        <InputLabel for="cep" value="CEP" required/>
                        <q-input
                            id="cep"
                            mask="#####-###"
                            outlined
                            v-model="form.cep"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.cep" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="logradouro" value="Logradoudo" required/>
                        <q-input
                            id="logradouro"
                            outlined
                            v-model="form.logradouro"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.logradouro" />
                    </div>
                    <div class="tw-flex-none tw-w-34 tw-flex-col">
                        <InputLabel for="numero" value="Numero" required/>
                        <q-input
                            id="numero"
                            outlined
                            v-model="form.numero"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.numero" />
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="complemento" value="Complemento" required/>
                        <q-input
                            id="complemento"
                            outlined
                            v-model="form.complemento"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.complemento" />
                    </div>
                    <div class="tw-flex-none tw-w-80 tw-flex-col">
                        <InputLabel for="bairro" value="Bairro" required/>
                        <q-input
                            id="bairro"
                            outlined
                            v-model="form.bairro"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.bairro" />
                    </div>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="estado" value="Estado" required/>
                        <q-input
                            id="estado"
                            outlined
                            v-model="form.estado"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.estado" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="municipio" value="Municipio" required/>
                        <q-input
                            id="municipio"
                            outlined
                            v-model="form.municipio"
                            class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                            <InputError class="tw-mt-2" :message="form.errors.municipio" />
                    </div>
                 </div> <!--Termina Aqui -->
                <div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
                    <InputLabel for="users_id" value="Estudante Cadastrado" required />
						<q-select 
							id="users_id" 
							outlined 
							map-options
							emit-value 
							v-model="form.users_id"
							:options="opcoesAlunos"
							class="tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
						<InputError class="tw-mt-2" :message="form.errors.users_id" />
                </div> 
                <div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
                    <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                        <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-2"
                            style="border-bottom: 2px solid #ccc">SELECIONE UMA TURMA</p>
                    </div>
                    <TurmaInInscricao :turmas="props.turmas" :cursos="props.cursos"/>
                </div>
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.editais')"
                        class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                    CANCELAR
                    </Link>
                    <span @click="store()"
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
import TurmaInInscricao from '@/Components/Selecao/TurmaInInscricao.vue'
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link } from '@inertiajs/vue3';
import { Notify } from 'quasar';
import { onMounted } from 'vue';
import { ref, computed, watch } from 'vue';

const props = defineProps({
    
    turmas: {
        type: Array,
        default: [],
    },
    users: {
        type: Array,
        default: []
    }
    
})

const opcoesAlunos = props.users.map(user => ({ label: user.name, value: user.id}))
const opcoesStatus = ['Ativo','Inativo','Bloqueado']
const opcoesDocumentos = [	'Documentacao1Value', 'Documentacao2Value', 'Documentacao3Value', 'Documentacao4Value' ];
// const opcoesEscola = props.escolas.map(escola => ({label: escola.nome, value: escola.id}))
// const opcoesMunicipio = props.municipios.map(municipio => ({label: municipio.nome, value: municipio.id}))

const form = useForm({
    users_id: '',
})

function update() {
	router.post(
		route('painel.inscricoes.update', form.id),
		{
			_method: 'patch',
			...form,
		},
		{
			preserveScroll: true,
			forceFormData: true,
			onSuccess: (res) => {
				form.reset();
				Notify.create({
					message: 'Dados do edital atualizados com sucesso.',
					color: 'secondary',
				});
			},
			onError: (err) => {
				Notify.create({
					message: 'Não foi possível atualizar os dados do edital.',
					color: 'negative',
				});
			},
		}
	);
}
</script>

