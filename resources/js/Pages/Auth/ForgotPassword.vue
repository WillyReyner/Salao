<script setup>
import RegisterLayout from '@/Layouts/RegisterLayout.vue';
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import TextInput from '@/Components/Pages/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <RegisterLayout>
        <Head title="Esqueci minha senha" />

        <div class="tw-mb-4 tw-text-sm tw-text-gray-600">
            Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um e-mail com uma redefinição de senha
            link que permitirá que você escolha um novo.
        </div>

        <div v-if="status" class="tw-mb-4 tw-font-medium tw-text-sm tw-text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="E-mail" />

                <TextInput
                    id="email"
                    type="email"
                    class="tw-mt-1 tw-block tw-w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="tw-mt-2" :message="form.errors.email" />
            </div>

            <div class="tw-flex tw-items-center tw-justify-end tw-mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Enviar link para redefinir senha
                </PrimaryButton>
            </div>
        </form>
    </RegisterLayout>
</template>
