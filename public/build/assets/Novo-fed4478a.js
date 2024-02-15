import{_ as V}from"./AuthenticatedLayout-0a5f0791.js";import{_ as q}from"./InputError-8e97e87c.js";import{_ as g}from"./InputLabel-e21345d2.js";import{T as A,k as C,h as _,o as c,f as m,a as e,u as a,w as d,F as x,Z as S,b as t,p as E,d as n,j as F,N as v,c as I,g as $}from"./app-4ab3c1a7.js";import{I as b}from"./iconify-59ac6911.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const j={class:"tw-flex tw-flex-1 tw-flex-col"},B={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4"},L=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},[t("h4",{class:"tw-font-title tw-font-semibold"},"Adicionar Areas")],-1),O=t("div",{class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},[t("p",{class:"tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"},"INFORMAÇÕES BÁSICAS")],-1),T={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2 tw-pb-4"},U={class:"tw-flex tw-flex-1 tw-flex-col"},R={class:"tw-grid tw-grid-row tw-gap-2 tw-m-2 tw-pb-4"},M={class:"tw-col-span-4"},Z={class:"tw-col-span-2 tw-mt-8"},z={class:"tw-flex tw-justify-end tw-gap-2"},Y={__name:"Novo",setup(D){const o=A({nome:"",inputs:[{valor:""}]});function h(){const s={nome:"Nome da Escola"};Object.keys(s).forEach(r=>{o[r]?o.errors[r]=null:o.errors[r]=`O campo ${s[r]} é obrigatório`})}const y=()=>{i.value.push({valor:""}),o.inputs=i.value},k=s=>{i.value.splice(s,1)},i=C([{valor:""}]);function N(){h(),o.post(route("painel.areas.store"),{preserveScroll:!0,onSuccess:s=>{o.reset(),v.create({message:"Area registrada com sucesso.",color:"secondary"})},onError:s=>{console.log(s),v.create({message:"Não foi possível registrar a Area.",color:"negative"})}})}return(s,w)=>{const r=_("q-input"),f=_("q-btn");return c(),m(x,null,[e(a(S),{title:"Tipo de Arquivo"}),e(V,null,{default:d(()=>[t("div",j,[t("div",B,[L,O,t("div",T,[t("div",U,[e(g,{for:"nome",value:"Nome",required:""}),e(r,{outlined:"",id:"nome",type:"text",required:"",autofocus:"",autocomplete:"nome",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm",modelValue:a(o).nome,"onUpdate:modelValue":w[0]||(w[0]=l=>a(o).nome=l)},null,8,["modelValue"]),e(q,{class:"tw-mt-2",message:a(o).errors.nome},null,8,["message"])])]),t("div",R,[(c(!0),m(x,null,E(i.value,(l,u)=>(c(),m("div",{class:"tw-grid tw-grid-cols-12 tw-gap-2",key:u},[t("div",M,[e(g,{for:"nome",value:"Sub-área",required:""}),e(r,{outlined:"",modelValue:l.valor,"onUpdate:modelValue":p=>l.valor=p,class:"tw-w-auto"},null,8,["modelValue","onUpdate:modelValue"])]),t("div",Z,[u>0?(c(),I(f,{key:0,onClick:p=>k(u),class:"tw-w-[1%] tw-bg-red-500 tw-text-white"},{default:d(()=>[n("-")]),_:2},1032,["onClick"])):$("",!0)])]))),128)),e(f,{onClick:y,class:"tw-w-[14%] tw-bg-green-700 tw-text-white tw-rounded-1xl",label:"Adicionar mais"},{default:d(()=>[n("  "),e(a(b),{icon:"gg:add-r",width:"20",height:"20",class:"tw-text-white tw-text-left"}),n("  ")]),_:1})]),t("div",z,[e(a(F),{href:s.route("painel.areas"),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-opacity-90 tw-border-primary active:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-primary tw-bg-white tw-items-center"},{default:d(()=>[n(" CANCELAR ")]),_:1},8,["href"]),t("span",{onClick:w[1]||(w[1]=l=>N()),class:"tw-inline-flex tw-cursor-pointer tw-px-8 tw-py-4 tw-border tw-border-transparent tw-rounded-md tw-font-body tw-font-semibold tw-text-base tw-uppercase hover:tw-bg-opacity-90 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150 tw-text-white tw-bg-green-500 tw-items-center"},[e(a(b),{icon:"fluent:save-16-regular",class:"tw-h-6 tw-w-6 tw-text-white tw-mr-2"}),n(" Salvar ")])])])])]),_:1})],64)}}};export{Y as default};
