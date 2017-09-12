<template>
<div class="file-overview clearfix">
	<a @click.prevent="show =true" class="overview-wrapper clearfix col-md-10">
		<div class="col-md-4 title-field">
			<h2 class="short-title" >{{short_title}}</h2>
			<h2 class="title-hover" >{{file.name}}</h2>
		</div>
		<div class="col-md-8 desc">
			<p >{{short_desc}}</p>
		</div>
	</a>
	<div class="remove">
		<img src="/images/edit-btn.png" alt="">
		<a class="remove-link " @click.prevent="remove"><img src="/images/close-icon.svg" alt=""></a>
	</div>
	
	<file-modal :upload="file" :show="show" @close="show = false"></file-modal>
</div>
</template>

<script>
import fileModal from './../modals/file-modal'
export default {

	name: 'file-overview',
	components:{
		fileModal
	},
	props:{
		file:{
			type:Object,
			required:true,
		}
	},
	data () {
		return {
			show:false
		}
	},
	computed:{
		short_desc(){
			if(this.file.data.description.length > 50){
				return this.file.data.description.substr(0,50) + '...'
			}
			return this.file.data.description
		},
		short_title(){
			if(this.file.name.length > 10)return this.file.name.substr(0,10) + '...'
				return this.file.name
		}
	},
	methods:{
		remove(){
			this.$emit('remove',this.file.name)
		}
	}
};
</script>

<style lang="scss" scoped>
.file-overview{
	padding:.5rem;
	border-top:1px solid #ccc;
	h2{
		margin-top: 11px;
    	margin-bottom: 11px;
	}

	&:hover{
		.title-field{
			.short-title{
				display:none;
			}
			.title-hover{
				display:block;
			}
		}
	}
	.desc{
		margin-top:11px;
		margin-bottom:11px;
	}
	.title-field{
		.short-title{
			dislay:block;
			transition: .2s ease-in-out;
		}

		.title-hover{
			display:none;
			transition: .2s ease-in-out;
		}
	}

	.remove{
		float:right;
		padding-top:1rem;
		padding-right:2rem;

		img{
    		width:16px;
    		margin-right:1rem;
    	}

		.remove-link{
			cursor:pointer;
		}
	}

	&:hover{
		background-color:#eee;
	}
}
</style>