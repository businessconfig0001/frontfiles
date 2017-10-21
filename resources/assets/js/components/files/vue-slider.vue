<template>
	<div class="slider-wrapper">
		<carousel :autoplay="true" :perPage="1" :paginationColor="'blue'" :navigationEnabled="true" navigationNextLabel="&#xf054;" navigationPrevLabel="&#xf053;">
			<slide v-for="slide in slides" class="slide">
				<a :href="slide.link">
					<img :src="'/images/slideshow/' +slide.img" alt="">
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
				this.slides=res.data.images.map(i =>{
					return{
						img:i,
						link:location.origin + '/file/' + i.split('.')[0]	
					}
					
				})
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
			left:60px;
		}

		&.VueCarousel-navigation-next{
			right:60px;
		}

	}
}
</style>