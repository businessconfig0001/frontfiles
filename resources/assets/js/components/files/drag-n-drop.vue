<template>
<div class="drag-container">
	<form enctype="multipart/form-data" novalidate class="clearfix">
		<div class="col-sm-4 col-offset-2 col-xs-12 bg-blue text-center dropbox">
			<input type="file" multiple name="file" :disabled="state ==='saving'" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length" accept="image/*,video/*,audio/*,application/pdf" class="input-file">
			<p v-if="state === 'saving'" class="progressbar">
			  	Uploading {{ fileCount }} files...
			  	<progress :value="progress" :max="progressBar.total"></progress>
			  	</ul>
			</p>
			<p v-else-if="state === 'more'">
			  	Add more files or <a @click.prevent="upload">save them</a>
			</p>
			<img v-else-if="state === 'done'" src="/images/processing.png" alt="">
			<p v-else>
			  	Drag your file(s) here to begin<br> or click to browse
			</p>
		</div>


		<div class="col-md-4 form" v-show="uploads.length">
			<h3>Overall data</h3>
			<div>
				<p>
					<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="title"/>
				</p>
				<p>
					<tag-input placeholder="#What" class="form-control" @change="changeWhatTags" :name="'whatTags'"></tag-input>
					
				</p>
				<p>
					<tag-input placeholder="#Who" class="form-control" @change="changeWhoTags" :name="'whoTags'"></tag-input>			
				</p>
			</div>
		</div>

		
		
	</form>
	<div class="col-md-12 upload-files" v-show="uploads.length">
			<div class="col-md-8 listing">
				<ul>
					<li v-for="upload in uploads">
						<file-overview :file="upload"></file-overview>
					</li>
				</ul>
			</div>
			<div class="col-md-4 upload-button">
				<a v-if="dropbox" class="submit btn btn-primary" @click.prevent="uploadFile">Upload</a>
				<a href="/profile" v-else class="submit btn btn-primary" title="Connect to ur dropbox to upload files">Connect to dropbox</a>
			</div>
		</div>
</div>
	
</template>

<script>
	import { Errors } from './../../classes/Errors'
	import { upload } from './../../services/uploadService'
	import tagInput from './../inputs/tag-input'
	import fileOverview from "./file-overview"
	import moment from 'moment'
	export default {
		name:'drag-n-drop',
		components:{
			fileOverview,
			tagInput
		},
		data(){
			return {
				state:'',
				uploads:[],
				progressBar:{},
				title:''
			}
		},
		props:{
			dropbox:{
				required:false,
				default:() => false
			}
		},
		computed:{
			progress(){
				let p=this.$store.state.progress
				return p
			}
		},
		watch:{
			title(){
				this.uploads=this.uploads.map(u => {
					u.data.title=this.title
					return u
				})
			}
		},
		mounted(){
			let modalName= 'first_upload'
			if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)
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
				  			when:moment(),
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
				this.$store.commit('resetProgress')
				this.state='saving'
				let total=this.uploads.reduce((total,x) => total += x.size,0)
				this.progressBar={
					loaded:0,
					total:total
				}
				let promises=[]
				for (let u in this.uploads){
					promises.push(upload(this.uploads[u],this.$store))
				}
				Promise.all(promises)
					.then(()=> {
						console.log('upload complete')
						this.state='done'
						this.uploads=[]
					})
					.catch((data) => {
						this.uploads[data.index]=data
					})
			},
			changeWhatTags(tag){
				this.uploads=this.uploads.map(u => {
					u.data.what.push(tag)
					return u
				})
			},
			changeWhoTags(tag){
				this.uploads=this.uploads.map(u => {
					u.data.who.push(tag)
					return u
				})
			}

		}
	}
</script>

<style lang="scss" scoped>
.drag-container{
	margin:2rem;

	h3{
		font-size:1.2rem;
		padding:1rem;

		span{
			color:white
		}

	}
	.form{
		float:right;

		input{
			&[placeholder]{
				color:#C7C7CD !important;
			}
		}
	}
	
	.upload-files{
		margin-top:2rem;
		position:static;
		
		.upload-button{
			display:flex;
			justify-content:center;
			align-items:center;
		}
		.listing{
			position:static;
		}
	}

	.dropbox {
		outline-offset: -10px;
		padding: 10px 10px;
		min-height: 250px; /* minimum height */
		position: relative;
		cursor: pointer;
		display:flex;
		align-items:center;
		justify-content:center;
		border:4px solid blue;

		&:hover {
			background: #F5F8FA;
			border:4px dashed blue;
			p{
				color:blue;
			}
			
		}

		.progressbar{
			width:60%;

			progress[value]{
				width:100%;
				appearance: none;
				-webkit-appearance: none;
				border:none;
				color:white;
			}

			progress[value]::-webkit-progress-value:after {
			    /* Only webkit/blink browsers understand pseudo elements on pseudo classes. A rare phenomenon! */
			    content: '';
			    position: absolute;
			    
			    width:5px; height:5px;
			    top:7px; right:7px;
			    
			    background-color: white;
			    border-radius: 100%;
			}

			progress[value]::-webkit-progress-bar {
			    background-color: rgba(0,0,0,0);
			    color:white;
			}

			progress[value]::-webkit-progress-value {
			    position: relative;
			    background-image:
					-webkit-linear-gradient( 135deg,transparent,transparent 33%,blue 33%,blue 66%,transparent 66%),
					-webkit-linear-gradient( top,#ddd,#ddd);
			    background-size: 35px 20px, 100% 100%, 100% 100%;
				animation: animate-stripes 5s linear infinite;
			}

			@keyframes animate-stripes { 100% { background-position: -100px 0; } }
		}

		.input-file {
			opacity: 0; /* invisible but it's there! */
			width: 100%;
			height: 250px;
			position: absolute;
			cursor: pointer;
		}

		p {
			font-size: 1.2em;
			text-align: center;
			color:white;

		}

		img{
			width:100%;
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
}

</style>
