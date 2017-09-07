<template>
<div class="display-container">
	<ul class="video-list">
		<li v-for="file in files">
			<file-block :file="file" @remove="remove" @edit="handleEdit"></file-block>
		</li>
	</ul>
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
		}
	},
	data () {
		return {
			files:[]
		}
	},
	methods:{
		handleEdit(file){
			this.files=this.files.map(f => {
				if(f.title === file.title)return file
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