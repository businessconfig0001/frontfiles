<template>
<div class="display-container">
	<ul class="video-list">
		<li v-for="video in videos">
			<video-block :video="video"></video-block>
		</li>
	</ul>
</div>
</template>

<script>
import videoBlock from './video-block'
export default {

	name: 'videos-display',
	components:{
		videoBlock
	},
	props:{
		videos:{
			required:true,
			type:Array
		}
	},
	data () {
		return {

		}
	}
};
</script>

<style lang="scss" scoped>
	li{
		width:33%;
		padding:2rem;
		display:inline-block;
	}
</style>