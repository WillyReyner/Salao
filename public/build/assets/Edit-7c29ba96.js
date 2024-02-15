import{_ as v}from"./AuthenticatedLayout-0a5f0791.js";import{_ as n}from"./InputError-8e97e87c.js";import{_ as m}from"./InputLabel-e21345d2.js";import{k as i,Q as h,m as V,T as q,h as u,o as k,f as U,a as t,u as l,w as p,F as B,Z as P,b as e,q as F}from"./app-4ab3c1a7.js";/* empty css                                                                     */import"./iconify-59ac6911.js";import"./ApplicationLogo-af625855.js";import"./logo-efg-4f53c449.js";import"./_plugin-vue_export-helper-c27b6911.js";const j={class:"tw-flex tw-flex-1 tw-flex-col"},E={class:"tw-flex tw-flex-1 tw-flex-col tw-justify-start tw-bg-white tw-shadow sm:tw-rounded-lg tw-px-8 tw-py-4 tw-overflow-hidden tw-overflow-y-scroll"},N=e("div",{class:"tw-flex md:tw-flex-row tw-flex-col tw-gap-4 tw-py-4 tw-items-center tw-justify-between items tw-border-b-2 tw-border-gray-200"},[e("h4",{class:"tw-font-title tw-font-semibold"}," Meu Perfil ")],-1),$=e("div",{class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},[e("p",{class:"tw-flex tw-flex-1 tw-text-green-800 tw-text-lg tw-font-title tw-my-4"}," Dados Pessoais ")],-1),C={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-8 tw-gap-2 tw-m-1"},I={class:"tw-flex tw-flex-4 tw-flex-col"},D={class:"q-file-image"},O=["src"],S={class:"tw-flex tw-flex-1 tw-flex-col"},T={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},z={class:"tw-flex tw-flex-col tw-mr-4 tw-w-3/4"},A={class:"tw-flex tw-flex-col tw-mr-4 tw-w-1/4"},G=e("br",null,null,-1),M=e("br",null,null,-1),Q=e("br",null,null,-1),R={class:"tw-flex md:tw-flex-row tw-flex-col md:tw-gap-10 tw-gap-2 tw-m-2"},K={class:"tw-flex tw-flex-1 tw-flex-col"},L={class:"tw-flex tw-flex-1 tw-flex-col"},Z={class:"tw-flex tw-flex-1 tw-flex-col"},H={class:"tw-flex tw-flex-1 tw-flex-col"},J=e("br",null,null,-1),we={__name:"Edit",props:{mustVerifyEmail:{type:Boolean},status:{type:String}},setup(W){i("");const r=h().props.auth.user,_=i("https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABlN930GwaMQz.jpg");i(""),i("");const g=i(null),x=d=>new Promise((s,c)=>{const w=new FileReader;w.readAsDataURL(d),w.onload=()=>s(w.result),w.onerror=f=>c(f)}),b=async d=>{g.value=await x(d),o.imagem=d},y=V(()=>`background-image: url(${g.value||_.value})`),o=q({id:r.id,name:r.name,email:r.email,cpf:r.cpf,email:r.email,telefone:r.telefone,role:[r.role],data_nascimento:r.data_nascimento?r.data_nascimento.split(" ")[0]:"",imagem:null});return(d,s)=>{const c=u("q-file"),w=u("q-input"),f=u("q-select");return k(),U(B,null,[t(l(P),{title:"Perfil"}),t(v,null,{default:p(()=>[e("div",j,[e("div",E,[N,$,e("div",C,[e("div",I,[e("div",D,[t(c,{disable:"","model-value":l(o).imagem,"onUpdate:modelValue":b,accept:".jpg,.png"},{before:p(()=>[e("div",{class:"q-file-image-preview",style:F(y.value)},[e("img",{src:`/storage/${l(r).imagem}`},null,8,O)],4)]),_:1},8,["model-value"])])]),e("div",S,[e("div",T,[e("div",z,[t(m,{for:"name",value:"Nome Completo",required:""}),t(w,{disable:"",id:"name",modelValue:l(o).name,"onUpdate:modelValue":s[0]||(s[0]=a=>l(o).name=a),class:"tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},null,8,["modelValue"]),t(n,{class:"tw-mt-2",message:l(o).errors.name},null,8,["message"])]),e("div",A,[t(m,{for:"role",value:"Perfil do Usuário",required:""}),t(f,{disable:"",options:d.opcoesTag,id:"role",modelValue:l(o).role,"onUpdate:modelValue":s[1]||(s[1]=a=>l(o).role=a),class:"tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},null,8,["options","modelValue"]),t(n,{class:"tw-mt-2",message:l(o).errors.role},null,8,["message"])])]),G,M,Q,e("div",R,[e("div",K,[t(m,{for:"email",value:"Email",required:""}),t(w,{disable:"",id:"email",modelValue:l(o).email,"onUpdate:modelValue":s[2]||(s[2]=a=>l(o).email=a),class:"tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},null,8,["modelValue"]),t(n,{class:"tw-mt-2",message:l(o).errors.email},null,8,["message"])]),e("div",L,[t(m,{for:"telefone",value:"Telefone",required:""}),t(w,{disable:"",mask:"(##) #####-####",id:"telefone",modelValue:l(o).telefone,"onUpdate:modelValue":s[3]||(s[3]=a=>l(o).telefone=a),class:"tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},null,8,["modelValue"]),t(n,{class:"tw-mt-2",message:l(o).errors.telefone},null,8,["message"])]),e("div",Z,[t(m,{for:"data_nascimento",value:"Data de Nascimento",required:""}),t(w,{disable:"",type:"date",id:"data_nascimento",modelValue:l(o).data_nascimento,"onUpdate:modelValue":s[4]||(s[4]=a=>l(o).data_nascimento=a),class:"tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},null,8,["modelValue"]),t(n,{class:"tw-mt-2",message:l(o).errors.data_nascimento},null,8,["message"])]),e("div",H,[t(m,{for:"cpf",value:"CPF",required:""}),t(w,{disable:"",mask:"###.###.###-##",id:"cpf",modelValue:l(o).cpf,"onUpdate:modelValue":s[5]||(s[5]=a=>l(o).cpf=a),class:"tw-mt-1 tw-text-gray-700 tw-h-[52px] tw-block tw-w-full tw-border-gray-200 focus:tw-border-gray-200 focus:tw-ring-0 tw-rounded-lg tw-shadow-sm"},null,8,["modelValue"]),t(n,{class:"tw-mt-2",message:l(o).errors.cpf},null,8,["message"])])])])]),J])])]),_:1})],64)}}};export{we as default};
