import cript from "../../support/cript";

const mutations = {
    ADD_PRODUCT_CART(state, params) {
        const company_uuid = params.uuid;
        const item = params.product;

        state.products.data.push({
            qty: 1,
            identify: item.identify,
            item,
        });

        localStorage.setItem(company_uuid, cript.cript(JSON.stringify(state.products.data)));
    },

    REMOVE_PROD_CART(state, params) {
        const company_uuid = params.uuid;
        const item = params.product;

        state.products.data = state.products.data.filter((productCart, index) => {
            return productCart.identify !== item.identify;
        });

        localStorage.setItem(company_uuid, cript.cript(JSON.stringify(state.products.data)));
    },

    INCREMENT_QTY_PROD_CART(state, params) {
        const item = params.product;
        const company_uuid = params.uuid;

        state.products.data = state.products.data.map((productCart, index) => {
            if (productCart.identify === item.identify) {
                state.products.data[index].qty++;
            }

            return state.products.data[index];
        });

        localStorage.setItem(company_uuid, cript.cript(JSON.stringify(state.products.data)));
    },

    DECREMENT_QTY_PROD_CART(state, params) {
        const item = params.product;
        const company_uuid = params.uuid;

        state.products.data = state.products.data.filter((productCart, index) => {
            if (productCart.identify == item.identify) {
                state.products.data[index].qty = state.products.data[index].qty - 1;
            }

            if (state.products.data[index].qty > 0)
                return state.products.data[index];
        });

        localStorage.setItem(company_uuid, cript.cript(JSON.stringify(state.products.data)));
    },

    CLEAR_CART(state, uuid) {
        state.products.data = [];
        localStorage.removeItem(uuid);
    },

    SET_CART(state, params) {
        state.products.data = params
    },

    TOTAL_CART(state) {
        let total = 0;
        state.products?.data?.map((itemCart, index) => {
            total += itemCart.qty * itemCart.item.price;
        });
        state.total = total;
    },

    SET_SHIPPING_VALUE_TO_TOTAL_CART(state, value) {
        state.total += parseFloat(value);
    },

    SET_IS_IN_CHECKOUT(state, value) {
        state.isInCheckout = value;
    },

    SET_SELECTED_ADDRESS(state, data) {
        state.selectedAddress = data;
    },

    SET_SHIPPING_METHODS(state, data) {
        state.shippingMethods.data = data;
    },

    SET_PAYMENT_METHODS(state, data) {
        state.paymentMethods.data = data;
    },

    SET_SELECTED_PAYMENT_METHOD(state, data) {
        state.selectedPaymentMethod = data;
    },

    SET_SELECTED_SHIPPING_METHOD(state, data) {
        state.selectedShippingMethod = data;
    }

};

export default mutations;