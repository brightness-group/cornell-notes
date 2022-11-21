require('./bootstrap');

import MultiRootEditor from './ckeditor/ckeditor';

import { createApp } from 'vue'

import AppLayout from './layouts/App';
import CornellNotes from './components/CornellNotes';
import PublicNote from './components/PublicNote';

import UserProfile from './components/account/UserProfile';
import ChangePassword from './components/account/ChangePassword';
import Billing from "./components/account/subscription/Billing";

import global from './utils/global';
import emitter from "./services/EventBus";
import user from "./services/User";
import note from "./services/Note";

const app = createApp({
    components: {
        AppLayout,
        CornellNotes,
        UserProfile,
        ChangePassword,
        Billing,
        PublicNote,
    }
});

app.config.globalProperties.$dn   = global;
app.config.globalProperties.$mitt = emitter;
app.config.globalProperties.$user = user;
app.config.globalProperties.$note = note;

app.mount('#app');
