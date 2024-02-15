<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import SelecaoLayout from '@/Layouts/SelecaoLayout.vue';
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import {onMounted, ref} from 'vue';
import {Icon} from "@iconify/vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import InputError from "@/Components/Pages/InputError.vue";
import {Notify} from 'quasar';
import axios from 'axios';
import Camera from "simple-vue-camera";

const props = defineProps({
	inscricao: {
		type: Object,
		default: {},
	},
	documentos: {
		type: Array,
		default: [],
	},
	nomeDocumentos: {
		type: Array,
		default: [],
	},
	comprovante: {
		type: Array,
		default: []
	}
})

const form = useForm({
	link: '',
	arquivos: [],
	verificacao_documento: "",
	verificacao_nascimento: "",
	verificacao_tipo_documento: "",
	inscricaoId: props.inscricao.id,
	documentoMatriculaId: '',
	inscricaoSelected: "",
	idDoc: "",
});

const testeSelected = ref('')
const openPresencial = ref(false)
const openOnline = ref(false)
const openDocumento = ref(false)

const filtersModal = ref(false)
const deleteModal = ref(false)
const estagio = ref(0)
const modalAnexosArquivos = ref(false)
const anexosModalPhoto = ref(false)
const fileAnexosModalVisible = ref(false)
const fileAnexosLinkModalVisible = ref(false)
const capturedImage = ref(null);
let capturedBlob = null;
const anexosId = ref('')
const slide = ref(1)
const idDoc = ref('')
const documentoMatriculaId = ref('')
const comprovantes2 = ref('')
const secondDialog = ref(false)

const imagem = ref('')

// Cursos
const filtroTipo = ref([])
const filtroModalidade = ref([])
const filtroTurno = ref([])

const localSelected = ref('');
const curso = ref([])

const open = ref('');
const camera = ref();

const estagios = [
	{titulo: '', subtitulo: ''}, //Home
	{titulo: 'Teste de Aptidão', subtitulo: 'Selecione uma das modalidades para realizar seu teste de aptidão.'},
	{titulo: 'Teste de Aptidão', subtitulo: ''},
	{titulo: '', subtitulo: ''},
	{titulo: '', subtitulo: ''},
	{titulo: '', subtitulo: ''},
	{titulo: '', subtitulo: ''},
	{titulo: '', subtitulo: ''},
	{titulo: '', subtitulo: ''},
	{titulo: '', subtitulo: ''},
]

function closeModal() {
	filtersModal.value = false
}

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
					imagem.value = 2;
				}
			} else {
				console.error('Ação inválida:', action);
			}
		} catch (error) {
			console.error('Erro ao capturar/excluir a imagem:', error);
			const video = ref(null);
			const canvas = ref(null);

			onMounted(async () => {
				try {
					const stream = await navigator.mediaDevices.getUserMedia({video: true});
					if (video.value) {
						video.value.srcObject = stream;
					}
				} catch (error) {
					console.error('Erro ao acessar a câmera: ', error.name, error.message);
				}
			});

			const takePhoto = () => {
				if (!video.value || !canvas.value) {
					console.error('Elementos de vídeo ou canvas não encontrados.');
					return;
				}

				const context = canvas.value.getContext('2d');
				if (!context) {
					console.error('getContext não é suportado neste navegador.');
					return;
				}

				context.drawImage(video.value, 0, 0, 640, 480);
				const dataURL = canvas.value.toDataURL('image/png');
				console.log('Foto tirada:', dataURL);

				// Aqui você pode enviar a imagem para o servidor (Laravel) usando uma requisição HTTP.
			};
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

function openItem(item) {
	if (open.value === item) {
		open.value = null;
	} else {
		open.value = item;
	}
}

const openAnexosModalPhoto = () => {
	secondDialog.value = true;
	setTimeout(function () {
		secondDialog.value = false;
		anexosModalPhoto.value = true
	}, 500); // 3000 milissegundos = 3 segundos
}

const closeAnexosModalPhoto = () => {
	anexosModalPhoto.value = false;
};

const openAnexosModal = (id, idDoc) => {
	secondDialog.value = true;
	setTimeout(function () {
		secondDialog.value = false;
		anexosId.value = id;
		modalAnexosArquivos.value = false;
		fileAnexosModalVisible.value = true;
	}, 500); // 3000 milissegundos = 3 segundos
}

const openAnexosLinkModal = (id, idDoc) => {
	secondDialog.value = true;
	setTimeout(function () {
		secondDialog.value = false;
		anexosId.value = id;
		fileAnexosLinkModalVisible.value = true;
	}, 500); // 3000 milissegundos = 3 segundos
}

const closeAnexosLinkModal = () => {
	fileAnexosLinkModalVisible.value = false;
}

const closeAnexosModal = () => {
	fileAnexosModalVisible.value = false;
};

const openModalAnexosArquivos = () => {
	secondDialog.value = true;
	setTimeout(function () {
		secondDialog.value = false;
		modalAnexosArquivos.value = true
	}, 500); // 3000 milissegundos = 3 segundos
}

const closeModalAnexosArquivos = () => {
	modalAnexosArquivos.value = false;
};

function avancar() {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		estagio.value = estagio.value + 1;
	}, 500); // 3000 milissegundos = 3 segundos
}

