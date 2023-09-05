import app from '../../../main';
import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import VueTheMask from 'vue-the-mask';
import money from 'v-money3'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Select2 from 'vue3-select2-component';

/**
 * widgets components
 */
app.component('Select2', Select2)
app.component('Pagination', Bootstrap5Pagination);


app.use(Vue3Toasity, { autoClose: 3000 });
app.use(VueTheMask);
app.use(money, {
    masked: false,
    prefix: '',
    suffix: '',
    thousands: ',',
    decimal: '.',
    precision: 2,
    disableNegative: false,
    disabled: false,
    min: null,
    max: null,
    allowBlank: false,
    minimumNumberOfCharacters: 0,
});
