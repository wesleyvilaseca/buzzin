const mutations = {
    SET_PRODUCTS_COMPANY(state, products) {
        state.products = products
    },

    SET_PRODUCTS_COMPANY_INCREMENT(state, products) {
        const productsIntoArray = new Proxy(state.products.data, {
            get(target, prop, receiver) {
                return target[prop]
            }
        });

        const newProduts = new Proxy(products.data, {
            get(target, prop, receiver) {
                return target[prop]
            }
        });

        const mergedObject = [...productsIntoArray, ...newProduts]
        state.products.data = mergedObject
    },
}

export default mutations;