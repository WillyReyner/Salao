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
	permissionsId: {
		type: Array,
		default: []
	},
	roles: {
		type: Object,
		default: {}
	},
	permissionsAll: {
		type: Array,
		default: []
	}
})

// Separar permissões em grupos
const permissionGroups = [
	{ name: 'Index', permissions: props.permissionsAll.filter(permission => permission.name.includes('Index')) },
	{ name: 'Criar', permissions: props.permissionsAll.filter(permission => permission.name.includes('Criar')) },
	{ name: 'Editar', permissions: props.permissionsAll.filter(permission => permission.name.includes('Editar')) },
	{ name: 'Excluir', permissions: props.permissionsAll.filter(permission => permission.name.includes('Excluir')) },
	{ name: 'Importar', permissions: props.permissionsAll.filter(permission => permission.name.includes('Importar')) },
	{ name: 'Exportar', permissions: props.permissionsAll.filter(permission => permission.name.includes('Exportar')) },
	{ name: 'Logs', permissions: props.permissionsAll.filter(permission => permission.name.includes('Logs')) },
	{ name: 'Sidebar', permissions: props.permissionsAll.filter(permission => permission.name.includes('Sidebar')) },
	{ name: 'Topbar', permissions: props.permissionsAll.filter(permission => permission.name.includes('Topbar')) },
];

permissionGroups.forEach((group) => {
	group.selectAll = ref(false);
});

function toggleSelectAll(group) {
	const anyUnchecked = group.permissions.some(permission => !form.permissions.includes(permission.id));
	group.selectAll = anyUnchecked;

	if (group.selectAll) {
		form.permissions = [...form.permissions, ...group.permissions.map(permission => permission.id)];
	} else {
		form.permissions = form.permissions.filter(id => !group.permissions.some(permission => permission.id === id));
	}
}

// Form
const form = useForm({
	id: props.roles && props.roles.id,
	name: props.roles && props.roles.name,
	permissions: props.permissionsId,
});

function validateForm() {
	const requiredFields = ['name'];

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

function update() {

	validateForm()

	router.post(route('painel.gestao.roles.update', form.id), {
		_method: 'patch',
		...form
	}, {
		preserveScroll: true,
		onSuccess: (res) => {
			form.reset()
			Notify.create({
				message: "Dados da permissão foram atualizados com sucesso.",
				color: "secondary"
			})
		},
		onError: (err) => {
			Notify.create({
				message: "Não foi possível atualizar os dados da permissão.",
				color: "negative"
			})
		}
	})
}
</script>

<template>
    <Head title="Permissões" />
    <AuthenticatedLayout>
	    <div class="tw-flex tw-flex-1 tw-flex-col">
		    <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-7 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
			    <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
				    <h4 class="tw-font-title tw-font-semibold">Adicionar Nível de Acesso</h4>
			    </div>
			    <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2">
				    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">NÍVEL DE ACESSO</p>
			    </div>
			    <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 ">
				    <div class="tw-flex tw-flex-1 tw-flex-col">
					    <InputLabel for="name" required value="Nome dos Níveis de Acesso"/>
					    <q-input id="name" v-model="form.name" autofocus
					             class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
					             outlined
					             required/>
					    <InputError :message="form.errors.name" class="tw-mt-2"/>
				    </div>
			    </div>
			    <div class="tw-flex tw-flex-col tw-m-2">
				    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-mt-4 tw-border-b-2 tw-border-gray-200">
					    PERMISSÕES</p>
			    </div>
			    <q-card>
				    <q-card-section>
					    <div class="tw-flex tw-flex-row tw-text-sm">
						    <div v-for="group in permissionGroups" :key="group.name">
							    <q-checkbox v-model="group.selectAll" :label="group.name" @click="toggleSelectAll(group)" class="tw-uppercase"/>
							    <div v-for="permission in group.permissions" :key="permission.id" class="tw-ml-3 tw-border-b tw-border-gray-200">
								    <q-checkbox v-model="form.permissions" :label="permission.name" :val="permission.id"/>
							    </div>
						    </div>
					    </div>
				    </q-card-section>
			    </q-card>
			    <div class="tw-flex tw-justify-end tw-gap-2 tw-mt-4">
				    <Link :href="route('painel.gestao.roles')"
				          class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
					    CANCELAR
				    </Link>
				    <span
					     class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center "
					     @click="update()">
						<Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="fluent:save-16-regular"/>
						Salvar
					</span>
			    </div>
		    </div>
	    </div>
    </AuthenticatedLayout>
</template>



