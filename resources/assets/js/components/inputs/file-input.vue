<template>
<div class="file-input-wrapper">
		<img v-show="link.length" :src="link" alt="">
		<input type="file" :name="options.name" @change="change" :accept="options.accept">
		<label :for="options.name">{{label}}</label>	
</div>
</template>

<script>
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
			let image=
			console.log(image)
			this.file=e.target.files[0]
			this.label=this.file.name
			if(FileReader){
				let fr = new FileReader()

				fr.onload = () => this.link = fr.result 

				fr.readAsDataURL(this.file)

			}
		}
	}
}
</script>

<style lang="scss" scoped>
.file-input-wrapper{
	display:flex;
	position:relative;
	img{
		width:100%
	}

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
</style>