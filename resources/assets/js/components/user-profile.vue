<template>
<section class="profile-container">
		<div class="row">
			<div class="col-xs-12">
				<div class="profile-picture col-xs-4">
					<img :src="user.avatar" />
				</div>

				<div class="profile-content col-xs-8">
					<div class="row">
						<div class="col-xs-5">
							<h1 class="title txt-large">{{ user.first_name + " " + user.last_name }}</h1>
							<div class="box">
								<h2 class=" subtitle location">{{ user.location }}</h2>
								<p class="txt-small">{{ user.bio }}</p>
							</div>
						</div>
						<div class="col-xs-7 box box-offset">
							<h2 class="subtitle">Recent</h2>

							<div class="row">
								<div class="thumbnails col-xs-12 no-pad">
									<div class="col-xs-12 col-sm-4">
										<div class="thumb">
											<img src="https://dummyimage.com/450x450/00f/fff" />
										</div>
										<p class="description txt-small">Allepo, Siria</p>
									</div>  
									<div class="col-xs-12 col-sm-4">
										<div class="thumb">
											<img src="https://dummyimage.com/450x450/00f/fff" />
										</div>
										<p class="description txt-small">Allepo, Siria</p>
									</div>  
									<div class="col-xs-12 col-sm-4">
										<div class="thumb">
											<img src="https://dummyimage.com/450x450/00f/fff" />
										</div>
										<p class="description txt-small">Rio de Janeiro, Brasil</p>
									</div>  
								</div>
							</div>
						</div>
						
					</div>

					<div class="row">
						<div class="col-xs-5">
								
							<p class="source">
								<a href="#">Midia ninja <i class="fa fa-arrow-right"></i></a>
							</p>
							<div class="box">
								<ul class="tags">
									<li>
										<a href="#" class="btn btn-border-blue txt-small">Photo</a>
									</li>
									<li>
										<a href="#" class="btn btn-border-blue txt-small">Video</a>
									</li>
									<li>
										<a href="#" class="btn btn-border-blue txt-small">Design</a>
									</li>
								</ul>	
							</div>
							
						</div>
						<div class="col-xs-7">
							<div class="box box-offset-small"></div>
						</div>	
					</div>

				</div>
			</div>
		</div>
		<div class="row">
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
		this.$store.commit('openModal','You are now an official FrontFiler and we are ready to start receiving your editorial footage, images or illustrations. You can complete your profile information whenever you want. After you upload your files, they will be available for sale and for sharing (the compressed copy).During this Beta phase, files can be sold by us directly to the client, and only if they show urgent relevancy. However, you decide whether you wish to sell or not, as well as set the price for all of your files.In the next platform’s phase you will have full control over the sales , which will be automatic and direct from you to the buyer')
	}
}
</script>

<style lang="css" scoped>
</style>