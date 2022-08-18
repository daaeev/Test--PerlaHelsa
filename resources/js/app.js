import Components from './components/index';
import { createApp } from 'vue';

const app = createApp({});

Components.forEach(element => {
    app.component(element.name, element);
});

app.mount('#application');