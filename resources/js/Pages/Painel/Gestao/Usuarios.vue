<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import Table from '@/Components/Pages/TableUsuarios.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    usuarios: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <Head title="Usuários" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">Usuários</h2>
        </template>

        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8 tw-space-y-6">
                <div class="tw-p-4 sm:tw-p-8 tw-bg-white tw-shadow sm:tw-rounded-lg">
                    <h5 class="tw-flex tw-flex-row tw-justify-between">Usuários do Sistema<PrimaryButton class="tw-text-white">NOVO</PrimaryButton></h5>
                    <Table :usuarios="props.usuarios"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
