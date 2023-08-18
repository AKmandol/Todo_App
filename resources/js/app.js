require('./bootstrap');

import { createApp } from 'vue'

import router from "./router.js"
import mainapp from './components/master.vue'

const app = createApp({
    components: {
        mainapp,
    }
})

app.use(router);
app.mount('#app');
