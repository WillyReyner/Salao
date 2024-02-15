<template>
	<Head title="Editais" />
	<AuthenticatedLayout>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
				<div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-font-title tw-font-semibold">
						{{ form.nome_completo}}
					</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						Dados do Estudante
					</p>
				</div>
				<!-- Linha 01 -->
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="nome_completo" value="Nome Completo" required />
						<q-input outlined id="nome_completo" map-options emit-value v-model="form.nome_completo"
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.nome_completo" />
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="documento" :value="form.tipo_documento" required />
						<q-input outlined id="documento" mask="###.###.###-##" map-options emit-value v-model="form.documento"
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.documento" />
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="situacao" value="Status" required />
						<q-select id="situacao" outlined map-options emit-value v-model="form.situacao" :options="opcoesStatus"
							class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
						<InputError class="tw-mt-2" :message="form.errors.situacao" />
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="data_nascimento" value="Data Nascimento" required />
						<q-input outlined id="data_nascimento" type="date" required autofocus autocomplete="data_nascimento"
							class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							v-model="form.data_nascimento" />
						<InputError class="tw-mt-2" :message="form.errors.dt_fim_edital" />
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="email" value="E-mail" required />
						<q-input outlined id="email" map-options emit-value v-model="form.email"
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.email" />
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="telefone" value="Telefone" required />
						<q-input outlined id="telefone" mask="(##) #####-####" map-options emit-value v-model="form.telefone"
							class="tw-mt-1 tw-text-gray-700 tw-bg-white-50 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
						</q-input>
						<InputError class="tw-mt-2" :message="form.errors.telefone" />
					</div>
				</div>
				<div v-if="props.comprovantes.length > 0" class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						DOCUMENTOS ANEXADOS PARA INSCRIÇÃO
					</p>
				</div>
				<!-- Documentos Anexados a Inscrição -->
				<div class="tw-grid tw-grid-cols-2 tw-gap-6">
					<div v-for="doc in props.comprovantes" :key="doc.id"
						class="tw-w-full tw-flex tw-items-center tw-justify-between">
						<div class="tw-w-full">
							<InputLabel :for="`tipo_arquivo_${doc.id}`" :value="getNomeDocumento(doc.tipo_arquivo_id)"
								required />
							<a v-if="doc.status === 'Sim'" class="tw-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
								VER DOCUMENTACAO
								<div class="tw-ml-auto">
									<Icon icon="material-symbols-light:quick-reference-all-outline" width="28"
										class="tw-text-green-700" @click="openFileModalInsc(doc.caminho, doc.id, doc.status)" />
								</div>
							</a>
							<a v-if="doc.status === 'Nao'"
								class="tw-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-rose-600 active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-red-700 tw-bg-white tw-items-center">
								VER DOCUMENTACAO
								<div class="tw-ml-auto">
									<Icon icon="material-symbols-light:quick-reference-all-outline" width="28"
										class="tw-text-red-700" @click="openFileModalInsc(doc.caminho, doc.id, doc.status)" />
								</div>
							</a>
							<InputError class="tw-mt-2" :message="form.errors.nome_completo" />
						</div>
						<div v-if="doc.status === 'Sim'" class="tw-ml-2 tw-pt-5 ">
							<Icon icon="tabler:square-check" width="40" class="tw-text-green-700" />
						</div>
						<div v-if="doc.status === 'Nao'" class="tw-ml-2 tw-pt-5 ">
							<Icon icon="charm:square-cross" width="40" class="tw-text-red-700" />
						</div>
						<q-dialog v-model="fileModalVisibleInsc">
							<q-card class="column full-height" style="width: 900px; max-width: 80vw;">
								<q-card-section style="height: 90%;">
									<iframe :src="fileToViewInsc" style="width: 100%; height: 100%; border: none"></iframe>
								</q-card-section>
								<q-card-actions align="right">
									<PrimaryButton @click="closeFileModalInsc"
										button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-8">
										FECHAR
									</PrimaryButton>
									<PrimaryButton v-if="docStatus !== 'Sim'" @click="doc && doc.id && validarDocInscricao(docId)" button-class="tw-text-white tw-flex tw-bg-primary tw-h-8 ">
										VALIDAR
									</PrimaryButton>
								</q-card-actions>
							</q-card>
						</q-dialog>
					</div>
				</div>
				<br />
				<div v-if="props.comprovantesMatricula.length > 0" class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"
						style="border-bottom: 2px solid #ccc">
						DOCUMENTOS ANEXADOS PARA MATRÍCULA
					</p>
				</div>
				<!-- Documentos Anexados a Inscrição -->
				<div class="tw-grid tw-grid-cols-2 tw-gap-6">
					<div v-for="doc_ in props.comprovantesMatricula" :key="doc_.id"
						class="tw-w-full tw-flex tw-items-center tw-justify-between">
						<div class="tw-w-full">
							<InputLabel :for="`tipo_arquivo_${doc_.id}`" :value="getNomeDocumento(doc_.tipo_arquivo_id)" required />
							<a v-if="doc_.status === 'Sim' " class="tw-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
								VER DOCUMENTACAO
								<div class="tw-ml-auto">
									<Icon icon="material-symbols-light:quick-reference-all-outline" width="28"
										class="tw-text-green-700" @click="openFileModalMatr(doc_.caminho, doc_.id, doc_.status)" />
								</div>
							</a>
							<a v-if="doc_.status === 'Nao' " class="tw-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-rose-600 active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-red-700 tw-bg-white tw-items-center">
								VER DOCUMENTACAO
								<div class="tw-ml-auto">
									<Icon icon="material-symbols-light:quick-reference-all-outline" width="28"
										class="tw-text-red-700" @click="openFileModalMatr(doc_.caminho, doc_.id, doc_.status)" />
								</div>
							</a>
							<InputError class="tw-mt-2" :message="form.errors.nome_completo" />
						</div>
						<div v-if="doc_.status === 'Sim'" class="tw-ml-2 tw-pt-5 ">
							<Icon icon="tabler:square-check" width="40" class="tw-text-green-700" />
						</div>
						<div v-if="doc_.status === 'Nao'" class="tw-ml-2 tw-pt-5 ">
							<Icon icon="charm:square-cross" width="40" class="tw-text-red-700" />
						</div>
						<q-dialog v-model="fileModalVisibleMatr">
							<q-card class="column full-height" style="width: 900px; max-width: 80vw;">
								<q-card-section style="height: 90%;">
									<iframe :src="fileToViewMatr" style="width: 100%; height: 100%; border: none"></iframe>
								</q-card-section>
								<q-card-actions align="right">
									<PrimaryButton @click="closeFileModalMatr"
										button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-8">
										FECHAR
									</PrimaryButton>
									<PrimaryButton v-if="docStatus !== 'Sim'"  @click="doc_ && doc_.id && validarDocMatricula(docId)" button-class="tw-text-white tw-flex tw-bg-primary tw-h-8 ">
										VALIDAR
									</PrimaryButton>
								</q-card-actions>
							</q-card>
						</q-dialog>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
						Turmas Selecionadas
					</p>
				</div>
				<TurmaInInscricoes disabled :turmas="turmas" :d="true" class="tw-pb-4"/>
				<div class="tw-flex tw-justify-end tw-gap-2">
					<Link :href="route('painel.inscricoes')"
						class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
					VOLTAR
					</Link>
					<span @click="update()"
						class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center">
						<Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
						Salvar
					</span>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
