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
                	<div class="container-fluid">
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

							<!-- Begin MailChimp Signup Form -->
							<div id="mc_embed_signup">
								<form action="//mdklive.us11.list-manage.com/subscribe/post?u=dfeda9ebea80059ddcd76838f&amp;id=2deb7e2552" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
									<div id="mc_embed_signup_scroll">

										<div class="mc-field-group">
											<input type="email" value="" name="EMAIL" class="required email form-control newsletter" id="mce-EMAIL" placeholder="E-mail">
										</div>
										<div id="mce-responses" class="clear">
											<div class="response" id="mce-error-response" style="display:none"></div>
											<div class="response" id="mce-success-response" style="display:none"></div>
										</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
										<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_dfeda9ebea80059ddcd76838f_2deb7e2552" tabindex="-1" value=""></div>
										<div class="clear"><input type="submit" value="SEND" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary newsletter"></div>
									</div>
								</form>
							</div>
							<!--End mc_embed_signup-->

                		</div>
                		<div class="col-sm-4 col-xs-12"></div> 
                	</div>
                </section>

                <section class="ff-divisor">
                        	<img src="{{ url('assets/images/ff-bg.png') }}" class="img-responsive">
                </section>

                <section class="col-xs-12  no-pad hero">
                    <div class="hero-image">
                        <img src="assets/images/riot1.jpg" alt="hero">
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
		                			<div class="col-xs-2 icon"><img src="assets/images/how-profile.png" class="img-responsive"></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">2. Shoot Photo or Video</div>
		                			<div class="col-xs-2 icon"><img src="assets/images/how-shoot.png" class="img-responsive"></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">3. Tag it</div>
		                			<div class="col-xs-2 icon"><img src="assets/images/how-tag.png" class="img-responsive"></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">4. Set the Price and License</div>
		                			<div class="col-xs-2 icon"><img src="assets/images/how-price.png" class="img-responsive"></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">5. Upload & Sell</div>
		                			<div class="col-xs-2 icon"><img src="assets/images/how-upload.png" class="img-responsive"></div>
		                		</div>
		                	</div>
		                	<div class="step">
		                		<div class="container">
		                			<div class="col-xs-10">6. Stay independent</div>
		                			<div class="col-xs-2 icon"><img src="assets/images/how-independent.png" class="img-responsive"></div>
		                		</div>
		                	</div>
		                </section>
	                </div>
                </section>

                <section class="ff-big">
                        	<img src="{{ url('assets/images/ff-big.png') }}" class="img-responsive">
                </section>

                <section class="footer bg-blue col-xs-12">
                    <div class="container">
                        <div class="col-sm-4 col-xs-12">
                        	<img src="{{ url('assets/images/logo-white-footer.png') }}" class="img-responsive">
                        	<p>&nbsp;</p><p>&nbsp;</p>
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