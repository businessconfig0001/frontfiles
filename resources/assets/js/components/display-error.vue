<template>
<div class="err-wrapper">
	<div v-show="error">
			<ul v-if="error instanceof Array">
				<li v-for="e in error">{{e}}</li>
			</ul>
			<span v-else>{{error}}</span>
	</div>
</div>
</template>

<script>
export default {

  name: 'display-error',
  props:{
  	error:{
  	}
  },
  data () {
    return {

    };
  }
};
</script>

<style lang="scss" scoped>
</style>