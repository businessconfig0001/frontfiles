<template>
<div class="block-container">
	<video controls>
		<source :src="video.url">
	</video>
	<div v-if="status">
		<h2>{{video.title}}</h2>
		<p>{{video.description}}</p>
		<ul>
			<li v-show="video.where">#Where: <span>{{video.where}}</span></li>
			<li v-show="video.when">#When: <span>{{date}}</span></li>
			<li v-show="video.who">#Who: <span>{{video.who}}</span></li>
			<li v-show="video.what">#What: <span>{{video.what}}</span></li>
		</ul>
		<a class="btn" @click.prevent="status = false">edit</a>
		<a class="btn" @click.prevent="del">delete</a>
	</div>
	<div v-else>
			<p>
				<display-error v-show="video.errors" :error="video.errors['title']"></display-error>
				<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="video.title"/>	
			</p>
			<p>
				<display-error v-show="video.errors" :error="video.errors['description']"></display-error>
				<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="video.description"></textarea>
			</p>
			<ul>
			<li>
				<display-error v-show="video.errors" :error="video.errors['where']"></display-error>
				#Where: <input type="text" name="where" v-model="video.where">
			</li>
			<li>
				<display-error v-show="video.errors" :error="video.errors['when']"></display-error>
				#When: <input type="date" name="when" v-model="video.when">
			</li>
			<li>
				<display-error v-show="video.errors" :error="video.errors['who']"></display-error>
				#Who: <input type="text" name="who" v-model="video.who">
			</li>
			<li>
				<display-error v-show="video.errors" :error="video.errors['what']"></display-error>
				#What: <input type="text" name="what" v-model="video.what">
			</li>
		</ul>
			<a class="btn" @click.prevent="update">edit</a>
			<a class="btn" @click.prevent="status = true ">Go back</a>
	</div>
</div>
</template>

<script>
import displayError from './display-error'
import moment from 'moment'
export default {

  name: 'video-block',
  components:{
  	displayError
  },
  props:{
  	video:{
  		required:true,
  		type:Object
  	}
  },
  mounted(){
  	this.video.errors={}
  },
  computed:{
  	date(){
  		return moment(this.video.when).format('DD/MM/YYYY')
  	}
  },
  data () {
    return {
    	status:true,
    	url:'/video'
    };
  },
  methods:{
  	update(){
  		let f=new FormData();
  		f.append('title',this.video.title)
  		f.append('description',this.video.description)
  		f.append('who',this.video.who)
  		f.append('when',this.video.when)
  		f.append('what',this.video.what)
  		f.append('where',this.video.where)

  		axios.patch(window.location.protocol + "//" + window.location.host + this.url + '/' + this.video.id, f)
  			.then(status = true)
  			.catch(this.video.erros = res.response.data)
  	},
  	del(){
  		axios.delete(window.location.protocol + "//" + window.location.host + this.url + '/' + this.video.id)
  			.then(this.$emit('remove'))
  			.catch(console.error)
  	}
  }
};
</script>

<style lang="scss" scoped>
.block-container{
	width:100%;
	background-color:white;
	padding: 1rem;

	video{
		width:100%;
	}
}
</style>