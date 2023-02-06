require('./bootstrap');
import { createApp } from 'vue';

import zoneCreateView from './views/admin/zone/zoneCreateView';

var app = createApp();
app.component("zone-create-view", zoneCreateView);
app.mount('#app');