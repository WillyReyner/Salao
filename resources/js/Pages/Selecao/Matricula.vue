<!--suppress JSIncompatibleTypesComparison -->
<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import SelecaoLayout from "@/Layouts/SelecaoLayout.vue";
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import {defineProps, ref} from 'vue';
import {Icon} from "@iconify/vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import InputError from "@/Components/Pages/InputError.vue";
import {Notify} from "quasar";
import axios from "axios";
import Camera from "simple-vue-camera";

const props = defineProps({
	inscricao: {
		type: Array,
		default: () => [],
	},
});

const form = useForm({
	verificacao_documento: "",
	verificacao_nascimento: "",
	verificacao_tipo_documento: "",
	inscricaoId: props.inscricao.id,
	documentoMatriculaId: '',
	inscricaoSelected: "",
	idDoc: "",
	tipo: "",
	arquivos: []
});

const inscricaoSelected = ref('')
const estagio = ref(0);
const estagioDoc = ref(1)
const slide = ref(1)

const camera = ref();
const capturedImage = ref(null);
let capturedBlob = null;

const imagem = ref('')

const open = ref("");
const fileToView = ref("");
const anexosId = ref("")
const idDocReactive = ref("")
const documentoMatriculaId = ref('')
const idDoc = ref('')

const fileModalVisible = ref(false);
const fileAnexosModalVisible = ref(false);
const anexosModalPhoto = ref(false)
const modalAnexosArquivos = ref(false)
const secondDialog = ref(false)
const filtroCurso = ref([])
const filtroEscola = ref([])
const inscricaoDocumento = ref([])
const comprovante = ref([])
const comprovantes2 = ref([])
const inscricao = ref([])
const file = ref([]);

const optionsDoc = ['CPF', 'RG', 'CNH', 'Passaporte (pass.te)']

const estagioDocs = [
	{titulo: '', subtitulo: ''},
	{titulo: 'Anexe foto frente e verso do seu documento de identidade com foto', subtitulo: 'FRENTE'},
	{titulo: 'Anexe foto frente e verso do seu documento de identidade com foto', subtitulo: 'VERSO'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Pessoais'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Endereço'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Escolares'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Sociais'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Como conheceu a EFG'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Comprovantes'},
	{titulo: 'Formulário de Inscrição ', subtitulo: 'Antes de finalizar sua inscrição, confira seus dados até o final.'},
]

const masks = {
	CPF: '###.###.###-##',
	RG: '##.###.###-#',
	CNH: '#########',
};

const captureSnapshot = async (action) => {
	if (camera.value) {
		try {
			if (action === 1) {
				capturedBlob = await camera.value.snapshot({width: 1920, height: 1080});

				const url = URL.createObjectURL(capturedBlob);
				if (capturedImage.value) {
					capturedImage.value.src = url;
					imagem.value = '1';
				}
			} else if (action === 2) {
				if (capturedImage.value) {
					capturedImage.value.src = '';
					imagem.value = '2';
				}
			} else {
				console.error('Ação inválida:', action);
			}
		} catch (error) {
			console.error('Erro ao capturar/excluir a imagem:', error);
		}
	}
};

const downloadAndUpload = () => {
	if (capturedBlob) {
		if (form.arquivos.length > 0) {
			form.arquivos.pop();
		}
		const newFile = new File([capturedBlob], 'captured_image.png', {type: 'image/png'});
		form.arquivos.push(newFile);
		anexosModalPhoto.value = false;
	} else {
		console.error('Nenhuma imagem capturada para download e upload.');
	}
};

const getMaskForTipoDoc = (tipoDoc) => {
	return masks[tipoDoc] || '';
};

const formatarQuebrasDeLinha = (texto) => {
	return texto.replace(/&/g, '\n');
};

function openItem(item) {
	if (open.value === item) {
		open.value = null;
	} else {
		open.value = item;
	}
}

const formatDate = (dateTime) => {
	const [dia, mes, ano] = new Date(dateTime).toLocaleDateString('pt-BR').split('/');
	return `${dia}/${mes}/${ano}`;
};

