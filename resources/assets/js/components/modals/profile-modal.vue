<template>
	<div>
    <slot></slot>  
	</div>
</template>

<script>
export default {

  name: 'profile-modal',

  data () {
    return {

    };
  },
  mounted(){
  	let modalName='first_profile'
  	if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)
  }
};
</script>

<style lang="scss">
.dropbox{
  width:12rem;
  margin-left:30%;
  margin-top:2rem;
}
</style>