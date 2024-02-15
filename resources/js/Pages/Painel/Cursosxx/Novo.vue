<script setup>
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, router, Link} from '@inertiajs/vue3';
import { Notify} from 'quasar';
import { onMounted } from 'vue';
import { ref } from 'vue';


const props = defineProps({
    turmas: {
        type: Array,
        default: []
    }
})

const form = useForm({
    nome: '',
    situacao: '',
    video_apresentacao: [],
    popularidade: '',
    avaliacao: '',
    carga_horaria: '',
    faixa_etaria: '',
    nivel: '',
    imagem: [],
    conteudo: '',
    destaque: '',
    eixo_tecnologico: '',
    objetivos: '',
    conteudo_programatico: '',
    campo_atuacao: '',
    resumo: '',
    trilha_informativa: '',
    curso_tecnico: '',
    qualificacao: '',
})


function store(){
    
    form.post(route('painel.cursos.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Curso registrado com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            console.log(err)
            Notify.create({
                message: "Não foi possível registrar o Curso.",
                color: "negative"
            })
        }
    })
}

const opcoesSituacao = ['Ativo', 'Inativo', 'Bloqueado']

</script>

<template>
    <Head title="Cursos" />
    
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">Adicionar Curso</h4>
                    
                </div>

                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES SOBRE O CURSO</p>
                </div>


                <!-- Arquivos -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-row tw-flex-1 tw-gap-2">
                        <div class="tw-flex tw-flex-col">
                            <q-file standout bg-color="blue" label-color="white" v-model="form.imagem" input-class="tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" label="Anexar Imagem"
                                >
                                <template v-slot:prepend>
                                    <Icon icon="ph:upload-light" class="tw-text-white"/>
                                </template>
                            </q-file>
                        </div>
                        <div class="tw-flex tw-flex-col tw-pt-4">
                            <p class="tw-text-base tw-text-gray-600">{{ form.imagem.name }}</p>
                        </div>
                    </div>
                    <div class="tw-flex tw-flex-row tw-flex-1 tw-gap-2">
                        <div class="tw-flex tw-flex-col">
                            <q-file standout bg-color="blue" label-color="white" v-model="form.video_apresentacao"  input-class="tw-text-gray-700 tw-block tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" label="Anexar Video"
                                >
                                <template v-slot:prepend>
                                    <Icon icon="ph:upload-light" class="tw-text-white"/>
                                </template>
                            </q-file>
                        </div>
                        <div class="tw-flex tw-flex-col tw-pt-4">
                            <p class="tw-text-base tw-text-gray-600">{{ form.video_apresentacao.name }}</p>
                        </div>
                    </div>
                    <div class="tw-flex tw-flex-row tw-flex-1"></div>
                </div>
                
                <!-- Nome, Situação e Destaque -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">

                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nome" value="Nome do Curso" required/>
                        <input id="nome" type="text" 
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.nome"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.nome" />
                    </div>
                    
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="situacao" value="Situação" required/>
                        <select
                            v-model="form.situacao" id="situacao" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="opcao in opcoesSituacao" :value="opcao">{{ opcao }}</option>
                           
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.situacao" />
                    </div>

                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="destaque" value="Destaque" required/>
                        <select
                            v-model="form.destaque" id="situacao" 
                            class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        >
                            <option v-for="turma in props.turmas" :value="turma.id">{{ turma.nome }}</option>
                           
                        </select>
                        <InputError class="tw-mt-2" :message="form.errors.destaque" />
                    </div>
                    
                </div>

                <!-- Resumo -->
                <div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
                    <InputLabel for="resumo" value="Resumo" required/>
                    <textarea v-model="form.resumo" rows="4" class="tw-mt-1 tw-text-gray-700  tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                    </textarea>
                </div>

                <!-- Conteúdo -->
                <div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
                    <InputLabel for="conteudo" value="Conteúdo" required/>
                    <textarea v-model="form.conteudo" rows="4" class="tw-mt-1 tw-text-gray-700  tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                    </textarea>
                </div>

                <!-- Trilha Informativa, Curso Técnico e Qualificação -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="trilha" value="Trilha Formativa" required/>
                        <input id="trilha" type="text" 
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.trilha_informativa"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.trilha_informativa" />
                    </div>

                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="curso_tecnico" value="Curso Técnico" required/>
                        <input id="curso_tecnico" type="text" 
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.curso_tecnico"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.curso_tecnico" />
                    </div>
                    
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="qualificacao" value="Qualificação" required/>
                        <input id="qualificacao" type="text" 
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.qualificacao"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.qualificacao" />
                    </div>
                
                </div>

                <!-- Eixo Tecnologico e Faixa Etaria -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="eixo_tecnologico" value="Eixo Tecnologico" required/>
                        <input id="eixo_tecnologico" type="text" 
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.eixo_tecnologico"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.eixo_tecnologico" />
                    </div>

                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="faixa_etaria" value="Para quem se destina" required/>
                        <input id="faixa_etaria" type="text" 
                        class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                        v-model="form.faixa_etaria"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.faixa_etaria" />
                    </div>
                </div>
                
                <!-- Objetivos -->
                <div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
                    <InputLabel for="objetivos" value="Objetivos" required/>
                    <textarea v-model="form.objetivos" rows="4" class="tw-mt-1 tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                    </textarea>
                </div>

                <!-- Conteúdo Programático -->
                <div class="tw-flex  tw-flex-col tw-gap-2 tw-m-2">
                    <InputLabel for="conteudo_programatico" value="Conteúdo Programático" required/>
                    <textarea v-model="form.conteudo_programatico" rows="4" class="tw-mt-1 tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                    </textarea>
                </div>

                <!-- Campo de Atuação -->
                <div class="tw-flex  tw-flex-col tw-gap-2 tw-m-2 tw-mb-10">
                    <InputLabel for="campo_atuacao" value="Campo de Atuação" required/>
                    <textarea v-model="form.campo_atuacao" rows="4" class="tw-mt-1 tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                    </textarea>
                </div>

                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.cursos')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                        CANCELAR
                    </Link>
                    <span @click="store()" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
                        <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" /> 
                        Salvar
                    </span>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
