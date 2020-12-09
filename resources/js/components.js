// Components
Vue.component('md-input', require('./components/form/Input').default);
Vue.component('sidebar', require('./components/sidebar/Sidebar').default);
Vue.component('sidebar-item', require('./components/sidebar/SidebarItem').default);
Vue.component('sidebar-button', require('./components/sidebar/SidebarButton').default);
Vue.component('modal', require('./components/Modal.vue').default);

// Views
Vue.component('login-form', require('./view/LoginForm').default);
Vue.component('client-form', require('./view/ClientForm').default);
Vue.component('order-form', require('./view/OrderForm').default);

