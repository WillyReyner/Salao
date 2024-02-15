<template>
    <Head title="Perfil" />
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div
                class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div
                    class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class="tw-font-title tw-font-semibold">
                        Meu Perfil
                    </h4>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
                        Dados Pessoais
                    </p>
                </div>
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-8 tw-gap-2 tw-m-1">
                    <!-- <div class="tw-flex tw-flex-1 tw-flex-col">imagem</div> -->
                    <div class="tw-flex tw-flex-4 tw-flex-col">
                        <div class="q-file-image">
                            <q-file disable :model-value="form.imagem" @update:model-value="updateFile"
                                accept=".jpg,.png">
                                <template v-slot:before>
                                    <div class="q-file-image-preview" :style="getImagePreviewStyle">
                                        <img :src="`/storage/${user.imagem}`" /> 
                                    </div>
                                </template>
                            </q-file>
                        </div>
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                            <div class="tw-flex tw-flex-col tw-mr-4 tw-w-3/4">
                                <InputLabel for="name" value="Nome Completo" required />
                                <q-input disable id="name" v-model="form.name"
                                    class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                                <InputError class="tw-mt-2" :message="form.errors.name" />
                            </div>
                            <div class="tw-flex tw-flex-col tw-mr-4 tw-w-1/4">
                                <InputLabel for="role" value="Perfil do Usuário" required />
                                <q-select disable :options="opcoesTag" id="role" v-model="form.role"
                                    class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                                <InputError class="tw-mt-2" :message="form.errors.role" />
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                            <div class="tw-flex tw-flex-1 tw-flex-col">
                                <InputLabel for="email" value="Email" required />
                                <q-input disable id="email" v-model="form.email"
                                    class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                                <InputError class="tw-mt-2" :message="form.errors.email" />
                            </div>
                            <div class="tw-flex tw-flex-1 tw-flex-col">
                                <InputLabel for="telefone" value="Telefone" required />
                                <q-input disable mask="(##) #####-####" id="telefone" v-model="form.telefone"
                                    class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                                <InputError class="tw-mt-2" :message="form.errors.telefone" />
                            </div>
                            <div class="tw-flex tw-flex-1 tw-flex-col">
                                <InputLabel for="data_nascimento" value="Data de Nascimento" required />
                                <q-input disable type="date" id="data_nascimento" v-model="form.data_nascimento"
                                    class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                                <InputError class="tw-mt-2" :message="form.errors.data_nascimento" />
                            </div>
                            <div class="tw-flex tw-flex-1 tw-flex-col">
                                <InputLabel for="cpf" value="CPF" required />
                                <q-input disable mask="###.###.###-##" id="cpf" v-model="form.cpf"
                                    class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                                <InputError class="tw-mt-2" :message="form.errors.cpf" />
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
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
const user = usePage().props.auth.user;

const defaultImage = ref(
  "https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"
);

const uploadUrl = ref("");
const destaque = ref("");
const srcImage = ref(null);

const toBase64 = (file) =>
  new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });

const updateFile = async (event) => {
  srcImage.value = await toBase64(event);
  form.imagem = event
};

const getImagePreviewStyle = computed(() => {
  let url = srcImage.value || defaultImage.value;
  return `background-image: url(${url})`;
});

const form = useForm({
    id: user.id,
    name: user.name,
    email: user.email,
    cpf: user.cpf,
    email: user.email,
    telefone: user.telefone,
    role: [user.role],
    data_nascimento: user.data_nascimento ? user.data_nascimento.split(' ')[0] : '',
    imagem: null,
});
</script>

<style>
.custom-uploader {
  max-width: 800px;
  /* Ajuste o valor conforme necessário */
  /* Outros estilos personalizados, se necessário */
}

.q-file-image {
  width: 300px;
  position: relative;
  height: 250px;
  overflow: hidden;
  border-radius: 4px;
}

.q-file-image .q-field {
  padding: 0;
  border: 0 none;
}

.q-file-image .q-field .q-field__before,
.q-file-image .q-field .q-field__inner,
.q-file-image .q-field .q-field__control,
.q-file-image .q-field .q-field__control-container,
.q-file-image .q-field .q-field__native,
.q-file-image .q-field .q-field__input,
.q-file-image .q-field .q-field__control:before {
  margin: 0 !important;
  padding: 0 !important;
  border: 0 none !important;
  box-shadow: none !important;
  border-radius: 0;
}

.q-file-image .q-field .q-field__control,
.q-file-image .q-field .q-field__native {
  height: 250px;
}

.q-file-image .q-file-image-preview {
  position: absolute;
  left: 0;
  top: 0;
  height: 250px;
  width: 100%;
}

.q-file-image .q-file-image-preview img {
  display: block;
  width: 100%;
  object-fit: cover;
  border-radius: 4px;
}

.q-file-image .q-file-image-preview {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
}
</style>