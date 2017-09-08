<template>
	<div v-show="show" class="delete-background clearfix">
		<div class="delete-form-wrapper col-md-4">
			<h2>Delete item?</h2>
			<div class="btns">
				<a @click.prevent="delRecord" class="btn btn-primary">Yes</a>
				<a @click.prevent="close" class="btn btn-primary">No</a>
			</div>
		</div>
	</div>
</template>

<script>
export default {

	name: 'delete-modal',
	data () {
		return {
			url:"'/files",
		}
	},
	props:{
		id:{
			required:true
		},
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
		delRecord(){
			axios.delete(window.location.protocol + "//" + window.location.host + this.url + '/' + this.id)
  			.then(this.$emit('remove'))
  			.catch(console.error)
		}
	}
};
</script>

<style lang="scss">
.delete-background{
	transition: .4s ease-out;
	position:absolute;
	z-index:999999;
	background-color:rgba(0,0,0,0.5);
	width: 100vw;
    height: 100vh;
    top: 0;
    left:0;


	.delete-form-wrapper{
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
