<template>
	<li :class="{ 'active' : active }">
		<a class="d-flex flex-column flex-sm-row align-items-center" :href="href">
			<i class="fas fa-fw mr-1"
			:class="[icon, iconColorClass]"></i>
			<div>
				<slot></slot>
			</div>
		</a>
	</li>
</template>

<script>
	export default {
		props: {
			active: { default: false },
			href: {},
			icon: {},
			iconColor: { default: 'primary' }
		},
		computed: {
			iconColorClass: function() {
				return 'text-' + this.iconColor;
			}
		}
	}
</script>