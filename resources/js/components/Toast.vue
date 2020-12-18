<template></template>

<script>
	export default {
		props: {
			type: { required: true },
			message: { required: true }
		},
		mounted() {
			toast[this.type](this.message);
		}
	}
</script>