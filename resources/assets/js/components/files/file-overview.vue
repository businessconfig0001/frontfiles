<template>
<div class="file-overview clearfix">
	<a @click.prevent="show =true" class="overview-wrapper clearfix col-md-8">
		<div class="col-md-6">
			<h2 >{{file.name}}</h2>	
		</div>
		<div class="col-md-6">
			<p >{{short_desc}}</p>
		</div>
	</a>
	<div class="col-md-3 remove">
		<a class="btn btn-primary " @click.prevent="remove">Remove</a>
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
			if(this.file.data.description.lenght > 100)return this.file.data.description.substr(0,100)
			return this.file.data.description
		}
	},
	methods:{
		remove(){
			this.$emit('remove',file.name)
		}
	}
};
</script>

<style lang="scss" scoped>
.file-overview{
	padding:1rem;
	border-top:1px solid #ccc;
	h2{
		margin-top: 22px;
    	margin-bottom: 11px;
	}
	.remove{
		float:right;
	}

	&:hover{
		background-color:#ddd;
	}
}
</style>