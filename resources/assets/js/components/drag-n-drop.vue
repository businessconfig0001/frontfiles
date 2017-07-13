<template>
<div class="drag-container">
	<form enctype="multipart/form-data" novalidate>
		<div class="col-sm-7 col-xs-12 bg-blue text-center dropbox">
			<input type="file" multiple name="video" :disabled="state ==='saving'" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length" accept="video/*" class="input-file">
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

		<div class="col-xs-12 col-sm-3 form">
			<div v-for="upload in uploads" class="form-group">
				<h3>{{upload.name}}</h3>
				<p>
					<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="upload.data.title"/>
					<!--<span v-show="typeof upload.errors['title'] !== 'undefined'">{{upload.errors['title']}}</span>-->
				</p>
				<p>
					<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="upload.data.description"></textarea>
					<!--<span v-show="typeof upload.errors['description'] !== 'undefined'">{{upload.errors['description']}}</span>-->
				</p>
				<p><input type="text" name="what" id="what" class="form-control" placeholder="#What" v-model="upload.data.what"/></p>
				<p><input type="" name="where" id="where" class="form-control" placeholder="#Where" v-model="upload.data.where"/></p>
				<p><input type="text" name="who" id="who" class="form-control" placeholder="#Who" v-model="upload.data.who"/></p>
				<p><input type="text" name="when" id="when" class="form-control" placeholder="#When" onfocus="(this.type='date')" v-model="upload.data.when"/></p>
			</div>
		</div>
		<a class="submit btn" @click.prevent="upload">Save</a>
	</form>
</div>
	
</template>

<script>
	import { upload } from './../services/uploadService'
	export default {
		name:'drag-n-drop',
		data(){
			return {
				state:'',
				uploads:[],
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
				  			what:'',
				  			where:'',
				  			when:'',
				  			who:''
				  		}
				  		if(this.uploads[x]) d = this.uploads[x].data 
					  	this.uploads.push({ 
					  		file:fileList[x],
					  		name:fileList[x].name,
					  		data: d,
					  		errors:[]
					  	})
				  });
				  this.state='more'
			},
			upload(){
				console.log('uploading ' + this.uploads.length + ' files')
				console.log(this.uploads)
				for (let u in this.uploads){
					 upload(this.uploads[u]).then(res => this.uploads = this.uploads.filter(x => (x.name !== u.name) && (x.file !== u.file)))
						.catch(res => this.uploads[u].errors = res.errors)
				}
			}

		}
	}
</script>

<style lang="scss" scoped>
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
</style>
