<div class="footer-section">
	<div class="container w-container">
		<div class="footer-row w-row">
			<div class="footer-column w-hidden-medium w-hidden-small w-hidden-tiny w-col w-col-3 w-col-stack">
				<h5 class="footer-headline">Listings</h5><a href="" @click.prevent="" class="footer-link"></a>
				{{--<a href="engines.html" class="footer-link w--current"> Engines</a>--}}
				<router-link :to="{name:'frontAircraft'}" class="footer-link w--current" >Aircraft &amp; Helicopters</router-link>
				<router-link :to="{name:'frontEngine'}" class="footer-link w--current" >Aircraft Engines</router-link>
				<router-link :to="{name:'frontApu'}" class="footer-link w--current" >Aircraft APU's</router-link>
				<router-link :to="{name:'frontPart'}" class="footer-link w--current" >Aircraft Parts</router-link>
				<router-link :to="{name:'frontWanted'}" class="footer-link w--current" >Wanted Assets</router-link>
				{{--<a href="/wanted" style="display: none" class="footer-link ">Wanted Assets</a>--}}
            </div>
			<div class="footer-column w-hidden-medium w-hidden-small w-hidden-tiny w-col w-col-3 w-col-stack">
				<h5 class="footer-headline">Connect &amp; Information</h5>
				<router-link :to="{name:'airports'}" class="footer-link" >Airports</router-link>
				<router-link :to="{name:'companies'}" class="footer-link" >Aviation Companies</router-link>
				<router-link :to="{name: 'frontContact'}" class="footer-link" >Aviation Professionals</router-link>
				
			</div>
			<div class="footer-column w-hidden-medium w-hidden-small w-hidden-tiny w-col w-col-3 w-col-stack">
				<h5 class="footer-headline">About</h5>
				<router-link :to="{name:'aboutAirbook'}" class="footer-link">  Airbook</router-link>
				<router-link :to="{name:'airbookFeatures'}" class="footer-link"> Airbook Features</router-link>
				<router-link :to="{name:'supports'}" class="footer-link" >Help &amp; Support</router-link>
			</div>

			<div class="footer-column w-col w-col-3 w-col-stack">
				<div class="footer-brand-wrapper"><img src="images/Airbook_logo_Silver.svg" width="150" alt="" class="image">
					@if(!auth()->user())
					<div class="footer-sign-wrapper">
						<a href="/login" target="_blank" class="footer-sign-button login w-button">Sign In</a>
						<a href="/register"  target="_blank" class="footer-sign-button signup w-button">Free Sign Up</a>
					</div>
					@endif
					<div class="footer-social-icons"><a href="https://www.facebook.com/airbook.aero" target="_blank" class="social-link fs-left"></a><a href="https://twitter.com/airbookaero" target="_blank" class="social-link"></a><a href="https://www.linkedin.com/company/airbook" target="_blank" class="social-link"></a><a href="https://www.instagram.com/airbook.aero/" target="_blank" class="social-link"></a><a href="https://plus.google.com/112119922414364224379" target="_blank" class="social-link"></a><a href="https://www.youtube.com/channel/UCCg_n48SbSsmp5H3cR5j_vg" target="_blank" class="social-link fsright"></a></div>
				</div>
			</div>

		</div>
		<div class="footer-info-block">
			<div class="footer-sub-link-block">
				<router-link :to="{name:'terms'}" class="footer-sub-links">Terms of Service</router-link>
				<router-link :to="{name:'policy'}" class="footer-sub-links">Privacy Policy</router-link>
			 
				
			</div>
			<div class="copyright">© 2017-{{date('Y')}}, Airbook. All Rights Reserved</div>
			<a href="#Top" class="back-to-top w-button"></a>
		</div>
	</div>
</div>


@if(!request()->cookie('cookieStore'))
<div class="cookies-alert-section" data-ix="show-cookies-section" style="opacity: 0; transform: translateX(0px) translateY(100px) translateZ(0px); transition: opacity 200ms ease 0s, transform 200ms ease 0s; transform-style: preserve-3d;" >
	<div class="container w-container">
		<div class="cookies-block">
			<div class="cookies-alert-message">
				Airbook uses cookies to deliver best user experience.
				<router-link :to="{name:'policy'}" class="cookies-link">Learn more</router-link>
				
			</div>
			<a href="#" id="post-cookies" class="cookies-accept-button w-button" data-ix="close-cookies-alert" style="transition: all 0.05s ease 0s;">
				Ok, Got it!
			</a>
			<form id="cookie-form" action="/store-cookies" method="post" style="display: none;">@csrf</form>
		</div>
	</div>
</div>
@endif
