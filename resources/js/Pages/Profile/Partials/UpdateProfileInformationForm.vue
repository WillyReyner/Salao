<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

</script>

<template>
    <section>
        <header>
            <h2 class="tw-text-lg tw-font-medium tw-text-gray-900">Informações do perfil</h2>

            <p class="tw-mt-1 tw-text-sm tw-text-gray-600">
                Atualize as informações de perfil e o endereço de e-mail da sua conta.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="tw-mt-6 tw-space-y-6">
            <div>
                <InputLabel for="name" value="Nome Completo" required/>
                <q-input 
                    outlined 
                    id="name" 
                    type="text" 
                    class="tw-mt-1 tw-block tw-w-full" 
                    v-model="form.name" 
                    required autofocus 
                    autocomplete="name" />
                <InputError class="tw-mt-2" :message="form.errors.name" />
            </div>
            <div>
                <InputLabel for="email" value="E-mail" />
                <q-input outlined id="email" type="email" class="tw-mt-1 tw-block tw-w-full" v-model="form.email" required
                    autocomplete="username" />
                <InputError class="tw-mt-2" :message="form.errors.email" />
            </div>
            <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
                <p class="tw-text-sm tw-mt-2 tw-text-gray-800">
                    Seu endereço de e-mail não foi verificado.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="tw-underline tw-text-sm tw-text-gray-600 hover:tw-text-gray-900 tw-rounded-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500">
                    Clique aqui para reenviar o e-mail de verificação.
                    </Link>
                </p>
                <div v-show="props.status === 'verification-link-sent'"
                    class="tw-mt-2 tw-font-medium tw-text-sm tw-text-green-600">
                    Um novo link de verificação foi enviado para o seu endereço de e-mail.
                </div>
            </div>
            <div class="tw-flex tw-items-center tw-gap-4">
                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>
                <Transition enter-from-class="tw-opacity-0" leave-to-class="tw-opacity-0"
                    class="tw-transition tw-ease-in-out">
                    <p v-if="form.recentlySuccessful" class="tw-text-sm tw-text-gray-600">Salvo.</p>
                </Transition>
            </div>
        </form>
    </section>
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
                </div>
                <!-- Tipo, Turno e Modalidade -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="categoria" value="Categoria" required/>
                        <select
                            v-model="form.categoria" id="categoria" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesCategoria" :value="opcao">{{ opcao }}</option>
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.categoria" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="horas_curso" value="Carga Horária" required/>
                        <select
                            v-model="form.horas_curso" id="horas_curso" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesCargahoraria" :value="opcao">{{ opcao }}</option>
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.horas_curso" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="modalidade" value="Modalidade" required/>
                        <select
                            v-model="form.modalidade" id="modalidade" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesModalidade" :value="opcao">{{ opcao }}</option>
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.modalidade" />
                    </div>
                </div>
    
                <!-- Horas Curso, Nivel, Faixa Etaria -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nivel" value="Nivel" required/>
                        <select
                            v-model="form.nivel" id="nivel" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesNivel" :value="opcao">{{ opcao }}</option>
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.nivel" />
                    </div>
    
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="faixa_etaria" value="Faixa Etária" required/>
                        <select
                            v-model="form.faixa_etaria" id="faixa_etaria" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesFaixaetaria" :value="opcao">{{ opcao }}</option>
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.faixa_etaria" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="vagas" value="Vagas" required/>
                        <input id="vagas" type="number" required autofocus autocomplete="vagas"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.vagas"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.vagas" />
                    </div> 
                </div>
    
                <!-- Resumo -->
                <div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
                    <InputLabel for="resumo" value="Resumo" required/>
                    <textarea v-model="form.resumo" rows="4" class="tw-mt-1 tw-text-gray-700  tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                    </textarea>
                </div>
    
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-font-semibold tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">DATA E HORA</p>
                </div>
                <hr>
    
                <div class="tw-flex tw-flex-row tw-mt-8 md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-auto tw-w-80 tw-flex-col">
                        <InputLabel for="dias_semana" value="Dias da Semana" required/>
                        <select
                            v-model="form.dias_semana" id="dias_semana" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesDiasSemana" :value="opcao">{{ opcao }}</option>
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.dias_semana" />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="turno" value="Turno" required/>
                        <select
                            v-model="form.turno" id="turno" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesTurno" :value="opcao">{{ opcao }}</option>
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.turno" />
                    </div>
                    <div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
                        <InputLabel for="hora_inicio" value="Hora de Início" required/>
                        <input
                            id="hora_inicio"
                            type="time"  
                            required
                            autofocus
                            autocomplete="hora_inicio"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.hora_inicio"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.hora_inicio" />
                    </div>
                    <div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
                        <InputLabel for="hora_termino" value="Hora de Termino" required/>
                        <input
                            id="hora_termino"
                            type="time" 
                            autofocus
                            autocomplete="hora_termino"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.hora_termino" 
                        />
                        <InputError class="tw-mt-2" :message="form.errors.hora_termino" />
                    </div>
                    <div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
                        <InputLabel for="hora_termino" value="Hora de Termino" required/>
                        <input
                            id="data_inicio"
                            type="date" 
                            autofocus
                            autocomplete="data_inicio"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.data_inicio" 
                        />
                        <InputError class="tw-mt-2" :message="form.errors.data_inicio" />
                    </div>
                    <!-- <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="data_inicio_inscricao" value="Precisão de Início" required/>
                        <input id="data_inicio_inscricao" type="date" required autofocus autocomplete="data_inicio_inscricao"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.data_inicio_inscricao"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.data_inicio_inscricao" />
                    </div>                    -->
                </div>
                
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.turmas')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                        VOLTAR
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

<style>
[type='text']:focus,
[type='email']:focus,
[type='url']:focus,
[type='password']:focus,
[type='number']:focus,
[type='date']:focus,
[type='datetime-local']:focus,
[type='month']:focus,
[type='search']:focus,
[type='tel']:focus,
[type='time']:focus,
[type='week']:focus,
[multiple]:focus,
textarea:focus,
select:focus {
    --tw-ring-shadow: 0;
}
</style>
