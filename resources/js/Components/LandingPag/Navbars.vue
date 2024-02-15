<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import DropdownMenu from '@/Components/LandingPag/DropdownMenu.vue';
import DropdownMenuLink from '@/Components/LandingPag/DropdownMenuLink.vue';
import NavLink from '@/Components/LandingPag/NavLink.vue';
import ResponsiveNavLink from '@/Components/LandingPag/ResponsiveNavLink.vue';
import { Icon } from '@iconify/vue'
import logoEfg from '../../../imgs/logo-efg.png'
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
const showingNavigationDropdown = ref(false);
</script>

<template>
<!-- TopMenu -->
<div class="tw-flex tw-h-[52px] tw-bg-green-700 tw-text-gray-50 tw-px-10 tw-shadow-md">
  <!-- Left -->
  <div class="tw-flex tw-flex-1 tw-items-center tw-justify-start tw-gap-2">
      <Icon icon="prime:instagram" class="tw-h-8 tw-w-8 tw-p-1 tw-rounded-full tw-bg-white tw-text-primary hover:tw-text-grass-300 tw-transition-colors"/>
      <Icon icon="iconoir:youtube" class="tw-h-8 tw-w-8 tw-p-1 tw-rounded-full tw-bg-white tw-text-primary hover:tw-text-grass-300 tw-transition-colors" />
      <Icon icon="ant-design:facebook-outlined" class="tw-h-8 tw-w-8 tw-p-1 tw-rounded-full tw-bg-white tw-text-primary hover:tw-text-grass-300 tw-transition-colors" />
      <Icon icon="ph:tiktok-logo" class="tw-h-8 tw-w-8 tw-p-1 tw-rounded-full tw-bg-white tw-text-primary hover:tw-text-grass-300 tw-transition-colors"/>
  </div>
  <!-- Center -->
  <div class="tw-flex tw-flex-1 tw-items-center tw-justify-center">
      <div class="tw-flex tw-flex-1  tw-relative tw-text-white focus-within:tw-text-gray-100 tw-border-b-[1px] tw-border-white">
          <span class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-2">
              <button type="submit" class="tw-p-1">
                  <Icon icon="ic:round-search" class="tw-h-5 tw-w-5"/>
              </button>
          </span>
          <input type="search" name="search" class="tw-font-body tw-border-none tw-py-2 tw-text-sm tw-text-white tw-bg-transparent tw-rounded-md tw-pl-10 focus:tw-outline-none focus:tw-text-gray-50 placeholder:tw-align-m placeholder:tw-text-gray-100 tw-flex-1" placeholder="Busque uma palavra chave no portal" autocomplete="off">
      </div>
  </div>
  <!-- Right -->
  <div class="tw-flex tw-flex-1 tw-items-center tw-justify-end tw-gap-8">
      <Link href="#" class="tw-font-title tw-font-bold hover:tw-text-grey-100 tw-transition-colors">
          ACESSO A INFORMAÇÃO
      </Link>
      <Link href="#" class="tw-font-title tw-font-bold hover:tw-text-grey-100 tw-transition-colors">
          TRANSPARÊNCIA
      </Link>
      <Link href="#" class="tw-font-title tw-font-bold hover:tw-text-grey-100 tw-transition-colors">
          SIGA - ALUNO
      </Link>
  </div>
</div>
<!-- Nav Menu -->
<div class="tw-px-6 sm:tw-px-6 lg:tw-px-4 tw-shadow-lg tw-border-b-1">
    <div class="tw-flex tw-flex-1 tw-items-center">
        <div class="tw-flex">
            <div class="tw-shrink-0 tw-flex tw-items-center">
                <Link :href="route('dashboard')">
                    <img :src=logoEfg class="tw-block tw-object-contain tw-fill-current tw-text-gray-800"/>
                </Link>
            </div>
        </div>
        <div class="tw-flex tw-flex-1 tw-items-end tw-justify-end tw-text-sm">
            <div class="tw-hidden tw-space-x-8 sm:tw-my-px sm:tw-ml-10 sm:tw-flex">
	            <q-btn-dropdown borderless class="tw-rounded-2xl tw-border-0 tw-shadow-none" label="Cursos" style="box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);" />
	            <q-btn-dropdown class="tw-rounded-2xl" label="IDEIA AO NEGOCIO" />
	            <q-btn-dropdown class="tw-rounded-2xl" label="SOU EFG" />
	            <q-btn-dropdown class="tw-rounded-2xl" label="INSTITUCIONAL" />
