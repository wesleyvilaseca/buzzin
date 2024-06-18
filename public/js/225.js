"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[225],{6262:(l,t)=>{t.A=(l,t)=>{const e=l.__vccOpts||l;for(const[l,o]of t)e[l]=o;return e}},9606:(l,t,e)=>{e.r(t),e.d(t,{default:()=>I});var o=e(9726),n={class:"modal-dialog modal-xl",role:"document"},d={class:"modal-content"},r={class:"modal-header"},i={class:"modal-title",id:"exampleModalLiveLabel"},a={class:"modal-body"},s={class:"card-header"},u=(0,o.Lk)("br",null,null,-1),c=(0,o.Lk)("br",null,null,-1),v=(0,o.Lk)("br",null,null,-1),k={key:0},p=["href"],L=[(0,o.Lk)("i",{class:"fa-solid fa-barcode"},null,-1)],m={class:"row"},_={class:"col-md-8"},b={class:"card-body"},y={class:"mt-2"},h={class:"mb-2"},f=(0,o.Lk)("strong",null,"Pagamento:",-1),g={key:0},C={class:"table-responsive"},W={class:"table table-condensed"},E=(0,o.Lk)("thead",null,[(0,o.Lk)("tr",null,[(0,o.Lk)("th",{scope:"col"},"#"),(0,o.Lk)("th",{scope:"col"},"Produto"),(0,o.Lk)("th",{scope:"col"},"Quantidade"),(0,o.Lk)("th",{scope:"col"},"Valor"),(0,o.Lk)("th",{scope:"col"},"Total")])],-1),S=["src","alt"],w=(0,o.Lk)("td",{colspan:"4"},[(0,o.Lk)("strong",null,"Subtotal")],-1),x={colspan:"4"},D=(0,o.Lk)("td",{colspan:"4"},[(0,o.Lk)("strong",null," Total ")],-1),M={class:"col-md-4"},X={key:0,class:"mt-2"},Q=(0,o.Lk)("h5",null,"Endereço de entrega",-1),q={class:""},F={class:""},P=(0,o.Lk)("br",null,null,-1),R=(0,o.Lk)("br",null,null,-1),B=(0,o.Lk)("br",null,null,-1),T=(0,o.Lk)("br",null,null,-1);const $={props:{display:{required:!0},order:{type:Object,required:!0}},computed:{subtotal:function(){var l,t=0;return null===(l=this.order)||void 0===l||null===(l=l.products)||void 0===l||l.map((function(l,e){t+=l.qty*l.price})),t},total:function(){return this.order.total.toLocaleString("pt-br",{minimumFractionDigits:2})}},data:function(){return{status:"",loading:!1}},methods:{closeDetails:function(){this.$emit("closeDetails")},updateStatus:function(){},moneyMask:function(l){return"number"!=typeof l?l:new Intl.NumberFormat("pt-BR",{style:"currency",currency:"BRL"}).format(l)}},watch:{order:function(){this.status=this.order.status}}};const I=(0,e(6262).A)($,[["render",function(l,t,e,$,I,K){var O,A,j,z,N,V,G,H,J,U,Y,Z,ll,tl,el;return(0,o.uX)(),(0,o.CE)("div",{id:"exampleModalLive",class:"modal fade show",tabindex:"-1",role:"dialog","aria-labelledby":"exampleModalLiveLabel",style:(0,o.Tr)({display:e.display})},[(0,o.Lk)("div",n,[(0,o.Lk)("div",d,[(0,o.Lk)("div",r,[(0,o.Lk)("h5",i,"Detalhes do Pedido "+(0,o.v_)(e.order.identify),1),(0,o.Lk)("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close",onClick:t[0]||(t[0]=function(){return K.closeDetails&&K.closeDetails.apply(K,arguments)})})]),(0,o.Lk)("div",a,[(0,o.Lk)("form",{action:"#",method:"POST",class:"form form-inline",onSubmit:t[1]||(t[1]=(0,o.D$)((function(){return K.updateStatus&&K.updateStatus.apply(K,arguments)}),["prevent"]))},null,32),(0,o.Lk)("div",s,[(0,o.eW)(" Data: "+(0,o.v_)(e.order.date_br)+" ",1),u,(0,o.eW)(" Status pedido: "),(0,o.Lk)("strong",null,(0,o.v_)(e.order.status_label),1),(0,o.eW)(),c,e.order.integration?((0,o.uX)(),(0,o.CE)(o.FK,{key:0},[(0,o.eW)(" Status pagamento: "),(0,o.Lk)("strong",null,(0,o.v_)(null===(O=e.order)||void 0===O||null===(O=O.order_integration_transaction)||void 0===O?void 0:O.status),1),(0,o.eW)(),v,"ticket"==(null===(A=e.order)||void 0===A||null===(A=A.order_integration_transaction)||void 0===A?void 0:A.payment_type_id)?((0,o.uX)(),(0,o.CE)("span",k,[(0,o.eW)(" Imprimir boleto: "),(0,o.Lk)("a",{href:null===(j=e.order)||void 0===j||null===(j=j.order_integration_transaction)||void 0===j?void 0:j.external_resource_url,target:"_blank",class:"btn btn-warning btn-sm"},L,8,p)])):(0,o.Q3)("",!0)],64)):(0,o.Q3)("",!0)]),(0,o.Lk)("div",m,[(0,o.Lk)("div",_,[(0,o.Lk)("div",b,[(0,o.Lk)("div",y,[(0,o.Lk)("div",h,[f,(0,o.eW)(" "+(0,o.v_)(null===(z=e.order)||void 0===z||null===(z=z.payment_method)||void 0===z?void 0:z.description)+" ",1),e.order.integration?((0,o.uX)(),(0,o.CE)(o.FK,{key:0},["ticket"==(null===(N=e.order.order_integration_transaction)||void 0===N?void 0:N.payment_type_id)?((0,o.uX)(),(0,o.CE)("span",g," - Boleto ")):(0,o.Q3)("",!0)],64)):(0,o.Q3)("",!0)])]),(0,o.Lk)("div",C,[(0,o.Lk)("table",W,[E,(0,o.Lk)("tbody",null,[((0,o.uX)(!0),(0,o.CE)(o.FK,null,(0,o.pI)(e.order.products,(function(l,t){return(0,o.uX)(),(0,o.CE)("tr",{key:t},[(0,o.Lk)("td",null,[(0,o.Lk)("img",{src:l.image,alt:l.title,style:{"max-width":"50px"}},null,8,S)]),(0,o.Lk)("td",null,(0,o.v_)(l.title),1),(0,o.Lk)("td",null,(0,o.v_)(l.qty),1),(0,o.Lk)("td",null,"R$ "+(0,o.v_)(l.price),1),(0,o.Lk)("td",null,"R$ "+(0,o.v_)(l.qty*l.price),1)])})),128))]),(0,o.Lk)("tfoot",null,[(0,o.Lk)("tr",null,[w,(0,o.Lk)("td",null,(0,o.v_)(K.moneyMask(K.subtotal)),1)]),(0,o.Lk)("tr",null,[(0,o.Lk)("td",x,[(0,o.Lk)("strong",null,(0,o.v_)(K.moneyMask(null===(V=e.order)||void 0===V||null===(V=V.shipping_method)||void 0===V?void 0:V.description)),1)]),(0,o.Lk)("td",null,(0,o.v_)(K.moneyMask(null===(G=e.order)||void 0===G||null===(G=G.shipping_method)||void 0===G?void 0:G.price)),1)]),(0,o.Lk)("tr",null,[D,(0,o.Lk)("td",null,(0,o.v_)(K.moneyMask(e.order.total)),1)])])])])])]),(0,o.Lk)("div",M,["Retirada"!==(null===(H=e.order)||void 0===H||null===(H=H.shipping_method)||void 0===H?void 0:H.description)?((0,o.uX)(),(0,o.CE)("div",X,[Q,(0,o.Lk)("div",q,[(0,o.Lk)("div",F,[(0,o.eW)(" Endereço: "+(0,o.v_)(null===(J=e.order.client_address)||void 0===J?void 0:J.address)+" - nº: "+(0,o.v_)(null===(U=e.order.client_address)||void 0===U?void 0:U.number),1),P,(0,o.eW)(" Complemento: "+(0,o.v_)(null===(Y=e.order.client_address)||void 0===Y?void 0:Y.complement)+" ",1),R,(0,o.eW)(" Bairro: "+(0,o.v_)(null===(Z=e.order.client_address)||void 0===Z?void 0:Z.district)+" ",1),B,(0,o.eW)(" CEP: "+(0,o.v_)(null===(ll=e.order.client_address)||void 0===ll?void 0:ll.zip_code)+" ",1),T,(0,o.eW)(" "+(0,o.v_)(null===(tl=e.order.client_address)||void 0===tl?void 0:tl.city)+" - "+(0,o.v_)(null===(el=e.order.client_address)||void 0===el?void 0:el.state),1)])])])):(0,o.Q3)("",!0)])])])])])],4)}]])}}]);