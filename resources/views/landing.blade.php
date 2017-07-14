@extends('layouts.app')

@section('content')

<div id="landing">
  <!-- HERO !-->
                <section class="col-xs-12  no-pad hero">
                    <div class="hero-image">
                        <img src="assets/images/hero.jpg" alt="hero">
                    </div>
                </section>
                <!-- /HERO !-->

                <section id="about-us">
                	<div class="container">
                		<div class="col-sm-6 col-xs-12">
	                		<h3>WHO</h3>
	                		<h2>WE ARE</h2>
	                		<p>FF is an open, collaborative network platform of media activists, freelance journalists & witness citizens.</p>
	                		<p>We created from bottom up a new powerful management and monetary tool to keep our journalistic work independent & autonomous.</p>
	                		<p>Truth travels faster in social networks and we want to help the fire spread. We are in for the long ride.</p>
	                		<p class="text-blue">Join us.</p>
	                	</div>
                		<div class="col-sm-6 col-xs-12"></div>
                		<div class="col-sm-8 col-xs-12 mailing">
                			<input type="text" placeholder="E-mail">
                			<input type="submit" class="bg-blue" value="SEND">
                		</div>
                		<div class="col-sm-4 col-xs-12"></div> 
                	</div>
                </section>

                <section class="ff-divisor"></section>

                <section class="col-xs-12  no-pad hero">
                    <div class="hero-image">
                        <img src="assets/images/beach-img.jpg" alt="hero">
                    </div>
                </section>

                <section id="how-it-works">
	                <div class="container">
	                	<h3>HOW IT</h3>
		                <h2>WORKS</h2>
		                </div>
		                <section class="steps">
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">1. Create a Profile</div>
		                			<div class="col-xs-2 icon"><i class="fa fa-plus" aria-hidden="true"></i></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">2. Shoot a Photo & Video</div>
		                			<div class="col-xs-2 icon"><i class="fa fa-circle" aria-hidden="true"></i></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">3. Tag it</div>
		                			<div class="col-xs-2 icon">#</div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">4. Price and License</div>
		                			<div class="col-xs-2 icon">$ &copy;</div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">5. Upload & Sell</div>
		                			<div class="col-xs-2 icon"><i class="fa fa-arrow-up" aria-hidden="true"></i></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">6. Keep independent</div>
		                			<div class="col-xs-2 icon"><i class="fa fa-bolt" aria-hidden="true"></i></div>
		                		</div>
		                	</div>
		                </section>
	                </div>
                </section>

                <section class="col-xs-12 ff-divisor"></section>
                <section class="col-xs-12 ff-divisor"></section>
                <section class="col-xs-12 ff-divisor"></section>

                <section class="footer bg-blue col-xs-12">
                    <div class="container">
                        <div class="col-sm-4 col-xs-12">
                        	<img src="{{ url('assets/images/logo-white.png') }}" class="img-responsive">
                        	<p>&nbsp;</p>
                        	<p><a href="mailto: info@frontfiles.com">info@frontfiles.com</a></p>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                        	<i class="fa fa-facebook" aria-hidden="true"></i>
                        	<i class="fa fa-twitter" aria-hidden="true"></i>
                        	<i class="fa fa-instagram" aria-hidden="true"></i>
                        	<i class="fa fa-youtube" aria-hidden="true"></i>
                        </div>
                    </div>
                </section>

                <!-- /modules -->
</div>
@endsection