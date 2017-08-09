<template>
<div class="file-input-wrapper">
		<input type="file" :name="options.name" @change="change" :accept="options.accept" :value="value">
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
		value:{
			required:false
		}
	},
	data () {
		return {
			label:""
		};
	},
	mounted(){
		this.label=this.options.label
	},
	methods:{
		change(event){
			this.label = event.target.files[0].name
		}
	}
}
</script>

<style lang="scss" scoped>
.file-input-wrapper{
	display:flex;
	position:relative;

	input{
		flex:1;
		opacity: 0;
		width:100%;
		position: absolute;
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