<template>
<div class="tag-wrapper">
	<ul v-show="tags.length" class="tags">
		<li v-for="tag in tags" class="tag">
			{{ tag }}
			<a @click.prevent="removeTag(tag)"><i class="fa fa-times"></i></a>
		</li>
	</ul>
	<input type="text" v-model="new_tag" :placeholder="placeholder" @keyup.enter="addTag" @blur="addTag" class="form-control">
</div>
</template>

<script>
export default {

	name: 'tag-input',
	props:{
		tags:{
			required:false,
			type:Array,
			default:() => []
		},
		placeholder:{
			required:false,
			type:String
		},
		name:{
			required:false,
			type:String
		}
	},
	data () {
		return {
			new_tag:''
		};
	},
	methods:{
		addTag(){
			if(this.new_tag){
				this.tags.push(this.new_tag)
				this.$emit('change',this.tags)
				this.new_tag='';
				
			}	
		},
		removeTag(t){
			this.tags=this.tags.filter(x => x !== t)
			this.$emit('change',this.tags)
		}
	},
};
</script>

<style lang="scss" scoped>
	.tag-wrapper{
		background-color:white;

		.tags{
			display:inline-block;

			.tag{

				display:inline-block;
				background-color:blue;
				color:white;
				margin-left:0.2rem;
				margin-top:0.1rem;
				padding: 0 .2rem

			}
		}

		.form-control{
			margin:0;
			padding:0;
			width:8rem;
			height:auto;
		}

		input{
				border:none;
				display:inline-block;

				&[placeholder]{
					color:#B1B7BA;
				}
			}
	}
</style>