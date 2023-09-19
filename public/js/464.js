"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[464,502],{5488:(t,e,n)=>{n.d(e,{Z:()=>c});var s=n(3907);function r(t){return r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},r(t)}function a(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,s)}return n}function i(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?a(Object(n),!0).forEach((function(e){o(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):a(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function o(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==r(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var s=n.call(t,e||"default");if("object"!==r(s))return s;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===r(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}const c={props:{ticketid:Number},components:{},data:function(){return{user_id:"",ticket_status:"",form:{ticket_id:"",message:"",tenant_user_id:""},errors:{ticket_id:"",message:"",tenant_user_id:""}}},computed:i(i({},(0,s.rn)({conversation:function(t){return t.ticket.ticket}})),{},{canSendMessage:function(){return this.checkStatus(),3!=this.ticket_status&&4!=this.ticket_status}}),mounted:function(){var t,e;this.getTicketSupport(this.ticketid),this.form.ticket_id=this.ticketid,this.user_id=null===(t=window)||void 0===t||null===(e=t.Laravel)||void 0===e?void 0:e.user_id;var n=this;window.Echo.channel("buzzin_database_private-message-ticket-tenant-created.".concat(n.user_id)).listen("MessageTicketTenantCreated",(function(t){n.setNewMessage(t.message),n.checkStatus(),setTimeout(n.scroll(),2e3)})),n.scroll()},methods:i(i(i({},(0,s.nv)(["getTicketSupport","sendSupportTicketMessage","closeTicketBySupport"])),(0,s.OI)({setNewMessage:"SET_NEW_MESSAGE_TICKET"})),{},{sendMessage:function(){var t=this;this.canSendMessage&&this.form.message&&(this.form.tenant_user_id||(this.form.tenant_user_id=this.getTenantId()),this.sendSupportTicketMessage(this.form).then((function(){t.form.message="",t.scroll()})))},closeTicket:function(){this.form.tenant_user_id||(this.form.tenant_user_id=this.getTenantId()),this.closeTicketBySupport(this.form).then((function(){return window.location.href="/admin-tickets"}))},scroll:function(){$("#chat_").animate({scrollTop:2e7},"slow")},getTenantId:function(){var t=this;return this.conversation.data.find((function(e){return e.user_id!=t.user_id})).user_id},checkStatus:function(){var t=this.conversation.data.find((function(t){return 3==t.status||4==t.status}));t&&(this.ticket_status=t.status)}})}},2299:(t,e,n)=>{n.d(e,{Z:()=>l});var s=n(5502),r=n(3907);function a(t){return a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},a(t)}function i(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(t);e&&(s=s.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,s)}return n}function o(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?i(Object(n),!0).forEach((function(e){c(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):i(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function c(t,e,n){return(e=function(t){var e=function(t,e){if("object"!==a(t)||null===t)return t;var n=t[Symbol.toPrimitive];if(void 0!==n){var s=n.call(t,e||"default");if("object"!==a(s))return s;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===a(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}const l={props:[],components:{conversationView:s.default},data:function(){return{conversationId:"",loding:!1,tickets:[]}},computed:o({},(0,r.rn)({my_tickets:function(t){return t.ticket.my_tickets}})),mounted:function(){var t=this;this.getAll(),this.getTicketsByAttendant().then((function(){console.log(t.my_tickets)}))},methods:o(o({},(0,r.nv)(["getTicketsByAttendant"])),{},{getAll:function(){var t=this;axios.get("/api/v1/tickets").then((function(e){return t.tickets=e.data})).catch((function(t){return alert("error")}))},showModalConversation:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:null;window.location.href="/admin-tickets/".concat(e,"/ticket")}})}},5434:(t,e,n)=>{n.d(e,{s:()=>L});var s=n(821),r={class:"top-chat"},a=(0,s._)("div",{class:"desc"},null,-1),i={key:0,class:"buttons"},o={key:1,class:"buttons"},c=[(0,s._)("div",{class:"alert alert-warning p-1 mt-3 fade show",role:"alert"}," Esse Ticket foi encerrado ",-1)],l={class:"chatbox"},u={class:"chat-window pt-2",id:"chat_"},d={key:0,class:"msg-container msg-remote",id:"msg-0"},f={class:"msg-box"},m={class:"flr"},p={class:"messages"},b=["innerHTML"],g={class:"timestamp"},_={class:"username"},v={class:"posttime"},h=(0,s._)("img",{class:"user-img",id:"user-0",src:"//gravatar.com/avatar/56234674574535734573000000000001?d=retro"},null,-1),y={key:1,class:"msg-container msg-self",id:"msg-0"},k={class:"msg-box"},w=(0,s._)("img",{class:"user-img",id:"user-0",src:"//gravatar.com/avatar/00034587632094500000000000000000?d=retro"},null,-1),S={class:"flr"},O={class:"messages"},D=["innerHTML"],T={class:"timestamp"},j={class:"username"},M={class:"posttime"},C={class:"chat-input",onsubmit:"return false;"},P={style:{width:"24px",height:"24px"},viewBox:"0 0 24 24"},E=[(0,s._)("path",{fill:"rgba(0,0,0,.38)",d:"M17,12L12,17V14H8V10H12V7L17,12M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L5,8.09V15.91L12,19.85L19,15.91V8.09L12,4.15Z"},null,-1)];function L(t,e,n,L,H,q){var Z=this;return(0,s.wg)(),(0,s.iD)(s.HY,null,[(0,s._)("div",r,[a,q.canSendMessage?((0,s.wg)(),(0,s.iD)("div",i,[(0,s._)("button",{class:"btn btn-sm btn-primary",onClick:e[0]||(e[0]=(0,s.iM)((function(t){return q.closeTicket()}),["prevent"]))}," Encerrar ticket")])):(0,s.kq)("",!0),q.canSendMessage?(0,s.kq)("",!0):((0,s.wg)(),(0,s.iD)("div",o,c))]),(0,s._)("section",l,[(0,s._)("section",u,[((0,s.wg)(!0),(0,s.iD)(s.HY,null,(0,s.Ko)(t.conversation.data,(function(t,e){return(0,s.wg)(),(0,s.iD)(s.HY,{key:e},[t.created_by_tenant?((0,s.wg)(),(0,s.iD)("article",d,[(0,s._)("div",f,[(0,s._)("div",m,[(0,s._)("div",p,[(0,s._)("p",{class:"msg",id:"msg-1",innerHTML:t.message},null,8,b)]),(0,s._)("span",g,[(0,s._)("span",_,(0,s.zw)(t.user_name),1),(0,s.Uk)("•"),(0,s._)("span",v,(0,s.zw)(t.created_at),1)])]),h])])):((0,s.wg)(),(0,s.iD)("article",y,[(0,s._)("div",k,[w,(0,s._)("div",S,[(0,s._)("div",O,[(0,s._)("p",{class:"msg",id:"msg-0",innerHTML:t.message},null,8,D)]),(0,s._)("span",T,[(0,s._)("span",j,(0,s.zw)(t.user_name),1),(0,s.Uk)("•"),(0,s._)("span",M,(0,s.zw)(t.created_at),1)])])])]))],64)})),128))]),(0,s._)("form",C,[(0,s.wy)((0,s._)("textarea",{cols:"30",rows:"10",placeholder:"Escreva uma mensagem","onUpdate:modelValue":e[1]||(e[1]=function(e){return t.form.message=e})},null,512),[[s.nr,t.form.message]]),q.canSendMessage?((0,s.wg)(),(0,s.iD)("button",{key:0,onClick:e[2]||(e[2]=function(t){return Z.sendMessage()})},[((0,s.wg)(),(0,s.iD)("svg",P,E))])):(0,s.kq)("",!0)])])],64)}},5978:(t,e,n)=>{n.d(e,{s:()=>C});var s=n(821),r={class:"card"},a=(0,s._)("div",{class:"card-header"}," Lista de chamados ",-1),i={class:"card-body"},o={class:"nav nav-tabs",id:"myTab",role:"tablist"},c=(0,s._)("li",{class:"nav-item",role:"presentation"},[(0,s._)("button",{class:"nav-link active",id:"home-tab","data-bs-toggle":"tab","data-bs-target":"#home",type:"button",role:"tab","aria-controls":"home","aria-selected":"true"},"Tickets em aberto")],-1),l={class:"nav-item",role:"presentation"},u={class:"nav-link position-relative",id:"profile-tab","data-bs-toggle":"tab","data-bs-target":"#profile",type:"button",role:"tab","aria-controls":"profile","aria-selected":"false"},d={key:0,class:"position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-0 ms-0"},f={class:"tab-content",id:"myTabContent"},m={class:"tab-pane fade show active",id:"home",role:"tabpanel","aria-labelledby":"home-tab"},p={class:"table table-condensed"},b=(0,s._)("thead",null,[(0,s._)("tr",null,[(0,s._)("th",null,"Descrição"),(0,s._)("th",null,"Status"),(0,s._)("th",null,"Data da criação"),(0,s._)("th",{width:"270"},"Ações")])],-1),g={key:0},_={key:0,class:"alert alert-warning p-1"},v={key:1,class:"alert alert-info p-1"},h=["onClick"],y=[(0,s._)("i",{class:"fa-solid fa-eye"},null,-1)],k={class:"tab-pane fade",id:"profile",role:"tabpanel","aria-labelledby":"profile-tab"},w={class:"table table-condensed"},S=(0,s._)("thead",null,[(0,s._)("tr",null,[(0,s._)("th",null,"Descrição"),(0,s._)("th",null,"Status"),(0,s._)("th",null,"Data da criação"),(0,s._)("th",{width:"270"},"Ações")])],-1),O={key:0},D={key:0,class:"alert alert-warning p-1"},T={key:1,class:"alert alert-info p-1"},j=["onClick"],M=[(0,s._)("i",{class:"fa-solid fa-eye"},null,-1)];function C(t,e,n,C,P,E){var L,H,q;return(0,s.wg)(),(0,s.iD)("div",r,[a,(0,s._)("div",i,[(0,s._)("ul",o,[c,(0,s._)("li",l,[(0,s._)("button",u,[(0,s.Uk)(" Tickets em atendimento "),(null===(L=t.my_tickets.data)||void 0===L?void 0:L.length)>0?((0,s.wg)(),(0,s.iD)("span",d,(0,s.zw)(null===(H=t.my_tickets.data)||void 0===H?void 0:H.length),1)):(0,s.kq)("",!0)])])]),(0,s._)("div",f,[(0,s._)("div",m,[(0,s._)("table",p,[b,(0,s._)("tbody",null,[t.tickets.length>0?((0,s.wg)(!0),(0,s.iD)(s.HY,{key:0},(0,s.Ko)(t.tickets,(function(t,e){return(0,s.wg)(),(0,s.iD)(s.HY,{key:e},[0==t.status?((0,s.wg)(),(0,s.iD)("tr",g,[(0,s._)("td",null,(0,s.zw)(t.description),1),(0,s._)("td",null,[0==t.status?((0,s.wg)(),(0,s.iD)("span",_," Em aberto")):(0,s.kq)("",!0),1==t.status?((0,s.wg)(),(0,s.iD)("span",v," Em atendimento")):(0,s.kq)("",!0)]),(0,s._)("td",null,(0,s.zw)(t.created_at),1),(0,s._)("td",null,[(0,s._)("a",{href:"#",onClick:(0,s.iM)((function(e){return E.showModalConversation(!0,t.id)}),["prevent"]),class:"btn btn-info btn-sm"},y,8,h)])])):(0,s.kq)("",!0)],64)})),128)):(0,s.kq)("",!0)])])]),(0,s._)("div",k,[(0,s._)("table",w,[S,(0,s._)("tbody",null,[(null===(q=t.my_tickets.data)||void 0===q?void 0:q.length)>0?((0,s.wg)(!0),(0,s.iD)(s.HY,{key:0},(0,s.Ko)(t.my_tickets.data,(function(t,e){return(0,s.wg)(),(0,s.iD)(s.HY,{key:e},[1==t.status?((0,s.wg)(),(0,s.iD)("tr",O,[(0,s._)("td",null,(0,s.zw)(t.description),1),(0,s._)("td",null,[0==t.status?((0,s.wg)(),(0,s.iD)("span",D," Em aberto")):(0,s.kq)("",!0),1==t.status?((0,s.wg)(),(0,s.iD)("span",T," Em atendimento")):(0,s.kq)("",!0)]),(0,s._)("td",null,(0,s.zw)(t.created_at),1),(0,s._)("td",null,[(0,s._)("a",{href:"#",onClick:(0,s.iM)((function(e){return E.showModalConversation(!0,t.id)}),["prevent"]),class:"btn btn-info btn-sm"},M,8,j)])])):(0,s.kq)("",!0)],64)})),128)):(0,s.kq)("",!0)])])])])])])}},3744:(t,e)=>{e.Z=(t,e)=>{const n=t.__vccOpts||t;for(const[t,s]of e)n[t]=s;return n}},5502:(t,e,n)=>{n.r(e),n.d(e,{default:()=>a});var s=n(9347),r=n(9);const a=(0,n(3744).Z)(r.Z,[["render",s.s]])},2464:(t,e,n)=>{n.r(e),n.d(e,{default:()=>a});var s=n(7233),r=n(3506);const a=(0,n(3744).Z)(r.Z,[["render",s.s]])},9:(t,e,n)=>{n.d(e,{Z:()=>s.Z});var s=n(5488)},3506:(t,e,n)=>{n.d(e,{Z:()=>s.Z});var s=n(2299)},9347:(t,e,n)=>{n.d(e,{s:()=>s.s});var s=n(5434)},7233:(t,e,n)=>{n.d(e,{s:()=>s.s});var s=n(5978)}}]);