require('./bootstrap');
import app from './main';
require('./config/components-registration/admin-dashboard/dashboard-components.js');
require('./config/components-registration/global-components/global-components.js');

import store from './store';

app.use(store);

app.mount('#app');