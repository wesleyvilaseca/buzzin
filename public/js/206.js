"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[206,307,994,660],{8895:(t,e,n)=>{n.d(e,{A:()=>l});var r=n(834);function o(t){return o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},o(t)}function a(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function i(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?a(Object(n),!0).forEach((function(e){c(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):a(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function c(t,e,n){return(e=function(t){var e=function(t,e){if("object"!=o(t)||!t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!=o(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"==o(e)?e:e+""}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}const l={data:function(){return{counter:0,loading:!1}},computed:i({},(0,r.aH)({preloader:function(t){return t.preloader.preloader},textPreloader:function(t){return t.preloader.textPreloader}})),methods:i(i({},(0,r.PY)({setPreloader:"SET_PRELOADER",setTextPreloader:"SET_TEXT_PRELOADER"})),{},{stop:function(){console.log("aqiu")}}),mounted:function(){var t=this;window.axios.interceptors.request.use((function(e){return t.counter++,t.setPreloader(!0),e}),(function(e){return t.setPreloader(!1),Promise.reject(e)})),window.axios.interceptors.response.use((function(e){return t.counter--,0==t.counter&&t.setPreloader(!1),e}),(function(e){return t.setPreloader(!1),Promise.reject(e)}))}}},62:(t,e,n)=>{n.d(e,{X:()=>l});var r=n(9726),o=n(9910),a={key:0,class:"preloader"},i=(0,r.Lk)("img",{src:o.A,alt:"Carregando...",style:{"max-width":"80px"}},null,-1),c={class:"fw-bold"};function l(t,e,n,o,l,u){return t.preloader?((0,r.uX)(),(0,r.CE)("div",a,[i,(0,r.Lk)("p",c,(0,r.v_)(t.textPreloader),1)])):(0,r.Q3)("",!0)}},5473:(t,e,n)=>{n.d(e,{A:()=>a});var r=n(6314),o=n.n(r)()((function(t){return t[1]}));o.push([t.id,".float[data-v-aa2baf66]{background-color:#25d366;border-radius:50px;bottom:40px;box-shadow:2px 2px 3px #999;color:#fff;font-size:30px;height:60px;position:fixed;right:40px;text-align:center;width:60px;z-index:100}.my-float[data-v-aa2baf66]{margin-top:16px}",""]);const a=o},375:(t,e,n)=>{n.d(e,{A:()=>a});var r=n(6314),o=n.n(r)()((function(t){return t[1]}));o.push([t.id,".brand_card[data-v-6769b16f]{cursor:pointer;transition:all .4s ease-in-out}",""]);const a=o},1235:(t,e,n)=>{n.d(e,{A:()=>a});var r=n(6314),o=n.n(r)()((function(t){return t[1]}));o.push([t.id,".modal-fade-enter[data-v-629a64f3],.modal-fade-leave-to[data-v-629a64f3]{opacity:0}.modal-backdrop[data-v-629a64f3]{z-index:-1!important}.modal-fade-enter-active[data-v-629a64f3],.modal-fade-leave-active[data-v-629a64f3]{transition:opacity .5s ease}.modalVue[data-v-629a64f3]{background-color:rgba(0,0,0,.6);display:none;height:100%;left:0;overflow:auto;position:fixed;top:0;width:100%;z-index:99!important}.modalVue.open[data-v-629a64f3]{display:block}.modalVue .modal-content[data-v-629a64f3]{border:1px solid #171717;margin:15% auto;padding:20px;width:80%}.modalVue .modal-content .close[data-v-629a64f3]{color:#aaa;float:right;font-size:28px;font-weight:700}.modalVue .modal-content .close[data-v-629a64f3]:focus,.modalVue .modal-content .close[data-v-629a64f3]:hover{color:#000;cursor:pointer;text-decoration:none}.modalVue .modal-footer[data-v-629a64f3]{padding:10px 0 0!important}.modalVue .modal-body[data-v-629a64f3],.modalVue .modal-header[data-v-629a64f3]{padding:10px 0!important}.modalVue .modal-header h5[data-v-629a64f3]{font-size:1.1em;padding-top:4px}.card[data-v-629a64f3]{margin-bottom:0!important;padding-bottom:0!important}",""]);const a=o},9485:(t,e,n)=>{n.d(e,{A:()=>a});var r=n(6314),o=n.n(r)()((function(t){return t[1]}));o.push([t.id,"element.style[data-v-4b893250]{padding:10px 0}.border-footer hr[data-v-4b893250]{color:#faebd7}.social-footer-links li a[data-v-4b893250],.title-section-footer[data-v-4b893250]{color:var(--136c5981)!important}.social-footer-links li a[data-v-4b893250]:hover{color:var(--2d13a0fe)!important}",""]);const a=o},3351:(t,e,n)=>{n.d(e,{A:()=>a});var r=n(6314),o=n.n(r)()((function(t){return t[1]}));o.push([t.id,".nav-cart[data-v-2cf1de2f]{background:var(--2003c910)!important}.nav-cart[data-v-2cf1de2f]:hover{background:var(--e6922d66)!important}.nav-link[data-v-2cf1de2f]{color:var(--c73335ee)!important}.nav-link[data-v-2cf1de2f]:hover{color:var(--dd2e32f4)!important}.nav-link .white-icon[data-v-2cf1de2f]{color:#fff!important}.nav-link .red-icon[data-v-2cf1de2f]{color:red!important}",""]);const a=o},5469:(t,e,n)=>{n.d(e,{A:()=>a});var r=n(6314),o=n.n(r)()((function(t){return t[1]}));o.push([t.id,".login_btn[data-v-62569a30]{background:var(--045771be)!important;border-radius:50px;color:#fff!important}.login_btn[data-v-62569a30]:hover{background:var(--ba0a52c4)!important}.input-group-text[data-v-62569a30]{background:var(--1802939a)!important;border-color:var(--1802939a);border-radius:.25rem 0 0 .25rem!important;color:#fff!important}.input-group[data-v-62569a30]:focus{border-color:var(--1802939a);box-shadow:none;outline:0}",""]);const a=o},9910:(t,e,n)=>{n.d(e,{A:()=>r});const r="/images/preloader.gif?30c0aa7c3e2579d868a66dccd1cf70bb"},6262:(t,e)=>{e.A=(t,e)=>{const n=t.__vccOpts||t;for(const[t,r]of e)n[t]=r;return n}},775:(t,e,n)=>{n.d(e,{A:()=>a});var r=n(8427),o=n(770);const a=(0,n(6262).A)(o.A,[["render",r.X]])},5816:(t,e,n)=>{n.d(e,{A:()=>s});var r=n(9726),o=[(0,r.Fv)('<div class="card-body text-center brand_card" data-v-6769b16f><div class="card-title" data-v-6769b16f><small data-v-6769b16f>Uma plataforma</small></div><p class="card-text" data-v-6769b16f><h5 class="fw-bold" data-v-6769b16f>Buzz<span class="fw-bold" style="color:#0d6efd;" data-v-6769b16f>In</span></h5></p></div>',1)];const a={props:[],components:{},data:function(){return{}},computed:{},mounted:function(){},created:function(){},methods:{redirect:function(){return window.open("http://buzzin.com.br","_blank")}}};var i=n(5072),c=n.n(i),l=n(375),u={insert:"head",singleton:!1};c()(l.A,u);l.A.locals;const s=(0,n(6262).A)(a,[["render",function(t,e,n,a,i,c){return(0,r.uX)(),(0,r.CE)("div",{class:"card p-0 ms-2",style:{width:"11rem"},onClick:e[0]||(e[0]=function(t){return c.redirect()})},o)}],["__scopeId","data-v-6769b16f"]])},2538:(t,e,n)=>{n.d(e,{A:()=>y});var r=n(9726),o={name:"modal-fade"},a=["id"],i={class:"bs-example-modal-center show"},c={class:"modal-content"},l={class:"modal-header"},u={class:"modal-title mt-0"},s={class:"modal-body"},d=function(t){return(0,r.Qi)("data-v-629a64f3"),t=t(),(0,r.jt)(),t}((function(){return(0,r.Lk)("p",null,"Conteudo aqui...",-1)}));const f={name:"Modal",props:{id:String,modalSize:String,showClose:{type:Boolean,default:!0},title:{type:String,required:!1,default:""}},methods:{close:function(){this.$emit("close")}}};var p=n(5072),m=n.n(p),v=n(1235),b={insert:"head",singleton:!1};m()(v.A,b);v.A.locals;const y=(0,n(6262).A)(f,[["render",function(t,e,n,f,p,m){return(0,r.uX)(),(0,r.CE)("div",o,[(0,r.Lk)("div",{class:"modalVue open",id:"".concat(n.id)},[(0,r.Lk)("div",i,[(0,r.Lk)("div",{class:(0,r.C4)(["modal-dialog modal-dialog-centered",n.modalSize?n.modalSize:"modal-xl"]),role:"document"},[(0,r.Lk)("div",c,[(0,r.Lk)("div",l,[(0,r.Lk)("h5",u,(0,r.v_)(n.title),1),n.showClose?((0,r.uX)(),(0,r.CE)("button",{key:0,type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close",onClick:e[0]||(e[0]=function(t){return m.close()})})):(0,r.Q3)("",!0)]),(0,r.Lk)("div",s,[(0,r.RG)(t.$slots,"content",{},(function(){return[d]}),!0)]),(0,r.RG)(t.$slots,"footer",{},void 0,!0)])],2)])],8,a)])}],["__scopeId","data-v-629a64f3"]])},6307:(t,e,n)=>{n.r(e),n.d(e,{default:()=>O});var r=n(9726),o={class:"mt-2 mb-3"},a={class:"slot mt-4"};var i=n(6660),c=n(5994),l=n(775),u={key:0},s=["href"],d=[function(t){return(0,r.Qi)("data-v-aa2baf66"),t=t(),(0,r.jt)(),t}((function(){return(0,r.Lk)("i",{class:"fa-brands fa-whatsapp my-float"},null,-1)}))];function f(t){return f="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},f(t)}function p(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function m(t,e,n){return(e=function(t){var e=function(t,e){if("object"!=f(t)||!t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!=f(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"==f(e)?e:e+""}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}const v={props:[],components:{},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?p(Object(n),!0).forEach((function(e){m(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):p(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},(0,n(834).aH)({extensions:function(t){return t.tenant.extensions},company:function(t){return t.tenant.company}})),data:function(){return{tag:"whatsapp",hasExtension:!1,extension:{}}},mounted:function(){},created:function(){},methods:{checkHasExtension:function(){var t,e=this;(this.hasExtension=this.extensions.data.some((function(t){return t.tag==e.tag})),this.hasExtension)&&(this.extension=this.extensions.data.find((function(t){return t.tag===e.tag})),this.extension.data=JSON.parse(null===(t=this.extension)||void 0===t?void 0:t.data))},setExtension:function(){}},watch:{"extensions.data":function(t,e){t.length>0&&this.checkHasExtension()}}};var b=n(5072),y=n.n(b),h=n(5473),g={insert:"head",singleton:!1};y()(h.A,g);h.A.locals;var k=n(6262);const x=(0,k.A)(v,[["render",function(t,e,n,o,a,i){var c;return t.hasExtension?((0,r.uX)(),(0,r.CE)("span",u,[(0,r.Lk)("a",{href:null===(c=t.extension)||void 0===c||null===(c=c.data)||void 0===c?void 0:c.link,class:"float",target:"_blank"},d,8,s)])):(0,r.Q3)("",!0)}],["__scopeId","data-v-aa2baf66"]]),w={components:{Header:i.default,Footer:c.default,PreloaderComponent:l.A,balonWhatsappComponent:x}},O=(0,k.A)(w,[["render",function(t,e,n,i,c,l){var u=(0,r.g2)("Header"),s=(0,r.g2)("PreloaderComponent"),d=(0,r.g2)("balonWhatsappComponent"),f=(0,r.g2)("Footer");return(0,r.uX)(),(0,r.CE)(r.FK,null,[(0,r.bF)(u),(0,r.Lk)("div",o,[(0,r.Lk)("div",a,[(0,r.bF)(s),(0,r.RG)(t.$slots,"content")])]),(0,r.bF)(d),(0,r.bF)(f)],64)}]])},5994:(t,e,n)=>{n.r(e),n.d(e,{default:()=>J});var r=n(9726),o=function(t){return(0,r.Qi)("data-v-4b893250"),t=t(),(0,r.jt)(),t},a={class:"mt-5"},i={class:"text-center text-lg-start text-dark pt-2",style:{"background-color":"#ECEFF1"}},c={class:""},l={class:"container text-center text-md-start mt-5"},u={class:"row mt-3"},s={class:"col-md-3 col-lg-4 col-xl-3 mx-auto mb-4"},d={class:"text-center text-capitalize fw-bold title-section-footer"},f=o((function(){return(0,r.Lk)("hr",{class:"mb-4 mt-0 d-inline-block mx-auto",style:{width:"60px","background-color":"#7c4dff",height:"2px"}},null,-1)})),p={key:0,class:"text-center"},m={class:"list-unstyled d-flex flex-row justify-content-center social-footer-links"},v={key:0},b=["href"],y=[o((function(){return(0,r.Lk)("i",{class:"fab fa-facebook-square"},null,-1)}))],h={key:1},g=["href"],k=[o((function(){return(0,r.Lk)("i",{class:"fab fa-instagram"},null,-1)}))],x=["href"],w=[o((function(){return(0,r.Lk)("i",{class:"fab fa-youtube"},null,-1)}))],O={class:"col-md-4 col-lg-3 col-xl-4 mx-auto mb-md-0 mb-4"},L=o((function(){return(0,r.Lk)("h6",{class:"text-center text-capitalize fw-bold title-section-footer"},"Contato",-1)})),j=o((function(){return(0,r.Lk)("hr",{class:"mb-4 mt-0 d-inline-block mx-auto",style:{width:"60px","background-color":"#7c4dff",height:"2px"}},null,-1)})),_=o((function(){return(0,r.Lk)("i",{class:"fas fa-home mr-3"},null,-1)})),P={key:0},E=o((function(){return(0,r.Lk)("i",{class:"fas fa-envelope mr-3"},null,-1)})),C={key:0},S=o((function(){return(0,r.Lk)("i",{class:"fas fa-phone mr-3"},null,-1)})),A={key:0,class:"col-lg-4 col-md-6 mb-4 mb-md-0"},D=o((function(){return(0,r.Lk)("h6",{class:"text-center text-capitalize fw-bold title-section-footer"},"Funcionamento",-1)})),X=o((function(){return(0,r.Lk)("hr",{class:"mb-4 mt-0 d-inline-block mx-auto",style:{width:"60px","background-color":"#7c4dff",height:"2px"}},null,-1)})),z={class:"table text-center"},F={class:"font-weight-normal"},W=o((function(){return(0,r.Lk)("div",{class:"text-center p-3",style:{"background-color":"#000",color:"#fff"}},[(0,r.eW)(" © 2023 Copyright: "),(0,r.Lk)("a",{class:"text-light",href:"https://buzzin.com.br/"},"Buzzin.com.br")],-1)}));var Q=n(2538),I=n(834);function N(t){return N="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},N(t)}function T(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function V(t,e,n){return(e=function(t){var e=function(t,e){if("object"!=N(t)||!t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!=N(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"==N(e)?e:e+""}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var R={components:{ModalComponent:Q.A},data:function(){return{}},computed:function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?T(Object(n),!0).forEach((function(e){V(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):T(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}({},(0,I.aH)({company:function(t){return t.tenant.company},paleta:function(t){return t.layout.paleta}})),methods:{},watch:{}},$=function(){(0,r.$9)((function(t){return{"136c5981":t.paleta.links,"2d13a0fe":t.paleta.links_hover}}))},q=R.setup;R.setup=q?function(t,e){return $(),q(t,e)}:$;const H=R;var B=n(5072),M=n.n(B),K=n(9485),G={insert:"head",singleton:!1};M()(K.A,G);K.A.locals;const J=(0,n(6262).A)(H,[["render",function(t,e,n,o,Q,I){var N,T,V,R,$,q;return(0,r.uX)(),(0,r.CE)("div",a,[(0,r.Lk)("footer",i,[(0,r.Lk)("section",c,[(0,r.Lk)("div",l,[(0,r.Lk)("div",u,[(0,r.Lk)("div",s,[(0,r.Lk)("h6",d,(0,r.v_)(t.company.name),1),f,t.company.about_us?((0,r.uX)(),(0,r.CE)("p",p,(0,r.v_)(t.company.about_us),1)):(0,r.Q3)("",!0),(0,r.Lk)("ul",m,[null!==(N=t.company)&&void 0!==N&&null!==(N=N.social)&&void 0!==N&&N.facebook?((0,r.uX)(),(0,r.CE)("li",v,[(0,r.Lk)("a",{class:"text-white px-2",target:"_blank",href:null===(T=t.company)||void 0===T||null===(T=T.social)||void 0===T?void 0:T.facebook},y,8,b)])):(0,r.Q3)("",!0),null!==(V=t.company)&&void 0!==V&&null!==(V=V.social)&&void 0!==V&&V.instagram?((0,r.uX)(),(0,r.CE)("li",h,[(0,r.Lk)("a",{class:"text-white px-2",target:"_blank",href:null===(R=t.company)||void 0===R||null===(R=R.social)||void 0===R?void 0:R.instagram},k,8,g)])):(0,r.Q3)("",!0),(0,r.Lk)("li",null,[(0,r.Lk)("a",{class:"text-white ps-2",target:"_blank",href:null===($=t.company)||void 0===$||null===($=$.social)||void 0===$?void 0:$.instagram},w,8,x)])])]),(0,r.Lk)("div",O,[L,j,(0,r.Lk)("p",null,[_,(0,r.eW)(" "+(0,r.v_)(t.company.address)+" ",1),t.company.number?((0,r.uX)(),(0,r.CE)("span",P,"nº "+(0,r.v_)(t.company.number),1)):(0,r.Q3)("",!0),(0,r.eW)(" "+(0,r.v_)(t.company.district)+" , "+(0,r.v_)(t.company.city)+" - "+(0,r.v_)(t.company.state),1)]),(0,r.Lk)("p",null,[E,(0,r.eW)(" "+(0,r.v_)(t.company.email),1)]),t.company.mobile_phone?((0,r.uX)(),(0,r.CE)("p",C,[S,(0,r.eW)(" "+(0,r.v_)(t.company.mobile_phone),1)])):(0,r.Q3)("",!0)]),(null===(q=t.company)||void 0===q||null===(q=q.operationDays)||void 0===q?void 0:q.length)>0?((0,r.uX)(),(0,r.CE)("div",A,[D,X,(0,r.Lk)("table",z,[(0,r.Lk)("tbody",F,[((0,r.uX)(!0),(0,r.CE)(r.FK,null,(0,r.pI)(t.company.operationDays,(function(t,e){return(0,r.uX)(),(0,r.CE)("tr",{key:e},[(0,r.Lk)("td",null,(0,r.v_)(t.description),1),(0,r.Lk)("td",null,[((0,r.uX)(!0),(0,r.CE)(r.FK,null,(0,r.pI)(null==t?void 0:t.time,(function(t,e){return(0,r.uX)(),(0,r.CE)("tr",{key:e},[(0,r.Lk)("td",null,[(0,r.Lk)("strong",null,(0,r.v_)(t.time_ini)+" - "+(0,r.v_)(t.time_end),1)])])})),128))])])})),128))])])])):(0,r.Q3)("",!0)])])]),W])])}],["__scopeId","data-v-4b893250"]])},6660:(t,e,n)=>{n.r(e),n.d(e,{default:()=>X});var r=n(9726),o=n(9910);var a=function(t){return(0,r.Qi)("data-v-2cf1de2f"),t=t(),(0,r.jt)(),t},i={class:"navbar navbar-expand-lg navbar-dark fixed-top bg-vuefood pt-2"},c={class:"container"},l={key:0,class:"text-center"},u=[a((function(){return(0,r.Lk)("img",{src:o.A,alt:"Carregando...",style:{"max-width":"35px"}},null,-1)}))],s={key:1},d=["src"],f=a((function(){return(0,r.Lk)("img",{src:"/images/404.png?7b2228749fd503a4203f872d074a5cfd",alt:"Em manutenção",style:{"max-width":"35px"}},null,-1)})),p={key:2},m={class:"navbar-nav ml-auto"},v={class:"nav-item nav-cart"},b=a((function(){return(0,r.Lk)("i",{class:"white-icon fa-solid fa-cart-shopping"},null,-1)})),y={class:"ms-1 white-icon"},h={class:"nav-item"},g=[a((function(){return(0,r.Lk)("i",{class:"red-icon fa-solid fa-right-from-bracket"},null,-1)}))];var k=n(834);function x(t){return x="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},x(t)}function w(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function O(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?w(Object(n),!0).forEach((function(e){L(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):w(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function L(t,e,n){return(e=function(t){var e=function(t,e){if("object"!=x(t)||!t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!=x(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"==x(e)?e:e+""}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var j={props:{},data:function(){return{title:"",meta:"",requested:!1}},computed:O({},(0,k.aH)({me:function(t){return t.auth.me},company:function(t){return t.tenant.company},productsCart:function(t){return t.cart.products.data},preloader:function(t){return t.preloader.preloader},maintence:function(t){return t.maintence.maintence},paleta:function(t){return t.layout.paleta}})),methods:O(O({},(0,k.i0)(["getMe","getTenant","getCart","setPaleta","logout","getSiteExtensions"])),{},{exit:function(){this.logout().then((function(){window.location.href=route("app.home")}))}}),mounted:function(){var t,e;(this.title=null===(t=this.$page)||void 0===t||null===(t=t.props)||void 0===t?void 0:t.title,this.meta=null===(e=this.$page)||void 0===e||null===(e=e.props)||void 0===e?void 0:e.meta,document.title=this.title?this.title:"BuzzIn!",this.meta)&&(document.createElement("meta").name=this.meta.description,meta1.content=this.meta.content)},created:function(){this.maintence||(this.getMe(),this.getTenant(),this.setPaleta())},watch:{company:function(){this.maintence||this.company.uuid&&!this.requested&&(this.requested=!0,this.getCart(this.company.uuid),this.getSiteExtensions({uuid:this.company.uuid}))}}},_=function(){(0,r.$9)((function(t){return{"2003c910":t.paleta.btn_color,e6922d66:t.paleta.btn_color_hover,c73335ee:t.paleta.links,dd2e32f4:t.paleta.links_hover}}))},P=j.setup;j.setup=P?function(t,e){return _(),P(t,e)}:_;const E=j;var C=n(5072),S=n.n(C),A=n(3351),D={insert:"head",singleton:!1};S()(A.A,D);A.A.locals;const X=(0,n(6262).A)(E,[["render",function(t,e,n,o,a,k){var x=(0,r.g2)("Link");return(0,r.uX)(),(0,r.CE)("header",null,[(0,r.Lk)("nav",i,[(0,r.Lk)("div",c,[t.maintence?((0,r.uX)(),(0,r.Wv)(x,{key:1,href:t.route("app.home"),class:"navbar-brand"},{default:(0,r.k6)((function(){return[f]})),_:1},8,["href"])):((0,r.uX)(),(0,r.Wv)(x,{key:0,href:t.route("app.home"),class:"navbar-brand"},{default:(0,r.k6)((function(){return[t.preloader?((0,r.uX)(),(0,r.CE)("span",l,u)):((0,r.uX)(),(0,r.CE)("span",s,[(0,r.Lk)("img",{src:t.company.logo,alt:"BuzzIn",class:"logo"},null,8,d)]))]})),_:1},8,["href"])),t.maintence?(0,r.Q3)("",!0):((0,r.uX)(),(0,r.CE)("div",p,[(0,r.Lk)("ul",m,[(0,r.Lk)("li",v,[(0,r.bF)(x,{href:t.route("app.cart"),class:"nav-link btn-nav"},{default:(0,r.k6)((function(){return[b,(0,r.Lk)("span",y,(0,r.v_)(t.productsCart.length),1)]})),_:1},8,["href"])]),(0,r.Lk)("li",h,[t.me.name&&"undefined"!==t.me.name?((0,r.uX)(),(0,r.Wv)(x,{key:0,href:t.route("app.cliente.area"),class:"nav-link ms-5"},{default:(0,r.k6)((function(){return[(0,r.eW)(" Olá "+(0,r.v_)(t.me.name)+" ",1),(0,r.Lk)("span",{onClick:e[0]||(e[0]=(0,r.D$)((function(t){return k.exit()}),["prevent"])),class:"text-danger ms-2"},g)]})),_:1},8,["href"])):((0,r.uX)(),(0,r.Wv)(x,{key:1,href:t.route("app.login"),class:"nav-link ms-5"},{default:(0,r.k6)((function(){return[(0,r.eW)(" Login ")]})),_:1},8,["href"]))])])]))])])])}],["__scopeId","data-v-2cf1de2f"]])},3206:(t,e,n)=>{n.r(e),n.d(e,{default:()=>N});var r=n(9726),o=function(t){return(0,r.Qi)("data-v-62569a30"),t=t(),(0,r.jt)(),t},a={class:"pt-4 pb-5"},i={class:"d-flex justify-content-center pb-5"},c={class:"user_card"},l={class:"d-flex justify-content-center form_container"},u={key:0,class:"text-danger"},s={class:"input-group"},d=o((function(){return(0,r.Lk)("span",{class:"input-group-text",id:"basic-addon1"},[(0,r.Lk)("i",{class:"fas fa-envelope"})],-1)})),f={key:1,class:"text-danger"},p={class:"input-group"},m=o((function(){return(0,r.Lk)("span",{class:"input-group-text",id:"basic-addon1"},[(0,r.Lk)("i",{class:"fas fa-key"})],-1)})),v={class:"d-flex justify-content-center mt-3 login_container"},b={key:0},y={key:1},h=o((function(){return(0,r.Lk)("input",{type:"hidden",id:"recaptcha"},null,-1)})),g={class:"mt-4"},k={class:"d-flex justify-content-center links"},x={class:"mt-4"},w={class:"d-flex justify-content-center links"};var O=n(834),L=n(6307),j=n(7695),_=n(5816);function P(t){return P="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},P(t)}function E(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function C(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?E(Object(n),!0).forEach((function(e){S(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):E(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function S(t,e,n){return(e=function(t){var e=function(t,e){if("object"!=P(t)||!t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var r=n.call(t,e||"default");if("object"!=P(r))return r;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"==P(e)?e:e+""}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var A={props:[],components:{DefaultLayout:L.default,buzzInBrandComponent:_.A},data:function(){return{recaptcha:"",loading:!1,formData:{email:"",password:""},errors:{email:"",password:""}}},computed:C(C({},(0,O.aH)({company:function(t){return t.tenant.company},paleta:function(t){return t.layout.paleta},token_name:function(t){return t.auth.TOKEN_NAME}})),{},{deviceName:function(){return navigator.appCodeName+navigator.appName+navigator.platform+this.formData.email}}),mounted:function(){},created:function(){},methods:C(C({},(0,O.i0)(["login"])),{},{auth:function(){var t=this;if(this.reset(),"N"==this.recaptcha)return j.oR.error("Erro na validação do recaptcha",{autoClose:4e3});this.loading=!0;var e=C({device_name:this.deviceName},this.formData);this.login(e).then((function(){return j.oR.success("Login realizado com sucesso",{autoClose:3e3}),window.location.href="http://".concat(t.company.domain)})).catch((function(e){var n=e.response;if(422===n.status||404===n.status)return t.errors=Object.assign(t.errors,n.data.errors),void j.oR.error("Dados inválidos, verifique novamente",{autoClose:4e3});j.oR.error("Falha na operação",{autoClose:3e3}),setTimeout((function(){return t.reset()}),4e3)})).finally((function(){t.loading=!1}))},reset:function(){this.recaptcha||(this.recaptcha=document.getElementById("recaptcha").value),this.errors={email:"",password:""}}})},D=function(){(0,r.$9)((function(t){return{"045771be":t.paleta.btn_color,ba0a52c4:t.paleta.btn_color_hover,"1802939a":t.paleta.links}}))},X=A.setup;A.setup=X?function(t,e){return D(),X(t,e)}:D;const z=A;var F=n(5072),W=n.n(F),Q=n(5469),I={insert:"head",singleton:!1};W()(Q.A,I);Q.A.locals;const N=(0,n(6262).A)(z,[["render",function(t,e,n,o,O,L){var j=(0,r.g2)("buzzInBrandComponent"),_=(0,r.g2)("Link"),P=(0,r.g2)("DefaultLayout");return(0,r.uX)(),(0,r.Wv)(P,null,{content:(0,r.k6)((function(){return[(0,r.Lk)("div",a,[(0,r.bF)(j)]),(0,r.Lk)("div",i,[(0,r.Lk)("div",c,[(0,r.Lk)("div",l,[(0,r.Lk)("form",null,[""!=t.errors.email?((0,r.uX)(),(0,r.CE)("div",u,(0,r.v_)(t.errors.email[0]||""),1)):(0,r.Q3)("",!0),(0,r.Lk)("div",s,[d,(0,r.bo)((0,r.Lk)("input",{type:"email","onUpdate:modelValue":e[0]||(e[0]=function(e){return t.formData.email=e}),name:"email",class:"form-control input_user",placeholder:"E-mail"},null,512),[[r.Jo,t.formData.email]])]),""!=t.errors.password?((0,r.uX)(),(0,r.CE)("div",f,(0,r.v_)(t.errors.password[0]||""),1)):(0,r.Q3)("",!0),(0,r.Lk)("div",p,[m,(0,r.bo)((0,r.Lk)("input",{type:"password",name:"password","onUpdate:modelValue":e[1]||(e[1]=function(e){return t.formData.password=e}),class:"form-control input_pass",placeholder:"Senha",minlength:"8"},null,512),[[r.Jo,t.formData.password]])]),(0,r.Lk)("div",v,[(0,r.Lk)("button",{type:"button",name:"button",class:"btn login_btn",onClick:e[2]||(e[2]=(0,r.D$)((function(t){return L.auth()}),["prevent"]))},[t.loading?((0,r.uX)(),(0,r.CE)("span",b," Carregando ...")):((0,r.uX)(),(0,r.CE)("span",y,"Entrar"))])]),h])]),(0,r.Lk)("div",g,[(0,r.Lk)("div",k,[(0,r.eW)(" Não tem uma conta? "),(0,r.bF)(_,{href:t.route("app.register"),class:"ml-2"},{default:(0,r.k6)((function(){return[(0,r.eW)(" Cadastre-se! ")]})),_:1},8,["href"])])]),(0,r.Lk)("div",x,[(0,r.Lk)("div",w,[(0,r.eW)(" Esqueceu a senha? "),(0,r.bF)(_,{href:t.route("app.recover"),class:"ml-2"},{default:(0,r.k6)((function(){return[(0,r.eW)(" Recuperar a conta ")]})),_:1},8,["href"])])])])])]})),_:1})}],["__scopeId","data-v-62569a30"]])},770:(t,e,n)=>{n.d(e,{A:()=>r.A});var r=n(8895)},8427:(t,e,n)=>{n.d(e,{X:()=>r.X});var r=n(62)}}]);