const state = {
    products: {
        data: []
    },
    total: 0,
    subtotal: 0,
    isInCheckout: false,
    selectedAddress: {
        address: "",
        zip_code: "",
        state: "",
        city: "",
        district: "",
        number: "",
        complement: "",
        id: ""
    },
    shippingMethods: {
        data: []
    },
    selectedShippingMethod: {
        price: ""
    },
    paymentMethods: {
        data: []
    },
    selectedPaymentMethod: {
        description: ""
    },
    step: 0,
    troco: "",
    precisa_troco: "undefined",
    comment: ""
};

export default state;