import{T as u,o as c,c as f,w as d,a as o,u as e,Z as _,b as r,d as V,n as g,e as b}from"./app-4ab3c1a7.js";import{_ as k}from"./RegisterLayout-43dfe44b.js";import{_ as l}from"./InputError-8e97e87c.js";import{_ as i}from"./InputLabel-e21345d2.js";import{_ as v}from"./PrimaryButton-0afca82d.js";import{_ as m}from"./TextInput-070d7dd8.js";import"./iconify-59ac6911.js";const h={class:"tw-mt-4"},x={class:"tw-mt-4"},y={class:"tw-flex tw-items-center tw-justify-end tw-mt-4"},T={__name:"ResetPassword",props:{email:String,token:String},setup(p){const n=p,s=u({token:n.token,email:n.email,password:"",password_confirmation:""}),w=()=>{s.post(route("password.store"),{onFinish:()=>s.reset("password","password_confirmation")})};return($,a)=>(c(),f(k,null,{default:d(()=>[o(e(_),{title:"Redefinir senha"}),r("form",{onSubmit:b(w,["prevent"])},[r("div",null,[o(i,{for:"email",value:"E-mail"}),o(m,{id:"email",type:"email",class:"tw-mt-1 tw-block tw-w-full",modelValue:e(s).email,"onUpdate:modelValue":a[0]||(a[0]=t=>e(s).email=t),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(l,{class:"tw-mt-2",message:e(s).errors.email},null,8,["message"])]),r("div",h,[o(i,{for:"password",value:"Senha"}),o(m,{id:"password",type:"password",class:"tw-mt-1 tw-block tw-w-full",modelValue:e(s).password,"onUpdate:modelValue":a[1]||(a[1]=t=>e(s).password=t),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(l,{class:"tw-mt-2",message:e(s).errors.password},null,8,["message"])]),r("div",x,[o(i,{for:"password_confirmation",value:"Confirmar senha"}),o(m,{id:"password_confirmation",type:"password",class:"tw-mt-1 tw-block tw-w-full",modelValue:e(s).password_confirmation,"onUpdate:modelValue":a[2]||(a[2]=t=>e(s).password_confirmation=t),required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(l,{class:"tw-mt-2",message:e(s).errors.password_confirmation},null,8,["message"])]),r("div",y,[o(v,{class:g({"opacity-25":e(s).processing}),disabled:e(s).processing},{default:d(()=>[V(" Redefinir senha ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{T as default};
