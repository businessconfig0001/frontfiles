<template>
	<div v-show="show" class="modal-background clearfix">
		<div class="modal-wrapper modal-content col-md-4">
			<p class="modal-text">
				{{text}}
			</p>
			<a @click.prevent="close" class="btn btn-primary modal-button">Ok</a>
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
		},
		text(){
			return this.$store.state.modalText
		}
	},
	methods:{
		close(){
			this.$store.commit('closeModal')
		}
	},
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
	left:0;


	.modal-wrapper.modal-content{
		background-color:white;
		padding:3rem;
		position:absolute;
		left:50%;
		top: 10%;
  		transform: translate(-50%, -10%);
  		border-radius:0;

  		p{
  			padding:1rem;
  		}

		.modal-button{
			width:60%;
			margin-top:1rem;
			margin-left:20%;
		}		
		.close{
			padding:1rem;
			position:absolute;
			top:0;
			right:0;
		}
	}
}

</style>
