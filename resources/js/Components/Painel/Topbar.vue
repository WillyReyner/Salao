<script setup>
import {Icon} from '@iconify/vue';
import {router, useForm, usePage} from '@inertiajs/vue3';
import {defineProps, ref} from 'vue';
import axios from "axios";
import {Notify} from "quasar";

const page = usePage()

const props = defineProps(['user']);

const secondDialog = ref(false)
const roles = props.user.roles
const permissions = roles.map(role => role.permissions).flat();
const hasPermission = (permission) => {
	return permissions.some(userPermission => userPermission.name === permission);
};

function areas() {
	router.get(route('painel.areas'))
}
function logout() {
	router.post(route('logout'))
}

function profile() {
	router.get(route('profile.edit'))
}

function configuracoes() {
	router.get(route('painel.configuracoes'))
}

function inscricoes() {
	router.get(route('painel.inscricoes'))
}

function escolas() {
	router.get(route('painel.escolas'))
}

function tags() {
	router.get(route('painel.tags'))
}

function habilitacao() {
	router.get(route('painel.habilitacao'))
}

function municipios() {
	router.get(route('painel.municipios'))
}

function arquivos() {
	router.get(route('painel.documento'))
}

function usuarios() {
	router.get(route('painel.gestao.usuarios'))
}

function permissoes() {
	router.get(route('painel.gestao.permissoes'))
}

function niveis() {
	router.get(route('painel.gestao.roles'))
}

function logs() {
	router.get(route('painel.logs'))
}

function ticket() {
	router.get(route('painel.ticket'))
}


const form = useForm({
	id: '',
});
function Read(id) {
	form.id = id
	console.log(form.id)
	form.post(route('painel.ticket.read', id), {
		preserveScroll: true,
		onSuccess: (res) => {
			Notify.create({
				message: "Notificação lida com sucesso.",
			})
		},
		onError: (err) => {
			console.log(err)
			Notify.create({
				message: "Não foi possível registrar o Edital.",
				color: "negative"
			})
		}
	})
}

const tickets = page.props.notifications.map(item => item)

