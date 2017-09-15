<template>
	<div v-show="show" class="modal-background clearfix">
		<div class="oops-form-wrapper col-md-4">
			<h2>Ups! There's some problem to process your contents. Check if the filetype of your contents are correct</h2>
			<a @click.prevent="close" class="btn btn-primary">Ok</a>
			<a href="#" class="close" @click.prevent="close">&#10005</a>
		</div>
	</div>
</template>

<script>
export default {

	name: 'oops-modal',
	data () {
		return {
		}
	},
	props:{
		show:{
			required:true,
			type:Boolean
		}
	},
	watch:{
		show(){
			scroll(0,0)
		}
	},
	methods:{
		close(){
			this.$emit('close')
		},
	}
};
</script>

<style lang="scss">
.modal-background{
	transition: .4s ease-out;
	position:absolute;
	z-index:999999;
	background-color:rgba(0,0,0,0.5);
	width: 100vw;
    height: 100vh;
    top: 0;
    left:0;


	.oops-form-wrapper{
		background-color:white;
		padding:3rem;
		position:absolute;
		left:50%;
		top: 40%;
  		transform: translate(-50%, -40%);

		h2{
			padding-bottom:3rem;
			text-align: center;
		}

		.btns{
			width:100%;
			display:flex;
			justify-content:center;
			align-items:center;

			a{
				width:40%;
				margin-right:1rem;
			}
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
