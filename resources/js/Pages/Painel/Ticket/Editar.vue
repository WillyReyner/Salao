<template>
	<Head title="Tipo de Arquivo"/>
	<AuthenticatedLayout>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div
				 class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-font-title tw-font-semibold">Atualizar Documentos</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="nome" required value="Nome"/>
						<q-input id="nome" v-model="form.nome" autocomplete="nome" autofocus class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" outlined
						         required
						         type="text"/>
						<InputError :message="form.errors.nome" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="orientacao" required value="Orientação para Envio do Arquivo"/>
						<q-input id="orientacao" v-model="form.orientacao" autocomplete="orientacao" autofocus class="tw-mt-1 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" hint="Ao colocar a orientação, colocar '&' no final para que seja feito a quebra de linha. Ex: Teste& Teste& Teste"
						         outlined
						         required
						         type="textarea"/>
						<InputError :message="form.errors.orientacao" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="tipo_versao" required value="Esse documento precisa de FRENTE/VERSO ?"/>
						<div class="tw-flex tw-flex-row">
							<q-toggle v-model="form.tipo_versao" :val="Sim" label="Sim"/>
						</div>
						<InputError :message="form.errors.tipo_versao" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex tw-flex-auto md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-4">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="tipo_arquivo" required value="Tipo de Envio"/>
						<q-select v-model="form.tipo_arquivo" :options="optionsTipo" behavior="menu" class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" input-debounce="0"
						          outlined use-input
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.tipo_arquivo" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex tw-justify-end tw-gap-2">
					<Link :href="route('painel.documento')"
					      class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
						VOLTAR
					</Link>
					<span class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center "
					      @click="update()">
                        <Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="fluent:save-16-regular"/>
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
import {Icon} from '@iconify/vue';
import {Head, useForm, router, Link} from '@inertiajs/vue3';
import {Notify} from 'quasar';
import {ref, computed} from 'vue';

const props = defineProps({
	tiposArquivo: {
		type: Array,
		default: []
	}
});

const form = useForm({
	id: props.tiposArquivo.id,
	nome: props.tiposArquivo.nome,
	orientacao: props.tiposArquivo.orientacao,
	tipo_arquivo: props.tiposArquivo.tipo_arquivo,
	tipo_versao: props.tiposArquivo.tipo_versao === '1' ? true : false,
})

const tipo_versao = ref(false)
const opcoesTipoArquivos = ['Arquivo', 'Link'];
const optionsTipo = ref([])

function filterFn(val, update) {
	if (val === "") {
		update(() => {
			optionsTipo.value = opcoesTipoArquivos;
		});
		return;
	}

	update(() => {
		const needle = val.toLowerCase();
		optionsTipo.value = opcoesTipoArquivos.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
	});
}

function update() {
	router.post(route('painel.documento.update', form.id), {
		_method: 'patch',
		...form
	}, {
		preserveScroll: true,
		onSuccess: (res) => {
			form.reset()
			Notify.create({
				message: "Dados do tipo do arquivo atualizados com sucesso.",
				color: "secondary"
			})
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível atualizar os dados do tipo do arquivo.",
				color: "negative"
			})
		}
	})
}
</script>
