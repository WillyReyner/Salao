<template>
    <div>
        <Head title="Dashboard" />
        <q-dialog v-model="boasVindas">
            <div class="tw-px-20 tw-p-[25px] tw-flex-col tw-bg-white tw-rounded-2xl tw-justify-center tw-items-center tw-shadow-md">
                <div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden tw-justify-center tw-text-center tw-gap-4">
                    <h2 class="tw-font-body tw-font-bold tw-text-xl tw-text-primary">
                        Bem vindo(a), {{ page.props.auth.user.name }}, à Escola do Futuro de Goiás
                    </h2>
                    <h5 class="tw-font-body tw-font-normal tw-text-base tw-text-gray-500">
                        Esta plataforma é dedicada aos alunos da Escola do Futuro de Goiás. Aqui, você terá acesso a
                        informações sobre os cursos disponíveis, em andamento, novos cursos, certificados e outras
                        funcionalidades.
                    </h5>
                    <h5 class="tw-font-body tw-font-normal tw-text-base tw-text-gray-500">
                        Você já deu o primeiro passo rumo ao aprendizado e agora pode escolher um curso disponível para se
                        qualificar no mercado de trabalho.
                    </h5>
                    <h3 class="tw-font-body tw-font-bold tw-text-base tw-text-gray-700">
                        Antes disso, precisamos de algumas informações adicionais sobre você. Vamos começar?
                    </h3>
                    <div
                        class="tw-flex tw-flex-1 tw-flex-col tw-justify-center tw-items-center tw-gap-4 lg:tw-flex-row tw-pt-5">
                        <span @click="boasVindas = false"
                            class="tw-cursor-pointer tw-max-h-[50px] tw-items-center tw-flex-1 tw-p-3 tw-text-green-600 tw-text-base tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                            FECHAR
                        </span>
                        <PrimaryButton @click="nextMorph"
                            class="tw-max-h-[50px] tw-flex-1 tw-items-center tw-bg-green-600 tw-py-3 tw-text-white tw-justify-center">
                            VAMOS LÁ
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </q-dialog>
        <AuthenticatedLayout :props="page.props.auth.user">
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '6%' : '8%', left: isLargeScreen ? '87%' : '84%' }" >
                <q-card v-morph:card1:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-left-radius: 2em">
                    <q-card-section class="text-h6">
                        Área de Configurações
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '6%' : '8%', left: isLargeScreen ? '85%' : '82%' }">
                <q-card v-morph:card2:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-left-radius: 2em">
                    <q-card-section class="text-h6">
                        Área de Informações do Usuário
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '6%' : '8%', left: isLargeScreen ? '82%' : '78%' } ">
                <q-card v-morph:card3:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-left-radius: 2em">
                    <q-card-section class="text-h6">
                        Acesso as informações do Sistema
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '6%' : '8%', left: isLargeScreen ? '78%' : '74%' }">
                <q-card v-morph:card4:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-left-radius: 2em">
                    <q-card-section class="text-h6">
                        Notificações
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '16%' : '20%', left: isLargeScreen ? '9%' : '11%' }">
                <q-card v-morph:card5:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-right-radius: 2em">
                    <q-card-section class="text-h6">
                        Acesso a Dashboard do Sistema
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '27%' : '34%', left: isLargeScreen ? '9%' : '11%' }">
                <q-card v-morph:card6:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-right-radius: 2em">
                    <q-card-section class="text-h6">
                        Acesso a Dashboard dos Editais
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '33%' : '42%', left: isLargeScreen ? '9%' : '11%' }">
                <q-card v-morph:card7:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-right-radius: 2em">
                    <q-card-section class="text-h6">
                        Acesso a Dashboard das Inscrições
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '44%' : '57%', left: isLargeScreen ? '9%' : '11%' }">
                <q-card v-morph:card8:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-right-radius: 2em">
                    <q-card-section class="text-h6">
                        Acesso a Dashboard de Cursos
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '49%' : '63%', left: isLargeScreen ? '9%' : '11%' }">
                <q-card v-morph:card9:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="border-bottom-left-radius: 2em; border-bottom-right-radius: 2em; border-top-right-radius: 2em">
                    <q-card-section class="text-h6">
                        Acesso a Dashboard de Turmas
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Próximo" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-absolute" :style="{ top: isLargeScreen ? '60%' : '60%', left: isLargeScreen ? '8%' : '13%' }">
                <q-card v-morph:card10:mygroup:500.resize="morphGroupModel" class="tw-absolute tw-bg-primary text-white"
                    style="width: 300px;">
                    <q-card-section class="text-h6">
                        Obrigado por Escolher esse Tour, ficamos muito agradecidos por sua presença, Qualquer dúvida chamar
                        nosso suporte.
                    </q-card-section>
                    <q-card-actions align="right">
                        <q-btn flat label="Fechar" @click="nextMorph" />
                    </q-card-actions>
                </q-card>
            </div>
            <div class="tw-flex tw-flex-1 tw-p-6 tw-flex-col tw-bg-white tw-rounded-lg tw-h-[100%] tw-justify-center tw-items-center tw-shadow-md">
                 <div class="tw-grid tw-grid-cols-12 tw-overflow-hidden tw-justify-center tw-text-center">
                    <div class="tw-col-span-12 md:tw-col-span-6 lg:tw-col-span-12 tw-overflow-hidden tw-justify-center tw-items-center tw-text-center">
                        <h2 class="tw-font-title tw-font-bold tw-text-4xl tw-text-gray-700">
                            Olá, {{ page.props.auth.user.name }}. Seja bem vindo(a)!
                        </h2>
                        <h5 class="tw-font-body tw-font-normal tw-text-2xl tw-text-gray-500">
                            Acesse as nossas funcionalidades pelo menu lateral.
                        </h5>
		                    <img class="tw-w-auto tw-fill-current tw-object-contain tw-border tw-border-red-500" src="./../../../imgs/img-dashboard.png" alt="Content">
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const page = usePage();
const boasVindas = ref(false);

const foiMostradoDialogoBoasVindas = sessionStorage.getItem('dialogoBoasVindasMostrado');
if (!foiMostradoDialogoBoasVindas) {
    boasVindas.value = true;
    sessionStorage.setItem('dialogoBoasVindasMostrado', 'true');
}

const nextMorphStep = {
    btn: 'card1',
    card1: 'card2',
    card2: 'card3',
    card3: 'card4',
    card4: 'card5',
    card5: 'card6',
    card6: 'card7',
    card7: 'card8',
    card8: 'card9',
    card9: 'card10',
    card10: 'btn',
}

const morphGroupModel = ref('btn')

const nextMorph = () => {
    morphGroupModel.value = nextMorphStep[morphGroupModel.value]
    boasVindas.value = false
};

const isLargeScreen = ref(window.innerWidth > 1700);

const setCardPosition = () => {
    isLargeScreen.value = window.innerWidth > 1700;
};

onMounted(() => {
    window.addEventListener('resize', setCardPosition);
});
</script>


