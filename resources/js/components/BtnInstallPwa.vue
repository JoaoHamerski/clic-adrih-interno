<template>
	<button v-if="! window.matchMedia('(display-mode: standalone)').matches" @click.prevent="installPWA">
		<slot></slot>
	</button>
</template>
<script>
	export default {
		data() {
			return {
				deferredPrompt: '',
				window: window
			}
		},
		methods: {
			installPWA() {
				const promptEvent = this.deferredPrompt;

				if (! promptEvent) {
					return;
				}

				promptEvent.prompt();

				promptEvent.userChoice.then((result) => {
					this.deferredPrompt = null;
				});
			}
		},
		mounted() {
			window.addEventListener('beforeinstallprompt', (event) => {
				this.deferredPrompt = event;
			});
		}
	}
</script>