import{_ as d}from"./AuthenticatedLayout-0a5f0791.js";import{_ as u}from"./InputError-8e97e87c.js";import{_ as p}from"./InputLabel-e21345d2.js";import{T as g,h as x,o as _,f as b,a as s,u as w,w as n,F as y,Z as h,b as t,j as v,d as l,N as c}from"./app-4ab3c1a7.js";import{I as N}from"./iconify-59ac6911.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const q={class:"tw-flex tw-flex-1 tw-flex-col"},C={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4"},F=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},[t("h4",{class:"tw-font-title tw-font-semibold"},"Adicionar Permissão")],-1),S=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},[t("p",{class:"tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"},"INFORMAÇÕES BÁSICAS")],-1),V={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4"},j={class:"tw-flex tw-flex-1 tw-flex-col"},k={class:"tw-flex tw-justify-end tw-gap-2"},T={__name:"Novo",setup(A){const e=g({name:""});function m(){const o={name:"Nome da Permissão"};Object.keys(o).forEach(r=>{e[r]?e.errors[r]=null:e.errors[r]=`O campo ${o[r]} é obrigatório`})}function f(){m(),e.post(route("painel.gestao.permissoes.store"),{preserveScroll:!0,onSuccess:o=>{e.reset(),c.create({message:"Permissão registrada com sucesso.",color:"secondary"})},onError:o=>{console.log(o),c.create({message:"Não foi possível registrar a Permissão.",color:"negative"})}})}return(o,a)=>{const r=x("q-input");return _(),b(y,null,[s(w(h),{title:"Permissões"}),s(d,null,{default:n(()=>[t("div",q,[t("div",C,[F,S,t("div",V,[t("div",j,[s(p,{for:"name",value:"Nome",required:""}),s(r,{id:"name",outlined:"",required:"",autofocus:"",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm",modelValue:w(e).name,"onUpdate:modelValue":a[0]||(a[0]=i=>w(e).name=i)},null,8,["modelValue"]),s(u,{class:"tw-mt-2",message:w(e).errors.name},null,8,["message"])])]),t("div",k,[s(w(v),{href:o.route("painel.gestao.permissoes"),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center"},{default:n(()=>[l(" CANCELAR ")]),_:1},8,["href"]),t("span",{onClick:a[1]||(a[1]=i=>f()),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center"},[s(w(N),{icon:"fluent:save-16-regular",class:"tw-h-6 tw-w-6 tw-text-white tw-mr-2"}),l(" Salvar ")])])])])]),_:1})],64)}}};export{T as default};
