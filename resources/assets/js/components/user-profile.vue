<template>
<section class="profile-container">
		<div class="container">
			<div class="col-xs-12">
				<div class="profile-picture col-xs-3">
					<img :src="user.avatar" />
				</div>

				<div class="profile-content col-xs-9">
					<div class="row">
						<div class="col-xs-12">
							<h1 class="title txt-large">{{ user.first_name + " " + user.last_name }}</h1>
							<div class="box">
								<h2 class=" subtitle location">{{ user.location }}</h2>
								<p class="txt-small">{{ user.bio }}</p>
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</div>
		<div class="container files">
			<files-display :files="files"></files-display>
		</div>
</section>
</template>

<script>
import filesDisplay from './files-display'
export default {

	name: 'user-profile',
	components:{
		filesDisplay
	},
	props:{
		user:{
			required:true,
			type:Object
		},
		files:{
			required:true,
			type:Array
		}
	},
	data () {
		return {

		}
	},
	mounted(){
		scroll(0,0)
		let modalName='first_login'
		if(!localStorage.getItem(modalName))this.$store.commit('openModal',modalName)

	}
}
</script>

<style lang="scss" scoped>
.files{
	margin-top:2rem;
}
</style>