<template>
	<div class="position-relative">
		<div v-if="isLoading" class="loading">
        	<div class="spinner-border text-primary" role="status"></div>
     	</div>
     	<div ref="content">
     		
     	</div>
	</div>
</template>

<script>
	export default {
		props: {
			url: {},
			id: {},
		},
		data() {
			return {
				isLoading: false,
				dataUrl: this.url
			}
		},
		methods: {
			update() {
				this.isLoading = true;

				axios.get(this.dataUrl)
					.then(response => {
						this.$refs.content.innerHTML = response.data;
						this.isLoading = false;
					});
			},
			check(id) {
				return (Array.isArray(id) && id.includes(this.id)) || (id == this.id);
			}
		},
		mounted() {
			this.update();

			EventBus.$on('update-dynamic-view', (id, url = null) => {
				if (this.check(id)) {
					if (url != null) {
						this.dataUrl = url;
					}

					this.update();
				}
			});
		}
	}
</script>