function finalizar() {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		estagio.value = estagio.value + 1;
	}, 3000); // 3000 milissegundos = 3 segundos
}

function voltar() {
	secondDialog.value = true;
	// Definir secondDialog.value como false após 3 segundos
	setTimeout(function () {
		secondDialog.value = false;
		estagio.value = estagio.value - 1
	}, 500); // 3000 milissegundos = 3 segundos

}

const formatDate = (dateTime) => {
	const [dia, mes, ano] = new Date(dateTime).toLocaleDateString('pt-BR').split('/');
	return `${dia}/${mes}/${ano}`;
};

const formatTime = (dateTime) => {
	const horaMinuto = new Date(dateTime).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
	return `${horaMinuto}`;
};

const formatarQuebrasDeLinha = (texto) => {
	return texto.replace(/&/g, '\n');
};

function selecionarLocal() {
	secondDialog.value = true;
	setTimeout(function () {
		secondDialog.value = false;
		if (testeSelected.value === 'Presencial') {
			estagio.value = 3
		} else {
			estagio.value += 1;
		}
	}, 3000); // 3000 milissegundos = 3 segundos
}

function store(id, tipo_arquivoId, versao, tipo, tipo_arquivo) {

	const arquivosSelecionados = form.arquivos;
	form.documentoMatriculaId = tipo_arquivoId;
	form.idDoc = id;
	form.tipo_arquivo = tipo_arquivo;

	form.post(route('inscricao.aptidao.store'), {
		inscricaoId: idDoc,
		arquivos: form.arquivos,
		documentoMatriculaId: documentoMatriculaId,
		tipoArquivo: tipo_arquivo,

		onSuccess: (res) => {
			form.reset();
			Notify.create({
				message: "Inscrição realizada com sucesso.",
				color: "secondary"
			});

			secondDialog.value = true;
			setTimeout(function () {
				secondDialog.value = false;
				fileAnexosLinkModalVisible.value = false
				fileAnexosModalVisible.value = false

				axios.post(route('inscricao.aptidao.request'), {
					inscricaoSelected: id,
				})
					 .then((res) => {
						 comprovantes2.value = res.data.comprovante
						 estagio.value = 2;
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
			}, 500); // 3000 milissegundos = 3 segundos
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
				color: "negative"
			});
		}
	});
}