<!--               <DropdownMenu align="left" class="tw-border tw-border-red-500 tw-w-50" >-->
<!--                    <template #trigger>-->
<!--                        CURSOS-->
<!--                    </template>-->
<!--                    <template #content>-->
<!--                        <DropdownMenuLink :href="route('profile.edit')"> CURSOS </DropdownMenuLink>-->
<!--                        <DropdownMenuLink :href="route('logout')"> MINICURSOS </DropdownMenuLink>-->
<!--	                     <DropdownMenuLink :href="route('logout')"> EDITAIS </DropdownMenuLink>-->
<!--                    </template>-->
<!--               </DropdownMenu>-->
<!--	            <DropdownMenu align="left"  >-->
<!--		            <template #trigger>-->
<!--			            IDEIA AO NEGOCIO-->
<!--		            </template>-->
<!--		            <template #content>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> LABORATÓRIO DE INOVAÇÃO </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> ESPAÇO COLETIVO </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> CONSULTORIA </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> MONTE SEU NEGÓCIO </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> PROJETOS DE EXTENSÃO E CULTURA MAKER </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> EDITAIS </DropdownMenuLink>-->
<!--		            </template>-->
<!--	            </DropdownMenu>-->
<!--	            <DropdownMenu align="left" >-->
<!--		            <template #trigger>-->
<!--			            SOU EFG-->
<!--		            </template>-->
<!--		            <template #content>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> GRUPOS DE PESQUISA </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> GRUPOS DE EXTENSÃO E CULTURA MAKER </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> LEVEMENTE </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> BIBLIOTECA </DropdownMenuLink>-->
<!--		            </template>-->
<!--	            </DropdownMenu>-->
<!--	            <DropdownMenu align="left" >-->
<!--		            <template #trigger>-->
<!--			            INSTITUCIONAL-->
<!--		            </template>-->
<!--		            <template #content>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> QUEM SOMOS </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> UNIDADES </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> NOTÍCIAS </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> IDENTIDADE VISUAL </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('profile.edit')"> FALE CONOSCO </DropdownMenuLink>-->
<!--			            <DropdownMenuLink :href="route('logout')"> TRABALHE CONOSCO </DropdownMenuLink>-->
<!--		            </template>-->
<!--	            </DropdownMenu>-->
<!--                <DropdownMenu align="left" >-->
<!--                    <template #trigger>-->
<!--                        STAI-->
<!--                    </template>-->
<!--                    <template #content>-->
<!--                        <DropdownMenuLink :href="route('profile.edit')"> CAMPUS PARTY </DropdownMenuLink>-->
<!--                        <DropdownMenuLink :href="route('logout')"> SIMPÓSIOS </DropdownMenuLink>-->
<!--                    </template>-->
<!--                </DropdownMenu>-->
<!--                <DropdownMenu align="left" >-->
<!--                    <template #trigger>-->
<!--                        ESCOLAS-->
<!--                    </template>-->
<!--                    <template #content>-->
<!--                        <DropdownMenuLink :href="route('profile.edit')"> CAMPUS PARTY </DropdownMenuLink>-->
<!--                        <DropdownMenuLink :href="route('logout')"> SIMPÓSIOS </DropdownMenuLink>-->
<!--                    </template>-->
<!--                </DropdownMenu>-->
<!--                <DropdownMenu align="left" >-->
<!--                    <template #trigger>-->
<!--                        EVENTOS-->
<!--                    </template>-->

<!--                    <template #content>-->
<!--                        <DropdownMenuLink :href="route('profile.edit')"> CAMPUS PARTY </DropdownMenuLink>-->
<!--                        <DropdownMenuLink :href="route('logout')"> SIMPÓSIOS </DropdownMenuLink>-->
<!--                    </template>-->
<!--                </DropdownMenu>-->
            </div>
        </div>
        <div class="tw-hidden sm:tw-flex sm:tw-items-center sm:tw-justify-end sm:tw-ml-6 tw-gap-10">
            <Link href="#">
                <PrimaryButton buttonClass="tw-bg-green-700 tw-text-white tw-h-2 active:tw-bg-transparent hover:tw-bg-transparent focus:tw-bg-transparent hover:tw-text-grass-700 tw-transition-colors tw-w-auto">INSCREVA-SE</PrimaryButton>
            </Link>
<!--            <Link href="#">-->
<!--                <PrimaryButton buttonClass="tw-text-white">CADASTRE-SE</PrimaryButton>-->
<!--            </Link>-->
        </div>
        <!-- Hamburger -->
        <div class="-tw-mr-2 tw-flex tw-items-center sm:tw-hidden">
            <button
                @click="showingNavigationDropdown = !showingNavigationDropdown"
                class="tw-inline-flex tw-items-center tw-justify-center tw-p-2 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 focus:tw-text-gray-500 tw-transition tw-duration-150 tw-ease-in-out">
                <svg class="tw-h-6 tw-w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'tw-hidden': showingNavigationDropdown, 'tw-inline-flex': !showingNavigationDropdown, }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                    <path :class="{ 'tw-hidden': !showingNavigationDropdown, 'tw-inline-flex': showingNavigationDropdown, }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
    </div>
</div>
</template>