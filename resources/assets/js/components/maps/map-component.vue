<template>
	<div class="map-wrapper">
		<svg ref="map"></svg>
	</div>
</template>

<script>
import { map } from './../../services/mapService'
export default {

	name: 'map-component',

	data () {
		return {
			svg:{}
		}
	},
	props:{
		data:{
			required:true,
			type:Array
		}
	},
	mounted(){
		map(this.$refs.map,this.data)
	}
};
</script>

<style lang="scss" scoped>
	.map-wrapper{
		width:100%;
		height:53rem;

		svg{
			margin-top:-8rem;
			width:100%;
			height:100%;
		}
	}
</style>