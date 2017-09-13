<template>
<div class="file-input-wrapper">
		<div class="file-wrapper">
			<img v-if="link.length" :src="link" alt="">	
		</div>	
		<div v-show="!link.length"  class="input-wrapper">
			<input  type="file" @change="change" :accept="options.accept">
			<input  ref="fileinput" type="text" :name="options.name" class="hidden">
			<label :for="options.name">{{label}}</label>
			<canvas ref="canvas" class="hidden"></canvas>	
		</div>
		<a  v-if="link.length" class="close" @click.prevent="remove" ><img src="/images/close-icon.svg" alt=""></a>
</div>
</template>

<script>
import smartcrop from 'smartcrop'
import { cropper } from './../../helpers'
export default {

	name: 'file-input',
	props:{
		options:{
			type:Object,
			required:true
		},
	},
	data () {
		return {
			label:'',
			file:'',
			link:''
		};
	},
	mounted(){
		this.label=this.options.label
	},
	methods:{
		change(e){
			let image=new Image()
			this.file=e.target.files[0]
			this.label=this.file.name
			if(FileReader){
				let fr = new FileReader()
				let image= new Image()
				fr.onload = () => {
					
					image.src=fr.result 
				} 

				image.onload = () => {
					smartcrop.crop(image, {width: 200, height: 200}).then(result => {
						let canvas=this.$refs.canvas
  						//cropper(image,canvas,result)
  						let options=result.topCrop
  						let ctx= canvas.getContext('2d')
						canvas.width=200
						canvas.height=200
						ctx.drawImage(image,options.x,options.y,options.width,options.height,0,0,200,200)
  						let dataUrl= canvas.toDataURL("image/png")
  						this.link=dataUrl
  						this.$emit('change',dataUrl)
  						this.$refs.fileinput.setAttribute('value',dataUrl)
					})	
				}
					

				fr.readAsDataURL(this.file)

			}
		},
		remove(){
			this.label=this.options.label
			this.link=''
			this.$refs.fileinput.setAttribute('value',false)
			this.$emit('change',false)
		}
	}
}
</script>

<style lang="scss" scoped>
.file-input-wrapper{
	position:relative;
	.close{
		position:absolute;
		right:5px;
		top:5px;

		img{
			width:12px;
			height:12px;
		}
	}
	.file-wrapper{
		display: flex;
		justify-content:center;
		align-items:center;
		img{
			width:200px;
			border-radius:50%;
		}	
	}
	

	.input-wrapper{
		display:flex;
		position:relative;

		input{
			flex:1;
			opacity: 0;
			width:100%;
			height: 100%;
			position: absolute;
			cursor:pointer;

		}
		label{
			padding:1rem;
			text-align:center;
			flex:1;
			background-color:blue;
			color:white;
			cursor:pointer;
		}
	}
}

</style>