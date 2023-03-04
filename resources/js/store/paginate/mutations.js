export const mutations = {
    SET_PAGINATE(state, data) {
        var next_page = data.current_page + 1
        state.meta = {
            prev_page: data.from,
            current_page: data.current_page,
            per_page: data.per_page,
            total: data.total,
            next_page: data.current_page == data.last_page ? "" : next_page
        }
    },
}

export default mutations;