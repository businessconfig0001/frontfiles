<template>
	<div class="slider-wrapper">
		<carousel :autoplay="true" :perPage="1" :paginationColor="'blue'" :navigationEnabled="true" navigationNextLabel="<i class='fa fa-chevron-right'></i>" navigationPrevLabel="<i class='fa fa-chevron-left '></i>">
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
		width:100%;
		height:70vh;
		overflow:hidden;
		display:flex;
		align-items:center;
		justify-content:center;
		a{
			width:100%;
		}
		img{
			min-width:100%;
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
		font-size:3rem;

		&.VueCarousel-navigation-prev{
			left:2%;
		}

		&.VueCarousel-navigation-next{
			right:2%;
		}

	}

	@media(max-width:1000px){
		.slide{
			height:35vh;
			a{
				width:100%;
			}
			img{
				min-width:100%;
				height:25rem;
			}
		}
		.VueCarousel-navigation-button{
		font-size:1rem;

		&.VueCarousel-navigation-prev{
			left:10%;
		}

		&.VueCarousel-navigation-next{
			right:10%;
		}

	}
	}
}
</style>