<script setup>
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router, Link } from "@inertiajs/vue3";
import { Notify, Dialog } from "quasar";
import { computed, ref } from "vue";
import { Icon } from "@iconify/vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import InputError from "@/Components/Pages/InputError.vue";
import TurmaInInscricoes from "@/Components/Selecao/TurmaInInscricao.vue";

const props = defineProps({
	inscricoes: {
		type: Object,
		default: {},
	},
	turmas: {
		type: Array,
		default: {},
	},
	comprovantes: {
		type: Object,
		default: {},
	},
	comprovantesMatricula: {
		type: Object,
		default: {},
	},
	documentacao_inscricao: {
		type: Array,
		default: [],
	},
	documentacao_matricula: {
		type: Array,
		default: [],
	},
});

const fileToViewInsc = ref("");
const fileToViewMatr = ref("");
const fileModalVisibleInsc = ref(false);
const fileModalVisibleMatr = ref(false);
const docId = ref('');
const docStatus = ref('')


const openFileModalInsc = (caminho, id, status) => {
	fileToViewInsc.value = getPublicStorageUrl(caminho);
	docId.value = id;
	docStatus.value = status;
	fileModalVisibleInsc.value = true;
};

const openFileModalMatr = (caminho, id, status) => {
	fileToViewMatr.value = getPublicStorageUrl(caminho);
	docId.value = id;
	docStatus.value = status;
	fileModalVisibleMatr.value = true;
};

