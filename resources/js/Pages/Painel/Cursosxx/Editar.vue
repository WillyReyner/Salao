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
    },
    curso: {
        type: Object,
        default: {}
    }
})

const form = useForm({
    id: props.curso.id,
    nome: props.curso.nome,
    situacao: props.curso.situacao,
    video_apresentacao: [],
    popularidade: props.curso.popularidade,
    avaliacao: props.curso.avaliacao,
    carga_horaria: props.curso.carga_horaria,
    faixa_etaria: props.curso.faixa_etaria,
    nivel: props.curso.nivel,
    imagem: [],
    conteudo: props.curso.conteudo,
    destaque: props.curso.destaque,
    eixo_tecnologico: props.curso.eixo_tecnologico,
    objetivos: props.curso.objetivos,
    conteudo_programatico: props.curso.conteudo_programatico,
    campo_atuacao: props.curso.campo_atuacao,
    resumo: props.curso.resumo,
    trilha_informativa: props.curso.trilha_informativa,
    curso_tecnico: props.curso.curso_tecnico,
    qualificacao: props.curso.qualificacao,
})


function update(){
    router.post(route('painel.cursos.update', form.id), {
        _method: 'patch',
        ...form
    }, {
        preserveScroll: true,
        onSuccess: (res) => {
            form.reset()
            Notify.create({
                message: "Dados do municipio atualizados com sucesso.",
                color: "secondary"
            })
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível atualizar os dados do municipio.",
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
                    <h4 class=" tw-font-title tw-font-semibold">Atualizar Curso</h4>
                    
                </div>

                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES SOBRE O CURSO</p>
                </div>


                <!-- Arquivos -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-row tw-flex-1 tw-gap-2 tw-items-start">
                        <div class="tw-flex tw-flex-col">
                            <q-file standout bg-color="blue" label-color="white" v-model="form.imagem" input-class="tw-text-gray-700 tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" label="Anexar Imagem"
                                >
                                <template v-slot:prepend>
                                    <Icon icon="ph:upload-light" class="tw-text-white"/>
                                </template>
                            </q-file>
                        </div>
                        <div class="tw-flex tw-flex-col tw-pt-4">
                            <p class="tw-text-base tw-text-gray-600">
                                {{ form.imagem.name }}
                            </p>
                        </div>
                        <p class="tw-text-base tw-text-gray-600">
                            <img v-if="props.curso.imagem" class="tw-h-20 tw-aspect-video tw-rounded-xl" :src="`/storage/${props.curso.imagem}`" />
                        </p>
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
                            <p class="tw-text-base tw-text-gray-600">
                                {{ form.video_apresentacao.name }}
                            </p>
                        </div>
                        <p class="tw-text-base tw-text-gray-600">
                            <img v-if="props.curso.video_apresentacao" class="tw-h-20 tw-aspect-video tw-rounded-xl" :src="`/storage/${props.curso.video_apresentacao}`" />
                        </p>
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
