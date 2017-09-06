<template>
<div class="display-container">
	<ul class="video-list">
		<li v-for="file in files">
			<file-block :file="file" @remove="remove"></file-block>
		</li>
	</ul>
	<edit-modal :files="files" :url="'/files'" @edit="handleEdit"></edit-modal>
</div>
</template>

<script>
import editModal from './../modals/edit-modal'
import fileBlock from './file-block'
export default {

	name: 'files-display',
	components:{
		fileBlock,
		editModal
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
				if(f.title = file.title)return file
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