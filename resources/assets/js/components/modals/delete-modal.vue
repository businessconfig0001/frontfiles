<template>
	<div v-show="show" class="delete-background clearfix">
		<div class="delete-form-wrapper col-md-4">
			<h2>Delete item?</h2>
			<div v-if="state=== 'loading'">
				<loading-icon></loading-icon>
			</div>
			<div class="btns" v-else>
				<a @click.prevent="delRecord" class="btn btn-primary">Yes</a>
				<a @click.prevent="close" class="btn btn-primary">No</a>
			</div>
		</div>
	</div>
</template>

<script>
import loadingIcon from './../icons/loading-icon2'
export default {

	name: 'delete-modal',
	components:{
		loadingIcon
	},
	data () {
		return {
			url:'/files',
			state:''
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
			this.state='loading'
			axios.delete(window.location.origin + this.url + '/' + this.id)
  			.then(() => {
  				setTimeout(() => {
  					this.$emit('remove')	
  				},3000)
  				
  			})
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
