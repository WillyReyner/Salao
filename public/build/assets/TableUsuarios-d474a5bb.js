import{k as b,T as S,h as c,E as F,o as s,f as o,a as r,w,b as t,t as a,F as p,p as h,g as m,i as U,u as j,j as A,G as B,N as x}from"./app-4ab3c1a7.js";const G=t("div",{class:"tw-text-2xl"},"Informações do Usuário",-1),I={class:"tw-flex tw-flex-col tw-gap-2"},M={key:0},Q=t("h6",null,"Grupos: ",-1),T={key:1},$=t("h6",null,"Permissões: ",-1),L={class:"tw-antialiased tw-font-sans"},O={class:"tw-container tw-mx-auto"},R={class:"tw-py-8"},H={class:"-tw-mx-4 sm:-tw-mx-8 tw-px-4 sm:tw-px-8 tw-py-4 tw-overflow-x-auto"},K={class:"tw-inline-block tw-min-w-full tw-shadow tw-rounded-lg tw-overflow-hidden"},P={class:"tw-min-w-full tw-leading-normal"},W=t("thead",null,[t("tr",null,[t("th",{class:"tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider"}," Nome "),t("th",{class:"tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider"}," Grupo(s) "),t("th",{class:"tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider"}," Adicionado em "),t("th",{class:"tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider"}," Status "),t("th",{class:"tw-px-5 tw-py-3 tw-border-b-2 tw-border-gray-200 tw-bg-gray-100 tw-text-left tw-text-xs tw-font-semibold tw-text-gray-600 tw-uppercase tw-tracking-wider"}," Ações ")])],-1),z={class:"tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm"},J={class:"tw-flex tw-items-center"},X=t("div",{class:"tw-flex-shrink-0 tw-w-10 tw-h-10"},[t("img",{class:"tw-w-full tw-h-full tw-rounded-full",src:"https://t3.ftcdn.net/jpg/05/16/27/58/360_F_516275801_f3Fsp17x6HQK0xQgDQEELoTuERO4SsWV.jpg",alt:""})],-1),Y={class:"tw-ml-3"},Z={class:"tw-text-gray-900 tw-whitespace-no-wrap tw-items-center"},tt={class:"tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm"},et={class:"tw-text-gray-900 tw-whitespace-no-wrap"},st={class:"tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm"},ot={class:"tw-text-gray-900 tw-whitespace-no-wrap"},at=t("td",{class:"tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm"},[t("span",{class:"tw-relative tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-green-900 tw-leading-tight"},[t("span",{"aria-hidden":"",class:"tw-absolute tw-inset-0 tw-bg-green-200 tw-opacity-50 tw-rounded-full"}),t("span",{class:"tw-relative"},"Ativo")])],-1),rt={class:"tw-px-5 tw-py-5 tw-border-b tw-border-gray-200 tw-bg-white tw-text-sm"},lt=["onClick"],nt=t("span",{"aria-hidden":"",class:"tw-absolute tw-inset-0 tw-bg-slate-200 tw-opacity-50 tw-rounded-full"},null,-1),wt=t("span",{class:"tw-relative"},"Detalhar",-1),it=[nt,wt],ct=t("span",{"aria-hidden":"",class:"tw-absolute tw-inset-0 tw-bg-blue-200 tw-opacity-50 tw-rounded-full"},null,-1),dt=t("span",{class:"tw-relative"},"Editar",-1),pt=["onClick"],ut=t("span",{"aria-hidden":"",class:"tw-absolute tw-inset-0 tw-bg-red-200 tw-opacity-50 tw-rounded-full"},null,-1),_t=t("span",{class:"tw-relative"},"Deletar",-1),ht=[ut,_t],bt={__name:"TableUsuarios",props:{usuarios:{type:Array,default:[]}},setup(f){const y=f,l=b({}),u=b(!1);function v(n=[]){u.value=!0,l.value=n}const k=S({id:"",name:"",roles:[],permissions:[]});function q(n){B.create({title:"<h5>Confirmação</h5>",message:`<p>Você deseja realmente remover o usuário <b>${n.name}</b>?</p>`,cancel:!0,persistent:!0,html:!0}).onOk(()=>{k.delete(route("painel.gestao.usuarios.destroy",n.id),{preserveScroll:!0,onSuccess:d=>{showModal.value=!1,x.create({message:"Usuário removido com sucesso.",color:"secondary"})},onError:d=>{x.create({message:"Não foi possível remover esse Usuário.",color:"negative"})}})})}return(n,d)=>{const g=c("q-card-section"),C=c("q-btn"),D=c("q-card-actions"),N=c("q-card"),V=c("q-dialog"),E=F("close-popup");return s(),o(p,null,[r(V,{modelValue:u.value,"onUpdate:modelValue":d[0]||(d[0]=e=>u.value=e)},{default:w(()=>[r(N,{style:{"min-width":"40vw","max-width":"90vw"}},{default:w(()=>[r(g,null,{default:w(()=>[G]),_:1}),r(g,{class:"q-pt-none"},{default:w(()=>[t("div",I,[t("p",null,"Nome: "+a(l.value.name),1),l.value.roles.length?(s(),o("ul",M,[Q,(s(!0),o(p,null,h(l.value.roles,(e,i)=>(s(),o("li",{key:i},a(e.id)+" - "+a(e.name),1))),128))])):m("",!0),l.value.permissions.length?(s(),o("ul",T,[$,(s(!0),o(p,null,h(l.value.permissions,(e,i)=>(s(),o("li",{key:i},a(e.id)+" - "+a(e.name),1))),128))])):m("",!0)])]),_:1}),r(D,{align:"right"},{default:w(()=>[U(r(C,{label:"Fechar",color:"dark"},null,512),[[E]])]),_:1})]),_:1})]),_:1},8,["modelValue"]),t("div",L,[t("div",O,[t("div",R,[t("div",H,[t("div",K,[t("table",P,[W,t("tbody",null,[(s(!0),o(p,null,h(y.usuarios,(e,i)=>(s(),o("tr",{key:i},[t("td",z,[t("div",J,[X,t("div",Y,[t("p",Z,a(e.name),1)])])]),t("td",tt,[t("p",et,a(e.roles.map(_=>_.name).toString()),1)]),t("td",st,[t("p",ot,a(e.created_at),1)]),at,t("td",rt,[t("span",{onClick:_=>v(e),class:"tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-gray-900 tw-leading-tight"},it,8,lt),r(j(A),{href:n.route("painel.gestao.usuarios.editar",e.id),class:"tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-blue-900 tw-leading-tight"},{default:w(()=>[ct,dt]),_:2},1032,["href"]),t("span",{onClick:_=>q(e),class:"tw-relative tw-cursor-pointer tw-inline-block tw-px-3 tw-py-1 tw-font-semibold tw-text-red-900 tw-leading-tight"},ht,8,pt)])]))),128))])])])])])])])],64)}}};export{bt as _};
