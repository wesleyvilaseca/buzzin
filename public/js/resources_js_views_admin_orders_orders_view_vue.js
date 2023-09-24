"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_admin_orders_orders_view_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=script&lang=js":
/*!***********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=script&lang=js ***!
  \***********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    display: {
      required: true
    },
    order: {
      type: Object,
      required: true
    }
  },
  computed: {
    subtotal: function subtotal() {
      var _this$order, _this$order$products;
      var total = 0;
      (_this$order = this.order) === null || _this$order === void 0 ? void 0 : (_this$order$products = _this$order.products) === null || _this$order$products === void 0 ? void 0 : _this$order$products.map(function (item, index) {
        total += item.qty * item.price;
      });
      return total;
    },
    total: function total() {
      return this.order.total.toLocaleString('pt-br', {
        minimumFractionDigits: 2
      });
    }
  },
  data: function data() {
    return {
      status: '',
      loading: false,
      RETIRADA: 'Retirada'
    };
  },
  methods: {
    closeDetails: function closeDetails() {
      this.$emit('closeDetails');
    },
    updateStatus: function updateStatus() {
      var _this = this;
      this.loading = true;
      axios.patch('/api/v1/my-orders', {
        status: this.status,
        identify: this.order.identify
      }).then(function (response) {
        return _this.$emit('statusUpdated');
      })["catch"](function (error) {
        return alert('error');
      })["finally"](function () {
        return _this.loading = false;
      });
    }
  },
  watch: {
    order: function order() {
      this.status = this.order.status;
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/orders.view.vue?vue&type=script&lang=js":
/*!*************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/orders.view.vue?vue&type=script&lang=js ***!
  \*************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _partials_DetailOrder__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./_partials/DetailOrder */ "./resources/js/views/admin/orders/_partials/DetailOrder.vue");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  created: function created() {},
  mounted: function mounted() {
    this.getOrders();
  },
  data: function data() {
    return {
      RETIRADA: 'Retirada',
      orders: {
        data: []
      },
      loadingOrders: false,
      dateFilter: new Date().getFullYear() + '-' + ("0" + (new Date().getMonth() + 1)).slice(-2) + '-' + ("0" + new Date().getDate()).slice(-2),
      status: 'all',
      order: {
        identify: "",
        total: "",
        status: "",
        status_label: "",
        date: "",
        date_br: "",
        company: {
          name: "",
          image: "",
          uuid: "",
          contact: ""
        },
        client: {
          name: "",
          email: ""
        },
        table: "",
        products: [],
        evaluations: []
      },
      displayOrder: 'none'
    };
  },
  computed: {},
  methods: {
    paymentTypeIntegration: function paymentTypeIntegration(order) {
      // console.log(order.order_integration_transaction)
      if (order.payment_method.integration) {
        switch (order.order_integration_transaction.payment_type_id) {
          case 'ticket':
            return 'Boleto';
          default:
            return 'Cartão de crédito';
        }
      }
    },
    getOrders: function getOrders() {
      var _this = this;
      this.reset();
      this.loadingOrders = true;
      axios.get('/api/v1/my-orders', {
        params: {
          status: this.status,
          date: this.dateFilter
        }
      }).then(function (response) {
        return _this.orders = response.data;
      })["catch"](function (error) {
        return alert('error');
      })["finally"](function () {
        return _this.loadingOrders = false;
      });
    },
    reset: function reset() {
      this.orders = {
        data: []
      };
    },
    statusUpdated: function statusUpdated(params) {
      this.closeDetails();
      this.getOrders();
    },
    openDetails: function openDetails(order) {
      this.order = order;
      this.displayOrder = 'block';
    },
    closeDetails: function closeDetails() {
      this.order = {
        identify: "",
        total: "",
        status: "",
        status_label: "",
        date: "",
        date_br: "",
        company: {
          name: "",
          image: "",
          uuid: "",
          contact: ""
        },
        client: {
          name: "",
          email: ""
        },
        table: "",
        products: [],
        evaluations: []
      }, this.displayOrder = 'none';
    }
  },
  watch: {
    status: function status() {
      return this.getOrders();
    },
    dateFilter: function dateFilter() {
      return this.getOrders();
    }
  },
  components: {
    DetailOrder: _partials_DetailOrder__WEBPACK_IMPORTED_MODULE_0__["default"]
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=template&id=224ac294":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=template&id=224ac294 ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "modal-dialog modal-xl",
  role: "document"
};
var _hoisted_2 = {
  "class": "modal-content"
};
var _hoisted_3 = {
  "class": "modal-header"
};
var _hoisted_4 = {
  "class": "modal-title",
  id: "exampleModalLiveLabel"
};
var _hoisted_5 = {
  "class": "modal-body"
};
var _hoisted_6 = {
  "class": "row"
};
var _hoisted_7 = {
  "class": "col-md-7"
};
var _hoisted_8 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "status"
}, "Status:", -1 /* HOISTED */);
var _hoisted_9 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<option value=\"open\">Aberto</option><option value=\"done\">Completo</option><option value=\"rejected\">Rejeitado</option><option value=\"working\">Andamento</option><option value=\"canceled\">Cancelado</option><option value=\"delivering\">Em transito</option>", 6);
var _hoisted_15 = [_hoisted_9];
var _hoisted_16 = {
  "class": "col-md-5"
};
var _hoisted_17 = ["disabled"];
var _hoisted_18 = {
  "class": "row"
};
var _hoisted_19 = {
  "class": "col-md-7"
};
var _hoisted_20 = {
  "class": "card mt-2"
};
var _hoisted_21 = {
  "class": "card-header"
};
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_23 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_24 = {
  "class": "card-body"
};
var _hoisted_25 = {
  "class": "table-responsive"
};
var _hoisted_26 = {
  "class": "table table-condensed"
};
var _hoisted_27 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col"
}, "#"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col"
}, "Produto"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col"
}, "Quantidade"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col"
}, "Valor"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  scope: "col"
}, "Total")])], -1 /* HOISTED */);
var _hoisted_28 = ["src", "alt"];
var _hoisted_29 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "4",
  align: "right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, "Subtotal")], -1 /* HOISTED */);
