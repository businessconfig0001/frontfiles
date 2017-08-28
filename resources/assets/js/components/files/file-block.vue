<template>
<div class="block-container">
	<video controls v-if="file.type === 'video'">
		<source :src="file.url">
	</video>
	<img v-else-if="file.type === 'image'" src="" alt="">
	<audio controls v-else-if="file.type === 'audio'">
		<source :src="file.url">
	</audio>
	<div v-else class="download-file">
		<a :href="file.url">
			<i class="fa fa-download"></i>
		</a>
	</div>
	<div v-if="status" class="file-info">
		<h2>{{ file.title }}</h2>
		<p>{{ short_desc }}</p>
		<ul>
			<li v-show="file.where">#Where: <span>{{file.where}}</span></li>
			<li v-show="file.when">#When: <span>{{date}}</span></li>
			<li v-show="file.who">#Who: <span>{{file.who}}</span></li>
			<li v-show="file.what">#What: <span>{{file.what}}</span></li>
		</ul>
		<a class="btn btn-primary" @click.prevent="status = false">edit</a>
		<a class="btn btn-primary" @click.prevent="del">delete</a>
	</div>
	<div v-else>
			<p>
				<display-error v-show="file.errors" :error="file.errors['title']"></display-error>
				<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="file.title"/>
			</p>
			<p>
				<display-error v-show="file.errors" :error="file.errors['description']"></display-error>
				<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="file.description"></textarea>
			</p>
			<ul>
			<li>
				<display-error v-show="file.errors" :error="file.errors['where']"></display-error>
				#Where: <input type="text" name="where"  class="form-control" v-model="file.where">
			</li>
			<li>
				<display-error v-show="file.errors" :error="file.errors['when']"></display-error>
				#When: <input type="date" name="when"  class="form-control" v-model="file.when">
			</li>
			<li>
				<display-error v-show="file.errors" :error="file.errors['who']"></display-error>
				#Who: <input type="text" name="who"  class="form-control"v-model="file.who">
			</li>
			<li>
				<display-error v-show="file.errors" :error="file.errors['what']"></display-error>
				#What: <input type="text" name="what"  class="form-control" v-model="file.what">
			</li>
		</ul>
			<a class="btn btn-primary" @click.prevent="update">edit</a>
			<a class="btn btn-primary" @click.prevent="status = true ">Go back</a>
	</div>
</div>
</template>

<script>
import displayError from './../inputs/display-error'
import moment from 'moment'
export default {

  name: 'file-block',
  components:{
  	displayError
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
  		return moment(this.file.when).format('DD/MM/YYYY')
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
    	url:'/files'
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
  	}
  }
};
</script>

<style lang="scss" scoped>
.block-container{
	width:100%;
	background-color:rgb(255,255,255);
	padding: 1rem;

	video,img,audio,.download-file{
		width:100%;

	}

	.file-info{
		padding:.5rem;

		h2{
			padding: .5rem 0;
			height:50px;
			font-weight:bolder;
			text-align:center;
		}
		
	}

	.btn{
		width:100%;
		margin: 0.5rem auto;
	}
}
</style>