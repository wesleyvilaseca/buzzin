"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[904,708,947,753],{9188:(e,t,r)=>{r.d(t,{Z:()=>a});var o=r(3645),n=r.n(o)()((function(e){return e[1]}));n.push([e.id,".hover-zoom[data-v-03d8ab28]{cursor:pointer;transition:transform .5s ease}.hover-zoom[data-v-03d8ab28]:hover{transform:scale(1.01)}",""]);const a=n},3744:(e,t)=>{t.Z=(e,t)=>{const r=e.__vccOpts||e;for(const[e,o]of t)r[e]=o;return r}},904:(e,t,r)=>{r.r(t),r.d(t,{default:()=>W});var o=r(821),n=function(e){return(0,o.dD)("data-v-03d8ab28"),e=e(),(0,o.Cn)(),e},a={class:"card mb-2"},i=n((function(){return(0,o._)("div",{class:"card-header text-center"},"Resumo do pedido",-1)})),c={class:"card-body"},s={class:"row"},l={class:"col-md-6 col-sm-12"},d={class:"card"},u=n((function(){return(0,o._)("div",{class:"card-header text-center",style:{"background-color":"#fff"}},[(0,o._)("h5",{class:"fw-bold"},"Como você prefere pagar?")],-1)})),m={class:"card-body"},p={class:"payment-options"},f=["onClick"],h={class:"row"},y={class:"col-md-2"},b={style:{"font-size":"50px"}},v={class:"col-md-8 mt-1"},g={class:"text-muted"},_=n((function(){return(0,o._)("hr",null,null,-1)})),w={key:1,class:"option ps-3 hover-zoom"},S={class:"row"},P={class:"col-md-2"},M={style:{"font-size":"50px"}},O={class:"col-md-8 mt-1"},C={class:"text-muted"},k={key:0,class:"col-md-6 col-sm-12"},E={class:"card"},x={class:"card-header text-center",style:{"background-color":"#fff"}},I={class:""},j={class:"fw-bold"},A={class:"card-body"},D={key:0,class:""},z=n((function(){return(0,o._)("i",{class:"fa-solid fa-chevron-left"},null,-1)})),T={key:1},B={key:2};var N=r(894),F=r(9753),R=r(9708),q=r(3947);function L(e){return L="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},L(e)}function Y(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}function U(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?Y(Object(r),!0).forEach((function(t){V(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):Y(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function V(e,t,r){return(t=function(e){var t=function(e,t){if("object"!==L(e)||null===e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var o=r.call(e,t||"default");if("object"!==L(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"===L(t)?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const Z={props:[],components:{formCreditcard:R.default,formSlip:q.default,ResumeOrderStepComponent:F.default},data:function(){return{paymentIntegrationMethodSelected:{id:""},paymentsMethods:[{id:1,title:"Cartão",description:"Crédito ou Débito",icon:"fa-solid fa-credit-card",flag:"credit_card"},{id:2,title:"Boleto bancário",description:" Pagamento aprovado em 1 ou 2 dias uteis",icon:"fa-solid fa-barcode",flag:"slip"}]}},computed:U(U({},(0,N.rn)({selectedPaymentMethod:function(e){return e.cart.selectedPaymentMethod}})),{},{mpConfig:function(){return JSON.parse(this.selectedPaymentMethod.data)}}),created:function(){this.mpConfig.card||this.removeItemFromArray(1),this.mpConfig.slip||this.removeItemFromArray(2)},methods:{setSelectedPaymentMethod:function(e){this.paymentIntegrationMethodSelected=e},removeItemFromArray:function(e){var t=this.paymentsMethods.findIndex((function(t){return t.id===e}));-1!==t&&this.paymentsMethods.splice(t,1)}}};var H=r(3379),K=r.n(H),J=r(9188),Q={insert:"head",singleton:!1};K()(J.Z,Q);J.Z.locals;const W=(0,r(3744).Z)(Z,[["render",function(e,t,r,n,N,F){var R,q,L=(0,o.up)("ResumeOrderStepComponent"),Y=(0,o.up)("formCreditcard"),U=(0,o.up)("formSlip");return(0,o.wg)(),(0,o.iD)(o.HY,null,[(0,o._)("div",a,[i,(0,o._)("div",c,[(0,o.Wm)(L,{showDefaultCreateOrderBtn:!1})])]),(0,o._)("div",s,[(0,o._)("div",l,[(0,o._)("div",d,[u,(0,o._)("div",m,[(0,o._)("div",p,[e.paymentIntegrationMethodSelected.id?((0,o.wg)(),(0,o.iD)("div",w,[(0,o._)("div",S,[(0,o._)("div",P,[(0,o._)("span",M,[(0,o._)("i",{class:(0,o.C_)(e.paymentIntegrationMethodSelected.icon)},null,2)])]),(0,o._)("div",O,[(0,o._)("h6",null,(0,o.zw)(e.paymentIntegrationMethodSelected.title),1),(0,o._)("p",C,(0,o.zw)(e.paymentIntegrationMethodSelected.description),1)])])])):((0,o.wg)(!0),(0,o.iD)(o.HY,{key:0},(0,o.Ko)(e.paymentsMethods,(function(e,t){return(0,o.wg)(),(0,o.iD)("div",{class:"option ps-3 hover-zoom",key:t,onClick:(0,o.iM)((function(t){return F.setSelectedPaymentMethod(e)}),["prevent"])},[(0,o._)("div",h,[(0,o._)("div",y,[(0,o._)("span",b,[(0,o._)("i",{class:(0,o.C_)(e.icon)},null,2)])]),(0,o._)("div",v,[(0,o._)("h6",null,(0,o.zw)(e.title),1),(0,o._)("p",g,(0,o.zw)(e.description),1)])]),_],8,f)})),128))])])])]),e.paymentIntegrationMethodSelected.id?((0,o.wg)(),(0,o.iD)("div",k,[(0,o._)("div",E,[(0,o._)("div",x,[(0,o._)("div",I,[(0,o._)("h5",j,(0,o.zw)(e.paymentIntegrationMethodSelected.title),1)])]),(0,o._)("div",A,[e.paymentIntegrationMethodSelected.id?((0,o.wg)(),(0,o.iD)("div",D,[(0,o._)("span",{class:"badge bg-dark text-light",onClick:t[0]||(t[0]=(0,o.iM)((function(e){return F.setSelectedPaymentMethod("")}),["prevent"])),style:{cursor:"pointer"}},[z,(0,o.Uk)(" Mudar ")])])):(0,o.kq)("",!0),e.paymentIntegrationMethodSelected.id&&"credit_card"==(null===(R=e.paymentIntegrationMethodSelected)||void 0===R?void 0:R.flag)?((0,o.wg)(),(0,o.iD)("div",T,[(0,o.Wm)(Y)])):(0,o.kq)("",!0),e.paymentIntegrationMethodSelected.id&&"slip"==(null===(q=e.paymentIntegrationMethodSelected)||void 0===q?void 0:q.flag)?((0,o.wg)(),(0,o.iD)("div",B,[(0,o.Wm)(U)])):(0,o.kq)("",!0)])])])):(0,o.kq)("",!0)])],64)}],["__scopeId","data-v-03d8ab28"]])},9708:(e,t,r)=>{r.r(t),r.d(t,{default:()=>D});var o=r(821),n={id:"pay"},a={class:"row"},i={class:"form-group mt-2 col-md-8"},c=(0,o._)("label",{class:"mb-1"},[(0,o._)("span",null,[(0,o._)("img",{id:"secure_thumbnail"})]),(0,o.Uk)(" Número do cartão: ")],-1),s={class:"form-group mt-2 col-md-4"},l=(0,o._)("label",{class:"mb-1"},"Vencimento:",-1),d=["value"],u=["value"],m=(0,o._)("input",{type:"hidden",id:"paymentMethodId"},null,-1),p=(0,o._)("input",{type:"hidden",id:"transactionAmount",value:"100"},null,-1),f=(0,o._)("div",{class:"form-group mt-2 col-md-8"},[(0,o._)("label",{class:"mb-1"},"Nome impresso no cartão:"),(0,o._)("input",{type:"text",id:"cardholderName",placeholder:"",class:"text-uppercase form-control form-control-sm","data-checkout":"cardholderName"})],-1),h={class:"form-group mt-2 col-md-4"},y=(0,o._)("label",{class:"mb-1"},"CVV:",-1),b={type:"text",id:"securityCode",placeholder:"",class:"form-control form-control-sm","data-checkout":"securityCode"},v={class:"form-group mt-2 col-md-12"},g=[(0,o._)("label",{class:"mb-1"},"Parcelas:",-1),(0,o._)("select",{class:"form-select form-select-sm",id:"installments"},null,-1)],_=(0,o._)("div",{class:"form-group mt-2 col-md-12"},[(0,o._)("label",{class:"mb-1"},"EMAIL:"),(0,o._)("input",{type:"email",id:"email",placeholder:"",class:"form-control form-control-sm"})],-1),w={class:"form-group mt-2 col-md-12"},S=(0,o._)("label",{class:"mb-1"},"CPF:",-1),P=(0,o._)("input",{id:"docType",value:"CPF","data-checkout":"docType",type:"hidden"},null,-1),M=["value"],O={class:"text-right mt-2 d-grid gap-2"};var C=r(894),k=r(8874);function E(e){return E="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},E(e)}function x(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}function I(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?x(Object(r),!0).forEach((function(t){j(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):x(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function j(e,t,r){return(t=function(e){var t=function(e,t){if("object"!==E(e)||null===e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var o=r.call(e,t||"default");if("object"!==E(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"===E(t)?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const A={props:[],components:{},data:function(){return{token_name:"buzzin",cardnumber:"",cpf:"",expiration:"",card_expiration:{expirationMonth:"",expirationYear:""},showstallmants:!1,paymentMethodId:""}},computed:I(I({},(0,C.rn)({selectedPaymentMethod:function(e){return e.cart.selectedPaymentMethod},selectedAddress:function(e){return e.cart.selectedAddress},products:function(e){return e.cart.products.data},shippingMethods:function(e){return e.cart.shippingMethods},comment:function(e){return e.cart.comment},troco:function(e){return e.cart.troco},precisa_troco:function(e){return e.cart.precisa_troco},selectedShippingMethod:function(e){return e.cart.selectedShippingMethod},company:function(e){return e.tenant.company}})),{},{mpConfig:function(){return JSON.parse(this.selectedPaymentMethod.data)}}),mounted:function(){},created:function(){this.startMp()},methods:I(I({},(0,C.OI)({clearCart:"CLEAR_CART",setPreloader:"SET_PRELOADER",setTextPreloader:"SET_TEXT_PRELOADER"})),{},{startMp:function(){var e=this,t=document.createElement("script");t.src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js",t.addEventListener("load",(function(){window.Mercadopago.setPublishableKey(e.mpConfig.public_key)})),document.body.appendChild(t);var r=document.querySelector("iframe");r&&(document.body.removeChild(r),document.body.removeChild(t))},_payCard:function(){document.getElementById("docNumber").value=this.cpf.replace(/[^a-zA-Z0-9]/g,""),document.getElementById("docType").value="CPF",window.Mercadopago.createToken(document.getElementById("pay"),this.setCardTokenAndPay)},setCardTokenAndPay:function(e,t){var r=this;if(200==e||201==e){var o;this.setTextPreloader("Finalizando pedido...");var n=document.getElementById("installments"),a={address:this.selectedAddress,products:this.products,shippingMethod:this.selectedShippingMethod,comment:this.comment,paymentMethod:this.selectedPaymentMethod,precisaTroco:this.precisa_troco?"Y":"N",troco:this.troco?this.troco:0,payment_integration_params:{token:t.id,payment_method_id:this.paymentMethodId,first_name:this.firstname,last_name:this.lastname,email:document.getElementById("email").value,cpf:this.cpf.replace(/[^a-zA-Z0-9]/g,""),installments:null!==(o=null==n?void 0:n.value)&&void 0!==o?o:1}},i=localStorage.getItem(this.token_name),c=new URLSearchParams({token_company:this.company.uuid}).toString(),s="/api/auth/v1/mp-order?".concat(c);return axios.post(s,a,{headers:{Authorization:"Bearer ".concat(i)}}).then((function(e){var t=e.data.data;k.Am.success("Pedido realizado com sucesso",{autoClose:3e3}),r.clearCart(r.company.uuid),window.location.href="http://".concat(r.company.domain,"/app/cliente-area?identify=").concat(t.identify)})).catch((function(e){if(null!=e&&e.response){var t=e.response;r.errors=Object.assign(r.errors,t.data.errors)}k.Am.error("Falha ao gerar boleto, tente novamente",{autoClose:5e3})})).finally((function(){r.setTextPreloader("Carregando...")}))}this._setError(t.cause[0].code)},setPaymentMethod:function(e,t){200==e?(this.paymentMethodId=t[0].id,document.getElementById("secure_thumbnail").src=t[0].secure_thumbnail):alert("".concat(t))},getIssuers:function(e){window.Mercadopago.getIssuers(e,this.setIssuers)},setIssuers:function(e,t){if(200==e){var r=document.getElementById("issuer");t.forEach((function(e){var t=document.createElement("option");t.text=e.name,t.value=e.id,r.appendChild(t)}))}else alert("issuers method info error: ".concat(t))},getInstallments:function(){window.Mercadopago.getInstallments({payment_method_id:this.paymentMethodId,amount:parseFloat(document.getElementById("transactionAmount").value),issuer_id:25},this.setInstallments)},setInstallments:function(e,t){200==e?(this.showstallmants=!0,document.getElementById("installments").options.length=0,t[0].payer_costs.forEach((function(e){var t=document.createElement("option");t.text=e.recommended_message,t.value=e.installments,document.getElementById("installments").appendChild(t)}))):this.showstallmants=!1},_setError:function(e){"205"===e&&k.Am.error("Digite o número do seu cartão.",{autoClose:3e3}),"E301"===e&&k.Am.error("Número do cartão inválido.",{autoClose:3e3}),"E302"===e&&k.Am.error("Confira o código de segurança.",{autoClose:3e3}),"221"===e&&k.Am.error("Digite o nome impresso no cartão.",{autoClose:3e3}),"208"!==e&&"209"!==e||k.Am.error("Digite o vencimento cartão.",{autoClose:3e3}),"325"!==e&&"326"!==e||k.Am.error("Vencimento do cartão inválido.",{autoClose:3e3}),"214"===e&&k.Am.error("Informe o número do seu CPF.",{autoClose:3e3}),"324"===e&&k.Am.error("Número do CPF inválido.",{autoClose:3e3})},clearCardForm:function(){document.getElementById("cardNumber").value="",document.getElementById("secure_thumbnail").src="",document.getElementById("cardExpirationMonth").value="",document.getElementById("cardExpirationYear").value="",document.getElementById("paymentMethodId").value="",document.getElementById("cardholderName").value="",document.getElementById("securityCode").value="",document.getElementById("email").value="",document.getElementById("docType").value="",document.getElementById("docNumber").value="",this.cardnumber="",this.cpf="",this.expiration="",this.card_expiration={expirationMonth:"",expirationYear:""},this.showstallmants=!1,this.startMp()}}),watch:{cardnumber:function(){var e=this.cardnumber.replace(/\s/g,"");e.length>=7&&window.Mercadopago.getPaymentMethod({bin:e.substring(0,6)},this.setPaymentMethod),16==e.length&&document.getElementById("paymentMethodId").value&&this.getInstallments()},paymentMethodId:function(){16==this.cardnumber.replace(/\s/g,"").length&&this.paymentMethodId&&this.getInstallments()},expiration:function(){if(this.expiration.includes("/")){var e=this.expiration.split("/");this.card_expiration.expirationMonth=e[0],this.card_expiration.expirationYear=e[1]}}}};const D=(0,r(3744).Z)(A,[["render",function(e,t,r,C,k,E){var x=(0,o.Q2)("mask");return(0,o.wg)(),(0,o.iD)("form",n,[(0,o._)("div",a,[(0,o._)("div",i,[c,(0,o.wy)((0,o._)("input",{type:"text",id:"cardNumber",placeholder:"____ ____ ____ ____","onUpdate:modelValue":t[0]||(t[0]=function(t){return e.cardnumber=t}),class:"form-control form-control-sm","data-checkout":"cardNumber"},null,512),[[x,"#### #### #### ####"],[o.nr,e.cardnumber]])]),(0,o._)("div",s,[l,(0,o.wy)((0,o._)("input",{type:"text","onUpdate:modelValue":t[1]||(t[1]=function(t){return e.expiration=t}),placeholder:"",class:"form-control form-control-sm"},null,512),[[o.nr,e.expiration],[x,"##/####"]]),(0,o._)("input",{type:"hidden",id:"cardExpirationMonth",value:e.card_expiration.expirationMonth,"data-checkout":"cardExpirationMonth"},null,8,d),(0,o._)("input",{type:"hidden",id:"cardExpirationYear",value:e.card_expiration.expirationYear,"data-checkout":"cardExpirationYear"},null,8,u),m,p]),f,(0,o._)("div",h,[y,(0,o.wy)((0,o._)("input",b,null,512),[[x,"###"]])]),(0,o.wy)((0,o._)("div",v,g,512),[[o.F8,e.showstallmants]]),_,(0,o._)("div",w,[S,(0,o.wy)((0,o._)("input",{type:"text","onUpdate:modelValue":t[2]||(t[2]=function(t){return e.cpf=t}),placeholder:"",class:"form-control form-control-sm"},null,512),[[o.nr,e.cpf],[x,"###.###.###-##"]]),P,(0,o._)("input",{id:"docNumber",value:e.cpf,"data-checkout":"docNumber",type:"hidden"},null,8,M)]),(0,o._)("div",O,[(0,o._)("button",{type:"submit",id:"form-checkout__submit",class:"btn btn-success",onClick:t[3]||(t[3]=(0,o.iM)((function(){return E._payCard&&E._payCard.apply(E,arguments)}),["prevent"]))}," Pagar")])])])}]])},3947:(e,t,r)=>{r.r(t),r.d(t,{default:()=>E});var o=r(821),n={id:"pay"},a={class:"row"},i={class:"form-group mt-2 col-md-12"},c=(0,o._)("label",{class:"mb-1"}," Nome ",-1),s={key:0,class:"form-text text-danger"},l={class:"form-group mt-2 col-md-12"},d=(0,o._)("label",{class:"mb-1"}," Sobrenome ",-1),u={key:0,class:"form-text text-danger"},m={class:"form-group mt-2 col-md-12"},p=(0,o._)("label",{class:"mb-1"},"EMAIL:",-1),f={key:0,class:"form-text text-danger"},h={class:"form-group mt-2 col-md-12"},y=(0,o._)("label",{class:"mb-1"},"CPF:",-1),b={key:0,class:"form-text text-danger"},v=(0,o._)("input",{id:"docType",value:"CPF","data-checkout":"docType",type:"hidden"},null,-1),g=["value"],_={class:"text-right mt-2 d-grid gap-2"};var w=r(894),S=r(8874);function P(e){return P="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},P(e)}function M(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}function O(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?M(Object(r),!0).forEach((function(t){C(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):M(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function C(e,t,r){return(t=function(e){var t=function(e,t){if("object"!==P(e)||null===e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var o=r.call(e,t||"default");if("object"!==P(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"===P(t)?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const k={props:[],components:{},data:function(){return{token_name:"buzzin",canSave:!1,firstname:"",lastname:"",cpf:"",email:"",errors:{cpf:"",firstname:"",lastname:"",email:""}}},computed:O(O({},(0,w.rn)({selectedPaymentMethod:function(e){return e.cart.selectedPaymentMethod},selectedAddress:function(e){return e.cart.selectedAddress},products:function(e){return e.cart.products.data},shippingMethods:function(e){return e.cart.shippingMethods},comment:function(e){return e.cart.comment},troco:function(e){return e.cart.troco},precisa_troco:function(e){return e.cart.precisa_troco},selectedShippingMethod:function(e){return e.cart.selectedShippingMethod},company:function(e){return e.tenant.company}})),{},{mpConfig:function(){return JSON.parse(this.selectedPaymentMethod.data)}}),created:function(){var e=this,t=document.createElement("script");t.src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js",t.addEventListener("load",(function(){window.Mercadopago.setPublishableKey(e.mpConfig.public_key)})),document.body.appendChild(t);var r=document.querySelector("iframe");r&&(document.body.removeChild(r),document.body.removeChild(t))},methods:O(O({},(0,w.OI)({clearCart:"CLEAR_CART",setPreloader:"SET_PRELOADER",setTextPreloader:"SET_TEXT_PRELOADER"})),{},{pay:function(){var e=this;if(this.reset(),this.validateForm(),this.canSave){var t={address:this.selectedAddress,products:this.products,shippingMethod:this.selectedShippingMethod,comment:this.comment,paymentMethod:this.selectedPaymentMethod,precisaTroco:this.precisa_troco?"Y":"N",troco:this.troco?this.troco:0,payment_integration_params:{first_name:this.firstname,last_name:this.lastname,payment_method_id:"slip",email:this.email,cpf:this.cpf.replace(/[^a-zA-Z0-9]/g,"")}},r=localStorage.getItem(this.token_name);this.setTextPreloader("Finalizando pedido...");var o=new URLSearchParams({token_company:this.company.uuid}).toString(),n="/api/auth/v1/mp-order?".concat(o);return axios.post(n,t,{headers:{Authorization:"Bearer ".concat(r)}}).then((function(t){var r=t.data.data;S.Am.success("Pedido realizado com sucesso",{autoClose:3e3}),e.clearCart(e.company.uuid),window.location.href="http://".concat(e.company.domain,"/app/cliente-area?identify=").concat(r.identify)})).catch((function(t){if(null!=t&&t.response){var r=t.response;e.errors=Object.assign(e.errors,r.data.errors)}S.Am.error("Falha ao gerar boleto, tente novamente",{autoClose:5e3})})).finally((function(){e.setTextPreloader("Carregando...")}))}},validateForm:function(){var e;return this.firstname?this.lastname?this.email?this.cpf?(null===(e=this.cpf)||void 0===e?void 0:e.length)<14?(this.canSave=!1,this.errors.cpf=["A quantida de caracteres informádo é inválido"]):void(this.canSave=!0):(this.canSave=!1,this.errors.cpf=["O CPF é um campo obrigatório"]):(this.canSave=!1,this.errors.email=["O email é um campo obrigatório"]):(this.canSave=!1,this.errors.lastname=["O sobrenome é um campo obrigatório"]):(this.canSave=!1,this.errors.firstname=["O nome é um campo obrigatório"])},clearCardForm:function(){this.firstname="",this.lastname="",this.cpf="",this.email=""},reset:function(){this.canSave=!1,this.errors={cpf:"",firstname:"",lastname:"",email:""}},b64:function(e){return btoa(encodeURIComponent(e).replace(/%([0-9A-F]{2})/g,(function(e,t){return String.fromCharCode("0x"+t)})))},b64D:function(e){return decodeURIComponent(atob(e).split("").map((function(e){return"%"+("00"+e.charCodeAt(0).toString(16)).slice(-2)})).join(""))},reverse:function(e){return e.split("").reverse().join("")},decode:function(e){e=this.reverse(e);for(var t=0;10!==t;)e=this.b64D(e),t++;return e},encode:function(e){for(var t=0;10!==t;)e=this.b64(e),t++;return this.reverse(e)}})};const E=(0,r(3744).Z)(k,[["render",function(e,t,r,w,S,P){var M=(0,o.Q2)("mask");return(0,o.wg)(),(0,o.iD)("form",n,[(0,o._)("div",a,[(0,o._)("div",i,[c,(0,o.wy)((0,o._)("input",{type:"text","onUpdate:modelValue":t[0]||(t[0]=function(t){return e.firstname=t}),class:"form-control form-control-sm"},null,512),[[o.nr,e.firstname]]),""!=e.errors.firstname?((0,o.wg)(),(0,o.iD)("div",s,(0,o.zw)(e.errors.firstname[0]||""),1)):(0,o.kq)("",!0)]),(0,o._)("div",l,[d,(0,o.wy)((0,o._)("input",{type:"text","onUpdate:modelValue":t[1]||(t[1]=function(t){return e.lastname=t}),class:"form-control form-control-sm"},null,512),[[o.nr,e.lastname]]),""!=e.errors.lastname?((0,o.wg)(),(0,o.iD)("div",u,(0,o.zw)(e.errors.lastname[0]||""),1)):(0,o.kq)("",!0)]),(0,o._)("div",m,[p,(0,o.wy)((0,o._)("input",{type:"email","onUpdate:modelValue":t[2]||(t[2]=function(t){return e.email=t}),class:"form-control form-control-sm"},null,512),[[o.nr,e.email]]),""!=e.errors.email?((0,o.wg)(),(0,o.iD)("div",f,(0,o.zw)(e.errors.email[0]||""),1)):(0,o.kq)("",!0)]),(0,o._)("div",h,[y,(0,o.wy)((0,o._)("input",{type:"text","onUpdate:modelValue":t[3]||(t[3]=function(t){return e.cpf=t}),class:"form-control form-control-sm"},null,512),[[o.nr,e.cpf],[M,"###.###.###-##"]]),""!=e.errors.cpf?((0,o.wg)(),(0,o.iD)("div",b,(0,o.zw)(e.errors.cpf[0]||""),1)):(0,o.kq)("",!0),v,(0,o._)("input",{id:"docNumber",value:e.cpf,"data-checkout":"docNumber",type:"hidden"},null,8,g)]),(0,o._)("div",_,[(0,o._)("button",{type:"submit",id:"form-checkout__submit",class:"btn btn-success",onClick:t[4]||(t[4]=(0,o.iM)((function(){return P.pay&&P.pay.apply(P,arguments)}),["prevent"]))}," Pagar ")])])])}]])},9753:(e,t,r)=>{r.r(t),r.d(t,{default:()=>g});var o=r(821),n={class:"table"},a=(0,o._)("thead",null,[(0,o._)("tr",null,[(0,o._)("th",{scope:"col"},"Produto"),(0,o._)("th",{scope:"col"},"Quantidade"),(0,o._)("th",{scope:"col"},"Valor"),(0,o._)("th",{scope:"col"},"Total")])],-1),i=(0,o._)("td",{colspan:"3",class:"text-right"},[(0,o._)("strong",null,"Subtotal")],-1),c={colspan:"3",class:"text-right"},s=(0,o._)("td",{colspan:"3",class:"text-right"},[(0,o._)("strong",null," Total ")],-1),l={colspan:"2"},d={key:0,colspan:"2"},u={key:0,class:"text-end mt-2"};var m=r(894),p=r(8874);function f(e){return f="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},f(e)}function h(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,o)}return r}function y(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?h(Object(r),!0).forEach((function(t){b(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):h(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}function b(e,t,r){return(t=function(e){var t=function(e,t){if("object"!==f(e)||null===e)return e;var r=e[Symbol.toPrimitive];if(void 0!==r){var o=r.call(e,t||"default");if("object"!==f(o))return o;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===t?String:Number)(e)}(e,"string");return"symbol"===f(t)?t:String(t)}(t))in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}const v={props:{showDefaultCreateOrderBtn:{type:Boolean,default:!0}},components:{},data:function(){return{}},computed:y({},(0,m.rn)({step:function(e){return e.cart.step},products:function(e){return e.cart.products.data},subtotal:function(e){return e.cart.subtotal},total:function(e){return e.cart.total},company:function(e){return e.tenant.company},me:function(e){return e.auth.me},address:function(e){return e.auth.address},selectedAddress:function(e){return e.cart.selectedAddress},selectedShippingMethod:function(e){return e.cart.selectedShippingMethod},selectedPaymentMethod:function(e){return e.cart.selectedPaymentMethod},troco:function(e){return e.cart.troco},precisa_troco:function(e){return e.cart.precisa_troco},comment:function(e){return e.cart.comment}})),mounted:function(){},methods:y(y(y({},(0,m.OI)({clearCart:"CLEAR_CART",setStep:"SET_STEP"})),(0,m.nv)(["sendCheckout"])),{},{createOrder:function(){if(!this.selectedPaymentMethod.integration)return this.defaultCreateOrder();this.setStep(4)},defaultCreateOrder:function(){var e=this,t={tenant_uuid:this.company.uuid,address:this.selectedAddress,products:this.products,shippingMethod:this.selectedShippingMethod,comment:this.comment,paymentMethod:this.selectedPaymentMethod,precisaTroco:this.precisa_troco?"Y":"N",troco:this.troco?this.troco:0};this.sendCheckout(t).then((function(t){var r=t.data.data;p.Am.success("Pedido realizado com sucesso",{autoClose:3e3}),e.clearCart(e.company.uuid),window.location.href="http://".concat(e.company.domain,"/app/cliente-area?identify=").concat(r.identify)})).catch((function(e){p.Am.error("Falha na operação, tente novamente",{autoClose:5e3})}))},moneyMask:function(e){return"number"!=typeof e?e:new Intl.NumberFormat("pt-BR",{style:"currency",currency:"BRL"}).format(e)}})};const g=(0,r(3744).Z)(v,[["render",function(e,t,r,m,p,f){return(0,o.wg)(),(0,o.iD)(o.HY,null,[(0,o._)("table",n,[a,(0,o._)("tbody",null,[((0,o.wg)(!0),(0,o.iD)(o.HY,null,(0,o.Ko)(e.products,(function(e,t){return(0,o.wg)(),(0,o.iD)("tr",{key:t},[(0,o._)("td",null,(0,o.zw)(e.item.description),1),(0,o._)("td",null,(0,o.zw)(f.moneyMask(e.item.price)),1),(0,o._)("td",null,(0,o.zw)(e.qty),1),(0,o._)("td",null,(0,o.zw)(f.moneyMask(e.qty*e.item.price)),1)])})),128))]),(0,o._)("tfoot",null,[(0,o._)("tr",null,[i,(0,o._)("td",null,(0,o.zw)(f.moneyMask(e.subtotal)),1)]),(0,o._)("tr",null,[(0,o._)("td",c,[(0,o._)("strong",null,(0,o.zw)(e.selectedShippingMethod.description),1)]),(0,o._)("td",null,(0,o.zw)(f.moneyMask(e.selectedShippingMethod.price)),1)]),(0,o._)("tr",null,[s,(0,o._)("td",null,(0,o.zw)(f.moneyMask(e.total)),1)]),(0,o._)("tr",null,[(0,o._)("td",l," Forma de pagamento: "+(0,o.zw)(e.selectedPaymentMethod.description),1)]),(0,o._)("tr",null,["pagar-em-dinheiro"==e.selectedPaymentMethod.tag&&e.troco>0?((0,o.wg)(),(0,o.iD)("td",d," Troco para: "+(0,o.zw)(f.moneyMask(e.troco)),1)):(0,o.kq)("",!0)])])]),r.showDefaultCreateOrderBtn?((0,o.wg)(),(0,o.iD)("div",u,[(0,o._)("button",{class:"btn btn-success btn-sm",onClick:t[0]||(t[0]=(0,o.iM)((function(e){return f.createOrder()}),["prevent"]))},"Finalizar pedido")])):(0,o.kq)("",!0)],64)}]])}}]);