const openAnexosModalPhoto = () => {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		anexosModalPhoto.value = true
	}, 500); // 3000 milissegundos = 3 segundos
}

const closeAnexosModalPhoto = () => {
	anexosModalPhoto.value = false;
};
const closeModalAnexosArquivos = () => {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		modalAnexosArquivos.value = false;
	}, 500); // 3000 milissegundos = 3 segundos

};


const openAnexosModal = (id, idDoc) => {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		idDocReactive.value = idDoc;
		anexosId.value = id;
		fileAnexosModalVisible.value = true;
	}, 500); // 3000 milissegundos = 3 segundos
}

const closeAnexosModal = () => {
	fileAnexosModalVisible.value = false;
};
const closeFileModal = () => {
	fileToView.value = "";
	fileModalVisible.value = false;
};

function avancar() {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		estagio.value = estagio.value + 1;
	}, 500); // 3000 milissegundos = 3 segundos
}

function voltar() {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		estagio.value = estagio.value - 1;
	}, 3000); // 3000 milissegundos = 3 segundos
}

function pesquisarInscricoes() {
	const verificacaoDocumento = form.verificacao_documento
	const tipoVerificacaoTipoDocumento = form.verificacao_tipo_documento
	const verificacaoDataNascimento = form.verificacao_nascimento

	axios.post(route('inscricao.matricula.estagio_1'), {
		verificacao_tipo_documento: tipoVerificacaoTipoDocumento,
		verificacao_documento: verificacaoDocumento,
		verificacao_nascimento: verificacaoDataNascimento
	})
		 .then((res) => {
			 inscricao.value = res.data.inscricao;
			 secondDialog.value = true;
			 // Definir secondDialog.value como false após 3 segundos
			 setTimeout(function () {
				 secondDialog.value = false;
				 estagio.value = estagio.value + 1;
			 }, 3000); // 3000 milissegundos = 3 segundos
		 })
		 .catch((err) => {
			 Notify.create({
				 message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
				 color: "negative"
			 });
			 estagio.value = 1;
		 });
}

function avancarId() {
	const inscricaoId = form.inscricaoSelected

	axios.post(route('inscricao.matricula.estagio_2'), {
		inscricaoSelected: inscricaoId,
	})
		 .then((res) => {
			 secondDialog.value = true;
			 // Definir secondDialog.value como false após 3 segundos
			 setTimeout(function () {
				 secondDialog.value = false;
				 inscricaoDocumento.value = res.data.inscricao;
				 comprovante.value = res.data.comprovante
				 estagio.value += 1;
			 }, 1000); // 3000 milissegundos = 3 segundos

		 })
		 .catch((err) => {
			 Notify.create({
				 message: "Não foi possível realizar a sua inscrição. Verifique suas informações." + err,
				 color: "negative"
			 });
			 estagio.value = 3;
		 });
}

