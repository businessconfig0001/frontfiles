<template>
	<div v-show="show" class="modal-background clearfix">
		<div class="modal-wrapper col-md-4">
			<p class="modal-content">
				
			</p>
			<a @click.prevent="close" class="btn btn-primary">Ok</a>
	  		<a href="#" class="close" @click.prevent="close">&#10005</a>
		</div>
	</div>
</template>

<script>
export default {

	name: 'modal-container',
	data () {
		return {
		}
	},
	computed:{
		show(){
			scroll(0,0)
			return this.$store.state.showModal
		}
	},
	methods:{
		close(){
			this.$store.commit('closeModal')
		}
	}
};
</script>

<style lang="scss">
.modal-background{
	transition: .4s ease-out;
	position:absolute;
	z-index:999999;
	background-color:rgba(0,0,0,0.5);
	width:100%;
	height:100%;
	top:0;


	.modal-wrapper{
		background-color:white;
		padding:3rem;
		position:absolute;
		left:50%;
		top: 10%;
  		transform: translate(-50%, -10%);

		
		.close{
			padding:1rem;
			position:absolute;
			top:0;
			right:0;
		}
	}
}

</style>
