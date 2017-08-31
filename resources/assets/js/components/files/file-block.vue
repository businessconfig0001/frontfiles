<template>
<div class="block-container">
	<div class="file-container" v-if="file.processed">
		<video controls v-if="file.type === 'video'">
			<source :src="file.azure_url">
		</video>
		<div class="img" v-else-if="file.type === 'image'">
			<img  :src="file.azure_url" alt="">	
			<a :href="file.azure_url">
				<i class="fa fa-download"></i>
			</a>
		</div>
		
		<audio controls v-else-if="file.type === 'audio'">
			<source :src="file.azure_url">
		</audio>
		<div v-else class="download-file">
			<a :href="file.azure_url">
				<i class="fa fa-download"></i>
			</a>
		</div>
	</div>
	<div class="file-container" v-else>
		<h2>Your file is still being processed</h2>
	</div>
	
	<div v-if="status" class="file-info">
		<h2><a :href="file.path">{{ file.title }}</a></h2>
		</ul>
		<a class="btn btn-primary" @click.prevent="status = false">edit</a>
		<a class="btn btn-primary" @click.prevent="del">delete</a>
	</div>
	<div v-else class="file-edit">
			<p>
				<display-error v-show="file.errors" :error="file.errors['title']"></display-error>
				<label for="title">Title</label>
				<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="file.title"/>
			</p>
			<p>
				<display-error v-show="file.errors" :error="file.errors['description']"></display-error>
				<label for="description">Description</label>
				<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="file.description"></textarea>
			</p>
			<ul>
			<li>
				<display-error v-show="file.errors" :error="file.errors['where']"></display-error>
				<label for="where">#Where:</label>
				 <input type="text" name="where"  class="form-control" @focus="initPlace" v-model="file.where">
			</li>
			<li>
				<display-error v-show="file.errors" :error="file.errors['when']"></display-error>
				<label for="when">#When:</label>
				 <date-picker :option="options" name="when"  class="form-control" :date="date" @change="changeDate"></date-picker>
			</li>
			<li>
				<display-error v-show="file.errors" :error="file.errors['who']"></display-error>
				<label for="who">#Who: </label>
				<tag-input type="text" name="who"  class="form-control tag-input" :tags="file.who"></tag-input>
			</li>
			<li>
				<display-error v-show="file.errors" :error="file.errors['what']"></display-error>
				<label class="what">#What:</label>
				<tag-input type="text" name="what"  class="form-control tag-input" :tags="file.what"></tag-input>
			</li>
			<li>
				<display-error v-show="file.errors" :error="file.errors['why']"></display-error>
				<label for="why">#Why:</label>
				 <input type="text" name="why"  class="form-control" v-model="file.why">
			</li>
		</ul>
			<a class="btn btn-primary" @click.prevent="update">Save</a>
			<a class="btn btn-primary" @click.prevent="status = true ">Go back without save</a>
	</div>
</div>
</template>

<script>
import displayError from './../inputs/display-error'
import moment from 'moment'
import datePicker from 'vue-datepicker'
export default {

  name: 'file-block',
  components:{
  	displayError,
  	datePicker
  },
  props:{
  	file:{
  		required:true,
  		type:Object
  	}
  },
  mounted(){
  	this.file.errors={}
  },
  computed:{
  	date(){
  		return moment(this.file.when)
  	},
  	formatted_date(){
  		this.date.format('DD/MM/YYYY')
  	},
  	short_desc(){
  		if(this.file.description.length > 100) return this.file.description.substring(0,100) + ' ...'
  		return this.file.description
  	},
  	title(){
  	}
  },
  data () {
    return {
    	status:true,
    	url:'/files',
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
    };
  },
  methods:{
  	update(){
  		let f = new FormData();
  		f.append('title',this.file.title)
  		f.append('description',this.file.description)
  		f.append('who',this.file.who)
  		f.append('when',this.file.when)
  		f.append('what',this.file.what)
  		f.append('where',this.file.where)
		f.append('_method', 'PATCH')

  		axios.post(window.location.protocol + "//" + window.location.host + this.url + '/' + this.file.id, f)
  			.then(status = true)
  			.catch(this.file.erros = res.response.data)
  	},
  	del(){
  		axios.delete(window.location.protocol + "//" + window.location.host + this.url + '/' + this.file.id)
  			.then(this.$emit('remove'))
  			.catch(console.error)
  	},
  	changeDate(date){
  		this.file.when = moment(date).format('YYYY-MM-DD')
  	},
  	initPlace(event){
		let placebox=new google.maps.places.Autocomplete(event.target)
		try{
			placebox.addListener('place_changed',() => {
				this.file.where = placebox.getPlace().formatted_address
			})	
		}
		catch(e){}	
	},
  }
};
</script>

<style lang="scss" scoped>
.block-container{
	width:100%;
	background-color:rgb(255,255,255);
	padding: 1rem;

	.file-container{
		display:flex;
		justify-content:center;
		align-items:center;
		height:13em;
		overflow:hidden;

		h2{
			color:#ddd;
		}
	}
	video,img{
		height:100%;
	}
	audio,.download-file{
		width:100%;

	}
	.img{
		position: relative;

			a{
				position: absolute;
				bottom: 0;
				right: 0;
				z-index: 100;
				font-size: 1rem;
				margin: .5rem;
				color:#eee
			}
	}

	.file-info{
		padding:.5rem;

		h2{
			padding: .5rem 0;
			height:50px;
			font-weight:bolder;
			text-align:center;
			a{
				color:blue;
			}
		}

		p{
			margin:.5rem 0;
		}

		li{
			font-weight:bolder;
			margin-bottom:.5rem;
			span{
				padding-left:.5rem;
				font-weight:400;
			}
		}
		
	}

	.file-edit{
		input,textarea,.tag-input{
			width:100%;
			margin-bottom:1rem;
		}
	}

	.btn{
		width:100%;
		margin: 0.5rem auto;
	}
}
</style>