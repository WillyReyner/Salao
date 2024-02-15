<script setup>
import Sidebar from '@/Components/Painel/Sidebar.vue';
import Topbar from '@/Components/Painel/Topbar.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const user = page.props.auth.user;
</script>

<template>
    <div>
        <div class="tw-min-h-screen tw-bg-gray-100 tw-flex tw-flex-1 tw-flex-row tw-max-w-screen">
            <Sidebar :user="user"/>
            <main class="tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden">
                <Topbar :user="user" />
                <div class="md:tw-flex tw-flex-1 tw-flex-row tw-p-2  tw-max-h-[calc(100vh-25px)] tw-overflow-x-hidden tw-overflow-y-scroll">
                    <slot :user="user"/>
                </div>
            </main>
        </div>
    </div>
</template>
<style>

[type='text']:focus,
[type='email']:focus,
[type='url']:focus,
[type='password']:focus,
[type='number']:focus,
[type='date']:focus,
[type='datetime-local']:focus,
[type='month']:focus,
[type='search']:focus,
[type='tel']:focus,
[type='time']:focus,
[type='week']:focus,
[multiple]:focus,
textarea:focus,
select:focus {
    --tw-ring-shadow: 0;
}

.tw-important {
    /* Suas regras de estilo aqui */
    font-size: 10px !important; /* Exemplo de estilo importante */
}

::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    border-radius: 10px;
    background: rgba(243, 243, 243, 0.1);
}

::-webkit-scrollbar-thumb {
    border-radius: 10px;
    background: rgba(0, 0, 0, 0.2);
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.4);
}

::-webkit-scrollbar-thumb:active {
    background: rgba(0, 0, 0, 0.9);
}</style>