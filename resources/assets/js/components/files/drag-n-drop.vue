<template>
<div class="drag-container">
	<form enctype="multipart/form-data" novalidate class="clearfix" @mouseenter="focus = true" @mouseleave="focus = false">
		<div class="col-sm-4 col-offset-2 col-xs-12 bg-blue text-center dropbox">
			<input type="file" multiple name="file" :disabled="state ==='saving'" @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length" accept="image/*,video/*,audio/*,application/pdf" class="input-file">
			<div v-if="state === 'saving'" class="progressbar">
			  	<loading-icon></loading-icon>
			  	<div class="loading-msg">
			  		<h3>Uploading files</h3>
			  		<p>
			  			This may take a few minutes
			  		</p>
			  		<p>
			  			please wait
			  		</p>
			  	</div>
			</div>
			<div v-else-if="state === 'more'">
			  	Add more files or <a @click.prevent="upload">save them</a>
			</div>
			<img v-else-if="state === 'done'" src="/images/processing.png" alt="">
			<div v-else>
			  	Drag your file(s) here to begin<br> or click to browse
			</div>
		</div>


		<div class="col-md-5 col-md-offset-2 upload-form" v-show="uploads.length"  >
			<h3>Tell us more about your files</h3>
			<div class="form-content clearfix">
				<div class="col-md-12">
					<div class="input col-md-12">
						<display-error :error="errors['title']"></display-error>
						<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="title" maxlength="40" />
					</div>
					<div class="input col-md-12">
						<display-error :error="errors['description']"></display-error>
						<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="description"></textarea>
					</div>
					<div class="input col-md-6">
						<display-error :error="errors['where']"></display-error>
						<places-input :options="{name:'where',className:'form-control',placeholder:'#Where'}" :content="where.location" @change="changeWhere"></places-input>
					</div>
					<div class="input col-md-5 col-md-offset-1">
						<display-error :error="errors['when']"></display-error>
						<date-picker :option="options" name="when"  class="form-control" :date="date" @change="changeDate" :limit="limit"></date-picker>
					</div>
					<div class="input col-md-12 tag-input">
						<display-error :error="errors['what']"></display-error>
						<tag-input placeholder="#What #Who #How" class="form-control" @change="changeWhatTags" :name="'whatTags'"></tag-input>						
					</div>
				</div>
				<div class="upload-button">
					<button v-if="dropbox" :disabled="state === 'saving'" class="submit btn btn-primary" @click.prevent="uploadFile" @keyup.enter="uploadFile">Upload all</button>
					<a href="/profile" v-else class="submit btn btn-primary" title="Connect to ur dropbox to upload files">Connect to dropbox</a>
				</div>
			</div>
		</div>

		
		
	</form>
	<div class="upload-files" v-show="uploads.length">
			<div class="listing">
				<ul>
					<li v-for="upload in uploads">
						<file-overview :file="upload" @remove="removeFile"></file-overview>
					</li>
				</ul>
			</div>
		</div>
	<oops-modal :show="showErr" @close="showErr=false"></oops-modal>
</div>
	
</template>

<script>
	import { Errors } from './../../classes/Errors'
	import { upload } from './../../services/uploadService'
	import tagInput from './../inputs/tag-input'
	import oopsModal from './../modals/oops-modal'
	import fileOverview from "./file-overview"
	import datePicker from 'vue-datepicker'
	import displayError from './../inputs/display-error'
	import moment from 'moment'
	import loadingIcon from './../icons/loading-icon'
	export default {
		name:'drag-n-drop',
		components:{
			fileOverview,
			tagInput,
			datePicker,
			displayError,
			loadingIcon,
			oopsModal
		},
		data(){
			return {
				state:'',
				errors:[],
				uploads:[],
				progressBar:{},
				title:'',
				where:{
					location:''
				},
				why:'',
				description:'',
				focus:false,
				showErr:false,
				date:{
					time:''
				},
					limit:[{
					type:'fromto',
					to:moment().format('YYYY-MM-DD')
				}],
				options:{
					placeholder:'#When',
					type: 'day',
	        		week: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
	        		month: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	        		format: 'YYYY-MM-DD',
	        		inputStyle: {
			          	display: 'block',
						width: '100%',
						height: 'auto',
						border:'none'
	        		},
	        		color: {
					    header: 'blue',
					    headerText: 'white'
					  }

				}
			}
		},
		props:{
			dropbox:{
				required:false,
				default:() => false
			},
			profile:{
				required:true,
				type:Object
			}
		},
		computed:{
			progress(){
				let p=this.$store.state.progress
				return p
			},
			enter(){
				return this.$store.state.enter
			},
		},
		watch:{
			title(){
				if(this.uploads.length === 1)this.uploads[0].data.title=this.title
				else{
					let counter= 1
					this.uploads=this.uploads.map(u => {
						u.data.title=this.title + ' - shoot ' +counter
						counter++
						return u
					})
				}	
				
			},
			where(){
				this.uploads=this.uploads.map(u => {
					u.data.where=this.where.location
					u.data.lat=this.where.lat
					u.data.lng=this.where.lng
					return u
				})
			},
			why(){
				this.uploads=this.uploads.map(u => {
					u.data.why=this.why
					return u
				})
			},
			description(){
				this.uploads=this.uploads.map(u => {
					u.data.description=this.description
					return u
				})
			},
			enter(){
				if(this.focus && this.enter && this.dropbox && this.uploads.length)this.uploadFile()
			}
		},
		mounted(){
			let modalName= 'first_upload'
			if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)
			this.date.time=moment().format('YYYY-MM-DD')
		},
		methods:{
			changeWhere(data){
				this.where=data
				this.uploads=this.uploads.map(u => {
					u.data.where=data.location
					u.data.lat=data.lat
					u.data.lng=data.lng
					return u
				})
			},
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
				  			lat:'',
				  			lng:'',
				  			when:moment().format('YYYY-MM-DD'),
				  			who:[],
				  			why:'',
							drive:'dropbox'
				  		}
				  		//if(this.uploads[x].name === name) d = this.uploads[x].data 
					  	this.uploads.push({ 
					  		file:fileList[x],
					  		size:fileList[x].size,
					  		name:name,
					  		data: d,
					  		errors:{},
					  		index:x,
					  		previous:0
					  	})
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
						this.state='done'
						this.uploads=[]
						window.location=window.location.origin + "/profile/" + this.profile.slug 
					})
					.catch((res) => {
						this.showErr=true
						this.state='more'
						this.errors=res.response.data
					})
			},
			changeWhatTags(tags){
				this.uploads=this.uploads.map(u => {
					u.data.what=tags
					return u
				})
			},
			changeWhoTags(tags){
				this.uploads=this.uploads.map(u => {
					u.data.who=tags
					return u
				})
			},
			changeDate(d){
				this.uploads=this.uploads.map(u => {
					u.data.when=moment(d).format('YYYY-MM-DD')
					return u
				})
				this.date.time=d
			},
			initPlace(event){
				let placebox=new google.maps.places.Autocomplete(event.target)
				try{
					placebox.addListener('place_changed',() => {
						this.where = placebox.getPlace().formatted_address
					})	
				}
				catch(e){
					console.error(e)
				}	
			},
			removeFile(name){
				this.uploads=this.uploads.filter(f => f.name !== name)
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
		padding-top:0;

		span{
			color:white
		}

	}
	.upload-form{
		p{
			width:100%;
			padding:.5rem;
			float:left;
		}

		.form-content{
			.input{
				padding:0;
			}

			.tag-input{
				height:6rem;
				margin-bottom: 1rem;
			}
		}
		.upload-button{
			float:left;
			width:100%;
			.submit:disabled{
				background-color:#ddd;
			}
			a,button{
				width:10rem;
				margin:0 auto;
			}
		}
	}
	
	.upload-files{
		margin-top:2rem;
		position:static;
		

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
		border:4px solid transparant;
		padding:0;
		margin-top:2.5rem;

		& > div{
			color:white;
		}

		&:hover {
			background: #F5F8FA;
			border:4px dashed blue;
			& > div{
				color:blue;
			}
			
		}

		.progressbar{
			width:60%;

			.loading-msg{
				color:white;
			}

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
