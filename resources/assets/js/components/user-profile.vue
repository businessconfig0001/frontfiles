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
							<h1 class="title txt-large">{{ user.fullName }}</h1>
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
</section>
</template>

<script>
export default {

  name: 'user-profile',
  props:{
  	user:{
  		required:true,
  		type:Object
  	}
  },
  data () {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
</style>