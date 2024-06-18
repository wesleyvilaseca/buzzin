"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_admin_tickets_tenant_support_view_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=script&lang=js":
/*!***************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=script&lang=js ***!
  \***************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm-bundler.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    ticketid: Number
  },
  components: {},
  data: function data() {
    return {
      user_id: '',
      ticket_status: '',
      form: {
        ticket_id: "",
        message: "",
        attendance_user_id: ""
      },
      errors: {
        ticket_id: "",
        message: "",
        attendance_user_id: ""
      }
    };
  },
  computed: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapState)({
    conversation: function conversation(state) {
      return state.ticket.ticket;
    }
  })), {}, {
    canSendMessage: function canSendMessage() {
      this.checkStatus();
      if (this.ticket_status == 3 || this.ticket_status == 4) {
        return false;
      }
      return true;
    }
  }),
  mounted: function mounted() {
    var _window;
    this.getTicket(this.ticketid);
    this.form.ticket_id = this.ticketid;
    this.user_id = (_window = window) === null || _window === void 0 || (_window = _window.Laravel) === null || _window === void 0 ? void 0 : _window.user_id;
    var that = this;
    window.Echo.channel("buzzin_database_private-message-ticket-support-created.".concat(that.user_id)).listen('MessageTicketSupportCreated', function (e) {
      that.setNewMessage(e.message);
      that.checkStatus();
      setTimeout(that.scroll(), 2000);
    });
    that.scroll();
  },
  methods: _objectSpread(_objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapActions)(["getTicket", "sendSupportTenatMessage", "closeTicketByTenant"])), (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapMutations)({
    setNewMessage: "SET_NEW_MESSAGE_TICKET"
  })), {}, {
    sendMessage: function sendMessage() {
      var _this = this;
      if (!this.canSendMessage) {
        return;
      }
      if (!this.form.message) {
        return;
      }
      if (!this.form.attendance_user_id) {
        this.form.attendance_user_id = this.getAttendantId();
      }
      this.sendSupportTenatMessage(this.form).then(function () {
        _this.form.message = "";
        _this.scroll();
      });
    },
    closeTicket: function closeTicket() {
      if (!this.form.tenant_user_id) {
        this.form.tenant_user_id = this.getAttendantId();
      }
      this.closeTicketByTenant(this.form).then(function () {
        return window.location.href = "/admin-tenant-tickets";
      });
    },
    scroll: function scroll() {
      $("#chat_").animate({
        scrollTop: 20000000
      }, "slow");
    },
    getAttendantId: function getAttendantId() {
      var _this2 = this;
      var objetoEncontrado = this.conversation.data.find(function (objeto) {
        return objeto.user_id != _this2.user_id;
      });
      return objetoEncontrado.user_id;
    },
    checkStatus: function checkStatus() {
      var objetoEncontrado = this.conversation.data.find(function (objeto) {
        return objeto.status == 3 || objeto.status == 4;
      });
      if (objetoEncontrado) {
        this.ticket_status = objetoEncontrado.status;
      }
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _conversation_view_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./conversation.view.vue */ "./resources/js/views/admin/tickets/tenant/conversation.view.vue");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm-bundler.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: [],
  components: {
    conversationView: _conversation_view_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      conversationId: "",
      canStoreTicket: false,
      loding: false,
      modal: 'none',
      modalConvesation: 'none',
      tickets: [],
      form: {
        ticket_type_id: "",
        description: "",
        message: ""
      },
      errors: {
        ticket_type_id: "",
        description: "",
        message: ""
      }
    };
  },
  computed: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_1__.mapState)({
    my_tickets: function my_tickets(state) {
      return state.ticket.my_tickets;
    }
  })), {}, {
    hasNotVizualizedMessages: function hasNotVizualizedMessages() {
      var _this$my_tickets;
      var objetoEncontrado = (_this$my_tickets = this.my_tickets) === null || _this$my_tickets === void 0 || (_this$my_tickets = _this$my_tickets.data) === null || _this$my_tickets === void 0 ? void 0 : _this$my_tickets.find(function (objeto) {
        return objeto.not_visualized_message > 0;
      });
      if (objetoEncontrado) {
        return true;
      }
      return false;
    }
  }),
  mounted: function mounted() {
    this.getTicketsByTenant();
  },
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_1__.mapActions)(["getTicketsByTenant"])), {}, {
    showModal: function showModal(state) {
      if (!state) {
        this.modal = 'none';
        this.resetForm();
        return;
      }
      this.modal = 'block';
    },
    showModalConversation: function showModalConversation(state) {
      var id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
      window.location.href = "/admin-tenant-tickets/".concat(id, "/ticket");
    },
    newSuport: function newSuport() {
      var _this = this;
      this.validateForm();
      if (!this.canStoreTicket) return;
      this.loading = true;
      axios.post('/api/v1/new-ticket', this.form).then(function (response) {
        _this.showModal(false);
        _this.resetForm();
        _this.getTicketsByTenant();
      })["catch"](function (error) {
        console.log(error);
      })["finally"](function () {
        return _this.loading = false;
      });
    },
    validateForm: function validateForm() {
      this.reset();
      if (!this.form.ticket_type_id) {
        this.canStoreTicket = false;
        return this.errors.ticket_type_id = ["Selecione o tipo de chamado"];
      }
      if (!this.form.description) {
        this.canStoreTicket = false;
        return this.errors.description = ["Informe uma descrição para o chamado"];
      }
      this.form.message = tinymce.get("message").getContent({
        format: 'raw'
      });
      if (!this.form.message) {
        this.canStoreTicket = false;
        return this.errors.message = ["Descreva o seu chamado"];
      }
      this.canStoreTicket = true;
    },
    reset: function reset() {
      this.canStoreTicket = false;
      this.errors = {
        ticket_type_id: "",
        description: "",
        message: ""
      };
    },
    resetForm: function resetForm() {
      this.form = {
        ticket_type_id: "",
        description: "",
        message: ""
      };
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=template&id=0030ec32":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=template&id=0030ec32 ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "top-chat"
};
var _hoisted_2 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "desc"
}, null, -1 /* HOISTED */);
var _hoisted_3 = {
  key: 0,
  "class": "buttons"
};
var _hoisted_4 = {
  key: 1,
  "class": "buttons"
};
var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "alert alert-warning p-1 mt-3 fade show",
  role: "alert"
}, " Esse Ticket foi encerrado ", -1 /* HOISTED */);
var _hoisted_6 = [_hoisted_5];
var _hoisted_7 = {
  "class": "chatbox"
};
var _hoisted_8 = {
  "class": "chat-window pt-2",
  id: "chat_"
};
var _hoisted_9 = {
  key: 0,
  "class": "msg-container msg-self",
  id: "msg-0"
};
var _hoisted_10 = {
  "class": "msg-box"
};
var _hoisted_11 = {
  "class": "flr"
};
var _hoisted_12 = {
  "class": "messages"
};
var _hoisted_13 = ["innerHTML"];
var _hoisted_14 = {
  "class": "timestamp"
};
var _hoisted_15 = {
  "class": "username"
};
var _hoisted_16 = {
  "class": "posttime"
};
var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
  "class": "user-img",
  id: "user-0",
  src: "//gravatar.com/avatar/56234674574535734573000000000001?d=retro"
}, null, -1 /* HOISTED */);
var _hoisted_18 = {
  key: 1,
  "class": "msg-container msg-remote",
  id: "msg-0"
};
var _hoisted_19 = {
  "class": "msg-box"
};
var _hoisted_20 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
  "class": "user-img",
  id: "user-0",
  src: "//gravatar.com/avatar/00034587632094500000000000000000?d=retro"
}, null, -1 /* HOISTED */);
var _hoisted_21 = {
  "class": "flr"
};
var _hoisted_22 = {
  "class": "messages"
};
var _hoisted_23 = ["innerHTML"];
var _hoisted_24 = {
  "class": "timestamp"
};
var _hoisted_25 = {
  "class": "username"
};
var _hoisted_26 = {
  "class": "posttime"
};
var _hoisted_27 = {
  "class": "chat-input",
  onsubmit: "return false;"
};
var _hoisted_28 = {
  style: {
    "width": "24px",
    "height": "24px"
  },
  viewBox: "0 0 24 24"
};
var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("path", {
  fill: "rgba(0,0,0,.38)",
  d: "M17,12L12,17V14H8V10H12V7L17,12M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L5,8.09V15.91L12,19.85L19,15.91V8.09L12,4.15Z"
}, null, -1 /* HOISTED */);
var _hoisted_30 = [_hoisted_29];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _this = this;
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [_hoisted_2, $options.canSendMessage ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-sm btn-primary",
    onClick: _cache[0] || (_cache[0] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.closeTicket();
    }, ["prevent"]))
  }, "Encerrar ticket")])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), !$options.canSendMessage ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_4, [].concat(_hoisted_6))) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_8, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.conversation.data, function (msg, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
      key: index
    }, [msg !== null && msg !== void 0 && msg.created_by_tenant ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("article", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
      "class": "msg",
      id: "msg-1",
      innerHTML: msg.message
    }, null, 8 /* PROPS */, _hoisted_13)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_15, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(msg.user_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("•"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(msg.created_at), 1 /* TEXT */)])]), _hoisted_17])])) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("article", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [_hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_22, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
      "class": "msg",
      id: "msg-0",
      innerHTML: msg.message
    }, null, 8 /* PROPS */, _hoisted_23)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_25, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(msg.user_name), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("•"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_26, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(msg.created_at), 1 /* TEXT */)])])])]))], 64 /* STABLE_FRAGMENT */);
  }), 128 /* KEYED_FRAGMENT */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", _hoisted_27, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
    cols: "30",
    rows: "10",
    placeholder: "Escreva uma mensagem",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return _ctx.form.message = $event;
    })
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.form.message]]), $options.canSendMessage ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("button", {
    key: 0,
    onClick: _cache[2] || (_cache[2] = function ($event) {
      return _this.sendMessage();
    })
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", _hoisted_28, [].concat(_hoisted_30)))])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])], 64 /* STABLE_FRAGMENT */);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=template&id=64c7395c":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=template&id=64c7395c ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "card"
};
var _hoisted_2 = {
  "class": "card-header"
};
var _hoisted_3 = {
  "class": "card-body"
};
var _hoisted_4 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("ul", {
  "class": "nav nav-tabs",
  id: "myTab",
  role: "tablist"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", {
  "class": "nav-item",
  role: "presentation"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  "class": "nav-link active",
  id: "home-tab",
  "data-bs-toggle": "tab",
  "data-bs-target": "#home",
  type: "button",
  role: "tab",
  "aria-controls": "home",
  "aria-selected": "true"
}, "Pendentes")]), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("li", {
  "class": "nav-item",
  role: "presentation"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
  "class": "nav-link",
  id: "profile-tab",
  "data-bs-toggle": "tab",
  "data-bs-target": "#profile",
  type: "button",
  role: "tab",
  "aria-controls": "profile",
  "aria-selected": "false"
}, "Finalizados")])], -1 /* HOISTED */);
var _hoisted_5 = {
  "class": "tab-content",
  id: "myTabContent"
};
var _hoisted_6 = {
  "class": "tab-pane fade show active",
  id: "home",
  role: "tabpanel",
  "aria-labelledby": "home-tab"
};
var _hoisted_7 = {
  "class": "table table-condensed"
};
var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Descrição"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Data da criação"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  width: "270"
}, "Ações")])], -1 /* HOISTED */);
var _hoisted_9 = {
  key: 0
};
var _hoisted_10 = {
  key: 0,
  "class": "alert alert-warning p-1"
};
var _hoisted_11 = {
  key: 1,
  "class": "alert alert-info p-1"
};
var _hoisted_12 = ["onClick"];
var _hoisted_13 = {
  "class": "fa-solid fa-eye position-relative"
};
var _hoisted_14 = {
  key: 0,
  "class": "ms-2 position-absolute start-100 translate-middle badge rounded-pill bg-danger"
};
var _hoisted_15 = {
  "class": "tab-pane fade",
  id: "profile",
  role: "tabpanel",
  "aria-labelledby": "profile-tab"
};
var _hoisted_16 = {
  "class": "table table-condensed"
};
var _hoisted_17 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Descrição"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Status"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Data da criação"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  width: "270"
}, "Ações")])], -1 /* HOISTED */);
var _hoisted_18 = {
  key: 0
};
var _hoisted_19 = {
  key: 0,
  "class": "alert alert-warning p-1"
};
var _hoisted_20 = {
  key: 1,
  "class": "alert alert-info p-1"
};
var _hoisted_21 = ["onClick"];
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa-solid fa-eye"
}, null, -1 /* HOISTED */);
var _hoisted_23 = [_hoisted_22];
var _hoisted_24 = {
  "class": "modal-dialog modal-xl",
  role: "document"
};
var _hoisted_25 = {
  "class": "modal-content"
};
var _hoisted_26 = {
  "class": "modal-header"
};
var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
  "class": "modal-title",
  id: "exampleModalLiveLabel"
}, "Novo chamado", -1 /* HOISTED */);
var _hoisted_28 = {
  action: "#",
  method: "POST"
};
var _hoisted_29 = {
  "class": "modal-body"
};
var _hoisted_30 = {
  "class": "container mb-2"
};
var _hoisted_31 = {
  "class": "form-group mt-2"
};
var _hoisted_32 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "* Qual o tipo de chamado?", -1 /* HOISTED */);
var _hoisted_33 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  disabled: "",
  selected: ""
}, "Selecione uma opção", -1 /* HOISTED */);
var _hoisted_34 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "0"
}, " Dúvidas ", -1 /* HOISTED */);
var _hoisted_35 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("option", {
  value: "1"
}, " Suporte ", -1 /* HOISTED */);
var _hoisted_36 = [_hoisted_33, _hoisted_34, _hoisted_35];
var _hoisted_37 = {
  key: 0,
  "class": "form-text text-danger"
};
var _hoisted_38 = {
  "class": "form-group mt-2"
};
var _hoisted_39 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "* Descrição do chamado:", -1 /* HOISTED */);
var _hoisted_40 = {
  key: 0,
  "class": "form-text text-danger"
};
var _hoisted_41 = {
  "class": "form-group mt-2"
};
var _hoisted_42 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", null, "* Detalhes:", -1 /* HOISTED */);
var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
  id: "message",
  ols: "30",
  rows: "5",
  "class": "form-control form-control-sm editor"
}, "\n                                ", -1 /* HOISTED */);
var _hoisted_44 = {
  key: 0,
  "class": "form-text text-danger"
};
var _hoisted_45 = {
  "class": "modal-footer"
};
var _hoisted_46 = {
  "class": "modal-dialog modal-xl",
  role: "document"
};
var _hoisted_47 = {
  "class": "modal-content"
};
var _hoisted_48 = {
  "class": "modal-header"
};
var _hoisted_49 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", {
  "class": "modal-title",
  id: "exampleModalLiveLabel"
}, "Detalhes do chamado", -1 /* HOISTED */);
var _hoisted_50 = {
  "class": "modal-body"
};
var _hoisted_51 = {
  "class": "modal-footer"
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_conversationView = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("conversationView");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Lista de chamados "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "ms-2 btn btn-outline-secondary btn-sm",
    onClick: _cache[0] || (_cache[0] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.showModal(true);
    }, ["prevent"]))
  }, " Abrir novo chamado ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [_hoisted_4, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_7, [_hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [_ctx.my_tickets.data.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 0
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.my_tickets.data, function (ticket, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
      key: index
    }, [ticket.status == 0 || ticket.status == 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.description), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [ticket.status == 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_10, " Em aberto")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), ticket.status == 1 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_11, " Em atendimento")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.created_at), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
      href: "#",
      onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
        return $options.showModalConversation(true, ticket.id);
      }, ["prevent"]),
      "class": "btn btn-info btn-sm"
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", _hoisted_13, [ticket.not_visualized_message > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_14, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.not_visualized_message), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])], 8 /* PROPS */, _hoisted_12)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 64 /* STABLE_FRAGMENT */);
  }), 128 /* KEYED_FRAGMENT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_16, [_hoisted_17, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [_ctx.my_tickets.data.length > 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
    key: 0
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.my_tickets.data, function (ticket, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
      key: index
    }, [ticket.status == 3 || ticket.status == 4 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.description), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [ticket.status == 3 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_19, " Encerrado pelo usuário")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), ticket.status == 4 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("span", _hoisted_20, " Encerrado pelo atendente")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(ticket.created_at), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
      href: "#",
      onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
        return $options.showModalConversation(true, ticket.id);
      }, ["prevent"]),
      "class": "btn btn-info btn-sm"
    }, [].concat(_hoisted_23), 8 /* PROPS */, _hoisted_21)])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 64 /* STABLE_FRAGMENT */);
  }), 128 /* KEYED_FRAGMENT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    id: "exampleModalLive",
    "class": "modal fade show",
    tabindex: "-1",
    role: "dialog",
    "aria-labelledby": "exampleModalLiveLabel",
    style: (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeStyle)({
      display: _ctx.modal
    })
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_26, [_hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn-close",
    "data-bs-dismiss": "modal",
    "aria-label": "Close",
    onClick: _cache[1] || (_cache[1] = function ($event) {
      return $options.showModal(false);
    })
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", _hoisted_28, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_29, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_30, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_31, [_hoisted_32, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return _ctx.form.ticket_type_id = $event;
    }),
    "class": "form-control form-control-sm",
    required: ""
  }, [].concat(_hoisted_36), 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, _ctx.form.ticket_type_id]]), _ctx.errors.ticket_type_id != '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_37, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.errors.ticket_type_id[0] || ""), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_38, [_hoisted_39, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "text",
    "onUpdate:modelValue": _cache[3] || (_cache[3] = function ($event) {
      return _ctx.form.description = $event;
    }),
    "class": "form-control form-control-sm",
    required: ""
  }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.form.description]]), _ctx.errors.description != '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_40, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.errors.description[0] || ""), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_41, [_hoisted_42, _hoisted_43, _ctx.errors.message != '' ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_44, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.errors.message[0] || ""), 1 /* TEXT */)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_45, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-sm btn-secondary",
    "data-bs-dismiss": "modal",
    onClick: _cache[4] || (_cache[4] = function ($event) {
      return $options.showModal(false);
    })
  }, "Cancelar"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    "class": "btn btn-sm btn-primary",
    onClick: _cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.newSuport();
    }, ["prevent"]))
  }, "Salvar")])])])])], 4 /* STYLE */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
    id: "modalConversation",
    "class": "modal fade show",
    tabindex: "-1",
    role: "dialog",
    "aria-labelledby": "exampleModalLiveLabel",
    style: (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeStyle)({
      display: _ctx.modalConvesation
    })
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_46, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_47, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_48, [_hoisted_49, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn-close",
    "data-bs-dismiss": "modal",
    "aria-label": "Close",
    onClick: _cache[6] || (_cache[6] = function ($event) {
      return $options.showModalConversation(false);
    })
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_50, [_ctx.conversationId ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(_component_conversationView, {
    key: 0,
    id: _ctx.conversationId
  }, null, 8 /* PROPS */, ["id"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_51, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn btn-sm btn-secondary",
    "data-bs-dismiss": "modal",
    onClick: _cache[7] || (_cache[7] = function ($event) {
      return $options.showModalConversation(false);
    })
  }, "Fechar")])])])], 4 /* STYLE */)], 64 /* STABLE_FRAGMENT */);
}

