<template>
  <Head title="Cursos" />
  <AuthenticatedLayout>
    <div class="tw-flex tw-flex-1 tw-flex-col">
      <div
        class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
        <div
          class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
          <h4 class="tw-font-title tw-font-semibold">
            Adicionar Usuário
          </h4>
        </div>
        <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
          <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">
            Dados Pessoais
          </p>
        </div>
        <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-2 tw-gap-2 tw-m-1 tw-pb-4">
          <!-- <div class="tw-flex tw-flex-1 tw-flex-col">imagem</div> -->
          <div class="tw-flex tw-flex-col">
            <div class="q-file-image">
              <q-file outlined :model-value="form.imagem" @update:model-value="updateFile" accept=".jpg,.png">
                <template v-slot:before>
                  <div class="q-file-image-preview" :style="getImagePreviewStyle">
                    <img :src="srcImage || defaultImage" />
                  </div>
                </template>
              </q-file>
            </div>
          </div>
          <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-1 tw-m-2 tw-pb-16">
              <div class="tw-flex tw-flex-col tw-mr-4 tw-w-3/4">
                <InputLabel for="name" value="Nome Completo" required />
                <q-input @keypress="apenasLetras" maxlength="256" outlined id="name" v-model="form.name"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.name" />
              </div>
              <div class="tw-flex tw-flex-col tw-mr-4 tw-w-1/4">
                <InputLabel for="role" value="Perfil do Usuário" required />
                <q-select emit-value map-options outlined :options="opcoesPermissions" id="role" v-model="form.role"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.role" />
              </div>
            </div>
            <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-2 tw-m-2">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="email" value="Email" required />
                <q-input outlined id="email" maxlength="80" v-model="form.email"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.email" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="telefone" value="Telefone" required />
                <q-input outlined mask="(##) #####-####" id="telefone" v-model="form.telefone"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.telefone" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="data_nascimento" value="Data de Nascimento" required />
                <q-input outlined type="date" id="data_nascimento" v-model="form.data_nascimento"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.data_nascimento" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="cpf" value="CPF" required />
                <q-input outlined mask="###.###.###-##" id="cpf" v-model="form.cpf"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.cpf" />
              </div>
            </div>
          </div>
        </div>
        <div class="tw-flex tw-justify-end tw-gap-2">
          <Link :href="route('painel.gestao.usuarios')"
            class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
          CANCELAR
          </Link>
          <span @click="store()"
            class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
            <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" />
            SALVAR
          </span>
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
  roles: {
    type: Array,
    default: [],
  },
  permissions: {
    type: Array,
    default: [],
  }
});

const opcoesPermissions = props.roles.map(role => ({ label: role.name, value: role.id }))
const uploadUrl = ref("");
const destaque = ref("");

const form = useForm({
  name: "",
  cpf: "",
  email: "",
  telefone: "",
  role: [],
  data_nascimento: "",
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

function validateForm() {
  const fieldLabels = {
    name: 'Nome',
    cpf: 'Cpf',
    email: 'Email',
    telefone: 'Telefone',
    role: 'Perfil do Usuário',
    data_nascimento: 'Data de Nascimento',
  };

  const requiredFields = Object.keys(fieldLabels);

  requiredFields.forEach(field => {
    if (!form[field]) {
      form.errors[field] = `O campo ${fieldLabels[field]} é obrigatório`;
    } else {
      form.errors[field] = null;
    }
  });
}

function capitalizeFirstLetter(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function store() {

  validateForm()

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

const apenasLetras = (event) => {
  const charCode = event.keyCode || event.which;
  if (
    (charCode > 64 && charCode < 91) || 
    (charCode > 96 && charCode < 123) || 
    charCode === 32 || 
    (charCode > 191 && charCode <= 255) 
  ) {
    return true;
  } else {
    event.preventDefault();
    return false;
  }
};

</script>

<style>
.custom-uploader {
  max-width: 800px;
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
