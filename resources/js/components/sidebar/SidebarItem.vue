<template>
	<li :class="{ 'active' : active }">
		<a :href="href">
			<span class="icon">
				<i class="fas fa-fw mr-1"
				:class="[icon, iconColorClass]"></i>
			</span>

			<span class="label">
				<slot></slot>
			</span>
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