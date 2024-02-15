<template>
  <Head title="Sistema de Seleção" />
  <SelecaoLayout>
    <!-- Modal de Filtros -->
    <q-dialog v-model="filtersModal">
      <q-card style="min-width: 40vw; max-width: 500px; border-radius: 20px; padding: 40px;">
        <q-card-section>
          <div class="tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold">Selecione as opções que deseja no filtro
            abaixo: </div>
        </q-card-section>
        <q-card-section class="q-p-none">
          <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4 tw-mb-4">
            <div class=" tw-flex tw-flex-1 tw-flex-col">
              <!-- Filtro de Categoria -->
              <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">CATEGORIA</h5>
              <div v-for="opcao in opcoesTipo"
                class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                <q-checkbox :val="opcao" v-model:model-value="filtroTipo" />
                {{ opcao }}
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col">
              <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4">MODALIDADE</h5>
              <!-- Filtro de Modalidade -->
              <div v-for="opcao in opcoesModalidade"
                class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                <q-checkbox :val="opcao" v-model:model-value="filtroModalidade" />
                {{ opcao }}
              </div>
            </div>
          </div>
          <div class="tw-flex tw-flex-1 tw-flex-row tw-gap-4">
            <div class=" tw-flex tw-flex-1 tw-flex-col">
              <h5 class="tw-font-title tw-text-base tw-font-semibold tw-text-primary">TURNO</h5>
              <!-- Filtro de Turno -->
              <div v-for="opcao in opcoesTurno"
                class="tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center">
                <q-checkbox :val="opcao" v-model:model-value="filtroTurno" />
                {{ opcao }}
              </div>
            </div>
          </div>
          <!-- Grupo de Botões -->
          <div class="tw-flex tw-flex-1 tw-flex-row tw-mt-10">
            <div class="tw-flex tw-flex-1">
              <button @click="clearFilters"
                class="tw-flex tw-px-8 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center">
                LIMPAR FILTROS
              </button>
            </div>
            <div class="tw-flex tw-flex-1 flex-row tw-gap-4">
              <button @click="closeModal"
                class="tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center">
                CANCELAR
              </button>
              <button @click="applyCursoFilter"
                class="tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center">
                APLICAR FILTROS
              </button>
            </div>
          </div>
        </q-card-section>
        <q-card-actions align="right">
          <!-- <q-btn label="Fechar" color="dark" v-close-popup /> -->
        </q-card-actions>
      </q-card>
    </q-dialog>
    <div
      class="tw-transition-all tw-max-w-[90vw] max-sm:tw-min-w-[80vw] tw-min-w-[40vw] tw-bg-white tw-rounded-lg tw-p-10 tw-pb-4 tw-overflow-x-hidden">
      <!-- Passo 1 -->
      <div v-if="estagio == 0" class="tw-justify-center tw-flex tw-flex-col tw-items-center tw-gap-5">
        <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5" />
        <h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">Olá, seja bem vindo</h5>
        <h6 class="tw-font-medium tw-font-subtitle tw-text-gray-900 tw-text-lg tw-leading-5">Seu futuro começa aqui</h6>
        <p
          class="lg:tw-max-w-[60vh] md:tw-max-w-[50vh] tw-text-center sm:tw-max-w-auto tw-font-subtitle tw-text-gray-900 tw-text-base tw-leading-5">
          Comece a sua jornada conosco e conquiste o seu sonho. Preencha seus dados básicos e dê o primeiro passo para uma
          nova etapa na sua vida.</p>
        <PrimaryButton @click="avancar" button-class="tw-text-white tw-bg-primary">VAMOS LÁ</PrimaryButton>
      </div>
      <div v-if="estagio > 0 && estagio <= 10"
        class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-justify-around tw-transition-all">
        <!-- Cabeçalho -->
        <div class="tw-flex tw-gap-5 tw-flex-col">
          <h4 class="tw-text-gray-800 tw-font-title tw-font-bold tw-leading-none tw-text-xl">{{ estagios[estagio].titulo
          }}</h4>
          <div class="tw-flex tw-justify-between">
            <h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">{{
              estagios[estagio].subtitulo }}</h5>
            <h5 class="tw-font-title tw-text-primary tw-font-semibold tw-text-base tw-leading-3">PASSO {{ estagio }} DE 10
            </h5>
          </div>
          <q-slider class="-tw-mt-4 tw-cursor-none" dense disable v-model="estagio" :min="0" :max="10" color="green"
            thumb-size="0px" track-size="6px" />
        </div>
        <!-- Modalidade -->
        <div v-if="estagio == 1" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <!-- Cards -->
          <div class="tw-flex tw-flex-1 tw-max-h-full">
            <div
              class="tw-grid tw-w-full tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-4 tw-gap-4 tw-px-2 tw-py-4 tw-max-w-full lg:tw-max-w-[60vw]">
              <Card v-if="modalidades.includes('Presencial')" @click="() => toogleModalidade('Presencial')"
                :selected="modalidadeSelecionada('Presencial')" icon="clarity:building-line" title="Presencial"
                description="O professor ensina em salas de aula e laboratórios, seguindo um cronograma previamente estabelecido" />
              <Card v-if="modalidades.includes('EAD')" @click="() => toogleModalidade('EAD')"
                :selected="modalidadeSelecionada('EAD')" icon="teenyicons:computer-outline" title="EAD"
                description="20% das aulas são presenciais, de acordo com a legislação. O restante é ensinado de forma online, dentro dos prazos estabelecidos" />
              <Card v-if="modalidades.includes('MOOC')" @click="() => toogleModalidade('MOOC')"
                :selected="modalidadeSelecionada('MOOC')" icon="teenyicons:computer-outline" title="MOOC"
                description="Os cursos MOOC são virtuais e automatizados, com inscrição e conclusão online, respeitando os prazos previstos" />
              <Card v-if="modalidades.includes('Online')" @click="() => toogleModalidade('Online')"
                :selected="modalidadeSelecionada('Online')" icon="typcn:video-outline" title="Online"
                description="Aprendizado é promovido através da plataforma virtual, usando computadores, smartphones ou tablets, com acesso à internet" />
            </div>
          </div>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-4 tw-justify-end tw-flex-col lg:tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-px-14 tw-self-center tw-bg-white tw-border-2 tw-border-primary tw-h-10">
                Voltar</PrimaryButton>
              <PrimaryButton @click="avancar" button-class="tw-text-white tw-px-14 tw-self-center tw-bg-primary tw-h-10">
                {{ modalidadesSelected.length ? 'AVANÇAR' : 'NÃO QUERO DEFINIR MODALIDADE' }}
              </PrimaryButton>
            </div>
          </div>
        </div>
        <!-- Local -->
        <div v-if="estagio == 2" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <div class="tw-flex tw-self-end tw-flex-row tw-mt-1 tw-h-10 tw-items-center tw-border tw-px-2 tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
            <Icon icon="majesticons:search-line" class="tw-h-6 tw-w-6 tw-text-gray-600" />
            <input id="buscaLocal" type="text" placeholder="Pesquise aqui" required autofocus autocomplete="busca"
              class="tw-appearance-none tw-border-none tw-w-full tw-text-gray-700 tw-h-9" v-model="filtroLocal" />
          </div>
          <div class="tw-flex tw-flex-1 tw-flex-col tw-min-w-[60vw] tw-overflow-hidden">
            <!-- Tabela de Locais -->
            <q-table flat wrap-cells hide-bottom v-model:rows="filteredEscolas" :columns="columnLocal" :visible-columns="visibleColumnsLocal"
              row-key="id" :filter="filtroLocal"
              no-data-label="Não foi possível localizar informações com o filtro inserido."
              no-results-label="Não foi possível localizar informações com o filtro inserido."
              rows-per-page-label="Registros por página" v-model:pagination="initialPagination"
              :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
              :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'" selection="single"
              v-model:selected="rowsSelectedLocal">
              <template v-slot:header="props">
                <q-tr :props="props" class="tw-h-20">
                  <q-td auto-width>
                    <q-checkbox dense v-model="props.selected" />
                  </q-td>
                  <q-th v-for="col in props.cols" :key="col.name" :props="props">
                    <span class="tw-font-title tw-text-gray-600 tw-text-lg">
                      {{ col.label }}
                    </span>
                  </q-th>
                </q-tr>
              </template>
              <template v-slot:body="props">
                <q-tr :props="props" no-hover :class="props.selected && 'tw-bg-green-100'"
                  class="roundful tw-overflow-hidden tw-rounded-lg hover:tw-bg-green-100 tw-h-20 tw-transition-colors">
                  <q-td auto-width>
                    <q-checkbox dense v-model="props.selected" />
                  </q-td>
                  <q-td v-for="col in props.cols" :key="col.name" :props="props">
                    <div v-if="col.name === 'actions'" class="tw-flex tw-flex-col tw-gap-2">
                      <button @click="() => { props.selected = !props.selected; avancar() }"
                        class="tw-flex flex-row tw-p-2 z-10 tw-justify-center tw-items-center">
                        <Icon icon="icons8:right-round" class="tw-h-10 tw-w-10 tw-text-primary" />
                      </button>
                    </div>
                    <div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
                      {{ col.value }}
                    </div>
                  </q-td>
                </q-tr>
              </template>
            </q-table>
          </div>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="avancar"
                button-class="tw-text-white tw-flex tw-bg-primary tw-h-10 tw-transition-all">
                {{ rowsSelectedLocal.length ? 'Avançar' : 'Não quero definir LOCAL' }}
              </PrimaryButton>
            </div>
          </div>
        </div>
        <!-- Cursos -->
        <div v-if="estagio == 3" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <div class="tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-items-center">
            <!-- Filtros Selecionados -->
            <div class="tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5">
              <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipTipo" @click="removeFilterTipo"
                color="green" text-color="green">
                Categoria
              </q-chip>
              <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipModalidade"
                @click="removeFilterModalidade" color="green" text-color="green">
                Modalidade
              </q-chip>
              <q-chip size="lg" :icon="evaCloseCircleOutline" outline clickable v-if="chipTurno"
                @click="removeFilterTurno" color="green" text-color="green">
                Turno
              </q-chip>
            </div>
            <!-- Filtrar, Exportar e Pesquisar -->
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5">
              <div class="tw-flex tw-flex-row tw-gap-5 tw-justify-end tw-items-center">
                <h5 @click="filtersModal = true"
                  class="tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2">
                  <Icon icon="ci:filter" class="tw-h-6 tw-w-6" />
                  Filtrar
                </h5>
              </div>
              <div
                class="tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm">
                <Icon icon="majesticons:search-line" class="tw-h-6 tw-w-6 tw-text-gray-600" />
                <input id="busca" type="text" placeholder="Pesquise aqui" required autofocus autocomplete="busca"
                  class="tw-appearance-none tw-border-none tw-w-full tw-text-gray-700" v-model="filtroCurso" />
              </div>
            </div>
          </div>
          <!-- Tabela de Locais -->
          <q-table flat wrap-cells hide-bottom v-model:rows="filteredTurmas" :columns="columnCurso" :visible-columns="visibleColumnsCurso"
            row-key="id" :filter="filtroCurso"
            no-data-label="Não foi possível localizar informações com o filtro inserido."
            no-results-label="Não foi possível localizar informações com o filtro inserido."
            rows-per-page-label="Registros por página" v-model:pagination="initialPagination"
            :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`"
            :selected-rows-label="(n) => n + ' registro(s) selecionado(s)'" selection="single"
            v-model:selected="rowsSelectedCursos">
            <template v-slot:header="props">
              <q-tr :props="props" class="tw-h-20">
                <q-td auto-width>
                  <q-td auto-width>
                    <q-checkbox dense v-model="props.selected" />
                  </q-td>
                </q-td>
                <q-th v-for="col in props.cols" :key="col.name" :props="props">
                  <span class="tw-font-title tw-text-gray-600 tw-text-lg">
                    {{ col.label }}
                  </span>
                </q-th>
              </q-tr>
            </template>
            <template v-slot:body="props">
              <q-tr :props="props" no-hover :class="props.selected && 'tw-bg-green-100'"
                class="tw-rounded-lg tw-overflow-hidden hover:tw-bg-green-100 tw-h-20 tw-transition-colors">
                <q-td auto-width>
                  <q-checkbox checked-icon="check_circle" @click="handleCursoSelecionado"
                    unchecked-icon="radio_button_unchecked" color="green" v-model="props.selected" />
                </q-td>
                <q-td v-for="col in props.cols" :key="col.name" :props="props">
                  <div v-if="col.name === 'edital'">
                    <a target="_blank"
                      :href="`https://efg.org.br/editais-detalhes?edital=${props.row.id}#tbodyCursosDisponibilizados`"
                      class="tw-cursor-pointer tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 active:tw-bg-opacity-90 tw-text-primary">
                      VER EDITAL
                    </a>
                  </div>
                  <div v-else class="tw-font-body tw-text-gray-800 tw-text-base">
                    {{ col.value }}
                  </div>
                </q-td>
              </q-tr>
            </template>
          </q-table>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton v-if="rowsSelectedCursos.length" @click="avancar"
                button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR</PrimaryButton>
              <PrimaryButton v-else button-class="tw-text-white tw-flex tw-bg-green-700 tw-h-10">SELECIONE UM CURSO
              </PrimaryButton>
            </div>
          </div>
        </div>
        <!-- Dados Pessoais -->
        <div v-if="estagio == 4" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <div class="tw-flex tw-flex-col">
            <p class="tw-text-xs tw-text-gray-600 tw-font-thin tw-leading-3">Os campos com <span
                class="tw-text-red-500">*</span> são obrigatórios.</p>
            <!-- Nome Completo e CPF -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="cpf" value="CPF" required />
                <q-input outlined mask="###.###.###-##" id="cpf" type="text" required autofocus autocomplete="cpf"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.cpf" :rules="cpfRules" :error="form.errors.cpf" />
                <InputError class="tw-mt-2" :message="form.errors.cpf" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="nome_completo" value="Nome Completo" required />
                <q-input outlined id="nome_completo" type="text" required autofocus autocomplete="nome_completo"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.nome_completo" />
                <InputError class="tw-mt-2" :message="form.errors.nome_completo" />
              </div>
            </div>
            <!-- Data de nascimento e Nome da mãe -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="data_nascimento" value="Data de Nascimento" required />
                <q-input outlined id="data_nascimento" type="date" required autofocus autocomplete="data_nascimento"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-text-gray-600 tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.data_nascimento" />
                <InputError class="tw-mt-2" :message="form.errors.data_nascimento" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="nome_mae" value="Nome da Mãe" required />
                <q-input outlined id="nome_mae" type="text" required autofocus autocomplete="nome_mae"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.nome_mae" />
                <InputError class="tw-mt-2" :message="form.errors.nome_mae" />
              </div>
            </div>
            <!-- Telefone e Tel. Alternativo -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="telefone" value="Telefone" required />
                <q-input outlined mask="(##) #####-####" id="telefone" type="text" required autofocus
                  autocomplete="telefone"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.telefone" />
                <InputError class="tw-mt-2" :message="form.errors.telefone" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="telefone_alternativo" value="Telefone Alternativo" />
                <q-input outlined mask="(##) #####-####" id="telefone_alternativo" type="text" required autofocus
                  autocomplete="telefone_alternativo"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.telefone_alternativo" />
                <InputError class="tw-mt-2" :message="form.errors.telefone_alternativo" />
              </div>
            </div>
            <!-- Email e Confirmação -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="email" value="E-mail" required />
                <q-input outlined id="email" type="text" required autofocus autocomplete="email"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.email" @blur="validateEmailFields" />
                <InputError class="tw-mt-2" :message="form.errors.email" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="email_confirmation" value="Confirmação de E-mail" required />
                <q-input outlined id="email_confirmation" type="text" required autofocus autocomplete="email_confirmation"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.email_confirmation" @blur="validateEmailFields" />
                <InputError class="tw-mt-2" :message="form.errors.email_confirmation" />
              </div>
            </div>
          </div>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR
              </PrimaryButton>
            </div>
          </div>
        </div>
        <!-- Endereço -->
        <div v-if="estagio == 5" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <div class="tw-flex tw-flex-col">
            <p class="tw-text-xs tw-text-gray-600 tw-font-thin tw-leading-3">Os campos com <span
                class="tw-text-red-500">*</span> são obrigatórios.</p>
            <!-- Cep -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="cep" value="CEP" required />
                <q-input outlined mask="#####-###" id="cep" type="text" required autofocus autocomplete="cep"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-full md:tw-w-[40%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.cep" @blur="buscarEnderecoPorCEP" />
                <InputError class="tw-mt-2" :message="form.errors.cep" />
                <br />
                <!-- <h5 class="tw-text-green-500 tw-text-sm tw-font-normal tw-font-body">Não sei meu cep</h5> -->
              </div>
            </div>
            <!-- Estado, Municipio e Bairro -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="estado" value="Estado" required />
                <q-select outlined :options="estados" v-model="form.estado" id="estado"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.estado" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="municipio" value="Municipio" required />
                <q-input outlined id="municipio" type="text" required autofocus autocomplete="municipio"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.municipio" />
                <InputError class="tw-mt-2" :message="form.errors.municipio" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="bairro" value="Bairro" required />
                <q-input outlined id="bairro" type="text" required autofocus autocomplete="bairro"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.bairro" />
                <InputError class="tw-mt-2" :message="form.errors.bairro" />
              </div>
            </div>
            <!-- Logradouro e Numero -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
                <InputLabel for="logradouro" value="Logradouro" required />
                <q-input outlined id="logradouro" type="text" required autofocus autocomplete="logradouro"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.logradouro" />
                <InputError class="tw-mt-2" :message="form.errors.logradouro" />
              </div>
              <div class="tw-flex flex-1 tw-w-full lg:tw-w-[31.5%] tw-flex-col">
                <InputLabel for="numero" value="Número" required />
                <q-input outlined id="numero" type="text" required autofocus autocomplete="numero"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full  tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.numero" />
                <InputError class="tw-mt-2" :message="form.errors.numero" />
              </div>
            </div>
            <!-- Complemento -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="complemento" value="Complemento" />
                <q-input outlined id="complemento" type="text" required autofocus autocomplete="complemento"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.complemento" />
                <InputError class="tw-mt-2" :message="form.errors.complemento" />
              </div>
            </div>
          </div>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR
              </PrimaryButton>
            </div>
          </div>
        </div>
        <!-- Dados Escolares -->
        <div v-if="estagio == 6" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <!-- Escolaridade e Origem -->
          <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
            <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
              <InputLabel for="escolaridade" value="Nível de Escolaridade" required class="tw-mb-2" />
              <div v-for="nivel, index of niveisEscolaridade" :key="index" class="tw-my-0.5">
                <input id="escolaridade" type="radio" v-model="form.escolaridade" :value="nivel" name="escolaridade"
                  class="tw-w-5 tw-h-5 tw-text-primary checked:tw-bg-primary tw-border-gray-300 tw-ring-0">
                <label for="escolaridade"
                  class="tw-ml-4 tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ nivel }}</label>
              </div>
              <InputError class="tw-mt-2" :message="form.errors.escolaridade" />
            </div>
            <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
              <InputLabel for="origem_escolar" value="Origem Escolar" required class="tw-mb-2" />
              <div v-for="tipo, index of tipoOrigemEscolar" :key="index" class="tw-my-0.5">
                <input id="origem_escolar" type="radio" v-model="form.origem_escolar" :value="tipo" name="origem"
                  class="tw-w-5 tw-h-5 tw-text-primary checked:tw-bg-primary tw-border-gray-300 tw-ring-0">
                <label for="origem_escolar"
                  class="tw-ml-4 tw-text-sm tw-font-medium tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ tipo
                  }}</label>
              </div>
              <InputError class="tw-mt-2" :message="form.errors.origem_escolar" />
            </div>
          </div>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR
              </PrimaryButton>
            </div>
          </div>
        </div>
        <!-- Dados Sociais -->
        <div v-if="estagio == 7" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <!-- Raça -->
          <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
            <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
              <InputLabel for="tiposRaca" value="Qual é a sua “cor ou raça/etnia”? (IBGE)" class="tw-mb-2" />
              <div
                v-for="tipo, index of ['Branca (Descendentes de europeus/ocidentais)', 'Preta (Descendentes de africanos/afro-brasileiros)', 'Parda (Descendentes de indivíduos de cor/etnias diferentes-miscigenação mestiçagem)', 'Cor Amarela (Descendentes de asiáticos/orientais)', 'Indígena (Descendentes de índios)', 'Outros']"
                :key="index" class="tw-my-0.5">
                <input id="tiposRaca" type="radio" v-model="form.raca" :value="tipo" name="tiposRaca"
                  class="tw-w-5 tw-h-5 tw-text-primary checked:tw-bg-primary tw-border-gray-300 tw-ring-0">
                <label for="tiposRaca" class="tw-ml-4 tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{
                  tipo
                }}</label>
              </div>
              <div v-if="form.raca == 'Outros'" class="tw-flex tw-flex-col tw-mt-2">
                <InputLabel for="outro_raca" value="Qual?" />
                <input id="outro_raca" type="text" autofocus autocomplete="outro_raca"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.outro_raca" />
                <InputError class="tw-mt-2" :message="form.errors.outro_raca" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
              <InputLabel for="tiposGenero" value="Qual é o seu “gênero”?" class="tw-mb-2" />
              <div v-for="tipo, index of ['Masculino', 'Ferminino', 'Outros']" :key="index" class="tw-my-0.5">
                <input id="tiposGenero" type="radio" v-model="form.genero" :value="tipo" name="tiposGenero"
                  class="tw-w-5 tw-h-5 tw-text-primary checked:tw-bg-primary tw-border-gray-300 tw-ring-0">
                <label for="tiposGenero" class="tw-ml-4 tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{
                  tipo
                }}</label>
              </div>
              <div v-if="form.genero == 'Outros'" class="tw-flex tw-flex-col tw-mt-2">
                <InputLabel for="outro_genero" value="Qual?" />
                <input id="outro_genero" type="text" autofocus autocomplete="outro_genero"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.outro_genero" />
                <InputError class="tw-mt-2" :message="form.errors.outro_genero" />
              </div>
            </div>
          </div>
          <!-- Programa Social e Deficiência -->
          <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
            <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
              <InputLabel for="possuiBeneficio" value="Você é beneficiário de algum programa social?" class="tw-mb-2" />
              <div v-for="opcao, index of ['Não', 'Sim']" :key="index" class="tw-my-0.5">
                <input id="programa_social" v-model="form.programa_social" type="radio" :value="opcao" name="programa_social"
                  class="tw-w-5 tw-h-5 tw-text-primary checked:tw-bg-primary tw-border-gray-300 tw-ring-0">
                <label for="programa_social"
                  class="tw-ml-4 tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ opcao }}</label>
              </div>
              <div v-if="form.programa_social == 'Sim'" class="tw-flex tw-flex-col tw-mt-2">
                <InputLabel for="form.programa_social" value="Quais programas você pertence?" />
                <input id="outro_programa_social" type="text" autofocus autocomplete="outro_programa_social"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.outro_programa_social" />
                <InputError class="tw-mt-2" :message="form.errors.outro_programa_social" />
                <InputLabel for="nis_pis" value="NIS/PIS (CadUnico)" class="tw-mt-2" />
                <input id="nis_pis" type="text" autofocus autocomplete="nis_pis"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.nis_pis" />
                <InputError class="tw-mt-2" :message="form.errors.nis_pis" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
              <InputLabel for="possuiDeficiencia" value="Você possui alguma deficiência?" class="tw-mb-2" />
              <div v-for="opcao, index of ['Não', 'Sim']" :key="index" class="tw-my-0.5">
                <input id="possuiDeficiencia" v-model="form.deficiencia" type="radio" :value="opcao"
                  name="possuiDeficiencia"
                  class="tw-w-5 tw-h-5 tw-text-primary checked:tw-bg-primary tw-border-gray-300 tw-ring-0">
                <label for="possuiDeficiencia"
                  class="tw-ml-4 tw-text-sm tw-font-medium tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ opcao
                  }}</label>
              </div>
              <div v-if="form.deficiencia == 'Sim'" class="tw-flex tw-flex-col tw-mt-2">
                <InputLabel for="outra_deficiencia" value="Qual(ais) sua(s) deficiência?" />
                <input id="outra_deficiencia" type="text" autofocus autocomplete="outra_deficiencia"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.outra_deficiencia" />
                <InputError class="tw-mt-2" :message="form.errors.outra_deficiencia" />
              </div>
            </div>
          </div>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR
              </PrimaryButton>
            </div>
          </div>
        </div>
        <!-- Como conheceu a EFG -->
        <div v-if="estagio == 8" class="tw-flex tw-flex-1 tw-flex-col tw-gap-4 tw-min-w-[60vw]">
          <!-- Como conheceu -->
          <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-col tw-gap-4 lg:tw-gap-2 tw-mt-4 tw-mb-2">
            <div class="tw-w-full tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-0.5">
              <div
                v-for="tipo, index of ['Google', 'Site da Escola do Futuro', 'Facebook ou Instagram', 'Whatsapp', 'Amigos/familiares', 'Na própria Escola do Futuro', 'Tv', 'Rádio', 'Pastor/padre/agente social ou outro líder da região onde moro', 'Outdoor', 'Carros de som', 'Outros']"
                :key="index" class="tw-my-0.5">
                <input id="tiposConheceu" v-model="form.como_conheceu" type="radio" :value="tipo" name="tiposConheceu"
                  class="tw-w-5 tw-h-5 tw-text-primary checked:tw-bg-primary tw-border-gray-300 tw-ring-0">
                <label for="tiposConheceu"
                  class="tw-ml-4 tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ tipo }}</label>
              </div>
            </div>
            <div v-if="form.como_conheceu == 'Outros'" class="tw-flex tw-flex-col tw-mt-2">
              <InputLabel for="outro_como_conheceu" value="Qual?" />
              <input id="outro_como_conheceu" type="text" autofocus autocomplete="outro_como_conheceu"
                class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                v-model="form.outro_como_conheceu" />
              <InputError class="tw-mt-2" :message="form.errors.outro_como_conheceu" />
            </div>
          </div>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR
              </PrimaryButton>
            </div>
          </div>
        </div>
        <div v-if="estagio === 9" class="tw-flex tw-flex-1 tw-flex-col tw-min-w-[40vw]">
          <div v-for="(item, index) in form.arquivos" :key="index" class="tw-pb-5">
            <div class="tw-flex md:tw-flex-row tw-flex-col">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <h5 class="tw-text-gray-600 tw-font-body tw-text-sm tw-mb-1">{{ item.nome }}</h5>
                <q-file outlined rounded bg-color="white" label-color="green" v-model="form.arquivos[index].arquivo"
                  accept="application/pdf"
                  input-class="tw-text-primary tw-block tw-self-start focus:tw-border-primary focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  label="Anexar Comprovante">
                  <template v-slot:prepend>
                    <Icon icon="majesticons:file-line" class="tw-text-green-700" />
                  </template>
                  <template v-slot:append>
                    <div class="tw-ml-auto">
                      <Icon icon="material-symbols-light:quick-reference-all-outline" class="tw-text-green-700"
                        @click="openFileModal(form.arquivos[index].arquivo)" />
                    </div>
                  </template>
                </q-file>
              </div>
            </div>
          </div>
          <q-dialog v-model="fileModalVisible" full-width>
            <q-card class="column full-height" style="width: 300px">
              <q-card-section style="width: 100%; height: 93%">
                <iframe :src="fileToView" style="width: 100%; height: 100%; border: none"></iframe>
              </q-card-section>
              <q-card-actions align="right">
                <q-btn label="Fechar" color="primary" @click="closeFileModal" />
              </q-card-actions>
            </q-card>
          </q-dialog>
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row tw-mt-2">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="avancar" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR
              </PrimaryButton>
            </div>
          </div>
        </div>
        <div v-if="estagio == 10" class="tw-flex tw-flex-1 tw-flex-col tw-min-w-[50vw]" style="overflow-y: auto;">
          <div class="tw-flex tw-flex-col tw-bg-green-50 tw-p-4 tw-rounded " style="overflow-y: auto;">
            <div class="tw-flex">
              <p class="tw-grid tw-grid-cols-8 tw-gap-7 tw-text-ls tw-font-bold tw-text-gray-600">DADOS PESSOAIS</p>
              <div class="tw-flex"><Icon icon="basil:edit-outline" width="30" height="30" class="tw-text-green-700"
                @click="irDadosPessoais(4)" value="EDITAR" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="cpf" value="CPF" />
                <q-input disable mask="###.###.###-##" id="cpf" type="text" autofocus autocomplete="cpf"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.cpf" :rules="cpfRules" :error="form.errors.cpf" />
                <InputError class="tw-mt-2" :message="form.errors.cpf" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="nome_completo" value="Nome Completo" />
                <q-input disable id="nome_completo" type="text" autofocus autocomplete="nome_completo"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.nome_completo" />
                <InputError class="tw-mt-2" :message="form.errors.nome_completo" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="data_nascimento" value="Data de Nascimento" />
                <q-input disable id="data_nascimento" type="date" autofocus autocomplete="data_nascimento"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-text-gray-600 tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.data_nascimento" />
                <InputError class="tw-mt-2" :message="form.errors.data_nascimento" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="nome_mae" value="Nome da Mãe" />
                <q-input disable id="nome_mae" type="text" autofocus autocomplete="nome_mae"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.nome_mae" />
                <InputError class="tw-mt-2" :message="form.errors.nome_mae" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="telefone" value="Telefone" />
                <q-input disable mask="(##) #####-####" id="telefone" type="text" autofocus autocomplete="telefone"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.telefone" />
                <InputError class="tw-mt-2" :message="form.errors.telefone" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="telefone_alternativo" value="Telefone Alternativo" />
                <q-input disable mask="(##) #####-####" id="telefone_alternativo" type="text" autofocus
                  autocomplete="telefone_alternativo"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.telefone_alternativo" />
                <InputError class="tw-mt-2" :message="form.errors.telefone_alternativo" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="email" value="E-mail" />
                <q-input disable id="email" type="text" required autofocus autocomplete="email"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.email" @blur="validateEmailFields" />
                <InputError class="tw-mt-2" :message="form.errors.email" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="email_confirmation" value="Confirmação de E-mail" />
                <q-input disable id="email_confirmation" type="text" autofocus autocomplete="email_confirmation"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.email_confirmation" @blur="validateEmailFields" />
                <InputError class="tw-mt-2" :message="form.errors.email_confirmation" />
              </div>
            </div>
          </div>
          <br />
          <div class="tw-flex tw-flex-col tw-bg-green-50 tw-p-4 tw-rounded">
            <p class="tw-text-ls tw-font-bold tw-text-gray-600">Endereço</p>
            <!-- Cep -->
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="cep" value="CEP" />
                <q-input disable mask="#####-###" id="cep" type="text" autofocus autocomplete="cep"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-full md:tw-w-[40%] tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.cep" @blur="buscarEnderecoPorCEP" />
                <InputError class="tw-mt-2" :message="form.errors.cep" />
                <br />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="estado" value="Estado" />
                <q-select disable :options="estados" v-model="form.estado" id="estado"
                  class="tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm" />
                <InputError class="tw-mt-2" :message="form.errors.estado" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="municipio" value="Municipio" />
                <q-input disable id="municipio" type="text" autofocus autocomplete="municipio"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.municipio" />
                <InputError class="tw-mt-2" :message="form.errors.municipio" />
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="bairro" value="Bairro" />
                <q-input disable id="bairro" type="text" autofocus autocomplete="bairro"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.bairro" />
                <InputError class="tw-mt-2" :message="form.errors.bairro" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4">
              <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
                <InputLabel for="logradouro" value="Logradouro" />
                <q-input disable id="logradouro" type="text" autofocus autocomplete="logradouro"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.logradouro" />
                <InputError class="tw-mt-2" :message="form.errors.logradouro" />
              </div>
              <div class="tw-flex flex-1 tw-w-full lg:tw-w-[31.5%] tw-flex-col">
                <InputLabel for="numero" value="Número" />
                <q-input disable id="numero" type="text" autofocus autocomplete="numero"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full  tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.numero" />
                <InputError class="tw-mt-2" :message="form.errors.numero" />
              </div>
            </div>
            <div class="tw-flex tw-flex-1 tw-flex-col lg:tw-flex-row tw-gap-4 lg:tw-gap-8 tw-mt-4 tw-mb-4">
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="complemento" value="Complemento" />
                <q-input disable id="complemento" type="text" autofocus autocomplete="complemento"
                  class="tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"
                  v-model="form.complemento" />
                <InputError class="tw-mt-2" :message="form.errors.complemento" />
              </div>
            </div>
          </div>
          <br>
          <div class="tw-grid tw-grid-cols-3 tw-gap-6">
            <div class="tw-flex-col tw-bg-green-50 tw-p-4 tw-rounded">
              <div class="tw-flex">
                <p class="tw-grid tw-grid-cols-2 tw-gap-12 tw-text-ls tw-font-bold tw-text-gray-600">DADOS ESCOLARES</p>
                <div class="tw-flex"><Icon icon="basil:edit-outline" width="30" height="30" class="tw-text-green-700"
                  @click="irDadosPessoais(6)" value="EDITAR" />
                </div>
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="origem_escolar" value="Origem Escolar" class="tw-mb-2" />
                <div v-for="tipo, index of tipoOrigemEscolar" :key="index">
                  <label v-if="form.origem_escolar === tipo" for="origem_escolar"
                    class="tw-text-sm tw-font-medium tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ tipo
                    }}</label>
                </div>
                <InputError class="tw-mt-2" :message="form.errors.origem_escolar" />
              </div>
              <div class="tw-flex tw-flex-1 tw-span tw-flex-col">
                <InputLabel for="escolaridade" value="Nível de Escolaridade" class="tw-mb-2" />
                <div v-for="nivel, index of niveisEscolaridade" :key="index">
                  <label v-if="form.escolaridade === nivel" for="escolaridade"
                    class="tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ nivel }}</label>
                </div>
                <InputError class="tw-mt-2" :message="form.errors.escolaridade" />
              </div>
            </div>
            <div class="tw-flex-col tw-bg-green-50 tw-p-4 tw-rounded">
              <div class="tw-flex">
                <p class="tw-grid tw-grid-cols-3 tw-gap-1 tw-text-ls tw-font-bold tw-text-gray-600">DADOS SOCIAIS</p>
                <div class="tw-flex"><Icon icon="basil:edit-outline" width="30" height="30" class="tw-text-green-700"
                  @click="irDadosPessoais(7)" value="EDITAR" />
                </div>
              </div>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="possuiBeneficio" value="Você é beneficiário de algum programa social?" />
                <div v-for="opcao, index of ['Não', 'Sim']" :key="index" class="tw-pb-1">
                  <label v-if="possuiBeneficio === opcao" for="possuiBeneficio"
                    class="tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ form.programa_social }}</label>
                </div>
              </div>
              <div v-if="form.programa_social == 'Sim'">
                <InputLabel v-if="form.programa_social === 'Sim'" for="programa_social" value="Qual?" />
                <q-input disable borderless id="programa_social" type="text" autofocus autocomplete="programa_social"
                  v-model="form.outro_programa_social" />
              </div>
              <div v-if="form.programa_social == 'Sim'">
                <InputLabel v-if="form.programa_social === 'Sim'" for="nis_pis" value="Qual?" />
                <q-input borderless disable id="nis_pis" type="text" autofocus autocomplete="nis_pis"
                  v-model="form.nis_pis" />
              </div>
              <hr/><br/>
              <div class="tw-flex tw-flex-1 tw-flex-col">
                <InputLabel for="possuiDeficiencia" value="Você possui alguma deficiência?" />
                <div v-for="opcao, index of ['Não', 'Sim']" :key="index" class="tw-pb-1">
                  <label v-if="possuiDeficiencia === opcao" for="possuiDeficiencia"
                    class="tw-text-sm tw-font-medium tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ form.deficiencia
                    }}</label>
                </div>
              </div>
              <div v-if="form.deficiencia == 'Sim'" class="tw-flex tw-flex-col">
                <InputLabel v-if="form.deficiencia == 'Sim'" for="outra_deficiencia" value="Qual?" />
                <q-input borderless disable id="outra_deficiencia" type="text" autofocus autocomplete="outra_deficiencia"
                  v-model="form.outra_deficiencia" />
                <InputError class="tw-mt-2" :message="form.errors.deficiencia" />
              </div>
            </div>
            <div class="tw-flex tw-flex-col tw-bg-green-50 tw-p-4 tw-rounded">
              <div class="tw-flex">
                <p class="tw-grid tw-grid-cols-2 tw-text-ls tw-font-bold tw-text-gray-600">COMO CONHECEU A EFG</p>
                <div class="tw-flex"><Icon icon="basil:edit-outline" width="30" height="30" class="tw-text-green-700"
                  @click="irDadosPessoais(8)" value="EDITAR" />
                </div>
              </div>
              <div class="tw-w-full tw-grid tw-grid-cols-1 lg:tw-grid-cols-2 tw-gap-0.5">
                <InputLabel for="tiposConheceu" value="Como conheceu a EFG?" />
                <div v-for="tipo, index of ['Google', 'Site da Escola do Futuro', 'Facebook ou Instagram', 'Whatsapp', 'Amigos/familiares', 'Na própria Escola do Futuro', 'Tv', 'Rádio', 'Pastor/padre/agente social ou outro líder da região onde moro', 'Outdoor', 'Carros de som', 'Outros']" :key="index">
                  <label v-if="tiposConheceu === tipo" for="tiposConheceu" class="tw-text-sm tw-font-body tw-text-gray-500 dark:tw-text-gray-300">{{ form.como_conheceu }}</label>
                </div>
              </div>
              <div v-if="form.como_conheceu == 'Outros'" class="tw-flex tw-flex-col">
                <InputLabel v-if="form.como_conheceu == 'Outros'" for="como_conheceu" value="Como?" />
                <q-input borderless disable id="como_conheceu" type="text" autofocus autocomplete="como_conheceu"
                  v-model="form.outro_como_conheceu" />
                <InputError class="tw-mt-2" :message="form.errors.como_conheceu" />
              </div>
            </div>
          </div>
          <br>
          <!-- Rodapé -->
          <div class="tw-flex tw-flex-1 tw-items-center tw-flex-col lg:tw-flex-row">
            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5 tw-mx-10 lg:tw-mx-0 lg:tw-mr-10" />
            <div class="tw-flex tw-flex-1 tw-gap-2 tw-justify-end tw-flex-row">
              <PrimaryButton @click="voltar"
                button-class="tw-text-primary tw-flex tw-bg-white tw-border-2 tw-border-primary tw-h-10">VOLTAR
              </PrimaryButton>
              <PrimaryButton @click="store" button-class="tw-text-white tw-flex tw-bg-primary tw-h-10">AVANÇAR
              </PrimaryButton>
            </div>
          </div>
        </div>
      </div>
      <!-- Confirmado -->
      <div v-if="estagio == 11" class="tw-flex tw-flex-1 tw-flex-col tw-gap-6 tw-text-center tw-justify-center ">
        <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5" />
        <h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">
          Inscrição realizada com sucesso!
        </h5>
        <h6 class="tw-font-medium tw-font-subtitle tw-text-gray-900 tw-text-lg tw-leading-6 tw-mb-4">
          Você receberá um e-mail de confirmação no e-mail cadastrado. <br /> Os próximos passos serão orientados
          via
          e-mail.
        </h6>
        <a href="https://efg.org.br/"
          class="tw-px-14 tw-inline tw-self-center tw-py-2 tw-rounded-xl tw-font-title tw-text-base tw-text-center tw-uppercase hover:tw-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-primary focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-border-2 tw-border-primary">a
          Voltar ao Site</a>
      </div>
    </div>
  </SelecaoLayout>
