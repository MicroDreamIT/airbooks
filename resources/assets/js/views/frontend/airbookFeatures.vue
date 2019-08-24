<template>
	<div v-if="metas">
		<search-layout></search-layout>

		<div class="general-page-section">
			<div class="container w-container">
				<div class="general-content-wrapper" v-if="sectionOne">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionOne.title}}</h3>
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
				<div class="general-content-wrapper" v-if="sectionTwo">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionTwo.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionTwo.body">

					</div>

				</div>
			</div>
		</div>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="general-content-wrapper" v-if="sectionThree">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionThree.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionThree.body">

					</div>
				</div>
			</div>
		</div>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="general-content-wrapper" v-if="sectionFour">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionFour.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionFour.body">

				</div>
				</div>
			</div>
		</div>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="general-content-wrapper" v-if="sectionFive">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionFive.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionFive.body"></div>
				</div>
			</div>
		</div>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="general-content-wrapper" v-if="sectionSix">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionSix.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionSix.body"></div>
				</div>
			</div>
		</div>
		<div class="general-page-section">
			<div class="container w-container">
				<div class="general-content-wrapper" v-if="sectionSeven">
					<div class="heading-block">
						<h3 class="home-section-title">{{sectionSeven.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div v-html="sectionSeven.body">

					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script src="./js/details/airbookFeature.js"></script>

