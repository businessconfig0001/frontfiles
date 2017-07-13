<template>
<div class="display-container">
	<ul class="video-list">
		<li v-for="video in videos">
			
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