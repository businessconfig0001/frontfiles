<template>
<div class="tag-wrapper">
	<ul v-show="tags.length" class="tags">
		<li v-for="tag in tags" class="tag">
			{{ tag }}
			<a @click.prevent="removeTag(tag)"><i class="fa fa-times"></i></a>
		</li>
	</ul>
	<input type="text" v-model="new_tag" :placeholder="placeholder" @keyup.enter="addTag">
</div>
</template>

<script>
export default {

	name: 'tag-input',
	props:{
		tags:{
			required:false,
			type:Array,
			default:[]
		},
		placeholder:{
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
				this.new_tag='';
			}	
		},
		removeTag(t){
			this.tags=this.tags.filter(x => x !== t)
		}
	}
};
</script>

<style lang="scss" scoped>
	.tag-wrapper{
		background-color:white;
		padding:0.5rem;

		.tags{
			display:inline-block;

			.tag{

				display:inline-block;
				background-color:blue;
				color:white;
				padding:0.5rem;
				margin-left:0.2rem;
				margin-top:0.1rem;

			}
		}

		input{
				border:none;
				display:inline-block;

				&[placeholder]{
					color:#C7C7CD;
				}
			}
	}
</style>