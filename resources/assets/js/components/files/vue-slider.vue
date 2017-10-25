<template>
	<div class="slider-wrapper">
		<carousel :autoplay="true" :perPage="1" :paginationColor="'blue'" :navigationEnabled="true" navigationNextLabel="<i class='fa fa-chevron-right fa-5x'></i>" navigationPrevLabel="<i class='fa fa-chevron-left fa-5x'></i>">
			<slide v-for="slide in slides"  class="slide">
				<a :href="'/files/' + slide.name">
					<img :src="'/images/slideshow/' +slide.src" alt="">
				</a>	
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
	.VueCarousel-navigation-button{
		color:blue !important;
		z-index:100;

		&.VueCarousel-navigation-prev{
			left:80px;
		}

		&.VueCarousel-navigation-next{
			right:80px;
		}

	}
}
</style>