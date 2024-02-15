<template>
    <Head title="Areas" />
    <AuthenticatedLayout>
	    <div class="tw-flex tw-flex-1 tw-flex-col">
		    <div class="tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll">
			    <q-card>
				    <q-card-section>
						aqui
				    </q-card-section>
			    </q-card>
		    </div>
	    </div>
    </AuthenticatedLayout>
</template>
<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { evaCloseCircleOutline } from "@quasar/extras/eva-icons"
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Dialog, Notify } from 'quasar'
import { Icon } from '@iconify/vue';
import { computed } from 'vue';
import InputLabel from '@/Components/Pages/InputLabel.vue';

const props = defineProps({
    areas: {
        type: Array,
        default: [],
    },
    user: {
        type: Object,
        default: {},
    }
});

const permissions = props.user.permissions

const hasPermission = (permission) => {
    return permissions.some(userPermission => userPermission === permission);
};

const form = useForm({
    id: [],
    nome: '',
    created_at: '',
})

const filtersModal = ref(false)
const deleteModal = ref(false)

const busca = ref('')
const initialPagination = ref({
    sortBy: 'desc',
    descending: false,
    page: 1,
    rowsPerPage: 10
})

const rowsSelected = ref([])

const dateFormatOptions = {
    year: "numeric", month: "numeric", day: "numeric"
}

function closeModal() {
    filtersModal.value = false
}


const columns = [
    { name: 'id', field: 'id', label: 'ID' },
    { name: 'nome', align: 'left', label: 'TIPO DE ARQUIVO', field: 'nome', sortable: true },
    { name: 'created_at', field: 'created_at', required: true, label: 'DATA DA CRIAÇÃO', format: val => `${new Date(val).toLocaleString('pt-BR', dateFormatOptions)}`, align: 'left', sortable: true },
    { name: 'situacao', field: 'situacao', required: true, label: 'STATUS', align: 'left', sortable: true },
    { name: 'actions', label: 'AÇÕES', align: 'center', field: 'id' },
]

const visibleColumns = [
    'id', 'nome', 'created_at', 'situacao', 'actions'
]


const filtroID = ref('')
const filtroNome = ref('')
const filtroCriacao = ref('')
const filteredAreas = ref(props.areas)

const chipID = computed(() => filtroID.value != '')
const chipNome = computed(() => filtroNome.value != '')
const chipCriacao = computed(() => filtroCriacao.value != '')



function applyFilters() {
    const filtradoCriacao = filtroCriacao.value != '' ? props.tiposArquivo.filter(tipo => tipo.created_at.split('T')[0] == filtroCriacao.value) : props.tiposArquivo
    const filtradoID = filtroID.value != '' ? filtradoCriacao.filter(tipo => tipo.id == filtroID.value) : filtradoCriacao
    const filtradoNome = filtroNome.value != '' ? filtradoID.filter(tipo => tipo.nome.toLowerCase().includes(filtroNome.value.toLowerCase())) : filtradoID
    filteredAreas.value = filtradoNome
    filtersModal.value = false
}

function removeFilterCriacao() {
    filtroCriacao.value = ''
    applyFilters()
}
function removeFilterID() {
    filtroID.value = ''
    applyFilters()
}
function removeFilterNome() {
    filtroNome.value = ''
    applyFilters()
}

function clearFilters() {
    filtroCriacao.value = ''
    filtroID.value = ''
    filtroNome.value = ''
}

function removeItem(item) {
    form.id = item.id || rowsSelected.value.map(row => row.id)

    form.delete(route('painel.areas.destroy'), {
        preserveScroll: true,
        onSuccess: (res) => {
            Notify.create({
                message: "Tipo(s) de Arquivo(s) removido(s) com sucesso.",
                color: "secondary"
            })
            window.location.href = '/areas';
            applyFilters()
        },
        onError: (err) => {
            Notify.create({
                message: "Não foi possível remover esse(s) Tipo(s) de Arquivo(s).",
                color: "negative"
            })
        }
    })

    deleteModal.value = false

}

function confirmRemoving(data) {
    rowsSelected.value = [data]
    deleteModal.value = true
}

const exportToCSV = () => {

    if (rowsSelected.value.length === 0) {
        const columns = [
            'ID',
            'NOME DAS TAGS',
            'SITUACAO'
        ];
        const data = filteredAreas.value.map((role) => [
            role.id,
            `"${role.nome}"`,
            role.situacao
        ]);
        const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'AreasExport.csv');
        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }

    else {
        const columns = [
            'ID',
            'NOME DAS TAGS',
            'SITUACAO'
        ];

        const data = rowsSelected.value.map((role) => [
            role.id,
            `"${role.nome}"`,
            role.situacao
        ]);

        const csvContent = `${columns.join(',')}\n${data.map((row) => row.join(',')).join('\n')}`;
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const url = window.URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.setAttribute('href', url);
        link.setAttribute('download', 'AreasExport.csv');
        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);
        window.URL.revokeObjectURL(url);
    }
};
</script>

<style>
.q-table__sort-icon {
    opacity: .5;
}

.q-btn {
    box-shadow: none;
    text-shadow: none;
}

.q-btn__content {
    color: black;
    font-size: 1.5rem;
}

.q-btn__content>.q-icon {
    font-size: 1.5rem;
    display: block;
}

.q-checkbox__bg {
    background-color: white;
    border-color: rgb(148, 148, 148);
    padding: 1px;
    border-radius: 6px;
    border-width: 1px;
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative !important;
}

.q-checkbox__inner--truthy .q-checkbox__bg {
    background-color: rgb(0, 218, 0);
}

.q-checkbox__bg>svg {
    display: flex;
    position: relative;
    width: 70% !important;
    height: 70% !important;
}

.q-chip {
    background-color: rgba(164, 255, 164, 0.418) !important;
    font-family: 'Open Sans';
    color: rgb(0, 255, 0);
    border: none;
}

/*
.q-chip--colored .q-chip__icon{
    color: none !important;
} */
</style>