"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[176],{3744:(e,t)=>{t.Z=(e,t)=>{const r=e.__vccOpts||e;for(const[e,n]of t)r[e]=n;return r}},4176:(e,t,r)=>{r.r(t),r.d(t,{default:()=>k});var n=r(821),i={class:"form-group"},s=(0,n._)("label",{for:"exampleInputEmail1",class:"form-label"},"Calcular frete",-1),o=["disabled"],a={key:0,class:""},l={class:""},c=(0,n._)("i",{class:"fas fa-spinner fa-spin"},null,-1),u={key:0,class:"alert alert-danger mt-2"},p={class:"list-group list-group-flush mt-2"},d={key:0,class:"ps-2"},g=(0,n._)("br",null,null,-1),f={key:0};var m=r(894);function h(e){return h="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},h(e)}function y(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function b(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?y(Object(r),!0).forEach((function(t){w(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):y(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function w(e,t,r){return(t=function(e){var t=function(e,t){if("object"!==h(e)||null===e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var n=r.call(e,t||"default");if("object"!==h(n))return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"===h(t)?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const v={props:[],components:{},data:function(){return{errorMessage:"",cartCep:"",sendingCep:"",loading:!1}},computed:b({},(0,m.rn)({selectedAddress:function(e){return e.cart.selectedAddress},shippingMethods:function(e){return e.cart.shippingMethods},total:function(e){return e.cart.total}})),mounted:function(){},methods:b(b({},(0,m.nv)(["shippingValue"])),{},{getShippingValue:function(e){this.errorMessage="";var t={cep:e.replace("-",""),cartPrice:this.total};return this.shippingValue(t)}}),watch:{cartCep:function(){var e=this;if(9===this.cartCep.length){if(this.sendingCep&&this.sendingCep==this.cartCep)return;this.sendingCep=this.cartCep,this.errorMessage="",this.loading=!0,this.getShippingValue(this.cartCep).catch((function(t){var r,n;null!=t&&null!==(r=t.response)&&void 0!==r&&null!==(n=r.data)&&void 0!==n&&n.message&&(e.errorMessage=t.response.data.message)})).finally((function(){return e.loading=!1}))}}}};const k=(0,r(3744).Z)(v,[["render",function(e,t,r,m,h,y){var b=(0,n.Q2)("mask");return(0,n.wg)(),(0,n.iD)(n.HY,null,[(0,n._)("div",i,[s,e.selectedAddress.zip_code?(0,n.kq)("",!0):(0,n.wy)(((0,n.wg)(),(0,n.iD)("input",{key:0,type:"text",id:"cep",class:"form-control","onUpdate:modelValue":t[0]||(t[0]=function(e){return h.cartCep=e}),placeholder:"Digite o CEP",maxlength:"9",disabled:h.loading},null,8,o)),[[n.nr,h.cartCep],[b,"#####-###"]])]),e.selectedAddress.zip_code?(0,n.kq)("",!0):((0,n.wg)(),(0,n.iD)("div",a,[(0,n._)("div",l,[h.loading?((0,n.wg)(),(0,n.iD)(n.HY,{key:0},[c,(0,n.Uk)(" Buscando... ")],64)):((0,n.wg)(),(0,n.iD)(n.HY,{key:1},[h.errorMessage?((0,n.wg)(),(0,n.iD)("div",u,(0,n.zw)(h.errorMessage)+" :( ",1)):(0,n.kq)("",!0),e.shippingMethods.data.length>0?((0,n.wg)(),(0,n.iD)(n.HY,{key:1},[(0,n._)("ul",p,[((0,n.wg)(!0),(0,n.iD)(n.HY,null,(0,n.Ko)(e.shippingMethods.data,(function(e,t){return(0,n.wg)(),(0,n.iD)("li",{class:"list-group-item list-group-item-success",key:t},[(0,n.Uk)((0,n.zw)(e.description)+" : ",1),(0,n._)("strong",null,"R$ "+(0,n.zw)(e.price),1),e.estimation?((0,n.wg)(),(0,n.iD)("ul",d,[(0,n._)("li",null,[(0,n.Uk)("Bairro: "),(0,n._)("strong",null,(0,n.zw)(e.estimation.location),1),g,(0,n._)("span",null,[(0,n.Uk)(" Tempo estimado: "),(0,n._)("strong",null," de "+(0,n.zw)(e.estimation.time_ini)+" a "+(0,n.zw)(e.estimation.time_end)+" "+(0,n.zw)(e.estimation.time_unid),1)])])])):(0,n.kq)("",!0)])})),128))]),e.shippingMethods.data[e.index++]?((0,n.wg)(),(0,n.iD)("hr",f)):(0,n.kq)("",!0)],64)):(0,n.kq)("",!0)],64))])]))],64)}]])}}]);