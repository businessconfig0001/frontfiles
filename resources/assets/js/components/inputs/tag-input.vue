<template>
<div class="tag-wrapper" @click="focus">
	<ul class="tags">
		<li v-for="tag in tags" class="tag">
			{{ tag }}
			<a @click.prevent="removeTag(tag)"><i class="fa fa-times"></i></a>
		</li>
		<li class="input"><input  ref="input" v-if="!disabled" v-model="new_tag" :placeholder="placeholder" @keyup.space.prevent="addTag" @blur="addTag" @keyup.delete="removeLast" class="form-control" :disabled="disabled" @keyup="change"></li>
	</ul>
	
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
			new_tag:'',
			disabled:false,
			previous:true,
			last:''
		};
	},
	methods:{
		change(){
				if(this.new_tag.length > 0 && this.last.length > 1){
					this.last = this.new_tag
					this.previous=true
				}
				else if(this.new_tag.length >= 1) this.last = this.new_tag
				else this.last=''
				console.log('last',this.last)
			
		},
		addTag(){
			if(this.new_tag === ' ')this.new_tag = ''
			if(this.new_tag.length){
				this.new_tag=this.new_tag.substr(0,this.new_tag.length -1).replace(' ','_')
				this.tags.push('#' + this.new_tag)
				this.$emit('change',this.tags)
				this.new_tag='';
				let charcount = this.tags.reduce((total,t) => total +=t.length,0)
				this.disabled=this.tags.length >= 40 || charcount >= 200
				
			}	
		},
		removeTag(t){
			this.tags=this.tags.filter(x => x !== t)
			this.$emit('change',this.tags)
			let charcount = this.tags.reduce((total,t) => total +=t.length,0)
			this.disabled=this.tags.length >= 40 || charcount >= 200
		},
		removeLast(){
			if(!this.new_tag.length  && this.tags.length && !this.last.length)this.removeTag(this.tags[this.tags.length -1])
		},
		focus(){
			this.$refs.input.focus()
		}
	},
	watch:{
		tags(){
			let charcount = this.tags.reduce((total,t) => total +=t.length,0)
			this.disabled=this.tags.length >= 40 || charcount >= 200
		}
	}
};
</script>

<style lang="scss" scoped>
	.tag-wrapper{
		background-color:white;
		height:100%;

		.tags{
			float:left;

			.tag{

				float:left;
				color:blue;
				border:1px solid #b1b7ba;
				margin-left:0.2rem;
				margin-top:0.1rem;
				padding: 0 .2rem;

				a{
					color:#b1b7ba;
				}

				&:last-of-type{
					margin-right:.5rem;
				}

			}
		}

		.input{
			float:left;
		}

		.form-control{
			margin-left:0.2rem;
			margin-top:0.1rem;
			padding:0;
			width:8rem;
			height:auto;
		}

		input{
				border:none;
				float:left;
			}
	}
</style>