<script setup>
import {computed, ref} from 'vue';
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';
import Dropdown from '@/Components/Pages/Dropdown.vue';
import DropdownLink from '@/Components/Pages/DropdownLink.vue';
import DropdownMenu from '@/Components/LandingPag/DropdownMenu.vue';
import DropdownMenuLink from '@/Components/LandingPag/DropdownMenuLink.vue';
import NavLink from '@/Components/LandingPag/NavLink.vue';
import ResponsiveNavLink from '@/Components/LandingPag/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.user)

const showingNavigationDropdown = ref(false);
</script>

<template>
	<div>
		<div class="tw-min-h-screen tw-bg-gray-100">
			<nav class="tw-border-b tw-border-gray-100 tw-bg-white tw-shadow-lg">
				<!-- Primary Navigation Menu -->
				<div class="tw-max-w-7xl tw-mx-auto tw-px-4 sm:tw-px-6 lg:tw-px-4">
					<div class="tw-flex tw-justify-between tw-h-20">
						<div class="tw-flex">
							<!-- Logo -->
							<div class="tw-shrink-0 tw-flex tw-items-center">
								<Link :href="route('dashboard')">
									<ApplicationLogo
										 class="tw-block tw-h-9 tw-w-auto tw-fill-current tw-text-gray-800"
									/>
								</Link>
							</div>

							<!-- Navigation Links -->
							<div class="tw-hidden tw-space-x-8 sm:-tw-my-px sm:tw-ml-10 sm:tw-flex">
								<NavLink :active="route().current('dashboard')" :href="route('dashboard')">
									Dashboard
								</NavLink>
								<DropdownMenu align="left" width="48">
									<template #trigger>
										CURSOS
									</template>

									<template #content>
										<DropdownMenuLink :href="route('painel.cursos')"> VER TODOS</DropdownMenuLink>
										<DropdownMenuLink :href="route('painel.cursos.create')"> NOVO</DropdownMenuLink>
										<DropdownMenuLink :href="route('painel.cursos')"> cursos</DropdownMenuLink>
										<DropdownMenuLink :href="route('painel.cursos.create')"> NOVO MODELO</DropdownMenuLink>
									</template>
								</DropdownMenu>
								<DropdownMenu align="left" width="48">
									<template #trigger>
										ESCOLAS
									</template>

									<template #content>
										<DropdownMenuLink :href="route('painel.escolas')"> VER TODAS</DropdownMenuLink>
										<DropdownMenuLink :href="route('painel.escolas.create')"> NOVO</DropdownMenuLink>
									</template>
								</DropdownMenu>
								<DropdownMenu align="left" width="48">
									<template #trigger>
										MUNICÍPIOS
									</template>

									<template #content>
										<DropdownMenuLink :href="route('painel.municipios')"> VER TODOS</DropdownMenuLink>
										<DropdownMenuLink :href="route('painel.municipios.create')"> NOVO</DropdownMenuLink>
									</template>
								</DropdownMenu>
								<NavLink :active="route().current('painel.editais')" :href="route('painel.editais')">
									EDITAIS
								</NavLink>
								<NavLink :active="route().current('painel.matriculados')" :href="route('painel.matriculados')">
									MATRÍCULAS
								</NavLink>

								<DropdownMenu v-if="user.roles.includes('admin')" align="left" class="tw-text-black" width="48">
									<template #trigger>
										GESTÃO
									</template>

									<template #content>
										<DropdownMenuLink :href="route('painel.gestao.usuarios')"> USUÁRIOS</DropdownMenuLink>
										<DropdownMenuLink :href="route('painel.gestao.grupos')"> GRUPOS</DropdownMenuLink>
										<DropdownMenuLink :href="route('painel.gestao.permissoes')"> PERMISSÕES</DropdownMenuLink>
									</template>
								</DropdownMenu>

							</div>
						</div>

						<div class="tw-hidden sm:tw-flex sm:tw-items-center sm:tw-ml-6">
							<!-- Settings Dropdown -->
							<div class="tw-ml-3 tw-relative">
								<Dropdown align="right" width="48">
									<template #trigger>
                                        <span class="tw-inline-flex tw-rounded-md">
                                            <button
	                                             class="tw-inline-flex tw-items-center tw-px-3 tw-py-2 tw-border tw-border-transparent tw-text-sm tw-leading-4 tw-font-medium tw-rounded-md tw-text-gray-500 tw-bg-white hover:tw-text-gray-700 focus:tw-outline-none tw-transition tw-ease-in-out tw-duration-150"
	                                             type="button"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
	                                                 class="tw-ml-2 -tw-mr-0.5 tw-h-4 tw-w-4"
	                                                 fill="currentColor"
	                                                 viewBox="0 0 20 20"
	                                                 xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
	                                                     clip-rule="evenodd"
	                                                     d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
	                                                     fill-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
									</template>

									<template #content>
										<DropdownLink :href="route('profile.edit')"> Perfil</DropdownLink>
										<DropdownLink :href="route('logout')" as="button" method="post">
											Sair
										</DropdownLink>
									</template>
								</Dropdown>
							</div>
						</div>

						<!-- Hamburger -->
						<div class="-tw-mr-2 tw-flex tw-items-center sm:tw-hidden">
							<button
								 class="tw-inline-flex tw-items-center tw-justify-center tw-p-2 tw-rounded-md tw-text-gray-400 hover:tw-text-gray-500 hover:tw-bg-gray-100 focus:tw-outline-none focus:tw-bg-gray-100 focus:tw-text-gray-500 tw-transition tw-duration-150 tw-ease-in-out"
								 @click="showingNavigationDropdown = !showingNavigationDropdown"
							>
								<svg class="tw-h-6 tw-w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path
										 :class="{
                                            'tw-hidden': showingNavigationDropdown,
                                            'tw-inline-flex': !showingNavigationDropdown,
                                        }"
										 d="M4 6h16M4 12h16M4 18h16"
										 stroke-linecap="round"
										 stroke-linejoin="round"
										 stroke-width="2"
									/>
									<path
										 :class="{
                                            'tw-hidden': !showingNavigationDropdown,
                                            'tw-inline-flex': showingNavigationDropdown,
                                        }"
										 d="M6 18L18 6M6 6l12 12"
										 stroke-linecap="round"
										 stroke-linejoin="round"
										 stroke-width="2"
									/>
								</svg>
							</button>
						</div>
					</div>
				</div>

				<!-- Responsive Navigation Menu -->
				<div
					 :class="{ 'tw-block': showingNavigationDropdown, 'tw-hidden': !showingNavigationDropdown }"
					 class="sm:tw-hidden"
				>
					<div class="tw-pt-2 tw-pb-3 tw-space-y-1">
						<ResponsiveNavLink :active="route().current('dashboard')" :href="route('dashboard')">
							Dashboard
						</ResponsiveNavLink>
					</div>

					<!-- Responsive Settings Options -->
					<div class="tw-pt-4 tw-pb-1 tw-border-t tw-border-gray-200">
						<div class="tw-px-4">
							<div class="tw-font-medium tw-text-base tw-text-gray-800">
								{{ $page.props.auth.user.name }}
							</div>
							<div class="tw-font-medium tw-text-sm tw-text-gray-500">{{ $page.props.auth.user.email }}</div>
						</div>

						<div class="tw-mt-3 tw-space-y-1">
							<ResponsiveNavLink :href="route('profile.edit')"> Perfil</ResponsiveNavLink>
							<ResponsiveNavLink :href="route('logout')" as="button" method="post">
								Sair
							</ResponsiveNavLink>
						</div>
					</div>
				</div>
			</nav>

			<!-- Page Content -->
			<main>
				<slot/>
			</main>
		</div>
	</div>

</template>


<style>
@import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@100;300;400;700;800&family=Open+Sans:wght@300;400;600;800&display=swap');

[type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus,
[type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus,
[type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus,
textarea:focus, select:focus {
	--tw-ring-shadow: 0;
}
</style>