import{k as w,T as _,h as v,o as c,f as m,b as a,a as e,u as t,w as i,a0 as g,e as y,d as V,g as x}from"./app-4ab3c1a7.js";import{_ as l}from"./InputError-8e97e87c.js";import{_ as u}from"./InputLabel-e21345d2.js";import{_ as k}from"./PrimaryButton-0afca82d.js";import"./iconify-59ac6911.js";const h=a("header",null,[a("h2",{class:"tw-text-lg tw-font-medium tw-text-gray-900"},"Atualizar senha"),a("p",{class:"tw-mt-1 tw-text-sm tw-text-gray-600"}," Certifique-se de que sua conta esteja usando uma senha longa e aleatória para se manter segura. ")],-1),b={class:"tw-flex tw-items-center tw-gap-4"},S={key:0,class:"tw-text-sm tw-text-gray-600"},T={__name:"UpdatePasswordForm",setup(C){const d=w(null),p=w(null),s=_({current_password:"",password:"",password_confirmation:""}),f=()=>{s.put(route("password.update"),{preserveScroll:!0,onSuccess:()=>s.reset(),onError:()=>{s.errors.password&&(s.reset("password","password_confirmation"),d.value.focus()),s.errors.current_password&&(s.reset("current_password"),p.value.focus())}})};return(N,o)=>{const n=v("q-input");return c(),m("section",null,[h,a("form",{onSubmit:y(f,["prevent"]),class:"tw-mt-6 tw-space-y-6"},[a("div",null,[e(u,{for:"current_password",value:"Senha atual"}),e(n,{outlined:"",id:"current_password",ref_key:"currentPasswordInput",ref:p,modelValue:t(s).current_password,"onUpdate:modelValue":o[0]||(o[0]=r=>t(s).current_password=r),type:"password",class:"tw-mt-1 tw-block tw-w-full",autocomplete:"current-password"},null,8,["modelValue"]),e(l,{message:t(s).errors.current_password,class:"tw-mt-2"},null,8,["message"])]),a("div",null,[e(u,{for:"password",value:"Nova senha"}),e(n,{outlined:"",id:"password",ref_key:"passwordInput",ref:d,modelValue:t(s).password,"onUpdate:modelValue":o[1]||(o[1]=r=>t(s).password=r),type:"password",class:"tw-mt-1 tw-block tw-w-full",autocomplete:"new-password"},null,8,["modelValue"]),e(l,{message:t(s).errors.password,class:"tw-mt-2"},null,8,["message"])]),a("div",null,[e(u,{for:"password_confirmation",value:"Confirmar senha"}),e(n,{outlined:"",id:"password_confirmation",modelValue:t(s).password_confirmation,"onUpdate:modelValue":o[2]||(o[2]=r=>t(s).password_confirmation=r),type:"password",class:"tw-mt-1 tw-block tw-w-full",autocomplete:"new-password"},null,8,["modelValue"]),e(l,{message:t(s).errors.password_confirmation,class:"tw-mt-2"},null,8,["message"])]),a("div",b,[e(k,{disabled:t(s).processing},{default:i(()=>[V("Salvar")]),_:1},8,["disabled"]),e(g,{"enter-from-class":"tw-opacity-0","leave-to-class":"tw-opacity-0",class:"tw-transition tw-ease-in-out"},{default:i(()=>[t(s).recentlySuccessful?(c(),m("p",S,"Salvo.")):x("",!0)]),_:1})])],32)])}}};export{T as default};
