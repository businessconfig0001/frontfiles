<template>
<div class="drag-container">
	<form enctype="multipart/form-data" novalidate class="clearfix">
		<div class="col-sm-7 col-xs-12 bg-blue text-center dropbox">
			<input type="file" multiple name="file" :disabled="state ==='saving'" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length" accept="image/*,video/*,audio/*,application/pdf" class="input-file">
			<p v-if="state === 'saving'">
			  	Uploading {{ fileCount }} files...
			  	<ul>
			  		<li v-for="p in progressBar">
			  			<span>{{p.name}}</span>
			  			<progress value="p.loaded" max="p.total"></progress>
			  		</li>
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
				<upload-form :upload="upload"></upload-form>
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
				progressBar:[]
			}
		},
		props:{
			files:{
				required:true,
				type:Array
			}
		},
		mounted(){
		},
		methods:{
			filesChange(fieldName, fileList) {
				console.log('got here')
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
							drive:''
				  		}
				  		if(this.uploads[x]) d = this.uploads[x].data 
					  	this.uploads[x]={ 
					  		file:fileList[x],
					  		size:fileList[x].size,
					  		name:name,
					  		data: d,
					  		errors:[],
					  		index:x
					  	}
				  });
				  this.state='more'
			},
			uploadFile(){
				for (let u in this.uploads){

					this.progressBar.push({
						name:u.name,
						loaded:0,
						total:u.size
					})
					setTimeout(()=>{this.execUpload(u)},10000)
						
				}
			},
			execUpload(u){
				console.log('executing')
				upload(this.uploads[u],(e) => this.progressBar[u.index].loaded=e.loaded).then(res => {
							this.uploads = this.uploads.filter(x => (x.name !== u.name) && (x.file !== u.file))
							this.progressBar.splice(u.index,1)
							this.files.push(res.data)
						})
						.catch(err => this.uploads[u].errors = err.response.data)
				},
			watch:{
				progressBar(){
					if(this.progressBar.length)this.state='saving'
					else this.state=''
				}
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