const closeFileModalInsc = () => {
	fileToViewInsc.value = "";
	fileModalVisibleInsc.value = false;
};

const closeFileModalMatr = () => {
	fileToViewMatr.value = "";
	fileModalVisibleMatr.value = false;
};

const getNomeDocumento = (tipoArquivoId) => {
	const tipoArquivoIdNum = parseInt(tipoArquivoId);
	const documento = props.documentacao_inscricao.find(
		(doc) => doc.id === tipoArquivoIdNum
	);
	return documento ? documento.nome : "";
};

const getNomeDocumentoMatricula = (tipoArquivoId) => {
	const tipoArquivoIdNum = parseInt(tipoArquivoId);
	const documento = props.documentacao_matricula.find(
		(doc) => doc.id === tipoArquivoIdNum
	);
	return documento ? documento.nome : "";
};

const opcoesStatus = ['Nova', 'Em Analise', 'Matriculado', 'Finalizado']

const form = useForm({
	id: props.inscricoes.id,
	nome_completo: props.inscricoes.nome_completo,
	cpf: props.inscricoes.cpf,
	situacao: props.inscricoes.situacao,
	email: props.inscricoes.email,
	telefone: props.inscricoes.telefone,
	data_nascimento: props.inscricoes.data_nascimento
		? props.inscricoes.data_nascimento.split(" ")[0]
		: "",
	telefone_alternativo: props.inscricoes.telefone_alternativo,
	tipo_documento: props.inscricoes.tipo_documento,
	documento: props.inscricoes.documento,
});

const formI = useForm({
	id: props.comprovantes.id
});

const formM = useForm({
	id: props.comprovantesMatricula.id
});

function validateForm() {
    const fieldLabels = {
		nome_completo: 'Nome',
		cpf: 'Fim do Edital',
      email: 'Email',
      data_nascimento: 'Data de Nascimento',
      telefone: 'Telefone',
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

function update() {

	validateForm()


    router.post(route('painel.inscricoes.update', form.id), {
        _method: 'patch',
        ...form,
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Dados da Inscricao foram atualizados com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível atualizar os dados da Turma.",
                color: "negative",
				
            })
        }
    })
}

function validarDocMatricula(id) {
	docId.value = id;
    router.post(route('painel.inscricoes.validarDocMatricula', { id: docId.value }), {
        _method: 'patch',
        ...formM,
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Documento de matrícula validado com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
			console.error('Erro na validação de documentos de matricula:', err);
            Notify.create({
                message: "Não foi possível atualizar os dados da Turma.",
                color: "negative"
            })
        }
    })
	 fileModalVisibleMatr.value = false;
}

function validarDocInscricao(id) {
	docId.value = id;
    router.post(route('painel.inscricoes.validarDocInscricao', { id: docId.value }), {
        _method: 'patch',
        ...formI,
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            formI.reset();
            Notify.create({
                message: "Documento de inscrição validado com sucesso.",
                color: "secondary"
            });
        },
        onError: (err) => {
            console.error('Erro na validação de documentos de inscrição:', err);
            Notify.create({
                message: "Não foi possível validar os documentos da Turma.",
                color: "negative"
            });
        }
    });
	fileModalVisibleInsc.value = false;
}

const getPublicStorageUrl = (path) => {
	return `/storage/${path}`;
};
</script>