var _hoisted_30 = {
  colspan: "4",
  align: "right"
};
var _hoisted_31 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
  colspan: "4",
  align: "right"
}, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, " Total ")], -1 /* HOISTED */);
var _hoisted_32 = {
  "class": "col-md-5"
};
var _hoisted_33 = {
  "class": "card mt-2"
};
var _hoisted_34 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", {
  "class": "card-header"
}, "Dados do cliente", -1 /* HOISTED */);
var _hoisted_35 = {
  "class": "card-body"
};
var _hoisted_36 = {
  "class": "row"
};
var _hoisted_37 = {
  "class": "col-md-5",
  style: {
    "font-size": "0.8rem"
  }
};
var _hoisted_38 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_39 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_40 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_41 = {
  key: 0,
  "class": "col-md-7",
  style: {
    "font-size": "0.8rem"
  }
};
var _hoisted_42 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_43 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_44 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_45 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);

function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _$props$order, _$props$order$shippin, _$props$order2, _$props$order2$shippi, _$props$order$client, _$props$order$client2, _$props$order3, _$props$order3$shippi, _$props$order$client_, _$props$order$client_2, _$props$order$client_3, _$props$order$client_4, _$props$order$client_5, _$props$order$client_6, _$props$order$client_7;
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", {
    id: "exampleModalLive",
    "class": "modal fade show",
    tabindex: "-1",
    role: "dialog",
    "aria-labelledby": "exampleModalLiveLabel",
    style: (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeStyle)({
      display: $props.display
    })
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h5", _hoisted_4, "Detalhes do Pedido " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.order.identify), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "btn-close",
    "data-bs-dismiss": "modal",
    "aria-label": "Close",
    onClick: _cache[0] || (_cache[0] = function () {
      return $options.closeDetails && $options.closeDetails.apply($options, arguments);
    })
  })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", {
    action: "#",
    method: "POST",
    "class": "form form-inline",
    onSubmit: _cache[2] || (_cache[2] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function () {
      return $options.updateStatus && $options.updateStatus.apply($options, arguments);
    }, ["prevent"]))
  }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_7, [_hoisted_8, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    name: "status",
    "class": "form-control form-control-sm",
    "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
      return $data.status = $event;
    })
  }, _hoisted_15, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.status]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "submit",
    "class": "btn btn-sm btn-info mt-4",
    disabled: $data.loading
  }, " Atualizar Status ", 8 /* PROPS */, _hoisted_17)])])], 32 /* HYDRATE_EVENTS */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_18, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_19, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Número do pedido: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.order.identify) + " ", 1 /* TEXT */), _hoisted_22, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Data: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.order.date_br) + " ", 1 /* TEXT */), _hoisted_23, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Status: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.order.status_label), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_24, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_25, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_26, [_hoisted_27, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($props.order.products, function (product, index) {
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: index
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("img", {
      src: product.image,
      alt: product.title,
      style: {
        "max-width": "50px"
      }
    }, null, 8 /* PROPS */, _hoisted_28)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.title), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.qty), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, "R$ " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.price), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, "R$ " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.qty * product.price), 1 /* TEXT */)]);
  }), 128 /* KEYED_FRAGMENT */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tfoot", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_29, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, " R$ " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.subtotal), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_30, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("strong", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order = $props.order) === null || _$props$order === void 0 ? void 0 : (_$props$order$shippin = _$props$order.shipping_method) === null || _$props$order$shippin === void 0 ? void 0 : _$props$order$shippin.description), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, " R$ " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order2 = $props.order) === null || _$props$order2 === void 0 ? void 0 : (_$props$order2$shippi = _$props$order2.shipping_method) === null || _$props$order2$shippi === void 0 ? void 0 : _$props$order2$shippi.price), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [_hoisted_31, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, " R$ " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.order.total), 1 /* TEXT */)])])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_32, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_33, [_hoisted_34, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_35, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_36, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_37, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Cliente: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client = $props.order.client) === null || _$props$order$client === void 0 ? void 0 : _$props$order$client.name) + " ", 1 /* TEXT */), _hoisted_38, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Email: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client2 = $props.order.client) === null || _$props$order$client2 === void 0 ? void 0 : _$props$order$client2.email) + " ", 1 /* TEXT */), _hoisted_39, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Celular: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.order.client_mobile_phone) + " ", 1 /* TEXT */), _hoisted_40, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" CPF: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.order.client_doc), 1 /* TEXT */)]), ((_$props$order3 = $props.order) === null || _$props$order3 === void 0 ? void 0 : (_$props$order3$shippi = _$props$order3.shipping_method) === null || _$props$order3$shippi === void 0 ? void 0 : _$props$order3$shippi.description) !== $data.RETIRADA ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_41, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Endereço: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client_ = $props.order.client_address) === null || _$props$order$client_ === void 0 ? void 0 : _$props$order$client_.address) + " - nº: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client_2 = $props.order.client_address) === null || _$props$order$client_2 === void 0 ? void 0 : _$props$order$client_2.number), 1 /* TEXT */), _hoisted_42, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Complemento: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client_3 = $props.order.client_address) === null || _$props$order$client_3 === void 0 ? void 0 : _$props$order$client_3.complement) + " ", 1 /* TEXT */), _hoisted_43, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" Bairro: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client_4 = $props.order.client_address) === null || _$props$order$client_4 === void 0 ? void 0 : _$props$order$client_4.district) + " ", 1 /* TEXT */), _hoisted_44, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" CEP: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client_5 = $props.order.client_address) === null || _$props$order$client_5 === void 0 ? void 0 : _$props$order$client_5.zip_code) + " ", 1 /* TEXT */), _hoisted_45, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)(" " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client_6 = $props.order.client_address) === null || _$props$order$client_6 === void 0 ? void 0 : _$props$order$client_6.city) + " - " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)((_$props$order$client_7 = $props.order.client_address) === null || _$props$order$client_7 === void 0 ? void 0 : _$props$order$client_7.state), 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)(" <ul>\n                        <li>Número do pedido: {{ order.identify }}</li>\n                        <li>Total: R$ {{ total }}</li>\n                        <li>Status: {{ order.status_label }}</li>\n                        <li>Data: {{ order.date_br }}</li>\n                        <li>\n                            Cliente:\n                            <ul>\n                                <li>Nome: {{ order.client.name }}</li>\n                                <li>image: {{ order.image }}</li>\n                                <li>uuid: {{ order.uuid }}</li>\n                                <li>Contato: {{ order.client.contact }}</li>\n                            </ul>\n                        </li>\n                        <li>Mesa: {{ order.table.name }}</li>\n                        <li>\n                            Produtos:\n                            <ul>\n                                <li v-for=\"(product, index) in order.products\" :key=\"index\">\n                                    <img :src=\"product.image\" :alt=\"product.title\" style=\"max-width: 100px;\">\n                                    {{ product.title }}\n                                </li>\n                            </ul>\n                        </li>\n                    </ul> ")])])])], 4 /* STYLE */);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/orders.view.vue?vue&type=template&id=3c32eea3":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/orders.view.vue?vue&type=template&id=3c32eea3 ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.esm-bundler.js");