</script>
<template>
	<Head title="Sistema de Seleção"/>
	<SelecaoLayout>
		<q-dialog v-model="filtersModal">
			<q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
				<q-card-section>
					<div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no
						filtro
						abaixo:
					</div>
				</q-card-section>
				<q-card-section class="q-p-none">
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4 tw-mb-4">
						<div class=" tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">CATEGORIA</h5>
							<div v-for="opcao in opcoesTipo"
							     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
								<q-checkbox v-model:model-value="filtroTipo" :val="opcao"/>
								{{ opcao }}
							</div>
						</div>
						<div class="tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">MODALIDADE</h5>
							<div v-for="opcao in opcoesModalidade"
							     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
								<q-checkbox v-model:model-value="filtroModalidade" :val="opcao"/>
								{{ opcao }}
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
						<div class=" tw-flex tw-flex-1 tw-flex-col">
							<h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">TURNO</h5>
							<div v-for="opcao in opcoesTurno"
							     class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
								<q-checkbox v-model:model-value="filtroTurno" :val="opcao"/>
								{{ opcao }}
							</div>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
						<div class="tw-flex tw-flex-1">
							<button
								 class="tw-flex tw-px-8 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center"
								 @click="clearFilters">
								LIMPAR FILTROS
							</button>
						</div>
						<div class="tw-flex tw-flex-1 flex-row tw-gap-4">
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"
								 @click="closeModal">
								CANCELAR
							</button>
							<button
								 class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"
								 @click="applyCursoFilter">
								APLICAR FILTROS
							</button>
						</div>
					</div>
				</q-card-section>
				<q-card-actions align="right">
				</q-card-actions>
			</q-card>
		</q-dialog>

		<q-dialog v-model="fileAnexosModalVisible">
			<q-carousel v-model="slide" animated arrows class="bg-white shadow-1 rounded-borders tw-h-auto tw-rounded-2xl"
			            control-color="primary" navigation-icon="radio_button_unchecked" transition-next="slide-left"
			            transition-prev="slide-right">
				<q-carousel-slide :name="1" class="tw-column tw-no-wrap flex-start tw-h-auto">
					<div class="tw-grid tw-grid-cols-12 ">
						<h5 class="tw-col-span-11 tw-text-blue-950 tw-font-bold font-['Exo 2'] tw-pb-4 tw-">Teste de Aptidão
						</h5>
						<Icon height="30" icon="ei:close-o" width="30" @click="closeAnexosModal"/>
					</div>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-xl tw-mb-6 tw-font-semibold tw-flex tw-justify-start">{{
							anexosId.nome
						}}</h5>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-lg tw-mb-1 tw-pt-3 tw-font-semibold tw-flex tw-justify-start">
						Deve conter: </h5>
					<p class="tw-flex tw-flex-1 tw-text-xl tw-text-gray-600 tw-font-thin tw-p-4 tw-rounded-lg"
					   style="white-space: pre-line;">
						{{ formatarQuebrasDeLinha(anexosId.tipo_arquivo.orientacao) }}
					</p>
					<q-file v-model="form.arquivos" accept="image/jpeg, image/jpg, application/pdf" bg-color="white"
					        class="tw-w-auto tw-items-center tw-mx-auto "
					        input-class="tw-text-primary tw-block tw-rounded-md tw-self-start focus:tw-border-primary focus:tw-ring-0 tw-shadow-sm"
					        label="SELECIONAR ARQUIVO" label-color="green"
					        outlined
					        rounded>
						<template v-slot:prepend>
							<Icon class="tw-text-green-700" icon="majesticons:file-line"/>
						</template>
					</q-file>
					<br/>
					<div class="tw-grid tw-grid-rows-2 tw-justify-center">
						<PrimaryButton
							 button-class="tw-text-primary tw-border tw-border-primary tw-flex tw-justify-center tw-h-10 tw-mb-1 tw-w-[350px]"
							 @click="openAnexosModalPhoto">
							<Icon class="tw-text-green-700 tw-pr-1" height="20" icon="akar-icons:camera" width="20"/>
							TIRAR FOTO
						</PrimaryButton>
						<PrimaryButton
							 button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10"
							 @click="store(props.inscricao.id, anexosId.tipo_arquivo.id, anexosId.tipo_arquivo.tipo_versao, 'Frente', anexosId.tipo_arquivo)">
							<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line" width="20"/>
							Continuar
						</PrimaryButton>
					</div>
				</q-carousel-slide>
			</q-carousel>
		</q-dialog>

		<q-dialog v-model="anexosModalPhoto" full-width>
			<q-card class="tw-py-1 tw-w-auto tw-rounded-2xl">
				<q-card-section class="tw-flex tw-flex-col tw-justify-between tw-items-center ">
					<div class="tw-grid tw-grid-cols-12 ">
						<h5 class="tw-col-span-11 tw-text-blue-800 tw-font-bold tw-font-['Exo 2'] tw-pb-4 tw-">Tirar Foto com
							a Câmera
						</h5>
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
						 button-class="tw-text-primary tw-border tw-border-primary tw-flex tw-justify-center tw-h-10 tw-w-auto tw-m-3"
						 @click="captureSnapshot(2)">
						<Icon class="tw-text-green-700 tw-pr-1" height="20" icon="akar-icons:camera" width="20"/>
						TIRAR
						OUTRA FOTO
					</PrimaryButton>
					<PrimaryButton button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10 tw-w-auto "
					               @click="downloadAndUpload">
						<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line" width="20"/>
						Enviar
						foto
					</PrimaryButton>
				</q-card-section>
			</q-card>
		</q-dialog>

		<q-dialog v-model="fileAnexosLinkModalVisible">
			<q-carousel v-model="slide" animated arrows class="bg-white shadow-1 rounded-borders tw-h-auto tw-rounded-2xl"
			            control-color="primary" navigation-icon="radio_button_unchecked" transition-next="slide-left"
			            transition-prev="slide-right">
				<q-carousel-slide :name="1">
					<div class="tw-grid tw-grid-cols-12">
						<h5 class="tw-col-span-11 tw-text-blue-950 tw-font-bold tw-font-['Exo 2'] tw-pb-4 tw-">Teste de
							Aptidão
						</h5>
						<Icon height="30" icon="ei:close-o" width="30" @click="closeAnexosLinkModal"/>
					</div>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-xl tw-mb-4 tw-font-semibold tw-flex tw-justify-start">{{
							anexosId.nome
						}}</h5>
					<p class="tw-w-[309px] tw-text-zinc-800 tw-text-sm tw-font-normal tw-font-['Open Sans']">Adicione um link
						que
						redirecione nosso professores para a avaliação do seu video teste em uma plataforma externa.</p>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-lg tw-mb-1 tw-pt-3 tw-font-semibold tw-flex tw-justify-start">
						Deve conter: </h5>
					<p class="tw-flex tw-flex-1 tw-text-xl tw-text-gray-600 tw-bg-green-50 tw-font-thin tw-p-4 tw-rounded-lg"
					   style="white-space: pre-line;">
						{{ formatarQuebrasDeLinha(anexosId.tipo_arquivo.orientacao) }}
					</p>
					<div class="tw-flex tw-flex-auto tw-flex-col tw-mt-1 tw-mb-8">
						<InputLabel for="link" required value="Link Para Acesso"/>
						<q-input id="link" v-model="form.link"
						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						         outlined placeholder="Url do vídeo" type="text"/>
						<InputError :message="form.errors.link" class="tw-mt-2"/>
					</div>
					<div class="tw-grid tw-justify-center">
						<PrimaryButton
							 button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10 tw-w-[350px]"
							 @click="store(props.inscricao.id, anexosId.tipo_arquivo.id, anexosId.tipo_arquivo.tipo_versao, 'Frente', anexosId.tipo_arquivo)">
							<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line" width="20"/>
							Continuar
						</PrimaryButton>
					</div>
				</q-carousel-slide>
			</q-carousel>
		</q-dialog>

		<q-dialog v-model="modalAnexosArquivos">
			<q-card class="tw-h-auto tw-rounded-2xl">
				<q-card-section class="tw-flex tw-flex-col tw-justify-between tw-items-right ">
					<div class="tw-grid tw-grid-cols-12 ">
						<h5 class="tw-col-span-11 tw-text-zinc-800 tw-font-bold font-['Exo 2'] tw-pb-4 tw-">Envio de
							Documentos
							Pessoais </h5>
						<Icon height="30" icon="ei:close-o" width="30" @click="closeModalAnexosArquivos"/>
					</div>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-xl tw-mb-2 tw-font-semibold tw-flex tw-justify-start">{{
							anexosId.tipo_arquivo.nome
						}}</h5>
					<h5 class="tw-text-gray-900 tw-font-body tw-text-lg tw-mb-1 tw-font-semibold tw-flex tw-justify-start">
						Arquivo Anexado: </h5>
					<div class="tw-grid tw-grid-cols-1 tw-gap-0 tw-w-full tw-mb-5">
						<div v-for="doc_ in comprovantes2.comprovantes_aptidao" :key="doc_.id">
							<p class="tw-pt-5 tw-text-lg">{{ doc_.tipo_arquivo.nome }}</p>
							<a class="tw-flex tw-cursor-pointer tw-px-2 tw-border tw-rounded-md tw-font-body tw-w-[100%] tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center">
								<Icon class="tw-pr-3 tw-flex-none tw-w-[10%]" height="33"
								      icon="heroicons:document" width="33"/>
								<p class="tw-mt-4 tw-w-[90%]">
									{{ doc_.nome_arquivo }} </p>
								<PrimaryButton class="tw-text-black tw-text-lg tw-w-[40%]">
									<Icon :rotate="1" icon="solar:menu-dots-bold"/>
									<q-menu auto-close>
										<div class="tw-flex tw-flex-col tw-gap-2">
											<span v-if="doc_.tipo_arquivo.tipo_arquivo === 'Arquivo'"
											      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-right tw-items-end"
											      title="Alterar" @click="openAnexosModal(doc_)">Substituir </span>
											<span v-if="doc_.tipo_arquivo.tipo_arquivo === 'Link'"
											      class="tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-right tw-items-end"
											      title="Alterar" @click="openAnexosLinkModal(doc_)">Substituir </span>
										</div>
									</q-menu>
								</PrimaryButton>
							</a>
							<InputError :message="form.errors.nome_completo" class="tw-mt-2"/>
							<div class="tw-flex tw-items-center tw-justify-between tw-mt-1">
								<div class="tw-flex tw-gap-2">
									<Icon class="tw-mt-1 tw-text-primary" icon="fluent-mdl2:status-circle-inner"/>
									<InputLabel class="tw-mb-4" value="Status"/>
								</div>
								<div class="tw-flex">
									<p class="tw-text-gray-500 tw-font-body tw-text-sm tw-mb-1 tw-font-semibold tw-flex tw-justify-start">
										Anexado em: &nbsp
										<InputLabel :value="formatDate(doc_.created_at)" class="tw-mb-1"/>
									</p>
								</div>
							</div>
							<hr/>
						</div>
					</div>
					<PrimaryButton
						 button-class="tw-text-white tw-flex tw-justify-center tw-bg-primary tw-h-10 tw-w-auto tw-pb-5"
						 @click="closeModalAnexosArquivos()">
						<Icon class="tw-text-white tw-pr-1" height="20" icon="majesticons:file-line" width="20"/>
						Concluir
					</PrimaryButton>
				</q-card-section>
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
			 class="tw-transition-all tw-max-w-[90vw] max-sm:tw-min-w-[80vw] tw-min-w-[40vw] tw-bg-white tw-rounded-2xl tw-p-5 tw-py-4 tw-overflow-x-hidden">
			<div v-if="estagio === 0" class="tw-justify-center tw-flex tw-flex-col tw-items-center tw-gap-5">
				<img alt="" class="tw-h-[60px] tw-w-auto tw-mb-5" src="../../../imgs/logo-efg.svg"/>
				<h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">Teste de Aptidão</h5>
				<h6 class="tw-font-medium tw-font-subtitle tw-text-gray-900 tw-text-lg tw-leading-5">Olá! Você esta
					acessando a
					página para envio de documentos.</h6>
				<p
					 class="lg:tw-max-w-[60vh] md:tw-max-w-[50vh] tw-text-center sm:tw-max-w-auto tw-font-subtitle tw-text-gray-900 tw-text-base tw-leading-5">
					Conforme descrito no Edital, separe seus documentos e vamos lá.</p>
				<PrimaryButton button-class="tw-text-white tw-bg-primary" @click="avancar">VAMOS LÁ</PrimaryButton>
			</div>
			<div v-if="estagio > 0 && estagio <= 10"
			     class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-justify-around tw-transition-all">
				<div class="tw-flex tw-gap-5 tw-flex-col">
					<h4 class="tw-text-gray-800 tw-font-title tw-font-bold tw-leading-none tw-text-xl">{{
							estagios[estagio].titulo
						}}</h4>
					<div class="tw-flex tw-justify-between">
						<h5 class="tw-font-title tw-text-gray-500 tw-font-semibold tw-text-lg">
							{{ estagios[estagio].subtitulo }}</h5>
					</div>
				</div>
				<div v-if="estagio === 1" class="tw-flex tw-flex-1 tw-flex-col tw-gap-2 tw-min-w-[60vw]">
					<div class="tw-flex tw-flex-1 tw-max-h-full">
						<div
							 class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-1 tw-gap-4 tw-px-2 tw-py-4 tw-max-w-full lg:tw-max-w-[60vw]">
							<q-card v-if="props.inscricao.turma.teste_aptidao_local_presencial === '1'"
							        style="min-width: 40vw; max-width: 100%; border-radius: 10px; padding: 20px;">
								<h5 class="tw-text-grey-500 tw-text-xl tw-font-normal tw-font-body">
									<q-radio v-model="testeSelected"
									         :val="'Presencial'" checked-icon="task_alt"
									         class=" tw-text-zinc-800 tw-text-base tw-font-bold tw-font-['Open Sans']"
									         unchecked-icon="panorama_fish_eye">
										{{ 'Teste Presencial' }}
									</q-radio>
								</h5>
								<div class="tw-flex tw-justify-end">
									<button @click="openPresencial = !openPresencial">
										<Icon v-if="!openPresencial" icon="ep:arrow-down"/>
										<Icon v-if="openPresencial" icon="ep:arrow-up"/>
									</button>
								</div>
								<Transition name="fade">
									<div v-if="openPresencial"
									     class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-1 tw-gap-4 tw-px-2 tw-py-4 tw-max-w-full lg:tw-max-w-[60vw]">
										<hr/>
										<p class="tw-text-xl tw-text-gray-600 tw-font-thin tw-leading-5 tw-pb-5 tw-mt-5">Ao
											selecionar a
											modalidade presencial você estará confirmando sua presença para as avaliações.</p>
										<p class="tw-font-bold tw-text-xl tw-text-gray-600 tw-leading-5 tw-pb-4">Informações sobre
											o teste de
											aptidão presencial</p>
										<div class="tw-grid tw-grid-cols-2 tw-gap-12 tw-pb-5">
											<div class="tw-grid tw-grid-cols-12 tw-gap-10 tw-text-lg">
												<Icon class="tw-text-primary" height="28" icon="uiw:date" width="28"/>
												{{ formatDate(props.inscricao.turma.teste_aptidao_data_presencial) }}
											</div>
											<div class="tw-grid tw-grid-cols-12 tw-gap-10 tw-text-lg">
												<Icon class="tw-text-primary" height="28" icon="solar:watch-square-outline"
												      width="28"/>
												{{ props.inscricao.turma.teste_aptidao_hora_presencial }}
											</div>
										</div>
										<div class="tw-grid tw-grid-cols-2 tw-gap-12 tw-pb-5">
											<div class="tw-grid tw-grid-cols-12 tw-gap-10 tw-text-lg">
												<Icon class="tw-text-primary" height="28" icon="solar:home-2-outline" width="28"/>
												{{ props.inscricao.turma.escola.nome }}
											</div>
										</div>
										<div class="tw-grid tw-grid-cols-2 tw-gap-12">
											<div class="tw-grid tw-grid-cols-12 tw-gap-10 tw-text-lg">
												<Icon class="tw-text-primary" height="28" icon="tdesign:location" width="28"/>
												{{ props.inscricao.turma.escola.municipio.nome }}
											</div>
										</div>
									</div>
								</Transition>
							</q-card>
							<q-card v-if="props.inscricao.turma.teste_aptidao_local_online === '1'"
							        style="min-width: 40vw; max-width: 100%; border-radius: 10px; padding: 20px;">
								<h5 class="tw-text-grey-500 tw-text-xl tw-font-normal tw-font-body">
									<q-radio v-model="testeSelected"
									         :val="'Online'" checked-icon="task_alt"
									         class=" tw-text-zinc-800 tw-text-base tw-font-bold tw-font-['Open Sans']"
									         unchecked-icon="panorama_fish_eye">
										{{ 'Enviar Teste Online' }}
									</q-radio>
								</h5>
								<div class="tw-flex tw-justify-end">
									<button @click="openOnline = !openOnline">
										<Icon v-if="!openOnline" icon="ep:arrow-down"/>
										<Icon v-if="openOnline" icon="ep:arrow-up"/>
									</button>
								</div>
								<Transition name="fade">
									<div v-if="openOnline"
									     class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-1 tw-gap-4 tw-px-2 tw-py-4 tw-max-w-full lg:tw-max-w-[60vw]">
										<hr/>
										<div>
											<p class="tw-text-zinc-800 tw-text-sm tw-font-bold tw-font-['Open Sans']"> Voce Deve
												Enviar: </p>
											<div>
												<q-card v-for="(item, index) in props.nomeDocumentos" :key="index"
												        class=" tw-p-5 tw-rounded-lg tw-bg-green-50 tw-text-emerald-900 tw-font-bold tw-text-sm tw-font-['Open Sans'] leading-[16.80px] tw-mb-4">
													{{ item }}
												</q-card>
											</div>

										</div>
									</div>
								</Transition>
							</q-card>
						</div>
					</div>
					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<PrimaryButton
								 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
								 @click="voltar">
								Voltar
							</PrimaryButton>
							<PrimaryButton v-if="testeSelected !== ''"
							               button-class="tw-text-white tw-px-14 tw-self-center tw-text-center tw-bg-primary tw-h-10 tw-w-[50%] tw-items-center tw-justify-center lg:tw-w-[18%]"
							               @click="selecionarLocal()">
								AVANÇAR
							</PrimaryButton>
						</div>
					</div>
				</div>
				<div v-if="estagio === 2" class="tw-flex tw-flex-1 tw-flex-col tw-gap-2 tw-min-w-[60vw]">
					<div class="tw-flex tw-flex-1 tw-max-h-full">
						<div
							 class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-1 tw-gap-4 tw-py-2 tw-max-w-full lg:tw-max-w-[60vw]">
							<div class="tw-bg-gray-100 tw-p-2 tw-rounded-lg">
								<p class="tw-font-bold tw-text-lg tw-mb-3">Enviar teste online</p>
								<p class="tw-w-[120px] tw-text-stone-500 tw-font-normal tw-font-['Open Sans'] tw-uppercase tw-mb-1">
									Curso:
								</p>
								<p class="tw-w-full tw-font-bold tw-font-['Open Sans'] tw-uppercase tw-mb-1">{{
										props.inscricao.turma.curso.nome
									}}</p>
								<p class="tw-w-full tw-text-stone-500 tw-font-normal tw-font-['Open Sans']">{{
										props.inscricao.turma.escola.nome + ' em ' + props.inscricao.turma.escola.municipio.nome
									}}</p>
								<p class="tw-font-normal tw-text-stone-800 tw-text-lg tw-font-['Open Sans']">Anexe abaixo os
									conteúdos
									necessários para finalizar seu teste de aptidão.</p>
							</div>
							<div v-for="(item, index) in props.inscricao.turma.tipo_arquivos" :key="index">
								<q-card class="tw-min-w-[40vw] tw-max-w-[100%] tw-pb-2 tw-p-3 tw-rounded-lg ">
									<p class="tw-w-[231px] tw-text-zinc-800 tw-text-lg tw-pl-4 tw-font-bold tw-font-['Open Sans']">
										{{
											item.tipo_arquivo.nome
										}}</p>
									<div class="tw-flex tw-justify-end">
										<button @click="openItem(item)">
											<Icon v-if="!open" icon="ep:arrow-down"/>
											<Icon v-if="open" icon="ep:arrow-up"/>
										</button>
									</div>
									<Transition name="fade">
										<div v-if="open === item"
										     class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-1 tw-gap-4 tw-px-2 tw-py-4 tw-max-w-full lg:tw-max-w-[60vw]">
											<hr>
											<p class="tw-flex tw-flex-1 tw-text-xl tw-text-gray-600 tw-font-thin tw-p-6 tw-rounded-lg"
											   style="white-space: pre-line;">
												{{ formatarQuebrasDeLinha(item.tipo_arquivo.orientacao) }}
											</p>
											<PrimaryButton v-if="item.tipo_arquivo.tipo_arquivo === 'Arquivo'"
											               button-class="tw-text-primary tw-flex tw-self-center tw-items-center tw-bg-white tw-border-2 tw-border-primary tw-h-12 tw-rouded-lg tw-w-auto text-center tw-justify-center"
											               @click="openAnexosModal(item)">
												<Icon class="tw-pr-1" height="30"
												      icon="material-symbols-light:upload-file-outline-rounded"
												      width="30"/>
												ANEXAR ARQUIVO
											</PrimaryButton>
											<PrimaryButton v-if="item.tipo_arquivo.tipo_arquivo === 'Link'"
											               button-class="tw-text-primary tw-flex tw-self-center tw-items-center tw-bg-white tw-border-2 tw-border-primary tw-h-12 tw-rouded-lg tw-w-auto text-center tw-justify-center"
											               @click="openAnexosLinkModal(item)">
												<Icon class="tw-pr-1" height="30" icon="solar:link-square-bold" width="30"/>
												ADICIONAR LINK
											</PrimaryButton>
										</div>
									</Transition>
								</q-card>
							</div>
						</div>
					</div>

					<div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
						<div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
							<PrimaryButton
								 button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10"
								 @click="voltar">
								Voltar
							</PrimaryButton>
							<PrimaryButton
								 button-class="tw-text-white tw-px-14 tw-self-center tw-text-center tw-bg-primary tw-h-10 tw-w-[50%] tw-items-center tw-justify-center lg:tw-w-[18%]"
								 @click="finalizar()">
								AVANÇAR
							</PrimaryButton>
						</div>
					</div>
				</div>

			</div>
			<div v-if="estagio === 3" class="tw-flex tw-flex-1 tw-flex-col tw-gap-6 tw-text-center tw-justify-center ">
				<img alt="" class="tw-h-[60px] tw-w-auto tw-mb-5" src="../../../imgs/logo-efg.svg"/>
				<h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">
					Teste de Aptidão realizado com sucesso!
				</h5>
				<h6 class="tw-font-medium tw-font-subtitle tw-text-gray-900 tw-text-lg tw-leading-6 tw-mb-4">
					Entraremos em contato com você!
					Os próximos passos serão orientados via
					e-mail e WhatsApp.
				</h6>
				<a class="tw-px-14 tw-inline tw-self-center tw-py-2 tw-rounded-xl tw-font-title tw-text-base tw-text-center tw-uppercase hover:tw-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-primary focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-border-2 tw-border-primary"
				   href="https://efg.org.br/">Voltar
					ao Site</a>
			</div>
		</div>
	</SelecaoLayout>
</template>
