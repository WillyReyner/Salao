<template>
  <Head title="Cursos" />
  <AuthenticatedLayout>
    <div class="tw-flex tw-flex-1 tw-flex-col">
      <div
        class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
        <div
          class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
          <h4 class="tw-font-title tw-font-semibold">
            Detalhes do Usuário
          </h4>
        </div>
        <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
          <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
            Dados Pessoais
          </p>
        </div>
        <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-8 tw-gap-2 tw-m-1 tw-pb-4">
          <!-- <div class="tw-flex tw-flex-1 tw-flex-col">imagem</div> -->
          <div class="tw-flex tw-flex-4 tw-flex-col">
            <div class="q-file-image">
              <q-file disable  :model-value="form.imagem" @update:model-value="updateFile" accept=".jpg,.png">
                <template v-slot:before>
                  <div class="q-file-image-preview" :style="getImagePreviewStyle">
                   <img :src="`/storage/${props.usuarios.imagem}`" />
                  </div>
                </template>
              </q-file>
            </div>
          </div>
          <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
              <div class="tw-flex tw-flex-col tw-mr-4 tw-w-3/4">
                <InputLabel for="name" value="Nome Completo" required />
                <q-input 
                  
                  disable
                  id="name"
                  v-model="form.name" 
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.name" />
              </div>
              <div class="tw-flex tw-flex-col tw-mr-4 tw-w-1/4">
                <InputLabel for="role" value="Perfil do Usuário" required />
                <q-select
                  
                  disable
                  :options="opcoesTag" 
                  id="role"
                  v-model="form.role" 
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
                <q-input 
                  
                  disable
                  id="email"
                  v-model="form.email" 
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.email" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="telefone" value="Telefone" required />
                <q-input 
                  
                  disable
                  mask="(##) #####-####"
                  id="telefone"
                  v-model="form.telefone" 
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.telefone" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="data_nascimento" value="Data de Nascimento" required />
                <q-input 
                  
                  disable
                  type="date"
                  id="data_nascimento"
                  v-model="form.data_nascimento" 
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.data_nascimento" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="cpf" value="CPF" required />
                <q-input
                  disable
                  
                  mask="###.###.###-##"
                  id="cpf"
                  v-model="form.cpf" 
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.cpf" />
              </div>
            </div>
          </div>
        </div>
        <div class="tw-flex tw-justify-end tw-gap-2">
            <Link :href="route('painel.gestao.usuarios')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                CANCELAR
            </Link>
            <Link :href="route('painel.gestao.usuarios.editar', props.usuarios.id)"
						class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
            <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" /> 
					Editar
					</Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import InputError from "@/Components/Pages/InputError.vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Icon } from "@iconify/vue";
import { Head, useForm, router, Link } from "@inertiajs/vue3";
import { Notify } from "quasar";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
  usuarios: {
    type: Array,
    default: [],
  },
});

const opcoesTag = ['Super Admin', 'Admin', 'Aluno', 'Usuário'];
const uploadUrl = ref("");
const destaque = ref("");

const form = useForm({
  id: props.usuarios.id,
  name: props.usuarios.name,
  cpf: props.usuarios.cpf,
  email: props.usuarios.email,
  telefone: props.usuarios.telefone,
  role: [props.usuarios.role],
  data_nascimento: props.usuarios.data_nascimento ? props.usuarios.data_nascimento.split(' ')[0] : '',
  imagem: null, // Certifique-se de que imagem é inicializado como um array vazio
});

const defaultImage = ref(
  "https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg"
);

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

function store() {
  form.post(route("painel.gestao.usuarios.store"), {
    forceFormData: true,
    preserveScroll: true,
    forceFormData: true,
    onSuccess: (res) => {
      form.reset();
      Notify.create({
        message: "Usuário registrado com sucesso.",
        color: "secondary",
      });
    },
    onError: (err) => {
      console.log(err);
      Notify.create({
        message: "Não foi possível registrar o usuário.",
        color: "negative",
      });
    },
  });
}

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
