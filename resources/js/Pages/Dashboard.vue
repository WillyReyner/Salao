<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>
    <Head title="Inicio" />

    <AuthenticatedLayout>
        <div class="tw-py-12">
            <div class="tw-mx-auto sm:tw-px-6 lg:tw-px-8 tw-overflow-y-scroll tw-w-auto">
                <div class="tw-overflow-hidden">
                    <img src="./../../imgs/logo-efg.png" alt="Content">
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