function store(id, tipo_arquivoId, versao, tipo) {

	const arquivosSelecionados = form.arquivos;
	form.documentoMatriculaId = tipo_arquivoId;
	form.idDoc = id;
	form.tipo = tipo;

	if (arquivosSelecionados.length === 0) {
		Notify.create({
			message: "Nenhum arquivo selecionado.",
			color: "negative"
		});
		estagio.value = 3;
		return;
	}

	form.post(route('inscricao.matricula.store'), {
		inscricaoId: idDoc,
		arquivos: form.arquivos,
		documentoMatriculaId: documentoMatriculaId,
		tipo: tipo,

		onSuccess: (res) => {
			form.reset();
			Notify.create({
				message: "Inscrição realizada com sucesso.",
				color: "secondary"
			});

			secondDialog.value = true;
			// Definir secondDialog.value como false após 3 segundos
			setTimeout(function () {
				secondDialog.value = false;
				axios.post(route('inscricao.matricula.estagio_2'), {
					inscricaoSelected: id,
				})
					 .then((res) => {
						 comprovantes2.value = res.data.comprovante
						 estagio.value = 3;
						 if (versao !== 0) {

							 slide.value = 2;
							 if (tipo === 'VERSO') {
								 console.log('1')
								 fileAnexosModalVisible.value = false;
								 anexosModalPhoto.value = false
								 modalAnexosArquivos.value = true
								 fileModalVisible.value = true
								 form.idDoc = id
							 }
						 } else {
							 console.log('2')
							 fileAnexosModalVisible.value = false;
							 anexosModalPhoto.value = false
							 modalAnexosArquivos.value = true
							 fileModalVisible.value = true
							 form.idDoc = id
						 }
						 fileAnexosModalVisible.value = false;
						 anexosModalPhoto.value = false
						 modalAnexosArquivos.value = true
						 form.idDoc = id
					 })
					 .catch((err) => {
						 Notify.create({
							 message: "Não foi possível realizar a sua inscrição. Verifique suas informações." + err,
							 color: "negative"
						 });
					 });
			}, 3000); // 3000 milissegundos = 3 segundos


		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
				color: "negative"
			});
			estagio.value = 3;
		}
	});
}
</script>
<!--suppress ALL -->
<template>
	<Head title="Sistema de Seleção"/>
	<SelecaoLayout>
		<q-dialog v-model="fileAnexosModalVisible">
			<q-carousel v-model="slide" animated arrows
			            class="bg-white shadow-1 rounded-borders tw-h-auto tw-rounded-2xl"
			            control-color="primary" navigation-icon="radio_button_unchecked" transition-next="slide-left"
			            transition-prev="slide-right">
				<q-carousel-slide :name="1" class="column no-wrap flex-start">
					<div class="tw-grid tw-grid-cols-12 ">
						<h5 class="tw-col-span-11 tw-text-zinc-800 tw-font-bold font-['Exo 2'] tw-pb-4 tw-">Envio de
							Documentos
							Pessoais </h5>
						<Icon height="30" icon="ei:close-o" width="30" @click="closeAnexosModal"/>
					</div>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-xl tw-mb-6 tw-font-semibold tw-flex tw-justify-start">
						{{ anexosId.tipo_arquivo.nome }}</h5>
					<div class="tw-flex tw-gap-5 tw-flex-col">
						<h4 class="tw-text-gray-800 tw-font-title tw-leading-none tw-text-base">
							{{ estagioDocs[estagioDoc].titulo }}</h4>
						<div v-if="anexosId.tipo_arquivo.tipo_versao !== '0'" class="tw-flex tw-justify-between">
							<h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">
								{{ estagioDocs[estagioDoc].subtitulo }}</h5>
							<h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">
								PASSO 0{{ estagioDoc }} DE 02
							</h5>
						</div>
						<q-slider v-if="anexosId.tipo_arquivo.tipo_versao === '1'" v-model="estagioDoc" :max="2"
						          :min="0"
						          class="-tw-mt-4 tw-cursor-none" color="green" dense disable thumb-size="0px"
						          track-size="6px"/>
					</div>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-lg tw-mb-1 tw-pt-3 tw-font-semibold tw-flex tw-justify-start">
						Deve conter: </h5>
					<div class="tw-flex tw-justify-center tw-bg-green-50 tw-text-base tw-py-3 tw-mb-4 tw-p-6"
					     style="white-space: pre-line;">
						{{ formatarQuebrasDeLinha(anexosId.tipo_arquivo.orientacao) }}
					</div>
					<q-file v-model="form.arquivos" accept="image/jpeg, image/jpg, application/pdf" bg-color="white"
					        class="tw-w-[100%] tw-items-center tw-mx-auto tw-rounded-lg"
					        input-class="tw-text-primary tw-block tw-rounded-lg tw-self-start focus:tw-border-primary focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
					        label="SELECIONAR ARQUIVO"
					        label-color="green"
					        outlined
					        rounded>
						<template v-slot:prepend>
							<Icon class="tw-text-green-700" icon="majesticons:file-line"/>
						</template>
					</q-file>
					<br/>
					<div class="tw-grid tw-grid-rows-2 tw-justify-center">
						<PrimaryButton
							 button-class="tw-text-primary tw-border tw-border-primary tw-flex tw-justify-center tw-h-10 tw-mb-1 tw-w-[100%]"
							 class="tw-w-[350px]"
							 @click="openAnexosModalPhoto">
							<Icon class="tw-text-green-700 tw-pr-1" height="20" icon="akar-icons:camera" width="20"/>
							TIRAR FOTO
						</PrimaryButton>

						<PrimaryButton
							 button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10 tw-w-[]"
							 @click="store(idDocReactive, anexosId.tipo_arquivo.id, anexosId.tipo_arquivo.tipo_versao, 'FRENTE')">
							<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line" width="20"/>
							Continuar
						</PrimaryButton>
					</div>
				</q-carousel-slide>
				<q-carousel-slide v-if="anexosId.tipo_arquivo.tipo_versao === '1'" :name="2"
				                  class="column no-wrap flex-start tw-h-[100%]">
					<div class="tw-grid tw-grid-cols-12 ">
						<h5 class="tw-col-span-11 tw-text-zinc-800 tw-font-bold font-['Exo 2'] tw-pb-4 tw-">
							Envio de Documentos Pessoais </h5>
						<Icon height="30" icon="ei:close-o" width="30" @click="closeAnexosModal"/>
					</div>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-xl tw-mb-6 tw-font-semibold tw-flex tw-justify-start">
						{{ anexosId.tipo_arquivo.nome }}</h5>
					<div class="tw-flex tw-gap-5 tw-flex-col">
						<h4 class="tw-text-gray-800 tw-font-title tw-leading-none tw-text-base">
							{{ estagioDocs[estagioDoc].titulo }}</h4>
						<div class="tw-flex tw-justify-between">
							<h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">
								VERSO</h5>
							<h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">
								PASSO 02 DE 02</h5>
						</div>
						<q-slider v-model="estagioDoc" :max="1" :min="0" class="-tw-mt-4 tw-cursor-none tw-pb-3"
						          color="green"
						          dense
						          disable thumb-size="0px" track-size="6px"/>
					</div>
					<q-file v-model="form.arquivos" accept="image/jpeg, image/jpg, application/pdf" bg-color="white"
					        class="tw-w-[100%] tw-items-center tw-mx-auto "
					        input-class="tw-text-primary tw-block tw-self-start focus:tw-border-primary focus:tw-ring-0 tw-rounded-base tw-shadow-sm"
					        label="SELECIONAR ARQUIVO"
					        label-color="green"
					        outlined
					        rounded>
						<template v-slot:prepend>
							<Icon class="tw-text-green-700" icon="majesticons:file-line"/>
						</template>
					</q-file>
					<br/>

					<PrimaryButton
						 button-class="tw-text-primary tw-border tw-border-primary tw-flex tw-justify-center tw-h-10 tw-mb-1 tw-w-[100%]"
						 @click="openAnexosModalPhoto">
						<Icon class="tw-text-green-700 tw-pr-1" height="20" icon="akar-icons:camera" width="20"/>
						TIRAR FOTO
					</PrimaryButton>
					<PrimaryButton
						 button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10 tw-w-[100%]"
						 @click="store(idDocReactive, anexosId.tipo_arquivo.id, anexosId.tipo_arquivo.tipo_versao, 'VERSO')">
						<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line" width="20"/>
						Concluir
					</PrimaryButton>
				</q-carousel-slide>
			</q-carousel>
		</q-dialog>

		<q-dialog v-model="anexosModalPhoto">
			<q-card class="tw-py-1 tw-h-auto tw-rounded-2xl">
				<q-card-section class="tw-flex tw-flex-col tw-justify-between tw-items-center">
					<div class="tw-grid tw-grid-cols-12 ">
						<h5 class="tw-col-span-11 tw-text-blue-800 tw-font-bold font-['Exo 2'] tw-pb-4 tw-">
							Tirar Foto com a Câmera </h5>
						<Icon height="30" icon="ei:close-o" width="30" @click="closeAnexosModalPhoto"/>
					</div>
					<div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-flex-1">
						<Camera ref="camera">
							<div class="tw-flex tw-flex-col tw-items-center tw-justify-end tw-h-full">
								<img ref="capturedImage" alt="" src=""/>
								<div v-if="imagem === 2 || imagem === ''">
									<button @click="captureSnapshot(1)">
										<Icon class=" tw-text-slate-50" icon="ion:ellipse" width="50"/>
									</button>
								</div>
							</div>
						</Camera>
					</div>
					<PrimaryButton
						 button-class="tw-text-primary tw-border tw-border-primary tw-flex tw-justify-center tw-h-10 tw-w-[100%] tw-m-3"
						 @click="captureSnapshot(2)">
						<Icon class="tw-text-green-700 tw-pr-1" height="20" icon="akar-icons:camera"
						      width="20"/>
						TIRAR OUTRA FOTO
					</PrimaryButton>
					<PrimaryButton
						 button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10 tw-w-[100%] "
						 @click="downloadAndUpload">
						<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line"
						      width="20"/>
						Enviar foto
					</PrimaryButton>
				</q-card-section>
			</q-card>
		</q-dialog>

		<q-dialog v-model="modalAnexosArquivos" full-width>
			<q-card class="tw-h-auto tw-rounded-2xl">
				<q-card-section class="tw-flex tw-flex-col tw-justify-between tw-items-center">
					<div class="tw-grid tw-grid-cols-12 ">
						<h5 class="tw-col-span-11 tw-text-zinc-800 tw-font-bold font-['Exo 2'] tw-pb-4 tw-">
							Envio de Documentos Pessoais </h5>
						<Icon height="30" icon="ei:close-o" width="30" @click="closeAnexosModal"/>
					</div>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-xl tw-mb-6 tw-font-semibold tw-flex tw-justify-start">
						{{ anexosId.tipo_arquivo.nome }}</h5>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-lg tw-mb-1 tw-font-semibold tw-flex tw-justify-start">
						Arquivo Anexado: </h5>
					<div class="tw-grid tw-grid-cols-1 tw-gap-6 tw-mb-3 tw-w-full">
						<div
							 v-for="doc_ in comprovantes2.filter(comprovante => comprovante.tipo_arquivo_id === anexosId.tipo_arquivo.id)"
							 :key="doc_.tipo_arquivo_id" class="tw-w-full tw-flex tw-items-center tw-justify-between">
							<div class="tw-w-full">
								<InputLabel :for="`tipo_arquivo_${doc_.id}`"
								            :value="doc_.tipo"
								            class="tw-mb-4"
								            required/>
								<a class="tw-flex tw-cursor-pointer tw-px-8 tw-py-1 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
									<Icon class="tw-pr-3" height="33" icon="heroicons:document" width="33"/>
									{{ doc_.nome_arquivo }}
								</a>
								<InputError :message="form.errors.nome_completo" class="tw-mt-2"/>
								<div class="tw-flex tw-items-center tw-justify-between tw-mt-2">
									<div class="tw-flex tw-gap-2">
										<Icon class="tw-mt-1 tw-text-primary" icon="fluent-mdl2:status-circle-inner"/>
										<InputLabel class="tw-mb-4" value="Status"/>
									</div>
									<div class="tw-flex">
										<p class="tw-text-gray-500 tw-font-body tw-text-sm tw-mb-1 tw-font-semibold tw-flex tw-justify-start">
											Anexado em: &nbsp
											<InputLabel :value="formatDate(doc_.tipo_arquivo.created_at)" class="tw-mb-4"/>
										</p>
									</div>
								</div>
							</div>
							<div v-if="doc_.status === 'Sim'" class="tw-ml-2 tw-pt-5 ">
								<Icon class="tw-text-green-700" icon="tabler:square-check" width="40"/>
							</div>
						</div>
					</div>
					<PrimaryButton
						 button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10 tw-w-[100%] "
						 @click="closeModalAnexosArquivos()">
						<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line" width="20"/>
						Concluir
					</PrimaryButton>
				</q-card-section>
			</q-card>
		</q-dialog>
		<q-dialog v-model="fileModalVisible">
			<q-card class="column full-height tw-h-auto tw-rounded-2xl">
				<q-card-section style="width: 100%; height: 93%">
					<iframe :src="fileToView" style="width: 100%; height: 100%; border: none"></iframe>
				</q-card-section>
				<q-card-actions align="right">
					<q-btn color="primary" label="Fechar" @click="closeFileModal"/>
				</q-card-actions>
			</q-card>
		</q-dialog>
		<q-dialog v-model="secondDialog">
			<div class="q-pa-md flex flex-center">
				<q-circular-progress
					 :thickness="0.22"
					 class="q-ma-md"
					 color="lime"
					 indeterminate
					 rounded
					 size="150px"
					 track-color="grey-3"
				/>
			</div>
		</q-dialog>
		<div
			 class="tw-transition-all tw-max-w-[93vw] max-sm:tw-min-w-[80vw] tw-min-w-[40vw] tw-bg-white tw-rounded-2xl tw-p-6 tw-pb-4 tw-overflow-x-hidden">
			<div v-if="estagio === 0" class="tw-w-[100%] tw-justify-center tw-rounded-lg">
				<div class="tw-flex tw-flex-col tw-justify-center tw-p-2 tw-bg-white tw-items-center tw-rounded-lg">
					<div class="tw-flex tw-flex-1 tw-justify-center tw-items-center tw-flex-col lg:tw-flex-row">
						<img alt=""
						     class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10"
						     src="../../../imgs/logo-efg.svg"/>
					</div>
					<p class="tw-w-[287px] tw-text-center tw-text-green-800 tw-text-[27px] tw-font-bold tw-font-['Exo 2'] tw-leading-[28.80px]">
						Envio de Documentos</p>
					<p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-5 tw-text-center">
						Olá! Você esta acessando a página para envio de documentos.</p>
					<p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-5 tw-text-center tw-pb-3"> Conforme
						descrito no
						Edital, separe seus documentos e vamos lá. </p>
					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-center tw-flex-row">
							<PrimaryButton button-class="tw-text-white tw-flex tw-bg-primary tw-h-10" @click="avancar">
								VAMOS LÁ
							</PrimaryButton>
						</div>
					</div>
				</div>
			</div>
			<div v-if="estagio === 1" class="tw-w-[100%] tw-justify-center tw-rounded-lg">
				<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
					<img alt=""
					     class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10"
					     src="../../../imgs/logo-efg.svg"/>
				</div>
				<h4 class="tw-pb-4">Login</h4>
				<p class="tw-text-lg tw-text-gray-600 tw-font-thin"> Preencha os campos abaixo para continuar </p>
				<div class="tw-flex tw-flex-1 tw-items-start tw-flex-col lg:tw-grid">
					<InputLabel for="documento" required value="Documento"/>
					<div class="tw-mt-1 tw-pb-3 tw-flex tw-flex-1 tw-gap-1 tw-w-[100%]">
						<q-select v-model="form.verificacao_tipo_documento" :options="optionsDoc"
						          class="tw-h-[52px] tw-block tw-w-[30%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          outlined/>
						<InputError :message="form.errors.verificacao_tipo_documento" class="tw-mt-2"/>
						<!--suppress JSValidateTypes -->
						<q-input id="documento" v-model="form.verificacao_documento"
						         :error="form.errors.verificacao_documento"
						         :mask="getMaskForTipoDoc(form.verificacao_tipo_documento)"
						         autocomplete="documento" autofocus
						         class="tw-h-[52px] tw-w-[100%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         required type="text"/>
						<InputError :message="form.errors.documento" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-gap-5 tw-pb-4">
					<div class="tw-w-[100%] tw-justify-center tw-rounded-xl tw-pb-4">
						<InputLabel for="verificacao_nascimento" value="Data de Nascimento"/>
						<q-input id="verificacao_nascimento" v-model="form.verificacao_nascimento"
						         autocomplete="verificacao_nascimento" autofocus
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined
						         type="date"/>
						<InputError :message="form.errors.verificacao_nascimento" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex tw-flex-col">
					<div class="tw-grid tw-grid-cols-1 tw-gap-2 tw-w-[100%] lg:tw-flex tw-flex-1 tw-justify-end">
						<PrimaryButton button-class="tw-text-white tw-justify-center tw-flex tw-bg-primary tw-h-10"
						               @click="pesquisarInscricoes">CONTINUAR
						</PrimaryButton>
						<PrimaryButton
							 button-class="tw-text-primary tw-justify-center tw-bg-white tw-border-2 tw-border-primary tw-h-10"
							 @click="voltar">
							VOLTAR
						</PrimaryButton>
					</div>
				</div>
			</div>
			<br/>
			<div v-if="estagio === 2" class="tw-bg-white tw-pb-2 tw-flex tw-flex-col tw-gap-4 tw-w-[100%] tw-rounded-lg">
				<h4 class="tw-text-zinc-800 tw-font-bold font-['Exo 2'] tw-leading-normal">Cursos Inscritos</h4>
				<p class="tw-w-[100%] tw-text-base font-normal font-['Open Sans']">Selecione um dos cursos que você se
					inscreveu
					para enviar a documentação.</p>
				<div v-for="(item, index) in inscricao" :key="index">
					<q-card style="min-width: 40vw; max-width: 100%; border-radius: 10px; padding: 20px;">
						<q-radio v-model="form.inscricaoSelected" :val="item.id" checked-icon="task_alt"
						         class="tw-text-lg tw-mb-2"
						         unchecked-icon="panorama_fish_eye">{{ item.turma.curso.nome }}
						</q-radio>
						<div class="tw-flex tw-justify-end">
							<button @click="openItem(item)">
								<Icon icon="ep:arrow-down"/>
							</button>
						</div>
						<Transition name="fade">
							<div v-if="open === item" class="tw-mt-5">
								<hr>
								<p class="tw-text-xl tw-text-gray-600 tw-pt-5">
									Local: <br><b> {{ item.turma.edital.escola.nome }} em
									{{ item.turma.edital.escola.municipio.nome }}</b></p>
								<p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-bg-gray-100 tw-p-6 tw-rounded-lg">
									{{ item.turma.nome }}
								</p>
							</div>
						</Transition>
					</q-card>
				</div>
				<!-- Rodapé -->
				<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
					{{ item }}
					<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
						<PrimaryButton button-class="tw-text-white tw-justify-center tw-flex tw-bg-primary tw-h-10"
						               @click="avancarId()">CONTINUAR
						</PrimaryButton>
						<PrimaryButton
							 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
							 @click="voltar">
							VOLTAR
						</PrimaryButton>
					</div>
				</div>
			</div>
			<div v-if="estagio === 3" class="tw-flex tw-flex-1 tw-bg-white tw-flex-col tw-w-[100%] tw-rounded-lg">
				<h5 class="tw-text-zinc-800 tw-font-bold font-['Exo 2'] tw-pb-4">Envio de Documentos Pessoais</h5>
				<div class="tw-justify-center tw-items-center tw-rounded-lg tw-bg-slate-100 tw-p-2 tw-mb-4">
					<p class="tw-text-base tw-font-semibold tw-py-4"> {{ inscricaoDocumento[0].turma.curso.nome }} </p>
					<div class="tw-grid tw-grid-cols-1 tw-gap-12 tw-pb-5 ">
						<div class="tw-grid tw-grid-cols-12 tw-gap-10 tw-text-lg ">
							<Icon class="tw-text-primary" height="28" icon="uiw:date" width="28"/>
							{{ formatDate(inscricaoDocumento[0].created_at) }}
						</div>
					</div>
					<div class="tw-grid tw-grid-cols-1 tw-gap-12 tw-pb-5">
						<div class="tw-grid tw-grid-cols-12 tw-gap-10 tw-text-lg">
							<Icon class="tw-text-primary" height="28" icon="solar:home-2-outline" width="28"/>
							{{ inscricaoDocumento[0].turma.edital.escola.nome }}
						</div>
					</div>
					<div class="tw-grid tw-grid-cols-1 tw-gap-12">
						<div class="tw-grid tw-grid-cols-12 tw-gap-10 tw-text-lg">
							<Icon class="tw-text-primary" height="28" icon="tdesign:location" width="28"/>
							{{ inscricaoDocumento[0].turma.edital.escola.municipio.nome }}
						</div>
					</div>
				</div>
				<p class="tw-font-base tw-text-zinc-800 font-['Exo 2'] tw-pb-4">Anexe abaixo os documentos necessários para
					finalizar seu processo de matricula.</p>
				<div v-for="(item, index) in inscricaoDocumento[0].turma.edital.tipo_arquivos" :key="index" class="tw-pb-5">
					<div class="tw-flex md:tw-flex-row tw-flex-col">
						<div class="tw-flex tw-flex-1 tw-flex-col tw-pb-4">
							<h5 class="tw-text-gray-900 tw-font-body tw-text-sm tw-mb-1 tw-font-semibold">
								{{ item.tipo_arquivo.nome }}
							</h5>
							<div class="tw-flex tw-justify-end">
								<button @click="openItem(item)">
									<Icon icon="ep:arrow-down"/>
								</button>
							</div>
							<Transition name="fade">
								<div v-if="open === item" class="tw-mt-5">
									<hr>
									<p class="tw-flex tw-flex-1 tw-text-xl tw-text-gray-600 tw-font-thin tw-p-6 tw-rounded-lg"
									   style="white-space: pre-line;">
										{{ formatarQuebrasDeLinha(item.tipo_arquivo.orientacao) }}</p>
									<PrimaryButton
										 button-class="tw-text-primary tw-flex tw-self-center tw-items-center tw-bg-white tw-border-2 tw-border-primary tw-h-12 tw-rounded-lg tw-w-[100%] text-center tw-justify-center"
										 @click="openAnexosModal(item, inscricaoDocumento[0].id)">
										<Icon class="tw-pr-1" height="30"
										      icon="material-symbols-light:upload-file-outline-rounded"
										      width="30"/>
										ANEXAR ARQUIVO
									</PrimaryButton>
								</div>
							</Transition>
						</div>
					</div>
					<hr>
				</div>
				<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row tw-mt-2">
					<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
						<PrimaryButton
							 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
							 @click="voltar">
							VOLTAR
						</PrimaryButton>
						<PrimaryButton button-class="tw-text-white tw-flex tw-bg-primary tw-h-10" @click="avancar">ENVIAR
						</PrimaryButton>
					</div>
				</div>
			</div>
			<div v-if="estagio === 4"
			     class="tw-flex tw-flex-1 tw-flex-col tw-gap-6 tw-p-8 tw-text-center tw-justify-center tw-bg-white tw-w-auto tw-rounded-lg">
				<img alt="" class="tw-h-[60px] tw-w-auto tw-mb-5" src="../../../imgs/logo-efg.svg"/>
				<h2 class="tw-font-bold tw-font-title tw-text-blue-900 tw-text-5xl tw-leading-9 tw-pb-1 ">
					Obrigado! Iremos validar os documentos!
				</h2>
				<h5 class="tw-font-bold tw-font-title tw-text-blue-900 tw-text-3xl tw-leading-7">
					Fique ligado em nossas redes sociais!
				</h5>
				<h6 class="tw-font-medium tw-font-subtitle tw-text-blue-900 tw-text-lg tw-leading-6 tw-mb-4">
					Indique a nossa escola para alguém que também pode aproveitas essa oportunidade!
				</h6>
			</div>
		</div>
		<!-- Confirmado -->
		<br/>
	</SelecaoLayout>
</template>

<style scoped>
button {
	padding: 10px;
	font-size: 16px;
}
</style>