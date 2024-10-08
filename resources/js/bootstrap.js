window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Socket from 'socket.io-client';
// window.Pusher = require('pusher-js');

const host = window.location.host;

window.io = Socket;
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: `${host}:6001`,
});

if (host === process.env.MIX_APP_URL.replace(/^https?:\/\//, '')) {
    require('./Echo');
}

