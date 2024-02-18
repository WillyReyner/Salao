<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';
import Dropdown from '@/Components/Pages/Dropdown.vue';
import DropdownLink from '@/Components/Pages/DropdownLink.vue';
import DropdownSidebar from '@/Components/Painel/DropdownSidebar.vue';
import DropdownSidebarLink from '@/Components/Painel/DropdownSidebarLink.vue';
import SidebarLink from './SidebarLink.vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue'
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import DropdownMenuLink from "@/Components/LandingPag/DropdownMenuLink.vue";
const page = usePage();
const user = computed(() => page.props.auth.user)
const roles = user.value.roles;
const permissions = roles.map(role => role.permissions).flat();
const hasPermission = (permission) => {
    return permissions.some(userPermission => userPermission.name === permission);
};
const showMenu = ref(false);

window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        showMenu.value = false
    } else {
        showMenu.value = true
    }
})

const openControle = ref(false)
const openAdministracao = ref(false)
const openStai = ref(false)

function openItem(item) {
    if (open.value == item) {
        open.value = null;
    } else {
        open.value = item;
    }
}

</script>
<template>
    <nav class="tw-border-b tw-border-gray-100 tw-flex tw-flex-col tw-bg-white tw-shadow-lg tw-overflow-x-hidden tw-transition-all"
        :class="showMenu ? 'tw-w-[100px]' : 'tw-w-[200px]'">
        <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-py-3">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-between">
                <div class="tw-flex tw-items-center tw-px-7">
                    <Link :href="route('dashboard')" v-if="!showMenu">
                    <ApplicationLogo class="tw-block tw-h-11 tw-w-auto tw-fill-current tw-text-gray-800 tw-pr-4" />
                    </Link>
                    <div class="tw-flex  tw-items-center">
                        <button @click="showMenu = !showMenu" title="Diminuir/Expandir Menu Lateral"
                            class="tw-inline-flex tw-items-center tw-justify-center tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 focus:tw-text-gray-500 tw-transition tw-duration-150 tw-ease-in-out">
                            <svg v-if="showMenu" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 32 32" fill="none">
                                <path d="M9.33337 16L18.6667 16M18.6667 16L14.6667 20M18.6667 16L14.6667 12"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M22.6666 21.3333L22.6666 10.6666" stroke="#666666" stroke-width="1.5"
                                    stroke-linecap="round" />
                                <path
                                    d="M2.66663 16C2.66663 9.71457 2.66663 6.57187 4.61925 4.61925C6.57187 2.66663 9.71457 2.66663 16 2.66663C22.2854 2.66663 25.4281 2.66663 27.3807 4.61925C29.3333 6.57187 29.3333 9.71457 29.3333 16C29.3333 22.2854 29.3333 25.4281 27.3807 27.3807C25.4281 29.3333 22.2854 29.3333 16 29.3333C9.71457 29.3333 6.57187 29.3333 4.61925 27.3807C2.66663 25.4281 2.66663 22.2854 2.66663 16Z"
                                    stroke="#666666" stroke-width="1.5" />
                            </svg>
                            <svg v-if="!showMenu" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                viewBox="0 0 30 30" fill="none">
                                <path d="M21.25 15L12.5 15M12.5 15L16.25 18.75M12.5 15L16.25 11.25" stroke="#666666"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8.75 20L8.75 10" stroke="#666666" stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M2.5 15C2.5 9.10744 2.5 6.16117 4.33058 4.33058C6.16117 2.5 9.10744 2.5 15 2.5C20.8926 2.5 23.8388 2.5 25.6694 4.33058C27.5 6.16117 27.5 9.10744 27.5 15C27.5 20.8926 27.5 23.8388 25.6694 25.6694C23.8388 27.5 20.8926 27.5 15 27.5C9.10744 27.5 6.16117 27.5 4.33058 25.6694C2.5 23.8388 2.5 20.8926 2.5 15Z"
                                    stroke="#666666" stroke-width="1.5" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="tw-h-[2px] tw-w-[calc(100%-48px)] tw-bg-gray-100 tw-my-7 tw-mx-6"></div>
                <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-between">
                    <!-- Navigation Links -->
                    <div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-y-scroll">
                        <SidebarLink v-if="!showMenu" :href="route('dashboard')" :active="route().current('dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path
                                    d="M11.275 3.5502L4.5375 8.8002C3.4125 9.6752 2.5 11.5377 2.5 12.9502V22.2127C2.5 25.1127 4.8625 27.4877 7.7625 27.4877H22.2375C25.1375 27.4877 27.5 25.1127 27.5 22.2252V13.1252C27.5 11.6127 26.4875 9.6752 25.25 8.8127L17.525 3.4002C15.775 2.1752 12.9625 2.2377 11.275 3.5502Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15 22.4873V18.7373V22.4873Z" fill="#666666" />
                                <path d="M15 22.4873V18.7373" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>&nbsp;
                            Início
                        </SidebarLink>
                        <SidebarLink v-if="showMenu" :href="route('dashboard')" :active="route().current('dashboard')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path
                                    d="M11.275 3.5502L4.5375 8.8002C3.4125 9.6752 2.5 11.5377 2.5 12.9502V22.2127C2.5 25.1127 4.8625 27.4877 7.7625 27.4877H22.2375C25.1375 27.4877 27.5 25.1127 27.5 22.2252V13.1252C27.5 11.6127 26.4875 9.6752 25.25 8.8127L17.525 3.4002C15.775 2.1752 12.9625 2.2377 11.275 3.5502Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15 22.4873V18.7373V22.4873Z" fill="#666666" />
                                <path d="M15 22.4873V18.7373" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>&nbsp;
                        </SidebarLink>
                        <SidebarLink v-if="(hasPermission('Sidebar Editais') && hasPermission('Index Editais')) && showMenu"
                            :href="route('painel.editais')" :active="route().current('painel.editais')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5">
                                    <path
                                        d="M4 21.4V2.6a.6.6 0 0 1 .6-.6h11.652a.6.6 0 0 1 .424.176l3.148 3.148A.6.6 0 0 1 20 5.75V21.4a.6.6 0 0 1-.6.6H4.6a.6.6 0 0 1-.6-.6ZM8 10h8m-8 8h8m-8-4h4" />
                                    <path d="M16 2v3.4a.6.6 0 0 0 .6.6H20" />
                                </g>
                            </svg>&nbsp;
                        </SidebarLink>
                        <SidebarLink
                            v-if="(hasPermission('Sidebar Inscricoes') && hasPermission('Index Inscricoes')) && showMenu"
                            :href="route('painel.inscricoes')" :active="route().current('painel.inscricoes')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path
                                    d="M25 10.3125V22.5C25 26.25 22.7625 27.5 20 27.5H10C7.2375 27.5 5 26.25 5 22.5V10.3125C5 6.25 7.2375 5.3125 10 5.3125C10 6.0875 10.3125 6.7875 10.825 7.3C11.3375 7.8125 12.0375 8.125 12.8125 8.125H17.1875C18.7375 8.125 20 6.8625 20 5.3125C22.7625 5.3125 25 6.25 25 10.3125Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M20 5.3125C20 6.8625 18.7375 8.125 17.1875 8.125H12.8125C12.0375 8.125 11.3375 7.8125 10.825 7.3C10.3125 6.7875 10 6.0875 10 5.3125C10 3.7625 11.2625 2.5 12.8125 2.5H17.1875C17.9625 2.5 18.6625 2.8125 19.175 3.325C19.6875 3.8375 20 4.5375 20 5.3125Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M10 16.25H15" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M10 21.25H20" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>&nbsp;
                        </SidebarLink>
                        <SidebarLink v-if="(hasPermission('Sidebar Cursos') && hasPermission('Index Cursos')) && showMenu"
                            :href="route('painel.cursos')" :active="route().current('painel.cursos')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                                <path
                                    d="M27.5 20.9251V5.83761C27.5 4.33761 26.275 3.22511 24.7875 3.35011H24.7125C22.0875 3.57511 18.1 4.91261 15.875 6.31261L15.6625 6.45011C15.3 6.67511 14.7 6.67511 14.3375 6.45011L14.025 6.26261C11.8 4.87511 7.825 3.55011 5.2 3.33761C3.7125 3.21261 2.5 4.33761 2.5 5.82511V20.9251C2.5 22.1251 3.475 23.2501 4.675 23.4001L5.0375 23.4501C7.75 23.8126 11.9375 25.1876 14.3375 26.5001L14.3875 26.5251C14.725 26.7126 15.2625 26.7126 15.5875 26.5251C17.9875 25.2001 22.1875 23.8126 24.9125 23.4501L25.325 23.4001C26.525 23.2501 27.5 22.1251 27.5 20.9251Z"
                                    stroke="#666666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15 6.8623V25.6123V6.8623Z" fill="#666666" />
                                <path d="M15 6.8623V25.6123" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M9.6875 10.6123H6.875" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M10.625 14.3623H6.875" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>&nbsp;
                        </SidebarLink>
                        <SidebarLink v-if="(hasPermission('Sidebar Stai') || hasPermission('Index Stai')) && showMenu"
                            :href="route('painel.stai.editais')" :active="route().current('painel.stai.editais')">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="note-2">
                                    <path id="Vector"
                                        d="M27.0752 13.0501L25.8502 18.2751C24.8002 22.7876 22.7252 24.6126 18.8252 24.2376C18.2002 24.1876 17.5252 24.0751 16.8002 23.9001L14.7002 23.4001C9.48772 22.1626 7.87522 19.5876 9.10022 14.3626L10.3252 9.12513C10.5752 8.06263 10.8752 7.13763 11.2502 6.37513C12.7127 3.35013 15.2002 2.53763 19.3752 3.52513L21.4627 4.01263C26.7002 5.23763 28.3002 7.82513 27.0752 13.0501Z"
                                        stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="Vector_2"
                                        d="M18.8249 24.2375C18.0499 24.7625 17.0749 25.2 15.8874 25.5875L13.9124 26.2375C8.94994 27.8375 6.33744 26.5 4.72494 21.5375L3.12494 16.6C1.52494 11.6375 2.84994 9.0125 7.81244 7.4125L9.78744 6.7625C10.2999 6.6 10.7874 6.4625 11.2499 6.375C10.8749 7.1375 10.5749 8.0625 10.3249 9.125L9.09994 14.3625C7.87494 19.5875 9.48744 22.1625 14.6999 23.4L16.7999 23.9C17.5249 24.075 18.1999 24.1875 18.8249 24.2375Z"
                                        fill="#666666" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="Vector_3" d="M15.8008 10.6621L21.8633 12.1996" stroke="#666666"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path id="Vector_4" d="M14.5742 15.5L18.1992 16.425" stroke="#666666" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                            </svg>
                        </SidebarLink>
                        <SidebarLink v-if="(hasPermission('Sidebar Stai') || hasPermission('Index Stai')) && showMenu"
                            :href="route('painel.stai.agendamento')" :active="route().current('painel.stai.agendamento')">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="clock">
                                    <path id="Vector" d="M15 12.0742V15.5617L16.75 17.3117" stroke="#666666"
                                        stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                    <path id="Vector_2"
                                        d="M6.875 15C6.875 10.5125 10.5125 6.875 15 6.875C19.4875 6.875 23.125 10.5125 23.125 15C23.125 17.6 21.9 19.925 20 21.4125H19.9875C18.6125 22.4875 16.8875 23.125 15 23.125C13.1375 23.125 11.425 22.5 10.05 21.4375H10.0375C8.1125 19.95 6.875 17.625 6.875 15Z"
                                        stroke="#666666" stroke-width="1.6" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="Vector_3"
                                        d="M10.0371 21.4371H10.0496C11.4246 22.4996 13.1371 23.1246 14.9996 23.1246C16.8871 23.1246 18.6121 22.4871 19.9871 21.4121H19.9996L19.3621 24.4996C18.7496 26.8746 17.3746 27.4996 15.6871 27.4996H14.3246C12.6371 27.4996 11.2496 26.8746 10.6496 24.4871L10.0371 21.4371Z"
                                        stroke="#666666" stroke-width="1.6" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="Vector_4"
                                        d="M10.0371 8.5625H10.0496C11.4246 7.5 13.1371 6.875 14.9996 6.875C16.8871 6.875 18.6121 7.5125 19.9871 8.5875H19.9996L19.3621 5.5C18.7496 3.125 17.3746 2.5 15.6871 2.5H14.3246C12.6371 2.5 11.2496 3.125 10.6496 5.5125L10.0371 8.5625Z"
                                        stroke="#666666" stroke-width="1.6" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                            </svg>
                        </SidebarLink>
                        <span v-if="(hasPermission('Sidebar Editais') || hasPermission('Sidebar Inscricoes')) && !showMenu"
                            class="flex tw-text-body tw-text-gray-600 tw-text-sm tw-font-thin tw-mt-6 tw-gap-5"
                            :class="showMenu ? 'tw-opacity-0 tw-px-0' : 'tw-opacity-100 tw-px-6'">CONTROLE
                            <Icon @click="openControle = !openControle" v-if="openControle" icon="bxs:up-arrow" width="15"
                                height="15" />
                            <Icon @click="openControle = !openControle" v-if="!openControle" icon="bxs:down-arrow"
                                width="15" height="15" />
                        </span>
                        <Transition name="fade">
                            <div v-if="openControle">
                                <SidebarLink
                                    v-if="(hasPermission('Sidebar Editais') && hasPermission('Index Editais')) && !showMenu"
                                    :href="route('painel.editais')" :active="route().current('painel.editais')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 14 14">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M8.351 5.307a1.166 1.166 0 0 0-1.1-.778h-.903a1.041 1.041 0 0 0-.223 2.059l1.375.3a1.167 1.167 0 0 1-.25 2.307h-.777c-.508 0-.94-.324-1.1-.777m1.489-3.889V3.362m0 7V9.196m-4.864 4.302v-2.5h2.5" />
                                            <path
                                                d="M13.388 5.804a6.5 6.5 0 0 1-11.39 5.35M.612 8.196a6.5 6.5 0 0 1 11.39-5.35" />
                                            <path d="M12.002.502v2.5h-2.5" />
                                        </g>
                                    </svg>
                                    &nbsp;&nbsp;Fluxo de Caixa
                                </SidebarLink>
                                <SidebarLink
                                    v-if="(hasPermission('Sidebar Inscricoes') && hasPermission('Index Inscricoes')) && !showMenu"
                                    :href="route('painel.inscricoes')" :active="route().current('painel.inscricoes')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M16 11.5a2.5 2.5 0 0 1 5 0a2.5 2.5 0 0 1-5 0M13 3v17h11V3zm9 13c-1.1 0-2 .9-2 2h-3a2 2 0 0 0-2-2V7c1.11 0 2-.89 2-2h3a2 2 0 0 0 2 2zM7 6c1.1 0 2 .9 2 2s-.9 2-2 2s-2-.9-2-2s.9-2 2-2m0-2C4.79 4 3 5.79 3 8s1.79 4 4 4s4-1.79 4-4s-1.79-4-4-4m0 10c-3.87 0-7 1.79-7 4v2h11v-2H2c0-.58 1.75-2 5-2c1.83 0 3.17.45 4 .95v-2.23C9.87 14.27 8.5 14 7 14" />
                                    </svg>
                                    &nbsp;&nbsp;Entradas
                                </SidebarLink>
                                <SidebarLink
                                    v-if="(hasPermission('Sidebar Inscricoes') && hasPermission('Index Inscricoes')) && !showMenu"
                                    :href="route('painel.inscricoes')" :active="route().current('painel.inscricoes')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M11.25 6H9c-1.886 0-2.828 0-3.414.586C5 7.172 5 8.114 5 10v6.25h14V10c0-1.886 0-2.828-.586-3.414C17.828 6 16.886 6 15 6h-2.25v4.973l.68-.794a.75.75 0 1 1 1.14.976l-2 2.333a.75.75 0 0 1-1.14 0l-2-2.333a.75.75 0 0 1 1.14-.976l.68.794zM5.03 17.75h13.94c-.052.79-.189 1.297-.556 1.664C17.828 20 16.886 20 15 20H9c-1.886 0-2.828 0-3.414-.586c-.367-.367-.504-.873-.555-1.664" />
                                        <path fill="currentColor"
                                            d="M5.889 3H18.11C20.26 3 22 4.8 22 7.02c0 1.29-.587 2.437-1.5 3.173v-.282c0-.866 0-1.66-.087-2.305c-.095-.711-.32-1.463-.938-2.08c-.618-.619-1.37-.844-2.08-.94c-.646-.086-1.44-.086-2.306-.086H8.91c-.865 0-1.659 0-2.304.087c-.711.095-1.463.32-2.08.938c-.619.618-.844 1.37-.94 2.08c-.086.646-.086 1.44-.086 2.306v.282A4.063 4.063 0 0 1 2 7.02C2 4.8 3.741 3 5.889 3" />
                                    </svg>
                                    &nbsp;&nbsp;Saidas
                                </SidebarLink>
                            </div>
                        </Transition>
                        <span v-if="(hasPermission('Sidebar Cursos') || hasPermission('Sidebar Turmas')) && !showMenu"
                            class="flex tw-text-body tw-text-gray-600 tw-text-sm tw-font-thin tw-mt-6 tw-gap-3"
                            :class="showMenu ? 'tw-opacity-0 tw-px-0' : 'tw-opacity-100 tw-px-6'">ADMINISTRAÇÃO
                            <Icon @click="openAdministracao = !openAdministracao" v-if="openAdministracao"
                                icon="bxs:up-arrow" width="15" height="15" />
                            <Icon @click="openAdministracao = !openAdministracao" v-if="!openAdministracao"
                                icon="bxs:down-arrow" width="15" height="15" />
                        </span>
                        <Transition name="fade">
                            <div v-if="openAdministracao">
                                <SidebarLink
                                    v-if="(hasPermission('Sidebar Cursos') && hasPermission('Index Cursos')) && !showMenu"
                                    :href="route('painel.cursos')" :active="route().current('painel.cursos')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32">
                                        <path fill="currentColor"
                                            d="M28.523 23.813c-.518-.51-6.795-2.938-7.934-3.396c-1.133-.45-1.585-1.697-1.585-1.697s-.51.282-.51-.51c0-.793.51.51 1.02-2.548c0 0 1.415-.397 1.134-3.68h-.34s.85-3.51 0-4.698c-.853-1.188-1.187-1.98-3.06-2.548c-1.87-.567-1.19-.454-2.548-.396c-1.36.057-2.492.793-2.492 1.188c0 0-.85.057-1.188.397c-.34.34-.906 1.924-.906 2.32s.283 3.06.566 3.624l-.337.11c-.283 3.284 1.132 3.682 1.132 3.682c.51 3.058 1.02 1.755 1.02 2.548c0 .792-.51.51-.51.51s-.453 1.246-1.585 1.697c-1.132.453-7.416 2.887-7.927 3.396c-.51.52-.453 2.896-.453 2.896h12.036l.878-3.46l-.78-.78l1.343-1.345l1.343 1.344l-.78.78l.878 3.46h12.036s.063-2.378-.453-2.897z" />
                                    </svg>&nbsp;
                                    Clientes
                                </SidebarLink>
                                <SidebarLink
                                    v-if="(hasPermission('Sidebar Turmas') && hasPermission('Index Turmas')) && !showMenu"
                                    :href="route('painel.turmas')" :active="route().current('painel.turmas')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32">
                                        <path fill="currentColor"
                                            d="M27 22v-5a2.002 2.002 0 0 0-2-2h-8v-5h3a2.002 2.002 0 0 0 2-2V4a2.002 2.002 0 0 0-2-2h-8a2.002 2.002 0 0 0-2 2v4a2.002 2.002 0 0 0 2 2h3v5H7a2.002 2.002 0 0 0-2 2v5H2v8h8v-8H7v-5h8v5h-3v8h8v-8h-3v-5h8v5h-3v8h8v-8ZM12 4h8v4h-8ZM8 28H4v-4h4Zm10 0h-4v-4h4Zm10 0h-4v-4h4Z" />
                                    </svg> &nbsp;
                                    Serviços
                                </SidebarLink>
                            </div>
                        </Transition>
                        <span v-if="(hasPermission('Sidebar Stai') || hasPermission('Index Stai')) && !showMenu"
                            class="flex tw-text-body tw-text-gray-600 tw-text-sm tw-font-thin tw-mt-6 tw-gap-5"
                            :class="showMenu ? 'tw-opacity-0 tw-px-0' : 'tw-opacity-100 tw-px-6'">STAI
                            <Icon @click="openStai = !openStai" v-if="openStai" icon="bxs:up-arrow" width="15"
                                height="15" />
                            <Icon @click="openStai = !openStai" v-if="!openStai" icon="bxs:down-arrow"
                                width="15" height="15" />
                        </span>
                        <Transition name="fade">
                            <div v-if="openStai">
                                <SidebarLink
                                    v-if="(hasPermission('Sidebar Stai') || hasPermission('Index Stai')) && !showMenu"
                                    :href="route('painel.stai.editais')" :active="route().current('painel.stai.editais')">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="note-2">
                                            <path id="Vector"
                                                d="M27.0752 13.0501L25.8502 18.2751C24.8002 22.7876 22.7252 24.6126 18.8252 24.2376C18.2002 24.1876 17.5252 24.0751 16.8002 23.9001L14.7002 23.4001C9.48772 22.1626 7.87522 19.5876 9.10022 14.3626L10.3252 9.12513C10.5752 8.06263 10.8752 7.13763 11.2502 6.37513C12.7127 3.35013 15.2002 2.53763 19.3752 3.52513L21.4627 4.01263C26.7002 5.23763 28.3002 7.82513 27.0752 13.0501Z"
                                                stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path id="Vector_2"
                                                d="M18.8249 24.2375C18.0499 24.7625 17.0749 25.2 15.8874 25.5875L13.9124 26.2375C8.94994 27.8375 6.33744 26.5 4.72494 21.5375L3.12494 16.6C1.52494 11.6375 2.84994 9.0125 7.81244 7.4125L9.78744 6.7625C10.2999 6.6 10.7874 6.4625 11.2499 6.375C10.8749 7.1375 10.5749 8.0625 10.3249 9.125L9.09994 14.3625C7.87494 19.5875 9.48744 22.1625 14.6999 23.4L16.7999 23.9C17.5249 24.075 18.1999 24.1875 18.8249 24.2375Z"
                                                fill="#666666" stroke="#666666" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path id="Vector_3" d="M15.8008 10.6621L21.8633 12.1996" stroke="#666666"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            <path id="Vector_4" d="M14.5742 15.5L18.1992 16.425" stroke="#666666"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                    &nbsp;&nbsp;Editais
                                </SidebarLink>

                                <SidebarLink
                                    v-if="(hasPermission('Sidebar Stai') || hasPermission('Index Stai')) && !showMenu"
                                    :href="route('painel.stai.agendamento')"
                                    :active="route().current('painel.stai.agendamento')">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g id="clock">
                                            <path id="Vector" d="M15 12.0742V15.5617L16.75 17.3117" stroke="#666666"
                                                stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                            <path id="Vector_2"
                                                d="M6.875 15C6.875 10.5125 10.5125 6.875 15 6.875C19.4875 6.875 23.125 10.5125 23.125 15C23.125 17.6 21.9 19.925 20 21.4125H19.9875C18.6125 22.4875 16.8875 23.125 15 23.125C13.1375 23.125 11.425 22.5 10.05 21.4375H10.0375C8.1125 19.95 6.875 17.625 6.875 15Z"
                                                stroke="#666666" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path id="Vector_3"
                                                d="M10.0371 21.4371H10.0496C11.4246 22.4996 13.1371 23.1246 14.9996 23.1246C16.8871 23.1246 18.6121 22.4871 19.9871 21.4121H19.9996L19.3621 24.4996C18.7496 26.8746 17.3746 27.4996 15.6871 27.4996H14.3246C12.6371 27.4996 11.2496 26.8746 10.6496 24.4871L10.0371 21.4371Z"
                                                stroke="#666666" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path id="Vector_4"
                                                d="M10.0371 8.5625H10.0496C11.4246 7.5 13.1371 6.875 14.9996 6.875C16.8871 6.875 18.6121 7.5125 19.9871 8.5875H19.9996L19.3621 5.5C18.7496 3.125 17.3746 2.5 15.6871 2.5H14.3246C12.6371 2.5 11.2496 3.125 10.6496 5.5125L10.0371 8.5625Z"
                                                stroke="#666666" stroke-width="1.6" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>
                                    </svg>
                                    &nbsp;&nbsp;Agendamentos
                                </SidebarLink>
                            </div>
                        </Transition>

                    </div>
                    <div class="tw-flex tw-flex-col">
                        <div class="tw-px-6">
                            <div class="tw-h-[2px] tw-w-full tw-bg-gray-100 tw-my-7"></div>
                            <img src="./../../../imgs/logo-efg-small.png" class="tw-h-8 tw-w-8" />
                        </div>
                    </div>
                </div>
        </div>
    </div>
</nav></template>
<style scoped>/*
   Enter and leave animations can use different
   durations and timing functions.
 */
.fade-enter-active {
    transition: all 0.8s ease-out;
}

.fade-leave-active {
    transition: all 0.5s cubic-bezier(1, 0.5, 0.8, 1);
}

.fade-enter-from,
.fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}

.vertical-line {
    border-left: 2px solid #ffffff;
    height: 400px;
    margin: 0 20px;
}</style>