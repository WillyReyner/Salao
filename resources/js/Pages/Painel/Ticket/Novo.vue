<template>
	<Head title="Tipo de Arquivo"/>
	<AuthenticatedLayout>
		<div class="tw-flex tw-flex-1 tw-flex-col">
			<div
				 class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
				<div
					 class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
					<h4 class="tw-font-title tw-font-semibold">Adicionar Tickets</h4>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2">
					<p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
				</div>
				<!--				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4">-->
				<!--					<div class="tw-flex tw-flex-1 tw-flex-col">-->
				<!--						<InputLabel for="nome" required value="Nome"/>-->
				<!--						<q-input id="nome" v-model="form.nome" autocomplete="nome" autofocus-->
				<!--						         class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"-->
				<!--						         outlined-->
				<!--						         required-->
				<!--						         type="text"/>-->
				<!--						<InputError :message="form.errors.nome" class="tw-mt-2"/>-->
				<!--					</div>-->
				<!--				</div>-->
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-4">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="ticket" required value="Ticket"/>
						<q-input id="ticket" v-model="form.ticket" autocomplete="ticket" autofocus
						         class="tw-mt-1 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"

						         outlined
						         required type="textarea"/>
						<InputError :message="form.errors.ticket" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-4">
					<div class="tw-flex tw-flex-1 tw-flex-col">
						<InputLabel for="users" required value="Destinatarios"/>
						<q-select v-model="form.users" :options="optionsTipo" behavior="menu"
						          class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
						          input-debounce="0"
						          multiple
						          outlined
						          use-chips use-input
						          @filter="filterFn">
							<template v-slot:no-option>
								<q-item>
									<q-item-section class="text-grey">
										No results
									</q-item-section>
								</q-item>
							</template>
						</q-select>
						<InputError :message="form.errors.users" class="tw-mt-2"/>
					</div>
				</div>
				<div class="tw-flex tw-justify-end tw-gap-2">
					<Link :href="route('painel.ticket')"
					      class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
						CANCELAR
					</Link>
					<span
						 class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center "
						 @click="store()">
                        <Icon class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" icon="fluent:save-16-regular"/>
                        Salvar
                    </span>
				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import {Head, useForm, router, Link} from '@inertiajs/vue3';
import {Notify} from 'quasar';
import {Icon} from '@iconify/vue';
import {ref, computed} from 'vue';

const props = defineProps({
	users: {
		type: Array,
		default: [],
	}
})

const form = useForm({
	ticket: '',
	users: [],
})

const tipo_versao = ref(false)
const opcoesUsers = props.users.map(resp => ({label: resp.name, value: resp.id}))
const optionsTipo = ref([])

function filterFn(val, update) {
	if (val === "") {
		update(() => {
			optionsTipo.value = opcoesUsers;
		});
		return;
	}

	update(() => {
		const needle = val.toLowerCase();
		optionsTipo.value = opcoesUsers.filter((v) => v.label.toLowerCase().indexOf(needle) > -1);
	});
}

function store() {

	form.post(route('painel.ticket.store'), {
		preserveScroll: true,
		onSuccess: (res) => {
			form.reset()
			Notify.create({
				message: "Tipo de Arquivo registrado com sucesso.",
				color: "secondary"
			})
		},
		onError: (err) => {
			console.log(err)
			Notify.create({
				message: "Não foi possível registrar o Tipo de Arquivo.",
				color: "negative"
			})
		}
	})
}
</script>