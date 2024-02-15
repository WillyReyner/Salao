<script setup>
import LoginLayout from '@/Layouts/LoginLayout.vue';
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <LoginLayout>
        <Head title="Entrar" />

        <div v-if="status" class="tw-mb-4 tw-font-medium tw-text-sm tw-text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit()" class="tw-w-80">
            <div class="tw-flex tw-flex-col">
                <InputLabel for="email" value="E-mail" />

                <input
                    id="email" type="email" required autofocus autocomplete="username"
                    class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                    v-model="form.email"
                />

                <InputError class="tw-mt-2" :message="form.errors.email" />
            </div>

            <div class="tw-mt-4">
                <InputLabel for="password" value="Senha" />

                <input
                    id="password" type="password" required autocomplete="current-password"
                    class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                    v-model="form.password"
                />

                <InputError class="tw-mt-2" :message="form.errors.password" />
            </div>

            <div class="tw-flex tw-flex-1 tw-flex-row tw-justify-between tw-items-center tw-mt-4">
                <label class="tw-flex tw-items-center">
                    <q-checkbox v-model="form.remember" />
                    <span class="tw-ml-1 tw-text-sm tw-text-gray-600">Lembre-me</span>
                </label>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="tw-underline tw-text-sm tw-text-gray-600 hover:tw-text-gray-900 tw-rounded-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-indigo-500"
                >
                    Esqueceu sua senha?
                </Link>
            </div>

            <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
                <PrimaryButton class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-justify-center tw-bg-primary" >
                    Entrar
                </PrimaryButton>
            </div>

            <div class="tw-flex tw-items-center tw-justify-end tw-mt-2">
                <Link :href="route('register')" class="tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-base tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                    Criar Conta
                </Link>
            </div>

            
        </form>
    </LoginLayout>
</template>
