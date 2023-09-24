"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_admin_tickets_support_conversation_view_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=script&lang=js":
/*!****************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=script&lang=js ***!
  \****************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm-bundler.js");
function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }

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
        tenant_user_id: ""
      },
      errors: {
        ticket_id: "",
        message: "",
        tenant_user_id: ""
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
    var _window, _window$Laravel;
    this.getTicketSupport(this.ticketid);
    this.form.ticket_id = this.ticketid;
    this.user_id = (_window = window) === null || _window === void 0 ? void 0 : (_window$Laravel = _window.Laravel) === null || _window$Laravel === void 0 ? void 0 : _window$Laravel.user_id;
    var that = this;
    window.Echo.channel("buzzin_database_private-message-ticket-tenant-created.".concat(that.user_id)).listen('MessageTicketTenantCreated', function (e) {
      that.setNewMessage(e.message);
      that.checkStatus();
      setTimeout(that.scroll(), 2000);
    });
    that.scroll();
  },
  methods: _objectSpread(_objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapActions)(["getTicketSupport", "sendSupportTicketMessage", "closeTicketBySupport"])), (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapMutations)({
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
      if (!this.form.tenant_user_id) {
        this.form.tenant_user_id = this.getTenantId();
      }
      this.sendSupportTicketMessage(this.form).then(function () {
        _this.form.message = "";
        _this.scroll();
      });
    },
    closeTicket: function closeTicket() {
      if (!this.form.tenant_user_id) {
        this.form.tenant_user_id = this.getTenantId();
      }
      this.closeTicketBySupport(this.form).then(function () {
        return window.location.href = "/admin-tickets";
      });
    },
    scroll: function scroll() {
      $("#chat_").animate({
        scrollTop: 20000000
      }, "slow");
    },
    getTenantId: function getTenantId() {
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

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=template&id=39b38b59":
/*!********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=template&id=39b38b59 ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
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
  "class": "msg-container msg-remote",
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
  "class": "msg-container msg-self",
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
  }, " Encerrar ticket")])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), !$options.canSendMessage ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_4, _hoisted_6)) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_7, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("section", _hoisted_8, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(_ctx.conversation.data, function (msg, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
      key: index
    }, [msg.created_by_tenant ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("article", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_10, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_11, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_12, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", {
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
  }, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("svg", _hoisted_28, _hoisted_30))])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])], 64 /* STABLE_FRAGMENT */);
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

/***/ "./resources/js/views/admin/tickets/support/conversation.view.vue":
/*!************************************************************************!*\
  !*** ./resources/js/views/admin/tickets/support/conversation.view.vue ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _conversation_view_vue_vue_type_template_id_39b38b59__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./conversation.view.vue?vue&type=template&id=39b38b59 */ "./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=template&id=39b38b59");
/* harmony import */ var _conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./conversation.view.vue?vue&type=script&lang=js */ "./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_conversation_view_vue_vue_type_template_id_39b38b59__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/admin/tickets/support/conversation.view.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=script&lang=js":
/*!************************************************************************************************!*\
  !*** ./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=script&lang=js ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./conversation.view.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=template&id=39b38b59":
/*!******************************************************************************************************!*\
  !*** ./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=template&id=39b38b59 ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_template_id_39b38b59__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_conversation_view_vue_vue_type_template_id_39b38b59__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./conversation.view.vue?vue&type=template&id=39b38b59 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/tickets/support/conversation.view.vue?vue&type=template&id=39b38b59");


/***/ })

}]);