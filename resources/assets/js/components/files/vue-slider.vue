<template>
	<div class="slider-wrapper">
		<carousel :autoplay="true" :perPage="1" :paginationColor="'blue'">
			<slide v-for="slide in slides" class="slide">
				<img :src="'/images/slideshow/' +slide" alt="">
			</slide>
		</carousel>
	</div>
</template>

<script>
export default {

	name: 'vue-slider',

	data () {
		return {
			slides:[]
		}
	},
	mounted(){
		axios.get(location.origin +'/slideshow')
			.then(res=>{
				console.log(res)
				this.slides=res.data.images
			})
			.catch(console.error)	
	}
	

};
</script>

<style lang="scss">
.slider-wrapper{
	width:100%;

	.slide{
		img{
			width:100%;
			height:50rem;
		}
	}

	.VueCarousel-pagination{
		margin-top:-5rem;
		margin-bottom:5rem;
		position: relative;
		z-index: 30;
	}
}
</style>