</template>
<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import SelecaoLayout from '@/Layouts/SelecaoLayout.vue';
import PrimaryButton from "@/Components/Pages/PrimaryButton.vue";
import { ref } from "vue";
import Card from "@/Components/Selecao/Card.vue";
import { Icon } from "@iconify/vue";
import { computed } from "vue";
import InputLabel from "@/Components/Pages/InputLabel.vue";
import InputError from "@/Components/Pages/InputError.vue";
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Notify } from 'quasar';
import axios from 'axios';
const props = defineProps({
  escolas: {
    type: Array,
    default: [],
  },
  turmas: {
    type: Array,
    default: [],
  },
  modalidade_turma: {
    type: Array,
    default: []
  },
  editais: {
    type: Array,
    default: []
  }
})
const modalidades = props.modalidade_turma.map(turma => turma.modalidade);
const estagios = [
  { titulo: '', subtitulo: '' }, //Home
  { titulo: 'Selecione uma ou mais modalidades de ensino que mais se adequa a sua necessidade', subtitulo: 'Modalidade' },
  { titulo: 'Selecione o local que deseja estudar', subtitulo: 'Local' },
  { titulo: 'Selecione o curso que deseja estudar', subtitulo: 'Cursos' },
  { titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Pessoais' },
  { titulo: 'Formulário de Inscrição ', subtitulo: 'Endereço' },
  { titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Escolares' },
  { titulo: 'Formulário de Inscrição ', subtitulo: 'Dados Sociais' },
  { titulo: 'Formulário de Inscrição ', subtitulo: 'Como conheceu a EFG' },
  { titulo: 'Formulário de Inscrição ', subtitulo: 'Comprovantes' },
  { titulo: 'Formulário de Inscrição ', subtitulo: 'Antes de finalizar sua inscrição, confira seus dados até o final.' },
]
const fileModalVisible = ref(false);
const fileToView = ref("");
const openFileModal = (file) => {
  if (file && file.type === "application/pdf") {
    fileToView.value = URL.createObjectURL(file);
    fileModalVisible.value = true;
  }
};
const closeFileModal = () => {
  fileToView.value = "";
  fileModalVisible.value = false;
};
const filtersModal = ref(false)
const deleteModal = ref(false)
const estagio = ref(0)
const nome = ref('')
const curso = ref('')
const unidade = ref('')
const cpf = ref('')
const email = ref('')
const busca = ref('')
const initialPagination = ref({
  sortBy: 'desc',
  descending: false,
  page: 1,
  rowsPerPage: 10
})
const rowsSelectedLocal = ref([])
const rowsSelectedCursos = ref([])
// Local
const filtroLocal = ref('')
const filteredEscolas = ref(props.escolas)
// Cursos
const filtroCurso = ref('')
const filtroTipo = ref([])
const filtroEscola = ref([])
const filtroModalidade = ref([])
const filtroTurno = ref([])
const filteredTurmas = ref(props.turmas)
const chipTipo = computed(() => filtroTipo.value.length > 0)
const chipEscola = computed(() => filtroEscola.value.length > 0)
const chipModalidade = computed(() => filtroModalidade.value.length > 0)
const chipTurno = computed(() => filtroTurno.value.length > 0)
// Social
const possuiDeficiencia = ref('Não')
const possuiBeneficio = ref('Não')
const tiposGenero = ref('')
const tiposRaca = ref('')
const tiposConheceu = ref('')
const dateFormatOptions = {
  year: "numeric", month: "numeric", day: "numeric"
}
function closeModal() {
  filtersModal.value = false
}
const modalidadesSelected = ref([])
const estados = [
  'AC - Acre',
  'AL - Alagoas',
  'AP - Amapá',
  'AM - Amazonas',
  'BA - Bahia',
  'CE - Ceará',
  'DF - Distrito Federal',
  'ES - Espírito Santo',
  'GO - Goías',
  'MA - Maranhão',
  'MT - Mato Grosso',
  'MS - Mato Grosso do Sul',
  'MG - Minas Gerais',
  'PA - Pará',
  'PB - Paraíba',
  'PR - Paraná',
  'PE - Pernambuco',
  'PI - Piauí',
  'RJ - Rio de Janeiro',
  'RN - Rio Grande do Norte',
  'RS - Rio Grande do Sul',
  'RO - Rondônia',
  'RR - Roraíma',
  'SC - Santa Catarina',
  'SP - São Paulo',
  'SE - Sergipe',
  'TO - Tocantins'
];
const niveisEscolaridade = [
  'Fundamental Incompleto',
  'Fundamental Completo',
  'Médio Incompleto',
  'Médio Completo',
  'Superior Incompleto',
  'Superior Completo',
]
const tipoOrigemEscolar = [
  'Ensino Público',
  'Ensino Privado'
]
const opcoesTipo = ['Capacitação', 'Qualificação', 'Técnico']
const opcoesTurno = ['EAD', 'Integral', 'Matutino', 'Vespertino', 'Noturno']
const opcoesModalidade = ['MOOC', 'EAD', 'Online', 'Presencial'];
const opcoesSituacao = ['Ativo', 'Inativo'];

const columnLocal = [
  { name: 'id', field: 'id', label: 'ID' },
  { name: 'municipio', align: 'left', label: 'MUNICÍPIO', field: 'municipio', format: item => item.nome, sortable: true },
  { name: 'nome', align: 'left', label: 'EFG/UDEPI', field: 'nome', sortable: true },
  { name: 'turmas', align: 'left', label: 'TURMAS DISPONÍVEIS', align: 'center', field: 'turmas', format: item => item.length, sortable: true },
  { name: 'actions', label: '', align: 'center', field: 'id' },
]

const visibleColumnsLocal = [
  'municipio', 'nome', 'turmas', 'actions'
]
const columnCurso = [
  { name: 'id', field: 'id', label: 'ID' },
  { name: 'curso', align: 'left', label: 'CURSO', field: 'curso', format: item => item.nome, sortable: true },
  { name: 'escola', align: 'left', label: 'ESCOLA', field: 'edital', format: item => item.escola.nome, sortable: true },
  { name: 'tipo', align: 'left', label: 'CATEGORIA', field: 'curso', format: item => item.categoria, sortable: true },
  { name: 'modalidade', align: 'left', label: 'MODALIDADE', field: 'modalidade', sortable: true },
  { name: 'turno', align: 'left', label: 'TURNO', field: 'turno', sortable: true },
  { name: 'vagas', align: 'center', label: 'VAGAS', field: 'vagas', sortable: true },
  { name: 'edital', align: 'left', label: 'EDITAL', field: 'edital', format: item => item.documentos[0], sortable: true },
]
const visibleColumnsCurso = [
  'curso', 'escola', 'tipo', 'modalidade', 'turno', 'vagas', 'edital'
]
const estagioId = ref('')
function irDadosPessoais(estagioId) {
  estagio.value = estagioId
}
function avancar() {
  applyCursoFilter()
  estagio.value = estagio.value + 1
}
function voltar() {
  estagio.value = estagio.value - 1
}
function modalidadeSelecionada(modalidade) {
  return modalidadesSelected.value.includes(modalidade)
}
function toogleModalidade(mod) {
  if (modalidadesSelected.value.includes(mod))
    modalidadesSelected.value = modalidadesSelected.value.filter(m => m != mod)
  else
    modalidadesSelected.value.push(mod)
    applyCursoFilter()
}

function applyCursoFilter() {
  const filtradoTipo = modalidadesSelected.value.length > 0 ? props.turmas.filter(turma => modalidadesSelected.value.includes(turma.modalidade)) : props.turmas;
  const filtradoEscola = filtroEscola.value.length > 0 ? filtradoTipo.filter(turma => filtroEscola.value.includes(turma.edital.escola_id.id)) : props.escolas;
  const filtradoTurno = filtroTurno.value.length > 0 ? filtradoEscola.filter(turma => filtroTurno.value.includes(turma.turno)) : props.turmas;
  const filtradoLocal = rowsSelectedLocal.value.length > 0 ? filtradoTurno.filter(turma => rowsSelectedLocal.value.filter(local => turma.edital.escola_id == local.id).length > 0) : filtradoTurno;

  filteredEscolas.value = modalidadesSelected.value.length > 0 ? props.escolas.filter(escola => escola.turmas.filter(turma => modalidadeSelecionada(turma.modalidade)).length > 0) : props.escolas

  filteredTurmas.value = filtradoTipo;
  filtersModal.value = false;
}
function removeFilterTipo() {
  filtroTipo.value = []
  applyCursoFilter()
}
function removeFilterEscola() {
  filtroEscola.value = []
  applyCursoFilter()
}
function removeFilterModalidade() {
  filtroModalidade.value = []
  applyCursoFilter()
}
function removeFilterTurno() {
  filtroTurno.value = []
  applyCursoFilter()
}
function clearFilters() {
  filtroEscola.value = []
  filtroTipo.value = []
  filtroModalidade.value = []
  filtroTurno.value = []
  filtroCurso.value = ''
}
const validateEmail = (email) => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
};
const validateEmailFields = () => {
  const isEmailValid = validateEmail(form.email);
  const isConfirmationValid = validateEmail(form.email_confirmation);
  if (!isEmailValid) {
    form.errors.email = 'Por favor, insira um e-mail válido.';
  } else {
    form.errors.email = '';
  }
  if (!isConfirmationValid) {
    form.errors.email_confirmation = 'Por favor, insira um e-mail de confirmação válido.';
  } else {
    form.errors.email_confirmation = '';
  }
};

const form = useForm({
  nome_completo: '',
  cpf: '',
  data_nascimento: '',
  nome_mae: '',
  telefone: '',
  telefone_alternativo: '',
  data_nascimento: '',
  email: '',
  email_confirmation: '',
  cep: '',
  estado: '',
  municipio: '',
  bairro: '',
  logradouro: '',
  numero: '',
  complemento: '',
  escolaridade: '',
  origem_escolar: '',
  raca: '',
  outro_raca: '',
  genero: '',
  outro_genero: '',
  programa_social: '',
  outro_programa_social: '',
  nis_pis: '',
  deficiencia: '',
  outra_deficiencia: '',
  como_conheceu: '',
  outro_como_conheceu: '',
  arquivos: [],
  rede: 'EFG',
  turma_id: ''
});

function handleCursoSelecionado() {
  const arquivosString = rowsSelectedCursos.value[0]?.edital?.documentos_inscricao || '';
  const nomesDeArquivos = arquivosString.split(',');
  const arquivos = nomesDeArquivos.map(nome => ({ nome: nome.trim(), arquivo: null })); form.arquivos = arquivos;
}

function store() {
  const arquivosSelecionados = form.arquivos.filter(item => item.arquivo);
  if (arquivosSelecionados.length === 0) {
    Notify.create({
      message: "Nenhum arquivo selecionado.",
      color: "negative"
    });
    return;
  }

  form.turma_id = rowsSelectedCursos.value[0].id;
  form.arquivos = arquivosSelecionados;
  form.post(route('inscricao.store'), {
    preserveScroll: true,
    forceFormData: true,
    onSuccess: (res) => {
      nome.value = form.nome_completo;
      curso.value = rowsSelectedCursos.value[0].nome;
      unidade.value = form.nome_completo;
      cpf.value = form.cpf;
      email.value = form.email;
      form.reset();
      Notify.create({
        message: "Inscrição realizada com sucesso.",
        color: "secondary"
      });
      estagio.value = 11;
    },
    onError: (err) => {
      Notify.create({
        message: "Não foi possível realizar a sua inscrição. Verifique suas informações.",
        color: "negative"
      });
      estagio.value = 9; // Redireciona de volta à etapa 9 em caso de erro
    }
  });
}
async function buscarEnderecoPorCEP() {
  const cep = form.cep.replace(/\D/g, ''); // Remove caracteres não numéricos do CEP
  if (cep.length === 8) {
    try {
      const response = await axios.get(`https://viacep.com.br/ws/${cep}/json/`);
      const data = response.data;
      if (!data.erro) {
        form.estado = data.uf;
        form.municipio = data.localidade;
        form.bairro = data.bairro;
        form.logradouro = data.logradouro;
        form.numero = '';
        form.complemento = '';
      } else {
        console.error('CEP não encontrado ou inválido.');
      }
    } catch (error) {
      console.error('Erro ao buscar o CEP:', error);
    }
  }
}
function isCPF(cpf) {
  cpf = cpf.replace(/\D/g, '');
  if (cpf.toString().length != 11 || /^(\d)\1{10}$/.test(cpf)) return false;
  var result = true;
  [9, 10].forEach(function (j) {
    var soma = 0, r;
    cpf.split(/(?=)/).splice(0, j).forEach(function (e, i) {
      soma += parseInt(e) * ((j + 2) - (i + 1));
    });
    r = soma % 11;
    r = (r < 2) ? 0 : 11 - r;
    if (r != cpf.substring(j, j + 1)) result = false;
  });
  return result;
}
const cpfRules = [
  (v) => !!v || 'CPF é obrigatório',
  (v) => isCPF(v) || 'CPF inválido',
];
</script>