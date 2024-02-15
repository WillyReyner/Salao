<script setup>
import RegisterLayout from '@/Layouts/RegisterLayout.vue';
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import TextInput from '@/Components/Pages/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <RegisterLayout>
        <Head title="Confirmar senha" />

        <div class="tw-mb-4 tw-text-sm tw-text-gray-600">
            Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="password" value="Senha" />
                <TextInput
                    id="password"
                    type="password"
                    class="tw-mt-1 tw-block tw-w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <InputError class="tw-mt-2" :message="form.errors.password" />
            </div>

            <div class="tw-flex tw-justify-end tw-mt-4">
                <PrimaryButton class="tw-ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Confirmar
                </PrimaryButton>
            </div>
        </form>
    </RegisterLayout>
</template>
