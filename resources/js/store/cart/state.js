const state = {
    products: {
        data: []
    },
    total: 0,
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
    step: 0
};

export default state;