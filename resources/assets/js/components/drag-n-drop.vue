<template>
<div class="drag-container">
	<form enctype="multipart/form-data" novalidate class="clearfix">
		<div class="col-sm-7 col-xs-12 bg-blue text-center dropbox">
			<input type="file" multiple name="file" :disabled="state ==='saving'" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length" accept="image/*,video/*,audio/*,application/pdf" class="input-file">
			<p v-if="state === 'saving'" class="progress">
			  	Uploading {{ fileCount }} files...
			  	<progress :value="progressBar.loaded" :max="progressBar.total"></progress>
			  	</ul>
			</p>
			<p v-else-if="state === 'more'">
			  	Add more files or <a @click.prevent="upload">save them</a>
			</p>
			<p v-else>
			  	Drag your file(s) here to begin<br> or click to browse
			</p>
		</div>


		<div class="col-xs-12 col-sm-3 form" v-show="uploads.length">
			<div v-for="upload in uploads" class="form-group">
				<upload-form :upload="upload" :errors="upload.errors" :dropbox="dropbox"></upload-form>
			</div>
			<a class="submit btn btn-primary" @click.prevent="uploadFile">Save</a>
		</div>
		
	</form>
	<div class="file-container">
		<files-display :files="files"></files-display>
	</div>
</div>
	
</template>

<script>
	import { Errors } from './../classes/Errors'
	import { upload } from './../services/uploadService'
	import uploadForm from './upload-form'
	export default {
		name:'drag-n-drop',
		components:{
			uploadForm
		},
		data(){
			return {
				state:'',
				uploads:[],
				progressBar:{}
			}
		},
		props:{
			files:{
				required:true,
				type:Array
			},
			dropbox:{
				required:true,
				type:Object
			}
		},
		mounted(){
		},
		methods:{
			filesChange(fieldName, fileList) {
				if (!fileList.length) return;

				// append the files to FormData
				Array.from(Array(fileList.length).keys())
				  .map(x => {
				  		let name=fileList[x].name
				  		let d = {
				  			title:'',
				  			description:'',
				  			what:[],
				  			where:'',
				  			when:'',
				  			who:[],
				  			why:'',
							drive:'nothing'
				  		}
				  		if(this.uploads[x]) d = this.uploads[x].data 
					  	this.uploads[x]={ 
					  		file:fileList[x],
					  		size:fileList[x].size,
					  		name:name,
					  		data: d,
					  		errors:{},
					  		index:x,
					  		previous:0
					  	}
				  });
				  this.state='more'
			},
			uploadFile(){
				this.state='saving'
				let total=this.uploads.reduce((total,x) => total += x.size,0)
				this.progressBar={
					loaded:0,
					total:total
				}
				let promises=[]
				for (let u in this.uploads){
					promises.push(upload(this.uploads[u],(e) => {
						this.progressBar.loaded +=e.loaded - this.uploads[u].previous
						this.uploads[u].previous=e.loaded
						
					}))
				}
				Promise.all(promises)
					.then(/*location.reload()*/)
					.catch((data) => {
						this.uploads[data.index]=data
					})
			}

		}
	}
</script>

<style lang="scss" scoped>
h3{
	font-size:1.2rem;
	padding:1rem;

	span{
		color:white
	}

}
form{
	display:block

	input{
		&[placeholder]{
			color:#C7C7CD !important;
		}
	}
}
.dropbox {
	outline-offset: -10px;
	padding: 10px 10px;
	min-height: 500px; /* minimum height */
	position: relative;
	cursor: pointer;
	display:flex;
	align-items:center;
	justify-content:center;
	&:hover {
		background: lightblue; /* when mouse over to the drop zone, change color */
	}

	.progress{
		width:60%;

		progress:{
			width:100%;
		}
	}

	.input-file {
		opacity: 0; /* invisible but it's there! */
		width: 100%;
		height: 500px;
		position: absolute;
		cursor: pointer;
	}

	p {
		font-size: 1.2em;
		text-align: center;
		color:white;

	}

}
.form-group{
	display:block;
	padding-bottom:2rem;
}
.file-container{
	display:block;
	width:100%;
}
</style>
