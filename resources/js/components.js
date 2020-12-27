import DatePick from 'vue-date-pick';

Vue.component('date-pick', Vue.prototype.$helpers.mergeRecursive(DatePick, {
	props: {
		nextMonthCaption: {type: String, default: 'Próximo mês'},
		prevMonthCaption: {type: String, default: 'Mês anterior'},
		setTimeCaption: {type: String, default: 'Selecione a hora:'},
		weekdays: {
		    type: Array,
		    default: () => ([
		        'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom'
		    ])
		},
		months: {
		    type: Array,
		    default: () => ([
		        'Janeiro', 'Fevereiro', 'Março', 'Abril',
		        'Maio', 'Junho', 'Julho', 'Agosto',
		        'Setembro', 'Outubro', 'Novebro', 'Dezembro'
		    ])
		}
	},
	methods: {
		 addCloseEvents() {
            if (! this.closeEventListener) {
                this.closeEventListener = e => this.inspectCloseEvent(e);
                ['click', 'keyup'].forEach(
                    eventName => document.addEventListener(eventName, this.closeEventListener)
                );
            }
        },
	}
}));

// Components
Vue.component('md-input', require('./components/form/Input').default);
Vue.component('sidebar', require('./components/sidebar/Sidebar').default);
Vue.component('sidebar-item', require('./components/sidebar/SidebarItem').default);
Vue.component('sidebar-button', require('./components/sidebar/SidebarButton').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('dynamic-view', require('./components/DynamicView.vue').default);
Vue.component('toast', require('./components/Toast.vue').default);
Vue.component('btn-install-pwa', require('./components/BtnInstallPwa.vue').default);

// Views
Vue.component('login-form', require('./view/LoginForm').default);
Vue.component('client-form', require('./view/clients/Form').default);
Vue.component('order-form', require('./view/orders/Form').default);
Vue.component('order-installments-form', require('./view/orders/InstallmentsForm').default);
Vue.component('order-cash-form', require('./view/orders/CashForm').default);
Vue.component('my-account-form', require('./view/my-account/Form').default);
Vue.component('send-reset-password-form', require('./view/SendResetPasswordForm').default);
Vue.component('reset-password-form', require('./view/ResetPasswordForm').default);

