<template>
	<div v-if="metas">
		<search-layout></search-layout>
		<!--GET IN TOUCH-->
		<div class="general-page-section no-border-line help-and-support-page">
			<div class="container w-container" v-if="sectionOne">
				<div class="heading-block">
					<h3 class="home-section-title">{{sectionOne.title}}</h3>
					<div class="line-block">
						<div class="blueline"></div>
						<div class="redline"></div>
					</div>
				</div>
				<div class="hs-wrapper">
					<div class="hs-lr-block dwc-image" :style="sectionOne.medias[0]|imagePathForStyle" v-if="sectionOne.medias"></div>
					<div class="hs-lr-block info-block">
						<div v-html="sectionOne.body">

						</div>
					</div>
				</div>
			</div>
		</div>
		<!--Connect on social media  -->
		<div class="social-section">
			<div class="container w-container" v-if="sectionTwo">
				<div class="social-flex-wrapper">
					<div v-html="sectionTwo.body">

					</div>
					<!--<h3 class="contact-social-headline">Connect on social media</h3>-->
					<!--<div class="contact-page-widget-block"><a href="https://www.facebook.com/airbook.aero" target="_blank" class="contact-social-widget"></a><a href="https://twitter.com/airbookaero" target="_blank" class="contact-social-widget"></a><a href="https://www.linkedin.com/company/airbook" target="_blank" class="contact-social-widget"></a></div>-->
				</div>
			</div>
		</div>
		<!--SEND US A MESSAGE-->
		<div class="general-page-section no-border-line">
			<div class="container w-container">
				<template v-if="sectionThree">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionThree.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionThree.body">

					</div>
				</template>

				<div class="hs-wrapper">
					<div class="hs-lr-block contact-form">
						<div class="w-form">
							<form id="wf-form-Contact-Form" name="wf-form-Contact-Form" data-name="Contact Form" @submit.prevent="sendEmail">
								<input type="text" v-model="name" class="general-txt-field w-input" maxlength="256" name="name" placeholder="Name" id="Name-2" required>
								<input type="email" v-model="email" class="general-txt-field w-input" maxlength="256" name="email" placeholder="Email" id="Email-2" required>
								<textarea id="Message" v-model="message" name="message" placeholder="Message" maxlength="5000" data-name="Message" class="general-txt-field general-txt-area w-input" required></textarea>
								<button type="submit" value="Send Message" data-wait="Please wait..." class="general-button w-button">submit</button>
							</form>
							<div class="success-message w-form-done">
								<div>Thank you! Your message has been received!</div>
							</div>
							<div class="w-form-fail">
								<div>Oops! Something went wrong. Please try again later..</div>
							</div>
						</div>
					</div>
					<div class="hs-lr-block contact-block-image"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script src="./js/details/helpAndSupport.js"></script>
