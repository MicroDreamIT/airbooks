<template>
	<div v-if="metas">
		<search-layout></search-layout>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="content-flex"  v-if="sectionOne">
					<div class="heading-block">
						<h3 class="home-section-title own-uppercase">{{sectionOne.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionOne.body">

					</div>
				</div>
			</div>
		</div>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="content-flex ceo-message"  v-if="sectionTwo">
					<template v-if="sectionTwo.medias">
						<div class="ceo-image" :style="sectionTwo.medias[0]|imagePathForStyle"></div>
					</template>

					<div class="about-content-block" v-html="sectionTwo.body">

					</div>
				</div>
			</div>
		</div>
		<div class="general-page-section mission-section" v-if="sectionThree">
			<div class="container w-container" v-html="sectionThree.body">
				<!--<h2 class="general-page-headline-h2 white-color"><span class="block-quote"></span> Our mission is to serve the aviation industry with innovative internet re-marketing solutions <span class="block-quote"></span></h2>-->
			</div>
		</div>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="heading-block">
					<h3 class="home-section-title">Our Products</h3>
					<div class="line-block">
						<div class="blueline"></div>
						<div class="redline"></div>
					</div>
				</div>
				<div class="general-row w-row">
					<div class="general-column w-col w-col-4 w-col-small-4 w-col-tiny-4">
						<a href="https://xbs.aero/aviation-products.html#xcam" target="_blank" class="product-wrapper xcam w-inline-block">
							<div class="product-desc w-hidden-small w-hidden-tiny">Continuous airworthiness management</div>
						</a>
					</div>
					<div class="general-column w-col w-col-4 w-col-small-4 w-col-tiny-4">
						<a href="https://xbs.aero/aviation-products.html#xcrm" target="_blank" class="product-wrapper xcrm w-inline-block">
							<div class="product-desc w-hidden-small w-hidden-tiny">Customer relationship management</div>
						</a>
					</div>
					<div class="general-column w-col w-col-4 w-col-small-4 w-col-tiny-4">
						<a href="https://xbs.aero/aviation-products.html#xdoc" target="_blank" class="product-wrapper xdocs w-inline-block">
							<div class="product-desc w-hidden-small w-hidden-tiny">Aircraft &amp; Airline records management</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</template>

<script src="./js/details/aboutAirbook.js"></script>
