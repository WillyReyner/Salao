<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/Pages/ApplicationLogo.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    canVerifyEmail:{
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Bem-vindo" />

    <div class="tw-relative tw-text-2xl sm:tw-flex sm:tw-justify-center sm:tw-items-center tw-min-h-screen tw-text-dark tw-bg-center tw-bg-white" >
        <div v-if="canLogin" class="sm:tw-fixed sm:tw-top-0 sm:tw-right-0 tw-p-12 tw-text-right">
            <Link v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="tw-font-semibold tw-text-dark hover:tw-text-gray-500 focus:tw-outline focus:tw-outline-2 focus:tw-rounded-sm"
                >Dashboard</Link>
            <template v-else>
                <Link :href="route('login')"
                    class="tw-font-semibold tw-text-dark hover:tw-text-gray-500 focus:tw-outline focus:tw-outline-2 focus:tw-rounded-sm">Entrar</Link>
                <Link v-if="canRegister" :href="route('register')" class="tw-ml-4 tw-font-semibold tw-text-dark hover:tw-text-gray-500 focus:tw-outline focus:tw-outline-2 focus:tw-rounded-sm">Registre-se</Link>
            </template>
        </div>
        <div class="tw-max-w-7xl tw-mx-auto tw-p-6 lg:tw-p-8">
            <div class="tw-flex tw-justify-center">
                <ApplicationLogo class="tw-w-full tw-h-20" />
            </div>
        </div>
    </div>
</template>
