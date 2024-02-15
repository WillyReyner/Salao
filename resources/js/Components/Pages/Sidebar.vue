<script setup>
import { ref, computed} from 'vue';
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';
import Dropdown from '@/Components/Pages/Dropdown.vue';
import DropdownLink from '@/Components/Pages/DropdownLink.vue';
import DropdownSidebar from '@/Components/Painel/DropdownSidebar.vue';
import DropdownSidebarLink from '@/Components/Painel/DropdownSidebarLink.vue';
import SidebarLink  from './SidebarLink.vue';
import { Link, usePage, router} from '@inertiajs/vue3';
import { Icon } from '@iconify/vue'

const page = usePage();
const user = computed(() => page.props.user)

const showMenu = ref(false);

function logout(){
    router.post(route('logout'));
}
</script>

<template>
    <nav class="tw-max-h-screen tw-border-b tw-border-gray-100 tw-flex tw-flex-col tw-bg-white tw-shadow-lg tw-overflow-x-hidden tw-overflow-scroll tw-transition-all" :class="showMenu ? 'tw-w-[90px]' : 'tw-w-[264px]'" >
        
        <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-py-8">
           
                <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-between">
                
                    <div class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-px-6">
                        <Link :href="route('dashboard')" v-if="!showMenu">
                            <ApplicationLogo
                                class="tw-block tw-h-11 tw-w-auto tw-fill-current tw-text-gray-800"
                            />
                        </Link>
                        <div class="-tw-mr-2 tw-flex tw-items-center">
                            <button @click="showMenu = !showMenu" class="tw-inline-flex tw-items-center tw-justify-center tw-p-2 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 focus:tw-text-gray-500 tw-transition tw-duration-150 tw-ease-in-out">
                                <Icon v-if="showMenu" icon="lucide:sidebar-open" class="tw-h-6 tw-w-6 tw-text-gray-600"/>
                                <Icon v-if="!showMenu" icon="lucide:sidebar-close" class="tw-h-6 tw-w-6 tw-text-gray-800"/>
                            </button>
                        </div>
                    </div>
                    <div class="tw-h-[2px] tw-w-[calc(100%-48px)] tw-bg-gray-100 tw-my-7 tw-mx-6"></div>

                    <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-between">
                        <!-- Navigation Links -->
                        <div class="tw-flex tw-flex-1 tw-flex-col">

                            <SidebarLink :reduced="showMenu" icon="majesticons:home-line" :href="route('dashboard')" :active="route().current('dashboard')">                           
                                Início
                            </SidebarLink>

                            <span class="flex tw-text-body tw-text-gray-600 tw-text-base tw-font-thin tw-mt-6"
                                :class="showMenu ? 'tw-opacity-0 tw-px-0' : 'tw-opacity-100 tw-px-6'"
                                >CONTROLE
                            </span>

                            <SidebarLink :reduced="showMenu" icon="formkit:people" :href="route('painel.editais')" :active="route().current('painel.editais')">     
                                Editais
                            </SidebarLink>
                            
                            <SidebarLink :reduced="showMenu" icon="system-uicons:clipboard" :href="route('painel.inscricoes')" :active="route().current('painel.inscricoes')">
                                Inscrições
                            </SidebarLink>

                            <span class="flex tw-text-body tw-text-gray-600 tw-text-base tw-font-thin tw-mt-6"
                                :class="showMenu ? 'tw-opacity-0 tw-px-0' : 'tw-opacity-100 tw-px-6'"
                                >ADMINISTRAÇÃO
                            </span>
                            
                            <SidebarLink :reduced="showMenu" icon="system-uicons:document" :href="route('painel.cursos')" :active="route().current('painel.curso')">                           
                                Cursos
                            </SidebarLink>

                            <SidebarLink :reduced="showMenu" icon="teenyicons:school-outline" :href="route('painel.escolas')" :active="route().current('painel.escolas')">
                                Unidades
                            </SidebarLink>

                            <SidebarLink :reduced="showMenu" icon="system-uicons:document" :href="route('painel.turmas')" :active="route().current('painel.turmas')">                           
                                Turmas
                            </SidebarLink>

                            <SidebarLink :reduced="showMenu" icon="mdi:city-variant-outline" :href="route('painel.municipios')" :active="route().current('painel.municipios')">
                                Municipios
                            </SidebarLink>
              


                        </div>

                        


                        <div class="tw-flex tw-flex-col">
                            <span  @click="logout()" :class="showMenu ? 'tw-justify-center tw-items-center' : 'tw-pl-6'" class="tw-cursor-pointer tw-flex btn-hover tw-shadow-sm tw-py-3 tw-px-4 tw-font-body tw-text-lg tw-items-center tw-border-r-2 hover:tw-bg-green-100 tw-border-white hover:tw-border-primary hover:tw-text-primary tw-leading-5 tw-text-gray-700 border-box focus:tw-outline-none  tw-transition tw-duration-150 tw-ease-in-out">     
                                <Icon icon="tabler:logout" class="tw-h-[28px] tw-w-[28px] tw-text-gray-500 tw-transition-all" :class="!showMenu && 'tw-mr-2'" />
                                <span v-if="!showMenu">Sair</span>
                            </span>
                            
                            <div class="tw-px-6">
                                <div class="tw-h-[2px] tw-w-full tw-bg-gray-100 tw-my-7"></div>
                                <img src="./../../../imgs/logo-efg-small.png" class="tw-h-8 tw-w-8"/>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
    </nav>
</template>