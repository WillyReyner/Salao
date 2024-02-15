
<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link} from '@inertiajs/vue3';
import { Notify } from 'quasar';
import {ref} from "vue";

const props = defineProps({
    areas: {
        type: Object,
        default: {}
    },
	subAreas:{
		 type: Array,
		 default: []
	}
})

const openSubAreas = ref(false)
const optionsSubAreas = ref([])
const tags = ref([]);
const tagInput = ref('');

const form = useForm({
    id: props.areas.id,
    nome: props.areas.nome,
	 subarea: props.areas.area_subareas.length > 0 ? props.areas.area_subareas.map(sub => ({
		 label: sub.subareas.nome,
		 value: sub.subareas.id})) : [],
})

const opcoesSubAreas = props.subAreas.map(sub => ({
	label: sub.nome,
	value: sub.id
}));

function capitalizeFirstLetter(str) {
	return str.charAt(0).toUpperCase() + str.slice(1);
}

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

const addTag = () => {
	if (tagInput.value.trim() !== '') {
		tags.value.push(tagInput.value.trim());
		tagInput.value = '';
		form.inputs = tags.value;
	}
};

const removeTag = (index) => {
	tags.value.splice(index, 1);
};

function filterFn(val, update) {
	if (val === "") {
		update(() => {
			optionsSubAreas.value = opcoesSubAreas
		});
		return;
	}
	update(() => {
		const needle = val.toLowerCase();
		optionsSubAreas.value = opcoesSubAreas.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
	});
}

function update(){
	validateForm()
	router.post(route('painel.areas.update', form.id), {
		_method: 'patch',
		...form
	}, {
		preserveScroll: true,
		onSuccess: (res) => {
			form.reset()
			Notify.create({
				message: "Dados da Area atualizados com sucesso.",
				color: "secondary"
			})
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível atualizar os dados da Area.",
				color: "negative"
			})
		}
	})
}

function deletarTag(index) {
	const formR = useForm({
		id: index
	})

	formR.post(route('painel.areas.subareas.destroy'), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Edital(is) removido(s) com sucesso.",
				color: "secondary"
			})
			applyFilters()
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível remover esse(s) edital(is).",
				color: "negative"
			})
		}
	})
}

</script>
<template>
	<Head title="Tipo de Arquivo" />
	<AuthenticatedLayout>
		<q-dialog v-model="openSubAreas">
			<q-card class="tw-flex tw-flex-1 tw-p-4 tw-gap-5 tw-rounded-2xl">
				<q-card-section class="tw-flex tw-flex-1 tw-flex-col tw-gap-5">
					<div>
						<InputLabel for="nome" value="Sub-áreas" required/>
						<q-input
							 outlined
							 v-model="tagInput"
							 @keydown.enter="addTag"
							 placeholder="Digite uma tag e pressione Enter"
							 class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						/>
					</div>
					<div class="tw-flex tw-flex-row tw-flex-wrap tw-gap-1">
						<div v-for="(tag, index) in subAreas" :key="index" class="tw-flex tw-items-center tw-gap-4 tw-text-base tw-border tw-border-green-800 tw-p-2 tw-rounded-2xl">
							{{ tag.nome }}
							<Icon @click="deletarTag(tag.id)" icon="line-md:remove" width="15" height="15" class="tw-text-green-500 tw-cursor-pointer"  />
						</div>
						<div v-for="(tag, index) in tags" :key="index" class="tw-flex tw-items-center tw-gap-4 tw-text-base tw-border tw-border-green-800 tw-p-2 tw-rounded-2xl">
							{{ tag }}
							<Icon @click="removeTag(index)" icon="line-md:remove" width="15" height="15" class="tw-text-green-500 tw-cursor-pointer"  />
						</div>
					</div>
					<div class="tw-flex tw-justify-end">
						<span @click="openSubAreas = true" class="tw-flex tw-justify-center tw-cursor-pointer tw-text-green-800 tw-text-lg tw-border tw-border-green-700 tw-items-center tw-rounded-2xl tw-w-[30%]">
						Salvar
					</span>
					</div>
				</q-card-section>
			</q-card>
		</q-dialog>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
				<div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-font-title tw-font-semibold">Adicionar Areas</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
				</div>
				<div class="tw-flex md:tw-flex-col md:tw-gap-4 tw-gap-2 tw-m-2 tw-pb-4">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="nome" value="Nome" required/>
						<q-input
							 outlined
							 id="nome"
							 type="text"
							 required
							 autofocus
							 autocomplete="nome"
							 class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
							 v-model="form.nome"/>
						<InputError class="tw-mt-2" :message="form.errors.nome" />
					</div>
					<div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-3">
						<InputLabel for="subarea" required value="Subáreas"/>
						<q-select v-model="form.subarea" :options="optionsSubAreas" behavior="menu"
						          class="tw-mt-1 tw-h-[100%] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0" multiple
						          outlined use-chips use-input
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
					</div>
				</div>
				<div class="tw-flex tw-justify-end tw-gap-2">
					<span @click="openSubAreas = true" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
						Abrir modal
					</span>
					<Link :href="route('painel.areas')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
						CANCELAR
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
