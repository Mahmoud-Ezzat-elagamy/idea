import axios from 'axios';
import  Alpine  from 'alpinejs';

window.axios = axios;
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-with'] = 'XMLHttpRequest';

window.Alpine = Alpine;
Alpine.start();
