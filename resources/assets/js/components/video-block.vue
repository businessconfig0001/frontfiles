<template>
<div class="block-container">
	<video controls>
		<source :src="video.url">
	</video>
	<div v-if="status">
		<h2>{{video.title}}</h2>
		<p>{{video.description}}</p>
		<a class="btn" @click.prevent="status = false">edit</a>
		<a class="btn" @click.prevent="del">delete</a>
	</div>
	<div v-else>
			<input type="text" name="title" id="title" class="form-control" placeholder="Title" v-model="video.title"/>
			<textarea name="description" id="description" class="form-control" placeholder="Description" v-model="video.description"></textarea>
			<a class="btn" @click.prevent="update">edit</a>
			<a class="btn" @click.prevent="status = true ">Go back</a>
	</div>
</div>
</template>

<script>
export default {

  name: 'video-block',
  props:{
  	video:{
  		required:true,
  		type:Object
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
  		axios.put(window.location.protocol + "//" + window.location.host + this.url,f)
  			.then(status = true)
  			.catch(console.error)
  	},
  	del(){
  		axios.delete(window.location.protocol + "//" + window.location.host + this.url + '?id=' + this.video.id)
  			.then(this.$emit('remove'))
  			.catch(console.error)
  	}
  }
};
</script>

<style lang="scss" scoped>
</style>