<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Dialog, Notify } from 'quasar'
import { Icon } from '@iconify/vue';
import { computed } from 'vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import InputError from '@/Components/Pages/InputError.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const tab = ref('');
</script>

<template>
    <Head title="Perfil" />
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
                </div>
                <q-card>
                    <q-tabs v-model="tab" dense class="text-grey" active-color="primary" indicator-color="primary" align="justify" narrow-indicator>
                        <q-tab name="mails" label="Perfil" />
                        <q-tab name="alarms" label="Senhas" />
                    </q-tabs>
                    <q-separator />
                    <q-tab-panels v-model="tab" animated>
                        <q-tab-panel name="mails">
                            <div class="text-h6">Perfil de Usuário</div>
                            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="tw-max-w-xl" />
                        </q-tab-panel>
                        <q-tab-panel name="alarms">
                            <div class="text-h6">Alarms</div>
                            <UpdatePasswordForm class="tw-max-w-xl" />
                        </q-tab-panel>
                    </q-tab-panels>
                </q-card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
