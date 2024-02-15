<template>
    <RegisterLayout>
        <Head title="Criar conta" />
        <form @submit.prevent="submit()" class="tw-flex tw-flex-1 tw-flex-col lg:tw-pt-0">
            <div class="tw-font-title tw-flex tw-flex-1 tw-flex-col tw-gap-2">
                <h6 class="tw-text-primary tw-font-semibold tw-text-base">Cadastre-se</h6>
                <h5 class="tw-text-gray-800 tw-font-semibold tw-text-2xl">Preencha o formulário de cadastro e junte-se a nós nessa nova jornada.</h5>
                <p class="tw-text-gray-600 tw-my-2 tw-text-[14px]">Os campos com <span class="tw-text-red-700">*</span> são obrigatórios.</p>
            </div> 
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-9 tw-mt-6"> 
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="name" value="Nome Completo" required/>
                    <q-input 
                        id="name" 
                        type="text" required autofocus autocomplete="name"
                        placeholder="Seu nome"
                        outlined
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.name"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.name" />
                </div>
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="cpf" value="CPF" required/>
                    <q-input id="cpf" type="text" required autofocus autocomplete="cpf"
                        placeholder="000.000.000-00"
                        mask="###.###.###-##" outlined
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-lg"
                        v-model="form.cpf"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.cpf" />
                </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-9 tw-mt-6">
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="data_nascimento" value="Data de Nascimento" required/>
                    <q-input 
                        id="data_nascimento" 
                        type="date" 
                        required 
                        autofocus 
                        autocomplete="data_nascimento"
                        placeholder="12/01/1995" 
                        outlined
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.data_nascimento"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.data_nascimento" />
                    <p v-if="isUnderAge" class="tw-text-red-700 tw-mt-1 tw-text-[14px]">Você deve ser maior de 14 anos para se cadastrar.</p>
                </div>
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="telefone" value="Telefone" required/>
                    <q-input id="telefone" type="text" required autofocus autocomplete="telefone"
                        placeholder="(00) 00000-0000"
                        mask="(##) #####-####" outlined
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.telefone"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.telefone" />
                </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-9 tw-mt-6">
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="email" value="E-mail" required/>
                    <q-input id="email" type="email" required autofocus autocomplete="email"
                        outlined
                        placeholder="seu@email.com"
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.email"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.email" />
                </div>
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="email_confirmation" value="Confirmação de E-mail" required/>
                    <q-input id="email_confirmation" type="email" required autofocus autocomplete="email"
                        outlined
                        placeholder="seu@email.com"
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.email_confirmation"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.email_confirmation" />
                </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-9 tw-mt-6">
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="password" value="Sua senha" required/>
                    <q-input id="password" type="password" required autofocus autocomplete="password"
                        outlined
                        placeholder="Sua senha"
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.password"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.password" />
                </div>
                <div class="tw-flex tw-flex-1 tw-flex-col">
                    <InputLabel for="password_confirmation" value="Confirmação de Senha" required/>
                    <q-input id="password_confirmation" type="password" required autofocus autocomplete="password"
                        outlined
                        placeholder="Confirme sua senha"
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.password_confirmation"
                    />
                    <InputError class="tw-mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-row tw-my-3">
                <label class="tw-flex tw-items-center -tw-ml-2">
                    <q-checkbox v-model="form.terms" />
                    <span class="tw-text-[14px] tw-text-gray-600 tw-pt-1">Eu li e concordo com o Termo de Uso e Privacidade.</span>
                </label>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4 lg:tw-gap-9 tw-mt-6">
                <div class="lg:tw-flex tw-hidden tw-flex-[2]"></div>
                <Link :href="route('login')" class="tw-flex tw-flex-1 tw-py-3 tw-items-center tw-text-primary tw-text-base tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                    Cancelar
                </Link>
                <PrimaryButton class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-justify-center tw-bg-primary">
                    Criar Conta
                </PrimaryButton>
            </div>
        </form>
    </RegisterLayout>
</template>

<script setup>
import RegisterLayout from '@/Layouts/RegisterLayout.vue';
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  email_confirmation: '',
  password: '',
  cpf: '',
  telefone: '',
  data_nascimento: '',
  password_confirmation: '',
  terms: false,
});

const submit = async () => {
  const birthDate = new Date(form.data_nascimento);
  const currentDate = new Date();
  const age = currentDate.getFullYear() - birthDate.getFullYear();

  if (age < 14) {
    form.errors.data_nascimento = 'Você deve ser maior de 14 anos para se cadastrar.';
    return;
  }

  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

  if (!passwordRegex.test(form.password)) {
    form.errors.password = 'A senha deve conter mínimo de oito caracteres, pelo menos uma letra maiúscula, uma letra minúscula, um número e um caractere especial';
    return;
  }

  console.log(form.value)

  await form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>