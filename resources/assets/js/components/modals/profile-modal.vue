<template>
	<div>
		<modal-container>
			<h2>Before proceeding you must associate your Cloud Drive account to your FF account.</h2>
			<p>
				At the moment we are only testing Dropbox but very soon we will accept almost every type of cloud available. FF will store your original files in your Cloud Drive and create a compressed copy with digital watermark and ID. This copy will be stored on our server and fully available on our platform, shareable for non-commercial use with no restrictions. We’ll use the compressed file to promote your work. However, you will always have full control over it.
			</p>
		</modal-container>
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

<style lang="scss" scoped>
</style>