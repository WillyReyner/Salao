import{k as f,m as U,T as Z,h as x,o as i,f as u,a,u as r,w as s,F as I,Z as At,b as o,i as N,v as B,p as V,d,g as m,j as z,c as v,N as J,t as L}from"./app-4ab3c1a7.js";import{_ as K}from"./PrimaryButton-0afca82d.js";import{_ as Dt}from"./AuthenticatedLayout-0a5f0791.js";import{e as T}from"./index-63df1496.js";import{I as _}from"./iconify-59ac6911.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const It=o("div",{class:"tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold"},"Selecione as opções que deseja no filtro abaixo: ",-1),St={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},jt={class:"tw-flex tw-flex-1 tw-flex-col"},qt=o("h5",{class:"tw-font-title tw-text-base tw-font-semibold tw-text-primary"},"Período de Início",-1),Ut=o("h5",{class:"tw-font-title tw-text-base tw-font-semibold tw-text-primary"},"Período de Fim",-1),Vt=o("br",null,null,-1),Lt={class:"tw-flex tw-flex-1 tw-flex-row tw-gap-4"},Tt={class:"tw-flex tw-flex-1 tw-flex-col"},Ft=o("h5",{class:"tw-font-title tw-text-base tw-font-semibold tw-text-primary"},"STATUS",-1),Rt={class:"tw-font-bod tw-text-gray-600 tw-text-lg tw-font-thin tw-flex tw-flex-row tw-items-center"},Ot=o("h5",{class:"tw-font-title tw-text-base tw-font-semibold tw-text-primary tw-mt-4"},"MODALIDADE",-1),zt={class:"tw-font-bod tw-text-gray-600 tw-text-lg tw-font-normal tw-flex tw-flex-row tw-items-center"},Mt={class:"tw-flex tw-flex-1 tw-flex-col"},Pt=o("h5",{class:"tw-font-title tw-text-base tw-font-semibold tw-text-primary"},"ESCOLA/UDEPI",-1),$t={class:"tw-font-bod tw-text-gray-500 tw-text-lg tw-font-normal tw-flex tw-flex-row tw-items-center"},Nt=o("h5",{class:"tw-font-title tw-text-base tw-font-semibold tw-text-primary"},"CATEGORIA",-1),Bt={class:"tw-font-bod tw-text-gray-500 tw-text-lg tw-font-normal tw-flex tw-flex-row tw-items-center"},Gt=o("div",{class:"tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold tw-text-center"}," Você tem certeza que deseja excluir o(s) registro(s) selecionado(s) definitivamente? ",-1),Ht={class:"tw-flex tw-flex-1 tw-flex-row tw-mt-10"},Qt={class:"tw-flex tw-flex-1 flex-row tw-gap-4"},Xt={class:"tw-flex tw-flex-1 tw-flex-col"},Zt={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll"},Jt={class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},Kt=o("h4",{class:"tw-text-gray-900 tw-font-title tw-font-semibold"},"Editais Cadastrados",-1),Wt={class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items"},Yt={key:0,class:"tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"},te={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center"},ee={class:"tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5"},oe={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5"},le={class:"tw-flex tw-flex-1 tw-flex-row tw-gap-5 tw-justify-end tw-items-center"},ae={class:"tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},se={class:"tw-antialiased tw-font-body"},ie={class:"tw-py-4 tw-overflow-x-auto"},ne={class:"tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden"},re={class:"tw-font-title tw-text-gray-600 tw-text-lg"},de={key:0},we={class:"tw-flex tw-flex-col tw-gap-2"},ce=["onClick"],ue={key:1,class:"tw-font-body tw-text-gray-800 tw-text-base"},ye={__name:"Index",props:{editais:{type:Array,default:[]},municipios:{type:Array,default:[]},escolas:{type:Array,default:[]},turmas:{type:Array,default:[]},countTurmas:{type:Array,default:[]},user:{type:Object,default:{}}},setup(W){const F=W,M=f(""),R=f(!1),O=f(!1),h=f([]),y=f([]),k=f([]),E=f(""),C=f(""),A=f([]),P=f(F.editais),Y=F.user.roles,tt=U(()=>h.value.length>0),et=U(()=>y.value.lenght>0),ot=U(()=>A.value.length>0),lt=U(()=>E.value.length>0),at=U(()=>C.value.length>0),st=U(()=>k.value.length>0),it=["Ativo","Inativo","Cancelado","Encerrado","Periodo de Inscrição Expirado","Processo Encerrado"],nt=["Presencial","EAD","Online","MOOC"],rt=["Capacitacao","Qualificação","Técnico"],dt=Y.map(l=>l.permissions).flat(),S=l=>dt.some(t=>t.name===l),G=Z({id:[],nome:""}),H=f({sortBy:"desc",descending:!1,page:1,rowsPerPage:10}),j=f([]);function wt(){R.value=!1}const ct=[{name:"id",field:"id",label:"id"},{name:"ID",field:"id",required:!0,label:"ID",align:"left",sortable:!0},{name:"nome",align:"left",label:"EDITAL",field:"nome",sortable:!0},{name:"turma",field:"contagem_editais",label:"TURMAS",sortable:!0},{name:"status",align:"right",label:"STATUS",field:"situacao",sortable:!0},{name:"actions",label:"AÇÕES",align:"center",field:"id"}],ut=["ID","turma","nome","data_fim_inscricao","status","actions"];function b(){let l=[...F.editais];h.value.length>0&&(l=l.filter(t=>h.value.includes(t.situacao))),y.value.length>0&&(l=l.filter(t=>y.value.includes(t.modalidade))),k.value.length>0&&(l=l.filter(t=>k.value.includes(t.escola_id))),A.value.length>0&&(l=l.filter(t=>A.value.includes(t.categoria))),E.value&&(l=l.filter(t=>new Date(t.created_at)>=new Date(E.value))),C.value&&(l=l.filter(t=>new Date(t.created_at)<=new Date(C.value))),P.value=l,R.value=!1}function ft(){y.value=[],b()}function mt(){A.value=[],b()}function pt(){k.value=[],b()}function xt(){h.value=[],b()}function vt(){E.value=[],b()}function gt(){C.value=[],b()}function _t(){A.value=[],y.value=[],k.value=[],h.value=[],E.value=[],C.value=[]}function bt(l){G.id=l.id||j.value.map(t=>t.id),G.post(route("painel.editais.destroy"),{preserveScroll:!0,onSuccess:t=>{J.create({message:"Edital(is) removido(s) com sucesso.",color:"secondary"}),window.location.href="/editais",b()},onError:t=>{J.create({message:"Não foi possível remover esse(s) edital(is).",color:"negative"})}}),O.value=!1}function ht(l){j.value=[l],O.value=!0}F.editais.filter(l=>new Date(l.dt_fim_edital)<new Date&&l.situacao==="Ativo").forEach(l=>{const t=Z({id:l.id,situacao:l.situacao});t.situacao==="Ativo"&&t.post(route("painel.editais.autoupdate",t.id),{preserveScroll:!0,forceFormData:!0,onSuccess:p=>{t.reset(),console.log(`Edital ${t.id} atualizado para 'Expirado'`)},onError:p=>{console.log(p)}})});const yt=()=>{if(j.value.length===0){const l=["ID","NOME DOS EDITAIS","STATUS"],t=P.value.map(c=>[c.id,`"${c.nome}"`,c.situacao]),p=`${l.join(",")}
${t.map(c=>c.join(",")).join(`
`)}`,g=new Blob([p],{type:"text/csv;charset=utf-8;"}),D=window.URL.createObjectURL(g),w=document.createElement("a");w.setAttribute("href",D),w.setAttribute("download","EditalExport.csv"),document.body.appendChild(w),w.click(),document.body.removeChild(w),window.URL.revokeObjectURL(D)}else{const l=["ID","NOME DOS EDITAIS","STATUS"],t=j.value.map(c=>[c.id,`"${c.nome}"`,c.situacao]),p=`${l.join(",")}
${t.map(c=>c.join(",")).join(`
`)}`,g=new Blob([p],{type:"text/csv;charset=utf-8;"}),D=window.URL.createObjectURL(g),w=document.createElement("a");w.setAttribute("href",D),w.setAttribute("download","EditalExport.csv"),document.body.appendChild(w),w.click(),document.body.removeChild(w),window.URL.revokeObjectURL(D)}};return(l,t)=>{const p=x("q-card-section"),g=x("q-checkbox"),D=x("q-card-actions"),w=x("q-card"),c=x("q-dialog"),q=x("q-chip"),$=x("q-td"),kt=x("q-th"),Q=x("q-tr"),Et=x("q-menu"),Ct=x("q-table");return i(),u(I,null,[a(r(At),{title:"Editais"}),a(Dt,null,{default:s(()=>[a(c,{modelValue:R.value,"onUpdate:modelValue":t[6]||(t[6]=e=>R.value=e)},{default:s(()=>[a(w,{style:{"min-width":"40vw","max-width":"500px","border-radius":"20px",padding:"40px"}},{default:s(()=>[a(p,null,{default:s(()=>[It]),_:1}),o("div",St,[o("div",jt,[qt,N(o("input",{id:"data_inicio",type:"date",autofocus:"",autocomplete:"data_inicio",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm","onUpdate:modelValue":t[0]||(t[0]=e=>E.value=e)},null,512),[[B,E.value]]),Ut,N(o("input",{id:"data_fim",type:"date",autofocus:"",autocomplete:"data_fim",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm","onUpdate:modelValue":t[1]||(t[1]=e=>C.value=e)},null,512),[[B,C.value]])])]),Vt,a(p,{class:"q-p-none"},{default:s(()=>[o("div",Lt,[o("div",Tt,[Ft,(i(),u(I,null,V(it,e=>o("div",Rt,[a(g,{val:e,"model-value":h.value,"onUpdate:modelValue":t[2]||(t[2]=n=>h.value=n)},null,8,["val","model-value"]),d(" "+L(e),1)])),64)),Ot,(i(),u(I,null,V(nt,e=>o("div",zt,[a(g,{val:e,"model-value":y.value,"onUpdate:modelValue":t[3]||(t[3]=n=>y.value=n)},null,8,["val","model-value"]),d(" "+L(e),1)])),64))]),o("div",Mt,[Pt,(i(!0),u(I,null,V(F.escolas,e=>(i(),u("div",$t,[a(g,{val:e.id,"model-value":k.value,"onUpdate:modelValue":t[4]||(t[4]=n=>k.value=n)},null,8,["val","model-value"]),d(" "+L(e.nome),1)]))),256)),Nt,(i(),u(I,null,V(rt,e=>o("div",Bt,[a(g,{val:e,"model-value":A.value,"onUpdate:modelValue":t[5]||(t[5]=n=>A.value=n)},null,8,["val","model-value"]),d(" "+L(e),1)])),64))])]),o("div",{class:"tw-flex tw-flex-1 tw-flex-row tw-mt-10"},[o("div",{class:"tw-flex tw-flex-1"},[o("button",{onClick:_t,class:"tw-flex tw-px-8 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center"}," LIMPAR FILTROS ")]),o("div",{class:"tw-flex tw-flex-1 flex-row tw-gap-4"},[o("button",{onClick:wt,class:"tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"}," CANCELAR "),o("button",{onClick:b,class:"tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"}," APLICAR FILTROS ")])])]),_:1}),a(D,{align:"right"})]),_:1})]),_:1},8,["modelValue"]),a(c,{modelValue:O.value,"onUpdate:modelValue":t[8]||(t[8]=e=>O.value=e)},{default:s(()=>[a(w,{style:{"min-width":"40vw","max-width":"380px","border-radius":"20px",padding:"50px"}},{default:s(()=>[a(p,null,{default:s(()=>[Gt]),_:1}),a(p,{class:"q-p-none"},{default:s(()=>[o("div",Ht,[o("div",Qt,[o("button",{onClick:t[7]||(t[7]=e=>O.value=!1),class:"tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"}," CANCELAR "),o("button",{onClick:bt,class:"tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"}," EXCLUIR ")])])]),_:1})]),_:1})]),_:1},8,["modelValue"]),o("div",Xt,[o("div",Zt,[o("div",Jt,[Kt,o("div",Wt,[S("Importar Editais")?(i(),u("h5",Yt,[a(r(_),{icon:"tabler:file-import",class:"tw-h-6 tw-w-6"}),d(" Importar CSV ")])):m("",!0),a(r(z),{href:l.route("painel.editais.create")},{default:s(()=>[S("Criar Editais")?(i(),v(K,{key:0,class:"tw-text-white tw-bg-green-500 tw-items-center"},{default:s(()=>[a(r(_),{icon:"icon-park-outline:add",class:"tw-h-6 tw-w-6 tw-text-white tw-mr-2"}),d(" ADICIONAR EDITAL ")]),_:1})):m("",!0)]),_:1},8,["href"])])]),o("div",te,[o("div",ee,[et.value?(i(),v(q,{key:0,size:"lg",icon:r(T),outline:"",clickable:"",onClick:ft,color:"green","text-color":"green"},{default:s(()=>[d(" Modalidade ")]),_:1},8,["icon"])):m("",!0),st.value?(i(),v(q,{key:1,size:"lg",icon:r(T),outline:"",clickable:"",onClick:pt,color:"green","text-color":"green"},{default:s(()=>[d(" Escola ")]),_:1},8,["icon"])):m("",!0),tt.value?(i(),v(q,{key:2,size:"lg",icon:r(T),outline:"",clickable:"",onClick:xt,color:"green","text-color":"green"},{default:s(()=>[d(" Status ")]),_:1},8,["icon"])):m("",!0),ot.value?(i(),v(q,{key:3,size:"lg",icon:r(T),outline:"",clickable:"",onClick:mt,color:"green","text-color":"green"},{default:s(()=>[d(" Categoria ")]),_:1},8,["icon"])):m("",!0),lt.value?(i(),v(q,{key:4,size:"lg",icon:r(T),outline:"",clickable:"",onClick:vt,color:"green","text-color":"green"},{default:s(()=>[d(" Data Inicio ")]),_:1},8,["icon"])):m("",!0),at.value?(i(),v(q,{key:5,size:"lg",icon:r(T),outline:"",clickable:"",onClick:gt,color:"green","text-color":"green"},{default:s(()=>[d(" Data Fim ")]),_:1},8,["icon"])):m("",!0)]),o("div",oe,[o("div",le,[o("h5",{onClick:t[9]||(t[9]=e=>R.value=!0),class:"tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"},[a(r(_),{icon:"ci:filter",class:"tw-h-6 tw-w-6"}),d(" Filtrar ")]),S("Exportar Editais")?(i(),u("h5",{key:0,onClick:yt,class:"tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"},[a(r(_),{icon:"tabler:file-export",class:"tw-h-6 tw-w-6"}),d(" Exportar CSV ")])):m("",!0)]),o("div",ae,[a(r(_),{icon:"majesticons:search-line",class:"tw-h-6 tw-w-6 tw-text-gray-600"}),N(o("input",{id:"busca",type:"text",placeholder:"Pesquise aqui",required:"",autofocus:"",autocomplete:"busca",class:"tw-appearance-none tw-border-none tw-w-full tw-text-gray-700","onUpdate:modelValue":t[10]||(t[10]=e=>M.value=e)},null,512),[[B,M.value]])])])]),o("div",se,[o("div",ie,[o("div",ne,[a(Ct,{flat:"","wrap-cells":"",rows:P.value,filter:M.value,columns:ct,"visible-columns":ut,"row-key":"id","no-data-label":"Não há informações cadastradas.","no-results-label":"Não foi possível localizar informações com o filtro inserido.","rows-per-page-label":"Registros por página",pagination:H.value,"onUpdate:pagination":t[11]||(t[11]=e=>H.value=e),"pagination-label":(e,n,X)=>`${e} à ${n} de ${X} registros`,"selected-rows-label":e=>e+" registro(s) selecionado(s)",selected:j.value,"onUpdate:selected":t[12]||(t[12]=e=>j.value=e),selection:"multiple"},{header:s(e=>[a(Q,{props:e,class:"tw-h-20"},{default:s(()=>[a($,{"auto-width":""},{default:s(()=>[a(g,{dense:"",modelValue:e.selected,"onUpdate:modelValue":n=>e.selected=n},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1024),(i(!0),u(I,null,V(e.cols,n=>(i(),v(kt,{key:n.name,props:e},{default:s(()=>[o("span",re,L(n.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:s(e=>[a(Q,{props:e,"no-hover":"",class:"roundful tw-overflow-hidden tw-rounded-lg hover:tw-bg-green-100 tw-h-20 tw-transition-colors"},{default:s(()=>[a($,{"auto-width":""},{default:s(()=>[a(g,{dense:"",modelValue:e.selected,"onUpdate:modelValue":n=>e.selected=n},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1024),(i(!0),u(I,null,V(e.cols,n=>(i(),v($,{key:n.name,props:e},{default:s(()=>[n.name==="actions"?(i(),u("div",de,[a(K,{class:"tw-text-black tw-text-lg"},{default:s(()=>[d("... "),a(Et,{"auto-close":""},{default:s(()=>[o("div",we,[a(r(z),{href:l.route("painel.editais.show",e.row.id),title:"Info",class:"tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"},{default:s(()=>[a(r(_),{icon:"arcticons:searchbar-ex",class:"tw-h-6 tw-w-6"}),d("  Visualizar ")]),_:2},1032,["href"]),S("Logs Editais")?(i(),v(r(z),{key:0,href:l.route("painel.editais.log",e.row.id),title:"Info",class:"tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"},{default:s(()=>[a(r(_),{icon:"arcticons:tenbitclockwidget",class:"tw-h-6 tw-w-6"}),d("  Histórico de Logs ")]),_:2},1032,["href"])):m("",!0),S("Editar Editais")?(i(),v(r(z),{key:1,href:l.route("painel.editais.editar",e.row.id),title:"Editar",class:"tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"},{default:s(()=>[a(r(_),{icon:"arcticons:simpletexteditor",class:"tw-h-6 tw-w-6"}),d("  Editar ")]),_:2},1032,["href"])):m("",!0),S("Excluir Editais")?(i(),u("span",{key:2,onClick:X=>ht(e.row),title:"Deletar",class:"tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-right tw-items-center"},[a(r(_),{icon:"arcticons:trashcan",class:"tw-h-6 tw-w-6"}),d("  Excluir ")],8,ce)):m("",!0)])]),_:2},1024)]),_:2},1024)])):(i(),u("div",ue,L(n.value),1))]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),_:1},8,["rows","filter","pagination","pagination-label","selected-rows-label","selected"])])])])])])]),_:1})],64)}}};export{ye as default};
