import{_ as x}from"./AuthenticatedLayout-0a5f0791.js";import{I as v}from"./iconify-59ac6911.js";import{T as b,h as i,o as n,f as w,a,u as o,w as h,F as c,Z as y,b as t,d as k,p as V,N as d,c as N}from"./app-4ab3c1a7.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const q={class:"tw-flex tw-flex-1 tw-flex-col"},B={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll"},C={class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},j=t("h4",{class:"tw-font-title tw-font-semibold"},"Cadastrar Grupo",-1),G={class:"tw-antialiased tw-font-sans"},S={class:"tw-container tw-mx-auto"},E={class:"tw-py-8"},F={class:"-tw-mx-4 sm:-tw-mx-8 tw-px-4 sm:tw-px-8 tw-py-4 tw-overflow-x-auto"},I={class:"tw-inline-block tw-min-w-full tw-shadow tw-rounded-lg tw-overflow-hidden"},T={class:"tw-py-2 tw-px-1 tw-flex tw-flex-1 tw-justify-around"},U={class:"q-gutter-sm"},H={__name:"Novo",props:{permissions:{type:Array,default:[]}},setup(u){const m=u,e=b({id:"",name:"",permissions:[]});function p(){e.post(route("painel.gestao.grupos.store"),{preserveScroll:!0,onSuccess:l=>{e.reset(),showModal.value=!1,d.create({message:"Grupo registrado com sucesso.",color:"secondary"})},onError:l=>{d.create({message:"Não foi possível registrar o grupo.",color:"negative"})}})}return(l,s)=>{const f=i("q-input"),_=i("q-checkbox");return n(),w(c,null,[a(o(y),{title:"Grupos"}),a(x,null,{default:h(()=>[t("div",q,[t("div",B,[t("div",C,[j,t("span",{onClick:s[0]||(s[0]=r=>p()),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-gray-600 focus:tw-bg-gray-600 active:tw-bg-gray-600 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center"},[a(o(v),{icon:"fluent:save-16-regular",class:"tw-h-6 tw-w-6 tw-text-white tw-mr-2"}),k(" Salvar ")])]),t("div",G,[t("div",S,[t("div",E,[t("div",F,[t("div",I,[a(f,{outlined:"","stack-label":"",modelValue:o(e).name,"onUpdate:modelValue":s[1]||(s[1]=r=>o(e).name=r),label:"Nome","error-message":o(e).errors.name,error:!!o(e).errors.name},null,8,["modelValue","error-message","error"]),t("div",T,[t("div",U,[(n(!0),w(c,null,V(m.permissions,(r,$)=>(n(),N(_,{"indeterminate-value":!1,modelValue:o(e).permissions,"onUpdate:modelValue":s[2]||(s[2]=g=>o(e).permissions=g),val:r.name,label:r.name,color:"teal"},null,8,["modelValue","val","label"]))),256))])])])])])])])])])]),_:1})],64)}}};export{H as default};
