<script setup>
import PrimaryButton from '@/Components/Pages/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    permissoes: {
        type: Array,
        default: [],
    },
});
</script>

<template>
    <Head title="Permissões" />
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="tw-font-semibold tw-text-xl tw-text-gray-800 tw-leading-tight">
                Permissões
            </h2>
        </template>
        <div class="tw-py-12">
            <div class="tw-max-w-7xl tw-mx-auto sm:tw-px-6 lg:tw-px-8 tw-space-y-6">
                <div class="tw-p-4 sm:tw-p-8 tw-bg-white tw-shadow sm:tw-rounded-lg">
                    <h5 class="tw-flex tw-flex-1 tw-justify-between">Permissões do Sistema</h5>
                    <div class="tw-antialiased tw-font-sans">
                        <div class="tw-container tw-mx-auto">
                            <div class="tw-py-8">
                                <div class="-tw-mx-4 sm:-tw-mx-8 tw-px-4 sm:tw-px-8 tw-py-4 tw-overflow-x-auto">
                                    <div class="tw-inline-block tw-min-w-full tw-shadow tw-rounded-lg tw-overflow-hidden">
                                        <q-list dense bordered padding class="rounded-borders">
                                            <q-item clickable v-ripple v-for="permission, index of props.permissoes" :key="index">
                                                <q-item-section>
                                                    {{ permission.name }}
                                                </q-item-section>
                                            </q-item>
                                        </q-list>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
