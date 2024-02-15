import{_ as p}from"./InputError-8e97e87c.js";import{_ as g}from"./InputLabel-e21345d2.js";import{_ as x}from"./AuthenticatedLayout-0a5f0791.js";import{I as _}from"./iconify-59ac6911.js";import{T as b,h,o as y,f as v,a as s,u as a,w as l,F as N,Z as O,b as t,j as V,d,O as j,N as c}from"./app-4ab3c1a7.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const q={class:"tw-flex tw-flex-1 tw-flex-col"},F={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4"},S=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},[t("h4",{class:"tw-font-title tw-font-semibold"},"Atualizar Permissões")],-1),k=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},[t("p",{class:"tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"},"INFORMAÇÕES BÁSICAS")],-1),E={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4"},$={class:"tw-flex tw-flex-1 tw-flex-col"},A={class:"tw-flex tw-justify-end tw-gap-2"},D={__name:"Editar",props:{permissoes:{type:Object,default:{}}},setup(m){const i=m,e=b({id:i.permissoes.id,name:i.permissoes.name});function f(){const o={name:"Nome da Permissão"};Object.keys(o).forEach(r=>{e[r]?e.errors[r]=null:e.errors[r]=`O campo ${o[r]} é obrigatório`})}function u(){f(),j.post(route("painel.gestao.permissoes.update",e.id),{_method:"patch",...e},{preserveScroll:!0,onSuccess:o=>{e.reset(),c.create({message:"Dados da permissão foram atualizados com sucesso.",color:"secondary"})},onError:o=>{c.create({message:"Não foi possível atualizar os dados da permissão.",color:"negative"})}})}return(o,w)=>{const r=h("q-input");return y(),v(N,null,[s(a(O),{title:"Permissões"}),s(x,null,{default:l(()=>[t("div",q,[t("div",F,[S,k,t("div",E,[t("div",$,[s(g,{for:"name",value:"Nome",required:""}),s(r,{outlined:"",id:"name",required:"",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm",modelValue:a(e).name,"onUpdate:modelValue":w[0]||(w[0]=n=>a(e).name=n)},null,8,["modelValue"]),s(p,{class:"tw-mt-2",message:a(e).errors.name},null,8,["message"])])]),t("div",A,[s(a(V),{href:o.route("painel.gestao.permissoes"),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center"},{default:l(()=>[d(" VOLTAR ")]),_:1},8,["href"]),t("span",{onClick:w[1]||(w[1]=n=>u()),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center"},[s(a(_),{icon:"fluent:save-16-regular",class:"tw-h-6 tw-w-6 tw-text-white tw-mr-2"}),d(" Salvar ")])])])])]),_:1})],64)}}};export{D as default};