/***/ }),

/***/ "./node_modules/vue-loader/dist/exportHelper.js":
/*!******************************************************!*\
  !*** ./node_modules/vue-loader/dist/exportHelper.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
// runtime helper for setting properties on components
// in a tree-shakable way
exports["default"] = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
        target[key] = val;
    }
    return target;
};


/***/ }),

/***/ "./resources/js/views/admin/tickets/tenant/conversation.view.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/views/admin/tickets/tenant/conversation.view.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _conversation_view_vue_vue_type_template_id_0030ec32__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./conversation.view.vue?vue&type=template&id=0030ec32 */ "./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=template&id=0030ec32");
/* harmony import */ var _conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./conversation.view.vue?vue&type=script&lang=js */ "./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=script&lang=js");
/* harmony import */ var _Users_wesleysanches_Desktop_projetos_laravel_buzzin_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_Users_wesleysanches_Desktop_projetos_laravel_buzzin_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_conversation_view_vue_vue_type_template_id_0030ec32__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/admin/tickets/tenant/conversation.view.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/admin/tickets/tenant/support.view.vue":
/*!******************************************************************!*\
  !*** ./resources/js/views/admin/tickets/tenant/support.view.vue ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _support_view_vue_vue_type_template_id_64c7395c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./support.view.vue?vue&type=template&id=64c7395c */ "./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=template&id=64c7395c");
/* harmony import */ var _support_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./support.view.vue?vue&type=script&lang=js */ "./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=script&lang=js");
/* harmony import */ var _Users_wesleysanches_Desktop_projetos_laravel_buzzin_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_Users_wesleysanches_Desktop_projetos_laravel_buzzin_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_support_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_support_view_vue_vue_type_template_id_64c7395c__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/admin/tickets/tenant/support.view.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=script&lang=js":
/*!***********************************************************************************************!*\
  !*** ./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./conversation.view.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=script&lang=js":
/*!******************************************************************************************!*\
  !*** ./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=script&lang=js ***!
  \******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_support_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_support_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./support.view.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=template&id=0030ec32":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=template&id=0030ec32 ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_template_id_0030ec32__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_template_id_0030ec32__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./conversation.view.vue?vue&type=template&id=0030ec32 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/conversation.view.vue?vue&type=template&id=0030ec32");


/***/ }),

/***/ "./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=template&id=64c7395c":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=template&id=64c7395c ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_support_view_vue_vue_type_template_id_64c7395c__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_support_view_vue_vue_type_template_id_64c7395c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./support.view.vue?vue&type=template&id=64c7395c */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/tenant/support.view.vue?vue&type=template&id=64c7395c");


/***/ })

}]);