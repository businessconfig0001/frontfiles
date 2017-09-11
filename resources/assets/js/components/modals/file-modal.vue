<template>
<div>
	<div v-if="show" class="modal-background clearfix">
		<div class="modal-wrapper modal-content col-md-4 file-edit">
			<h3>File: <span>{{upload.name}}</span></h3>
			<upload-form :upload="upload" :errors="upload.errors" :who="upload.data.who" :what="upload.data.what" @changeWhat="changeWhat" @changeWho="changeWho"></upload-form>
			<a class="btn btn-primary confirm" @click.prevent="close">close</a>
			<a href="#" class="close" @click.prevent="close">&#10005</a>
		</div>
	</div>
</div>
</template>

<script>
import uploadForm from './../files/upload-form'
export default {

	name: 'file-modal',
	props:{
		upload:{
			required:true,
			type:Object
		},
		show:{
			required:true,
			type:Boolean
		}

	},
	components:{
		uploadForm
	},
	data () {
		return {
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
		changeWhat(tags){
			this.upload.data.what=tags
		},
		changeWho(tags){
			this.upload.data.who=tags
		}	
	}
}
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


	.modal-wrapper.modal-content{
		width:60%;
		background-color:white;
		padding:3rem;
		position:absolute;
		left:50%;
		top: 40%;
  		transform: translate(-50%, -40%);
  		border-radius:0;


		.modal-button{
			width:60%;
			margin:.5rem;
			margin-left:20%;
		}

		&.file-edit{
			label{
				margin-bottom:.5rem;
			}
			.fields > li{
				width:50%;
				float:left;
				margin-bottom:.5rem;
				padding:.5rem;

					.error{
						float:right;
					}
			}

			.confirm{
				width:20rem;
				margin:0 auto;
				text-align:center;
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
