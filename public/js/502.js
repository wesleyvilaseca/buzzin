"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[502],{5488:(t,e,s)=>{s.d(e,{Z:()=>o});var n=s(3907);function r(t){return r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},r(t)}function i(t,e){var s=Object.keys(t);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(t);e&&(n=n.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),s.push.apply(s,n)}return s}function a(t){for(var e=1;e<arguments.length;e++){var s=null!=arguments[e]?arguments[e]:{};e%2?i(Object(s),!0).forEach((function(e){c(t,e,s[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(s)):i(Object(s)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(s,e))}))}return t}function c(t,e,s){return(e=function(t){var e=function(t,e){if("object"!==r(t)||null===t)return t;var s=t[Symbol.toPrimitive];if(void 0!==s){var n=s.call(t,e||"default");if("object"!==r(n))return n;throw new TypeError("@@toPrimitive must return a primitive value.")}return("string"===e?String:Number)(t)}(t,"string");return"symbol"===r(e)?e:String(e)}(e))in t?Object.defineProperty(t,e,{value:s,enumerable:!0,configurable:!0,writable:!0}):t[e]=s,t}const o={props:{ticketid:Number},components:{},data:function(){return{user_id:"",ticket_status:"",form:{ticket_id:"",message:"",tenant_user_id:""},errors:{ticket_id:"",message:"",tenant_user_id:""}}},computed:a(a({},(0,n.rn)({conversation:function(t){return t.ticket.ticket}})),{},{canSendMessage:function(){return this.checkStatus(),3!=this.ticket_status&&4!=this.ticket_status}}),mounted:function(){var t,e;this.getTicketSupport(this.ticketid),this.form.ticket_id=this.ticketid,this.user_id=null===(t=window)||void 0===t||null===(e=t.Laravel)||void 0===e?void 0:e.user_id;var s=this;window.Echo.channel("buzzin_database_private-message-ticket-tenant-created.".concat(s.user_id)).listen("MessageTicketTenantCreated",(function(t){s.setNewMessage(t.message),s.checkStatus(),setTimeout(s.scroll(),2e3)})),s.scroll()},methods:a(a(a({},(0,n.nv)(["getTicketSupport","sendSupportTicketMessage","closeTicketBySupport"])),(0,n.OI)({setNewMessage:"SET_NEW_MESSAGE_TICKET"})),{},{sendMessage:function(){var t=this;this.canSendMessage&&this.form.message&&(this.form.tenant_user_id||(this.form.tenant_user_id=this.getTenantId()),this.sendSupportTicketMessage(this.form).then((function(){t.form.message="",t.scroll()})))},closeTicket:function(){this.form.tenant_user_id||(this.form.tenant_user_id=this.getTenantId()),this.closeTicketBySupport(this.form).then((function(){return window.location.href="/admin-tickets"}))},scroll:function(){$("#chat_").animate({scrollTop:2e7},"slow")},getTenantId:function(){var t=this;return this.conversation.data.find((function(e){return e.user_id!=t.user_id})).user_id},checkStatus:function(){var t=this.conversation.data.find((function(t){return 3==t.status||4==t.status}));t&&(this.ticket_status=t.status)}})}},5434:(t,e,s)=>{s.d(e,{s:()=>P});var n=s(821),r={class:"top-chat"},i=(0,n._)("div",{class:"desc"},null,-1),a={key:0,class:"buttons"},c={key:1,class:"buttons"},o=[(0,n._)("div",{class:"alert alert-warning p-1 mt-3 fade show",role:"alert"}," Esse Ticket foi encerrado ",-1)],u={class:"chatbox"},l={class:"chat-window pt-2",id:"chat_"},d={key:0,class:"msg-container msg-remote",id:"msg-0"},m={class:"msg-box"},f={class:"flr"},g={class:"messages"},p=["innerHTML"],_={class:"timestamp"},h={class:"username"},v={class:"posttime"},b=(0,n._)("img",{class:"user-img",id:"user-0",src:"//gravatar.com/avatar/56234674574535734573000000000001?d=retro"},null,-1),k={key:1,class:"msg-container msg-self",id:"msg-0"},w={class:"msg-box"},y=(0,n._)("img",{class:"user-img",id:"user-0",src:"//gravatar.com/avatar/00034587632094500000000000000000?d=retro"},null,-1),S={class:"flr"},T={class:"messages"},M=["innerHTML"],O={class:"timestamp"},L={class:"username"},j={class:"posttime"},C={class:"chat-input",onsubmit:"return false;"},D={style:{width:"24px",height:"24px"},viewBox:"0 0 24 24"},E=[(0,n._)("path",{fill:"rgba(0,0,0,.38)",d:"M17,12L12,17V14H8V10H12V7L17,12M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L5,8.09V15.91L12,19.85L19,15.91V8.09L12,4.15Z"},null,-1)];function P(t,e,s,P,H,V){var x=this;return(0,n.wg)(),(0,n.iD)(n.HY,null,[(0,n._)("div",r,[i,V.canSendMessage?((0,n.wg)(),(0,n.iD)("div",a,[(0,n._)("button",{class:"btn btn-sm btn-primary",onClick:e[0]||(e[0]=(0,n.iM)((function(t){return V.closeTicket()}),["prevent"]))}," Encerrar ticket")])):(0,n.kq)("",!0),V.canSendMessage?(0,n.kq)("",!0):((0,n.wg)(),(0,n.iD)("div",c,o))]),(0,n._)("section",u,[(0,n._)("section",l,[((0,n.wg)(!0),(0,n.iD)(n.HY,null,(0,n.Ko)(t.conversation.data,(function(t,e){return(0,n.wg)(),(0,n.iD)(n.HY,{key:e},[t.created_by_tenant?((0,n.wg)(),(0,n.iD)("article",d,[(0,n._)("div",m,[(0,n._)("div",f,[(0,n._)("div",g,[(0,n._)("p",{class:"msg",id:"msg-1",innerHTML:t.message},null,8,p)]),(0,n._)("span",_,[(0,n._)("span",h,(0,n.zw)(t.user_name),1),(0,n.Uk)("•"),(0,n._)("span",v,(0,n.zw)(t.created_at),1)])]),b])])):((0,n.wg)(),(0,n.iD)("article",k,[(0,n._)("div",w,[y,(0,n._)("div",S,[(0,n._)("div",T,[(0,n._)("p",{class:"msg",id:"msg-0",innerHTML:t.message},null,8,M)]),(0,n._)("span",O,[(0,n._)("span",L,(0,n.zw)(t.user_name),1),(0,n.Uk)("•"),(0,n._)("span",j,(0,n.zw)(t.created_at),1)])])])]))],64)})),128))]),(0,n._)("form",C,[(0,n.wy)((0,n._)("textarea",{cols:"30",rows:"10",placeholder:"Escreva uma mensagem","onUpdate:modelValue":e[1]||(e[1]=function(e){return t.form.message=e})},null,512),[[n.nr,t.form.message]]),V.canSendMessage?((0,n.wg)(),(0,n.iD)("button",{key:0,onClick:e[2]||(e[2]=function(t){return x.sendMessage()})},[((0,n.wg)(),(0,n.iD)("svg",D,E))])):(0,n.kq)("",!0)])])],64)}},3744:(t,e)=>{e.Z=(t,e)=>{const s=t.__vccOpts||t;for(const[t,n]of e)s[t]=n;return s}},5502:(t,e,s)=>{s.r(e),s.d(e,{default:()=>i});var n=s(9347),r=s(9);const i=(0,s(3744).Z)(r.Z,[["render",n.s]])},9:(t,e,s)=>{s.d(e,{Z:()=>n.Z});var n=s(5488)},9347:(t,e,s)=>{s.d(e,{s:()=>n.s});var n=s(5434)}}]);