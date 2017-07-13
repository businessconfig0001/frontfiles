<template>
<div class="display-container">
	<ul class="video-list">
		<li v-for="video in videos">
			<video>
				<source :src="video.src">
			</video>
			<h2>{{video.title}}</h2>
			<p>{{video.description}}</p>
		</li>
	</ul>
</div>
</template>

<script>
export default {

  name: 'videos-display',
  props:{
  	videos:{
  		required:true,
  		type:Array
  	}
  }

  data () {
    return {

    };
  }
};
</script>

<style lang="scss" scoped>
</style>