import{T as mt,k as p,m as E,h as f,o as n,f as g,a as l,u as i,w as s,F as N,Z as pt,b as e,i as U,v as D,d,t as L,g as v,j as O,c as C,p as Q,N as X}from"./app-4ab3c1a7.js";import{_ as Z}from"./PrimaryButton-0afca82d.js";import{_ as xt}from"./AuthenticatedLayout-0a5f0791.js";import{e as $}from"./index-63df1496.js";import{I as _}from"./iconify-59ac6911.js";import{_ as F}from"./InputLabel-e21345d2.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const gt=e("div",{class:"tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold"},"Selecione as opções que deseja no filtro abaixo: ",-1),vt={class:"tw-flex tw-flex-1 tw-flex-row tw-gap-4"},_t={class:"tw-flex tw-flex-1 tw-flex-row tw-gap-6"},bt={class:"tw-flex tw-flex-1 tw-flex-col tw-gap-4"},yt={class:"tw-flex tw-flex-1 tw-flex-col"},ht={class:"tw-flex tw-flex-1 tw-flex-col"},Ct={class:"tw-flex tw-flex-1 tw-flex-col"},kt=e("div",{class:"tw-text-xl tw-font-title tw-text-gray-800 tw-font-bold tw-text-center"}," Você tem certeza que deseja excluir o(s) registro(s) selecionado(s) definitivamente? ",-1),qt={class:"tw-flex tw-flex-1 tw-flex-row tw-mt-10"},At={class:"tw-flex tw-flex-1 flex-row tw-gap-4"},jt={class:"tw-flex tw-flex-1 tw-flex-col"},It={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll"},Tt={class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},Vt=e("h4",{class:"tw-text-gray-900 tw-font-title tw-font-semibold"},"Tags Cadastradas",-1),Ut={class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items"},Dt={key:0,class:"tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"},Rt={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-mb-8 tw-items-center"},St={class:"tw-flex tw-flex-1 tw-flex-row tw-items-center tw-gap-2 md:tw-flex-row tw-pt-5"},Et={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-end tw-items-center tw-gap-6 md:tw-flex-row tw-pt-5"},Nt={class:"tw-flex tw-flex-1 tw-flex-row tw-gap-5 tw-justify-end tw-items-center"},Lt={class:"tw-flex tw-flex-1 tw-flex-row tw-mt-1 tw-h-[52px] tw-items-center tw-border tw-px-2 tw-w-full tw-border-gray-200 focus:tw-border-gray-300 tw-leading-10 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},Ot={class:"tw-antialiased tw-font-body"},$t={class:"tw-py-4 tw-overflow-x-auto"},Ft={class:"tw-flex tw-flex-1 tw-flex-col tw-overflow-hidden"},zt={class:"tw-font-title tw-text-gray-600 tw-text-lg"},Bt={key:0},Pt={class:"tw-flex tw-flex-col tw-gap-2"},Mt=["onClick"],Gt={key:1,class:"tw-font-body tw-text-gray-800 tw-text-base"},ee={__name:"Index",props:{tags:{type:Array,default:[]},user:{type:Object,default:{}}},setup(H){const T=H,J=T.user.permissions,q=a=>J.some(o=>o===a),z=mt({id:[],nome:"",created_at:""}),A=p(!1),j=p(!1),R=p(""),B=p({sortBy:"desc",descending:!1,page:1,rowsPerPage:10}),k=p([]),K={year:"numeric",month:"numeric",day:"numeric"};function W(){A.value=!1}const Y=[{name:"id",field:"id",label:"ID"},{name:"nome",align:"left",label:"TIPO DE ARQUIVO",field:"nome",sortable:!0},{name:"created_at",field:"created_at",required:!0,label:"DATA DA CRIAÇÃO",format:a=>`${new Date(a).toLocaleString("pt-BR",K)}`,align:"left",sortable:!0},{name:"situacao",field:"situacao",required:!0,label:"STATUS",align:"left",sortable:!0},{name:"actions",label:"AÇÕES",align:"center",field:"id"}],tt=["id","nome","created_at","situacao","actions"],b=p(""),y=p(""),h=p(""),V=p(T.tags),et=E(()=>b.value!=""),ot=E(()=>y.value!=""),lt=E(()=>h.value!="");function I(){const a=h.value!=""?T.tiposArquivo.filter(u=>u.created_at.split("T")[0]==h.value):T.tiposArquivo,o=b.value!=""?a.filter(u=>u.id==b.value):a,m=y.value!=""?o.filter(u=>u.nome.toLowerCase().includes(y.value.toLowerCase())):o;V.value=m,A.value=!1}function st(){h.value="",I()}function at(){b.value="",I()}function rt(){y.value="",I()}function nt(){h.value="",b.value="",y.value=""}function it(a){z.id=a.id||k.value.map(o=>o.id),z.delete(route("painel.tags.destroy"),{preserveScroll:!0,onSuccess:o=>{X.create({message:"Tipo(s) de Arquivo(s) removido(s) com sucesso.",color:"secondary"}),window.location.href="/tags",I()},onError:o=>{X.create({message:"Não foi possível remover esse(s) Tipo(s) de Arquivo(s).",color:"negative"})}}),j.value=!1}function wt(a){k.value=[a],j.value=!0}const ct=()=>{if(k.value.length===0){const a=["ID","NOME DAS TAGS","SITUACAO"],o=V.value.map(r=>[r.id,`"${r.nome}"`,r.situacao]),m=`${a.join(",")}
${o.map(r=>r.join(",")).join(`
`)}`,u=new Blob([m],{type:"text/csv;charset=utf-8;"}),x=window.URL.createObjectURL(u),w=document.createElement("a");w.setAttribute("href",x),w.setAttribute("download","TagsExport.csv"),document.body.appendChild(w),w.click(),document.body.removeChild(w),window.URL.revokeObjectURL(x)}else{const a=["ID","NOME DAS TAGS","SITUACAO"],o=k.value.map(r=>[r.id,`"${r.nome}"`,r.situacao]),m=`${a.join(",")}
${o.map(r=>r.join(",")).join(`
`)}`,u=new Blob([m],{type:"text/csv;charset=utf-8;"}),x=window.URL.createObjectURL(u),w=document.createElement("a");w.setAttribute("href",x),w.setAttribute("download","TagsExport.csv"),document.body.appendChild(w),w.click(),document.body.removeChild(w),window.URL.revokeObjectURL(x)}};return(a,o)=>{const m=f("q-card-section"),u=f("q-card-actions"),x=f("q-card"),w=f("q-dialog"),r=f("q-chip"),P=f("q-checkbox"),S=f("q-td"),dt=f("q-th"),M=f("q-tr"),ut=f("q-menu"),ft=f("q-table");return n(),g(N,null,[l(i(pt),{title:"Tags"}),l(xt,null,{default:s(()=>[l(w,{modelValue:A.value,"onUpdate:modelValue":o[3]||(o[3]=t=>A.value=t)},{default:s(()=>[l(x,{style:{"min-width":"40vw","max-width":"500px","border-radius":"20px",padding:"40px"}},{default:s(()=>[l(m,null,{default:s(()=>[gt]),_:1}),l(m,{class:"q-p-none"},{default:s(()=>[e("div",vt,[e("div",_t,[e("div",bt,[e("div",yt,[l(F,{for:"filtroID",value:"ID"}),U(e("input",{id:"filtroID",type:"number",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm","onUpdate:modelValue":o[0]||(o[0]=t=>b.value=t)},null,512),[[D,b.value]])]),e("div",ht,[l(F,{for:"filtroCriacao",value:"Data de Criação"}),U(e("input",{id:"filtroCriacao",type:"date",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm","onUpdate:modelValue":o[1]||(o[1]=t=>h.value=t)},null,512),[[D,h.value]])])]),e("div",Ct,[l(F,{for:"filtroNome",value:"Descrição"}),U(e("input",{id:"filtroNome",type:"text",class:"tw-mt-1 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-500 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm","onUpdate:modelValue":o[2]||(o[2]=t=>y.value=t)},null,512),[[D,y.value]])])])]),e("div",{class:"tw-flex tw-flex-1 tw-flex-row tw-mt-10"},[e("div",{class:"tw-flex tw-flex-1"},[e("button",{onClick:nt,class:"tw-flex tw-px-8 tw-py-3 tw-text-gray-700 tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-gray-700 tw-justify-center"}," LIMPAR FILTROS ")]),e("div",{class:"tw-flex tw-flex-1 flex-row tw-gap-4"},[e("button",{onClick:W,class:"tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"}," CANCELAR "),e("button",{onClick:I,class:"tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"}," APLICAR FILTROS ")])])]),_:1}),l(u,{align:"right"})]),_:1})]),_:1},8,["modelValue"]),l(w,{modelValue:j.value,"onUpdate:modelValue":o[5]||(o[5]=t=>j.value=t)},{default:s(()=>[l(x,{style:{"min-width":"40vw","max-width":"380px","border-radius":"20px",padding:"50px"}},{default:s(()=>[l(m,null,{default:s(()=>[kt]),_:1}),l(m,{class:"q-p-none"},{default:s(()=>[e("div",qt,[e("div",At,[e("button",{onClick:o[4]||(o[4]=t=>j.value=!1),class:"tw-flex tw-flex-1 tw-py-3 tw-text-primary tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-white tw-border-2 tw-border-primary tw-justify-center"}," CANCELAR "),d(L(a.id)+" ",1),e("button",{onClick:it,class:"tw-flex tw-flex-1 tw-py-3 tw-text-white tw-text-sm tw-uppercase tw-rounded-md tw-font-title tw-font-semibold tw-bg-primary tw-border-2 tw-border-primary tw-justify-center"}," EXCLUIR ")])])]),_:1})]),_:1})]),_:1},8,["modelValue"]),e("div",jt,[e("div",It,[e("div",Tt,[Vt,e("div",Ut,[q("Importar Tags")?(n(),g("h5",Dt,[l(i(_),{icon:"tabler:file-import",class:"tw-h-6 tw-w-6"}),d(" Importar CSV ")])):v("",!0),l(i(O),{href:a.route("painel.tags.create")},{default:s(()=>[q("Criar Tags")?(n(),C(Z,{key:0,class:"tw-text-white tw-bg-green-500 tw-items-center"},{default:s(()=>[l(i(_),{icon:"icon-park-outline:add",class:"tw-h-6 tw-w-6 tw-text-white tw-mr-2"}),d(" ADICIONAR TAGS ")]),_:1})):v("",!0)]),_:1},8,["href"])])]),e("div",Rt,[e("div",St,[et.value?(n(),C(r,{key:0,size:"lg",icon:i($),outline:"",clickable:"",onClick:at,color:"green","text-color":"green"},{default:s(()=>[d(" ID ")]),_:1},8,["icon"])):v("",!0),ot.value?(n(),C(r,{key:1,size:"lg",icon:i($),outline:"",clickable:"",onClick:rt,color:"green","text-color":"green"},{default:s(()=>[d(" Descrição ")]),_:1},8,["icon"])):v("",!0),lt.value?(n(),C(r,{key:2,size:"lg",icon:i($),outline:"",clickable:"",onClick:st,color:"green","text-color":"green"},{default:s(()=>[d(" Data de Criação ")]),_:1},8,["icon"])):v("",!0)]),e("div",Et,[e("div",Nt,[e("h5",{onClick:o[6]||(o[6]=t=>A.value=!0),class:"tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"},[l(i(_),{icon:"ci:filter",class:"tw-h-6 tw-w-6"}),d(" Filtrar ")]),q("Exportar Tags")?(n(),g("h5",{key:0,onClick:ct,class:"tw-text-gray-700 tw-cursor-pointer tw-flex tw-flex-row tw-text-lg tw-font-body tw-justify-center tw-gap-2"},[l(i(_),{icon:"tabler:file-export",class:"tw-h-6 tw-w-6"}),d(" Exportar CSV ")])):v("",!0)]),e("div",Lt,[l(i(_),{icon:"majesticons:search-line",class:"tw-h-6 tw-w-6 tw-text-gray-600"}),U(e("input",{id:"busca",type:"text",placeholder:"Pesquise aqui",required:"",autofocus:"",autocomplete:"busca",class:"tw-appearance-none tw-border-none tw-w-full tw-text-gray-700","onUpdate:modelValue":o[7]||(o[7]=t=>R.value=t)},null,512),[[D,R.value]])])])]),e("div",Ot,[e("div",$t,[e("div",Ft,[l(ft,{flat:"",rows:V.value,"onUpdate:rows":o[8]||(o[8]=t=>V.value=t),columns:Y,"visible-columns":tt,"row-key":"id",filter:R.value,"no-data-label":"Não há informações cadastradas.","no-results-label":"Não foi possível localizar informações com o filtro inserido.","rows-per-page-label":"Registros por página",pagination:B.value,"onUpdate:pagination":o[9]||(o[9]=t=>B.value=t),"pagination-label":(t,c,G)=>`${t} à ${c} de ${G} registros`,"selected-rows-label":t=>t+" registro(s) selecionado(s)",selected:k.value,"onUpdate:selected":o[10]||(o[10]=t=>k.value=t),selection:"multiple"},{header:s(t=>[l(M,{props:t,class:"tw-h-20"},{default:s(()=>[l(S,{"auto-width":""},{default:s(()=>[l(P,{dense:"",modelValue:t.selected,"onUpdate:modelValue":c=>t.selected=c},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1024),(n(!0),g(N,null,Q(t.cols,c=>(n(),C(dt,{key:c.name,props:t},{default:s(()=>[e("span",zt,L(c.label),1)]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),body:s(t=>[l(M,{props:t,"no-hover":"",class:"roundful tw-overflow-hidden tw-rounded-lg hover:tw-bg-green-100 tw-h-20 tw-transition-colors"},{default:s(()=>[l(S,{"auto-width":""},{default:s(()=>[l(P,{dense:"",modelValue:t.selected,"onUpdate:modelValue":c=>t.selected=c},null,8,["modelValue","onUpdate:modelValue"])]),_:2},1024),(n(!0),g(N,null,Q(t.cols,c=>(n(),C(S,{key:c.name,props:t},{default:s(()=>[c.name==="actions"?(n(),g("div",Bt,[l(Z,{class:"tw-text-black tw-text-lg"},{default:s(()=>[d("... "),l(ut,{"auto-close":""},{default:s(()=>[e("div",Pt,[l(i(O),{href:a.route("painel.tags.show",t.row.id),title:"Info",class:"tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"},{default:s(()=>[l(i(_),{icon:"arcticons:searchbar-ex",class:"tw-h-6 tw-w-6"}),d("  Visualizar ")]),_:2},1032,["href"]),q("Editar Tags")?(n(),C(i(O),{key:0,href:a.route("painel.tags.editar",t.row.id),title:"Editar",class:"tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 z-10 tw-justify-right tw-items-center"},{default:s(()=>[l(i(_),{icon:"arcticons:simpletexteditor",class:"tw-h-6 tw-w-6"}),d("  Editar ")]),_:2},1032,["href"])):v("",!0),q("Excluir Tags")?(n(),g("span",{key:1,onClick:G=>wt(t.row),title:"Deletar",class:"tw-flex hover:tw-bg-gray-100 flex-row tw-p-2 tw-justify-right tw-items-center"},[l(i(_),{icon:"arcticons:trashcan",class:"tw-h-6 tw-w-6"}),d("  Excluir ")],8,Mt)):v("",!0)])]),_:2},1024)]),_:2},1024)])):(n(),g("div",Gt,L(c.value),1))]),_:2},1032,["props"]))),128))]),_:2},1032,["props"])]),_:1},8,["rows","filter","pagination","pagination-label","selected-rows-label","selected"])])])])])])]),_:1})],64)}}};export{ee as default};
