<template>
<div class="display-container">
	<ul v-if="_files.length"class="video-list">
		<li v-for="file in files">
			<file-block :file="file" @remove="remove" @edit="handleEdit" :activeuser="activeuser"></file-block>
		</li>
	</ul>
	<div v-else>
		<h2>No matching files were found</h2>
	</div>
</div>
</template>

<script>
import fileBlock from './file-block'
export default {

	name: 'files-display',
	components:{
		fileBlock
	},
	props:{
		_files:{
			required:true,
			type:Array
		},
		activeuser:{
			default:() => false
		}
	},
	data () {
		return {
			files:[]
		}
	},
	methods:{
		handleEdit(file){
			console.log('got here',file)
			this.files=this.files.map(f => {
				if(f.id === file.id)return file
				return f
			})
		},
		remove(id){
			this.files=this.files.filter(f => f.id !== id)
		}
	},
	mounted(){
		this.files= this._files
	}
	
};
</script>

<style lang="scss" scoped>
.display-container{
	width:100%;
  		li{
			width:33%;
			padding:.5rem;
			float:left;
		}
	
}
	
</style>