var _hoisted_1 = {
  "class": "card-header"
};
var _hoisted_2 = {
  action: "#",
  method: "POST",
  "class": "form form-inline"
};
var _hoisted_3 = {
  "class": "row"
};
var _hoisted_4 = {
  "class": "col-md-3"
};
var _hoisted_5 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "status"
}, "Status:", -1 /* HOISTED */);
var _hoisted_6 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createStaticVNode)("<option value=\"all\">Todos</option><option value=\"open\">Aberto</option><option value=\"done\">Completo</option><option value=\"rejected\">Rejeitados</option><option value=\"working\">Andamento</option><option value=\"canceled\">Cancelado</option><option value=\"delivering\">Em transito</option>", 7);
var _hoisted_13 = [_hoisted_6];
var _hoisted_14 = {
  "class": "col-md-3"
};
var _hoisted_15 = {
  "class": "form-group"
};
var _hoisted_16 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("label", {
  "for": "date"
}, "Data:", -1 /* HOISTED */);
var _hoisted_17 = {
  "class": "card-body"
};
var _hoisted_18 = {
  "class": "table table-condensed"
};
var _hoisted_19 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Número"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Status entrega"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Data"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, "Detalhes"), /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", {
  width: "270"
}, "Ações")])], -1 /* HOISTED */);
var _hoisted_20 = {
  key: 0
};
var _hoisted_21 = {
  key: 1
};
var _hoisted_22 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
  "class": "alert alert-warning p-1"
}, "Retirada", -1 /* HOISTED */);
var _hoisted_23 = [_hoisted_22];
var _hoisted_24 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("br", null, null, -1 /* HOISTED */);
var _hoisted_25 = ["onClick"];
var _hoisted_26 = /*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("i", {
  "class": "fa-solid fa-eye"
}, null, -1 /* HOISTED */);
var _hoisted_27 = [_hoisted_26];
var _hoisted_28 = {
  key: 0
};
var _hoisted_29 = {
  key: 1
};
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_detail_order = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("detail-order");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("form", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [_hoisted_5, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("select", {
    name: "status",
    "class": "form-control",
    "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
      return $data.status = $event;
    }),
    onChange: _cache[1] || (_cache[1] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.getOrders();
    }, ["prevent"]))
  }, _hoisted_13, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelSelect, $data.status]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_14, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_15, [_hoisted_16, (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
    type: "date",
    "class": "form-control",
    "onUpdate:modelValue": _cache[2] || (_cache[2] = function ($event) {
      return $data.dateFilter = $event;
    }),
    onChange: _cache[3] || (_cache[3] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
      return $options.getOrders();
    }, ["prevent"]))
  }, null, 544 /* HYDRATE_EVENTS, NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.dateFilter]])])])])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_18, [_hoisted_19, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.orders.data, function (order, index) {
    var _order$shipping_metho;
    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", {
      key: index
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.identify), 1 /* TEXT */), (order === null || order === void 0 ? void 0 : (_order$shipping_metho = order.shipping_method) === null || _order$shipping_metho === void 0 ? void 0 : _order$shipping_metho.description) !== $data.RETIRADA ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", _hoisted_20, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.status_label), 1 /* TEXT */)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("td", _hoisted_21, _hoisted_23)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.date_br), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [order.payment_method.integration ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
      key: 0
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.payment_method.integration) + " - " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($options.paymentTypeIntegration(order)) + " ", 1 /* TEXT */), _hoisted_24, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("b", null, "Status: " + (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.order_integration_transaction.status), 1 /* TEXT */)], 64 /* STABLE_FRAGMENT */)) : ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
      key: 1
    }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(order.payment_method.description), 1 /* TEXT */)], 64 /* STABLE_FRAGMENT */))]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
      href: "#",
      onClick: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withModifiers)(function ($event) {
        return $options.openDetails(order);
      }, ["prevent"]),
      "class": "btn btn-info btn-sm"
    }, _hoisted_27, 8 /* PROPS */, _hoisted_25)])]);
  }), 128 /* KEYED_FRAGMENT */))])]), $data.loadingOrders ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_28, "Carregando seus pedidos")) : $data.orders.data.length == 0 ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_29, "Nenhum Pedido")) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_detail_order, {
    order: $data.order,
    display: $data.displayOrder,
    onCloseDetails: $options.closeDetails,
    onStatusUpdated: $options.statusUpdated
  }, null, 8 /* PROPS */, ["order", "display", "onCloseDetails", "onStatusUpdated"])]);
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

