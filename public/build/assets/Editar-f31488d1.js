import{T as m,o as p,f as g,a as r,u as a,w as n,F as x,Z as b,b as t,i as _,v,j as y,d as l,O as h,N as d}from"./app-4ab3c1a7.js";import{_ as T}from"./InputError-8e97e87c.js";import{_ as N}from"./InputLabel-e21345d2.js";import{_ as O}from"./AuthenticatedLayout-0a5f0791.js";import{I as j}from"./iconify-59ac6911.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const q={class:"tw-flex tw-flex-1 tw-flex-col"},A={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4"},E=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},[t("h4",{class:"tw-font-title tw-font-semibold"},"Atualizar Tipos de Arquivo")],-1),F=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},[t("p",{class:"tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"},"INFORMAÇÕES BÁSICAS")],-1),S={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4"},k={class:"tw-flex tw-flex-1 tw-flex-col"},V={class:"tw-flex tw-justify-end tw-gap-2"},R={__name:"Editar",props:{Tag:{type:Object,default:{}}},setup(c){const i=c,e=m({id:i.Tag.id,nome:i.Tag.nome});function f(){const s={nome:"Nome da Escola"};Object.keys(s).forEach(o=>{e[o]?e.errors[o]=null:e.errors[o]=`O campo ${s[o]} é obrigatório`})}function u(){f(),h.post(route("painel.tags.update",e.id),{_method:"patch",...e},{preserveScroll:!0,onSuccess:s=>{e.reset(),d.create({message:"Dados da Tag atualizados com sucesso.",color:"secondary"})},onError:s=>{d.create({message:"Não foi possível atualizar os dados da Tag.",color:"negative"})}})}return(s,w)=>(p(),g(x,null,[r(a(b),{title:"Tipo de Arquivo"}),r(O,null,{default:n(()=>[t("div",q,[t("div",A,[E,F,t("div",S,[t("div",k,[r(N,{for:"nome",value:"Nome",required:""}),_(t("input",{id:"nome",type:"text",required:"",autofocus:"",autocomplete:"nome",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm","onUpdate:modelValue":w[0]||(w[0]=o=>a(e).nome=o)},null,512),[[v,a(e).nome]]),r(T,{class:"tw-mt-2",message:a(e).errors.nome},null,8,["message"])])]),t("div",V,[r(a(y),{href:s.route("painel.tags"),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center"},{default:n(()=>[l(" VOLTAR ")]),_:1},8,["href"]),t("span",{onClick:w[1]||(w[1]=o=>u()),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center"},[r(a(j),{icon:"fluent:save-16-regular",class:"tw-h-6 tw-w-6 tw-text-white tw-mr-2"}),l(" Salvar ")])])])])]),_:1})],64))}};export{R as default};
