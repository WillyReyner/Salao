

<template>
    <Head title="Turmas" />
    
    <AuthenticatedLayout>
    
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
                <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">{{ form.nome }}</h4>
                </div>

                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">INFORMAÇÕES BÁSICAS</p>
                </div>

                <!-- Arquivos
                <div class="tw-flex tw-flex-row tw-flex-1 tw-gap-2 tw-items-start">
                    <p class="tw-text-base tw-text-gray-600">
                        <img v-if="form.imagem" class="tw-h-40 tw-aspect-video tw-rounded-xl" :src="`/storage/${form.imagem}`" />
                    </p>
                </div> -->
                
                <!-- Nome da Turma, Curso e Vagas -->
                <div class="tw-flex tw-flex-row tw-mt-8 md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-auto tw-w-80 tw-flex-col">
                        <InputLabel for="curso_id" value="Edital Vinculado" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.edital.nome"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.curso_id" />
                    </div>

                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="vagas" value="Curso Vinculado" required/>
                        <input id="vagas" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.curso.nome"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.vagas" />
                    </div>
                </div>
                <!-- Tipo, Turno e Modalidade -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="categoria" value="Categoria" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.categoria"
                        />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="horas_curso" value="Carga Horária" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.horas_curso"
                        />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="modalidade" value="Modalidade" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.modalidade"
                        />
                    </div>
                </div>
    
                <!-- Horas Curso, Nivel, Faixa Etaria -->
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="nivel" value="Nivel" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.nivel"
                        />
                    </div>
    
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="faixa_etaria" value="Faixa Etária" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.faixa_etaria"
                        />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="vagas" value="Vagas" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.vagas"
                        />
                    </div> 
                </div>
    
                <!-- Resumo -->
                <div class="tw-flex tw-flex-col tw-gap-2 tw-m-2">
                    <InputLabel for="resumo" value="Resumo" required/>
                    <textarea v-model="form.resumo" rows="4" class="tw-mt-1 tw-text-gray-700  tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" disabled>
                    </textarea>
                </div>
    
                <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <p class="tw-font-semibold tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4">DATA E HORA</p>
                </div>
                <hr>
    
                <div class="tw-flex tw-flex-row tw-mt-8 md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2">
                    <div class="tw-flex tw-flex-auto tw-w-80 tw-flex-col">
                        <InputLabel for="dias_semana" value="Dias da Semana" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.dias_semana"
                        />
                    </div>
                    <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="turno" value="Turno" required/>
                        <input id="curso_id" type="text" disabled
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.turno"
                        />
                    </div>
                    <div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
                        <InputLabel for="hora_inicio" value="Hora de Início" required/>
                        <input
                        disabled
                            id="hora_inicio"
                            type="time"  
                            required
                            autofocus
                            autocomplete="hora_inicio"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.hora_inicio"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.hora_inicio" />
                    </div>
                    <div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
                        <InputLabel for="hora_termino" value="Hora de Termino" required/>
                        <input
                        disabled
                            id="hora_termino"
                            type="time" 
                            autofocus
                            autocomplete="hora_termino"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.hora_termino" 
                        />
                        <InputError class="tw-mt-2" :message="form.errors.hora_termino" />
                    </div>
                    <div class="tw-flex tw-flex-auto tw-w-0 tw-flex-col">
                        <InputLabel for="hora_termino" value="Hora de Termino" required/>
                        <input
                        disabled
                            id="data_inicio"
                            type="date" 
                            autofocus
                            autocomplete="data_inicio"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.data_inicio" 
                        />
                        <InputError class="tw-mt-2" :message="form.errors.data_inicio" />
                    </div>
                    <!-- <div class="tw-flex tw-flex-1 tw-flex-col">
                        <InputLabel for="data_inicio_inscricao" value="Precisão de Início" required/>
                        <input id="data_inicio_inscricao" type="date" required autofocus autocomplete="data_inicio_inscricao"
                            class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                            v-model="form.data_inicio_inscricao"
                        />
                        <InputError class="tw-mt-2" :message="form.errors.data_inicio_inscricao" />
                    </div>                    -->
                </div>
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.turmas')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                        VOLTAR
                    </Link>
                    <Link :href="route('painel.turmas.editar', form.id)" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center ">
                        <Icon icon="fluent:save-16-regular" class="tw-h-6 tw-w-6 tw-text-white tw-mr-2" /> 
                        EDITAR
                    </Link>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/Pages/InputError.vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';
import { Head, useForm, router, Link} from '@inertiajs/vue3';
import { Notify } from 'quasar';
import { Icon } from '@iconify/vue';

const props = defineProps({
    turma: {
        type: Object,
        default: {}
    }
})

const form = useForm({
    id: props.turma.id,
    nome: props.turma.nome,
    edital: props.turma.edital,
    curso: props.turma.curso,
    categoria: props.turma.categoria,
    nivel: props.turma.nivel,
    faixa_etaria: props.turma.faixa_etaria,
    turno: props.turma.turno,
    modalidade: props.turma.modalidade,
    horas_curso: props.turma.horas_curso,
    resumo: props.turma.resumo,
    vagas: props.turma.vagas,
    data_inicio: props.turma.data_inicio,
    dias_semana: props.turma.dias_semana,
    edital_id: props.turma.edital_id,
    curso_id: props.turma.curso_id,
    hora_inicio: props.turma.hora_inicio,
    hora_termino: props.turma.hora_termino,
})

</script>