</script>
<template>
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
	<div class="tw-flex tw-flex-row tw-h-16 tw-bg-white tw-justify-end tw-text-gray-700 tw-shadow-md">
		<div class="tw-flex tw-flex- tw-flex-row tw-justify-end">
			<span
				 class="tw-justify-center tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none hover:tw-bg-gray-100 tw-transition tw-duration-150 tw-ease-in-out tw-relative"
				 title="Notificações">
                <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all" icon="iconoir:bell"/>
				<span
					 class="tw-absolute tw-top-2 tw-right-2 tw-rounded-full tw-w-4 tw-h-4 tw-text-sm tw-flex tw-items-center tw-justify-center tw-text-green-500 tw-border tw-border-green-500">
					{{ page.props.notifications.length }}
				</span>
	            <q-menu style="width:300px" transition-hide="jump-up" transition-show="jump-down">
                    <q-list >
	                    <q-item clickable v-for="notification in page.props.notifications" :key="notification.id">
								    <span v-bind:data-value="notification.ticket?.id" @click="Read(notification.ticket.id)"
								          class="tw-w-full tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out">
								        {{ notification.ticket?.tickets }}
								    </span>
	                    </q-item>
	                    <q-item v-if="page.props.notifications.lenght = 0 " clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out">
                                    &nbsp;&nbsp;Indisponível no momento
                                </span>
                            </q-item-section>
	                    </q-item>
                    </q-list>
	            </q-menu>
			</span>
			<span
				 class="tw-justify-center tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none hover:tw-bg-gray-100 tw-transition tw-duration-150 tw-ease-in-out"
				 title="Duvidas">
                <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all" icon="iconoir:help-circle"/>
                <q-menu style="width:300px" transition-hide="jump-up" transition-show="jump-down">
                    <q-list style="min-width: 100%">
                        <q-item clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out">
                                    &nbsp;&nbsp;Indisponível no momento
                                </span>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-menu>
            </span>
			<span alt="teste"
			      class="tw-justify-center tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none hover:tw-bg-gray-100 tw-transition tw-duration-150 tw-ease-in-out"
			      title="Dados de Usuário">
                <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all" icon="iconoir:profile-circle"/>
				<q-menu style="width:250px" transition-hide="jump-up" transition-show="jump-down">
                    <q-list style="min-width: 150px">
	                    <q-item clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out" @click="profile()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="arcticons:password"/>
                                    &nbsp;&nbsp;Ver Perfil
                                </span>
                            </q-item-section>
                        </q-item>
	                    <q-item clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="arcticons:password"/>
                                    &nbsp;&nbsp;Redefinir Senha
                                </span>
                            </q-item-section>
                        </q-item>
                    </q-list>
				</q-menu>
			</span>
			<span
				 v-if="hasPermission('Topbar Usuarios') || hasPermission('Topbar Escolas') || hasPermission('Topbar Tags') || hasPermission('Topbar Municipios') || hasPermission('Topbar Documentos') || hasPermission('Topbar Permissoes') || hasPermission('Topbar Nivel de Acesso') || hasPermission('Topbar Log')"
				 class="tw-justify-center tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none hover:tw-bg-gray-100 tw-transition tw-duration-150 tw-ease-in-out"
				 title="Configurações">
                <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all" icon="ci:settings"/>
                <q-menu style="width:250px" transition-hide="jump-up" transition-show="jump-down">
                    <q-list style="min-width: 150px">
                        <q-item v-if="hasPermission('Topbar Usuarios')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="usuarios()">
                                    <Icon
	                                     class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
	                                     icon="streamline:interface-user-profile-focus-close-geometric-human-person-profile-focus-user"/>
                                    &nbsp;&nbsp;Usuários
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Topbar Escolas')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="escolas()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="clarity:building-line"/>
                                    &nbsp;&nbsp;Escolas
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Topbar Tags')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="tags()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="cil:tags"/>
                                    &nbsp;&nbsp;Tags
                                </span>
                            </q-item-section>
                        </q-item>
	                    <q-item v-if="hasPermission('Topbar Tags')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="areas()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="cil:tags"/>
                                    &nbsp;&nbsp;Áreas
                                </span>
                            </q-item-section>
                        </q-item>
	                    <q-item v-if="hasPermission('Topbar Tags')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="configuracoes()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="cil:tags"/>
                                    &nbsp;&nbsp;Configuracoes
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Topbar Habilitacao')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="habilitacao()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="game-icons:skills"/>
                                    &nbsp;&nbsp;Habilitacao
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Topbar Permissoes')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="permissoes()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="solar:medal-ribbon-linear"/>
                                    &nbsp;&nbsp;Permissões
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Topbar Municipios')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="municipios()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="mingcute:building-5-line"/>
                                    &nbsp;&nbsp;Municípios
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Topbar Documentos')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="arquivos()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="quill:paper"/>
                                    &nbsp;&nbsp;Documentos
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Topbar Nivel de Acesso')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="niveis()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="uil:cell"/>
                                    &nbsp;&nbsp;Níveis de Acesso
                                </span>
                            </q-item-section>
                        </q-item>
	                    <q-item v-if="hasPermission('Topbar Ticket')" clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="ticket()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="mynaui:notification"/>
												&nbsp;&nbsp;Ticket
                                </span>
                            </q-item-section>
                        </q-item>
                        <q-item v-if="hasPermission('Logs Geral') " clickable>
                            <q-item-section>
                                <span
	                                 class="tw-justify-right tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out"
	                                 @click="logs()">
                                    <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all"
                                          icon="arcticons:tenbitclockwidget"/>
                                    &nbsp;&nbsp;Histórico de Logs
                                </span>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-menu>
            </span>
			<span
				 class="tw-justify-center tw-items-center tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-border-r-2  tw-border-white tw-leading-5 tw-text-gray-800 border-box focus:tw-outline-none hover:tw-bg-gray-100 tw-transition tw-duration-150 tw-ease-in-out"
				 title="Logout"
				 @click="logout()">
                <Icon class="tw-h-[24px] tw-w-[24px] tw-text-gray-600 tw-transition-all" icon="tabler:logout"/>
            </span>
		</div>
	</div>
</template>