/***/ "./resources/js/views/admin/orders/_partials/DetailOrder.vue":
/*!*******************************************************************!*\
  !*** ./resources/js/views/admin/orders/_partials/DetailOrder.vue ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _DetailOrder_vue_vue_type_template_id_224ac294__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DetailOrder.vue?vue&type=template&id=224ac294 */ "./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=template&id=224ac294");
/* harmony import */ var _DetailOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DetailOrder.vue?vue&type=script&lang=js */ "./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_DetailOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_DetailOrder_vue_vue_type_template_id_224ac294__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/admin/orders/_partials/DetailOrder.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/admin/orders/orders.view.vue":
/*!*********************************************************!*\
  !*** ./resources/js/views/admin/orders/orders.view.vue ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _orders_view_vue_vue_type_template_id_3c32eea3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./orders.view.vue?vue&type=template&id=3c32eea3 */ "./resources/js/views/admin/orders/orders.view.vue?vue&type=template&id=3c32eea3");
/* harmony import */ var _orders_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./orders.view.vue?vue&type=script&lang=js */ "./resources/js/views/admin/orders/orders.view.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_orders_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_orders_view_vue_vue_type_template_id_3c32eea3__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/views/admin/orders/orders.view.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=script&lang=js":
/*!*******************************************************************************************!*\
  !*** ./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DetailOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DetailOrder_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DetailOrder.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/admin/orders/orders.view.vue?vue&type=script&lang=js":
/*!*********************************************************************************!*\
  !*** ./resources/js/views/admin/orders/orders.view.vue?vue&type=script&lang=js ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_orders_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_orders_view_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./orders.view.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/orders.view.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=template&id=224ac294":
/*!*************************************************************************************************!*\
  !*** ./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=template&id=224ac294 ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DetailOrder_vue_vue_type_template_id_224ac294__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_DetailOrder_vue_vue_type_template_id_224ac294__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./DetailOrder.vue?vue&type=template&id=224ac294 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/_partials/DetailOrder.vue?vue&type=template&id=224ac294");


/***/ }),

/***/ "./resources/js/views/admin/orders/orders.view.vue?vue&type=template&id=3c32eea3":
/*!***************************************************************************************!*\
  !*** ./resources/js/views/admin/orders/orders.view.vue?vue&type=template&id=3c32eea3 ***!
  \***************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_orders_view_vue_vue_type_template_id_3c32eea3__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_orders_view_vue_vue_type_template_id_3c32eea3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./orders.view.vue?vue&type=template&id=3c32eea3 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/views/admin/orders/orders.view.vue?vue&type=template&id=3c32eea3");


/***/ })

}]);