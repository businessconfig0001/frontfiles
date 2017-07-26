<template>
<div class="drag-container">
	<form enctype="multipart/form-data" novalidate class="clearfix">
		<div class="col-sm-7 col-xs-12 bg-blue text-center dropbox">
			<input type="file" multiple name="file" :disabled="state ==='saving'" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length" accept="image/*,video/*,audio/*,application/pdf" class="input-file">
			<p v-if="state === 'saving'">
			  	Uploading {{ fileCount }} files...
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
				<h3>File: <span>{{upload.name}}</span></h3>
				<div v-show="upload.errors">
					<ul>
						<li v-for="error in errors">{{error}}</li>
					</ul>
				</div>
				<p>
					<display-error :error="upload.errors['title']"></display-error>
					<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="upload.data.title"/>
				</p>
				<p>
					<display-error :error="upload.errors['description']"></display-error>
					<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="upload.data.description"></textarea>
					
				</p>
				<p>
					<display-error :error="upload.errors['what']"></display-error>
					<tag-input placeholder="#What" :tags="upload.data.what"></tag-input>
					
				</p>
				<p>
					<display-error :error="upload.errors['where']"></display-error>
					<input type="" name="where" id="where" class="form-control" placeholder="#Where" v-model="upload.data.where"/>
					
				</p>
				<p>
					<display-error :error="upload.errors['who']"></display-error>
					<input type="text" name="who" id="who" class="form-control" placeholder="#Who" v-model="upload.data.who"/>			
				</p>
				<p>
					<display-error :error="upload.errors['when']"></display-error>
					<input type="text" name="when" id="when" class="form-control" placeholder="#When" onfocus="(this.type='date')" v-model="upload.data.when"/>
				</p>
				<p>
					<display-error :error="upload.errors['drive']"></display-error>
					<input type="radio" name="drive" value="azure" class="form-control" v-model="upload.data.drive" checked> Azure<br>
					<input type="radio" name="drive" value="dropbox" class="form-control" v-model="upload.data.drive"> Dropbox
				</p>
			</div>
			<a class="submit btn btn-primary" @click.prevent="upload">Save</a>
		</div>
		
	</form>
	<div class="file-container">
		<files-display :files="files"></files-display>
	</div>
</div>
	
</template>

<script>
	import { upload } from './../services/uploadService'
	import  displayError from './display-error'
	export default {
		name:'drag-n-drop',
		components:{
			displayError
		},
		data(){
			return {
				state:'',
				uploads:[],
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

				if (!fileList.length) return;

				// append the files to FormData
				Array.from(Array(fileList.length).keys())
				  .map(x => {
				  		let d = {
				  			title:'',
				  			description:'',
				  			what:[],
				  			where:'',
				  			when:'',
				  			who:'',
							drive:''
				  		}
				  		if(this.uploads[x]) d = this.uploads[x].data 
					  	this.uploads.push({ 
					  		file:fileList[x],
					  		name:fileList[x].name,
					  		data: d,
					  		errors:{}
					  	})
				  });
				  this.state='more'
			},
			upload(){
				console.log('uploading ' + this.uploads.length + ' files')
				console.log(this.uploads)
				for (let u in this.uploads){
					 upload(this.uploads[u]).then(res => {
					 	console.log('success')
					 	this.uploads = this.uploads.filter(x => (x.name !== u.name) && (x.file !== u.file))
					 	this.files.push(res.data)
					 })
						.catch(err => this.uploads[u].errors = err.response.data)
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
