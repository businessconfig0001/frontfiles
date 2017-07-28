@extends('layouts.app')

@section('content')
				

<!-- /profile -->
<section class="profile-container">
		<div class="row">
			<div class="col-xs-12">
				<div class="profile-picture col-xs-4">
					<img src="https://dummyimage.com/450x450/fff/111" />
				</div>

				<div class="profile-content col-xs-8">
				<div class="row">
					<div class="col-xs-5">
						<h1 class="title txt-large">{{ $user->name }}</h1>
						<div class="box">
							<h2 class=" subtitle location">São Paulo, Brasil</h2>	
							<p class="txt-small">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis erat, venenatis vitae iaculis dictum, sagittis quis urna. Curabitur nisi nulla, maximus in condimentum at, ornare vel eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis erat, venenatis vitae iaculis dictum, sagittis quis urna. Curabitur nisi nulla, maximus in condimentum at, ornare vel eros. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							 </p>
	
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
</section><!-- profile-details -->

@endsection