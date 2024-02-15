<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router, Link} from '@inertiajs/vue3';
import { Notify, Dialog } from 'quasar';
import { formatDate } from '@/Utils/Formats.js'
import { ref } from 'vue'
import { Icon } from '@iconify/vue'
import InputLabel from '@/Components/Pages/InputLabel.vue';

const props = defineProps({
    tipoArquivo: {
        type: Object,
        default: {}
    },
    logs: {
        type: Object,
        default: []
    }
})

const logColumns = [
    { name: 'date', align: 'center', label: 'Data e Horário', field: 'created_at', sortable: true },
    { name: 'user', align: 'center', label: 'Usuário', field: 'causer', sortable: true },
    { name: 'event', align: 'center', label: 'Ação', field: 'event', sortable: true },
    { name: 'properties', align: 'left', label: 'Descrição', field: 'properties', sortable: false },
]

const logLabels = {
    nome: "Nome",
}

const actionLabels = {
    created: "Criação",
    updated: "Edição",
    deleted: "Exclusão",
};

const initialPagination = ref({
    sortBy: 'desc',
    descending: false,
    page: 1,
    rowsPerPage: 10
})

</script>

<template>
    <Head title="Municípios" />
    <AuthenticatedLayout>
        <div class="tw-flex tw-flex-1 tw-flex-col">
            <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4">
                <div class="tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200">
                    <h4 class=" tw-font-title tw-font-semibold">Histórico do tipo de arquivo {{ tipoArquivo.nome }}</h4>
                </div>
                <div class="tw-antialiased tw-font-body">
                    <div class="tw-py-4 tw-overflow-x-auto">
                        <div class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
                            <q-table
                                flat
                                :columns="logColumns"
                                :rows="logs"
                                row-key="id"
                                no-data-label="Sem dados de log"
                                rows-per-page-label="Registros por página"
                                v-model:pagination="initialPagination"
                                :pagination-label="(first, end, total) => `${first} à ${end} de ${total} registros`">
                                <template v-slot:header="props">
                                    <q-tr :props="props" class="tw-h-20">
                                        <q-th v-for="col in props.cols"
                                            :key="col.name"
                                            :props="props" >
                                            <span class="tw-font-title tw-text-gray-600 tw-text-lg">
                                                {{ col.label }}
                                            </span>
                                        </q-th>
                                    </q-tr>
                                </template>
                                <template v-slot:body="props">
                                    <q-tr :props="props" no-hover class="roundful tw-overflow-hidden tw-rounded-lg hover:tw-bg-green-100 tw-h-20 tw-transition-colors">
                                        <q-td v-for="col in props.cols"
                                            :key="col.name"
                                            :props="props">{{ col.name }}
                                            <div v-if="col.name =='date'">{{ formatDate(props.row.created_at) }}</div>
                                            <div v-else-if="col.name == 'user'">{{ props.row.causer?.name ?? 'Sistema' }}</div>
                                            <div v-else-if="col.name == 'event'">{{ actionLabels[props.row.event] || 'Outra ação' }}</div>
                                            <div v-else-if="col.name == 'properties'">
                                                <div v-for="(value, key) in props.row.properties.attributes">
                                                    <div v-if="key != 'created_by' && key != 'updated_by'">
                                                        {{ logLabels[key] || key }}: {{ value }}
                                                    </div>
                                                </div>
                                            </div>
                                        </q-td>
                                    </q-tr>
                                </template>
                            </q-table>
                        </div>
                    </div>
                </div>
                <div class="tw-flex tw-justify-end tw-gap-2">
                    <Link :href="route('painel.documento')" class="tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center ">
                        VOLTAR
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
