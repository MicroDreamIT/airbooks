<template>
	<div>
			<div class="airBookPlans" v-if="loaded">
				<!--<div class="airBookPlans">-->
				<h1>Airbook Plans</h1>
				<p>The most cost-effective & advanced aviation remarketing<br> platform for you.</p>
			</div>

			<div class="col-md-12 d-flex justify-content-center flex-wrap plan-bg">
				<!--card Block Wrapper-->
				<div class="planCards">
					<!--card Start-->
					<div class="planBlock card">
							<div class="planHead">
								{{leftPlan.name}}
							</div>
							<div class="planMonth">
								<span>{{leftPlan.title}}</span>
								<span> {{leftPlan.sub_title}}</span>
							</div>
							<div class="planContentHeading">
								market
							</div>
							<div class="planContentBlock">
                                <div class="planContent" v-for="item in leftPlan.points">
                                    {{item.number_points>99?'Unlimited':item.number_points}}
                                    <span>{{item.points_type}}</span>
                                    <span>{{item.point_text}}</span>
                                </div>
							</div>
                        <div v-html="leftPlan.details">

                        </div>
						    <!--<div class="planContentHeading">-->
								<!--access-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent"> Everything on Airbook </div>-->
							<!--</div>-->
						   <!--<div class="planContentHeading">-->
							   <!--FEATURES & ADD-ONS-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent"> Limited features </div>-->
								<!--<div class="planContent"> No-Add-ons </div>-->
							<!--</div>-->
						 <div class="buyNow">

						 </div>
						
						</div>
					<!--card Start-->
					<div class="planBlock card">
							<div class="planHead">
								{{centerPlan.name}}
							</div>
							<div class="planMonth personal">
								<span>{{centerPlan.title}}</span>
								<span>{{centerPlan.sub_title}}</span>
							</div>
							<div class="planContentHeading">
								market
							</div>
							<div class="planContentBlock">
                                <div class="planContent" v-for="item in centerPlan.points">
                                    {{item.number_points>99?'Unlimited':item.number_points}}
                                    <span>{{item.points_type}}</span>
                                    <span>{{item.point_text}}</span>
                                </div>
							</div>
                        <div v-html="centerPlan.details">

                        </div>
							<!--<div class="planContentHeading">-->
								<!--connect-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent">  20 direct email/month </div>-->
								<!--<div class="planContent">  - </div>-->
								<!--<div class="planContent">  Unlimited Wanted </div>-->
							<!--</div>-->
						    <!--<div class="planContentHeading">-->
								<!--access-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent"> Everything on Airbook </div>-->
							<!--</div>-->
						   <!--<div class="planContentHeading">-->
							   <!--FEATURES & ADD-ONS-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent"> Limited features </div>-->
								<!--<div class="planContent"> No-Add-ons </div>-->
							<!--</div>-->
						<div class="buyNow">
                            <select v-model="planType">
                                <option :value="'monthly'">monthly</option>
                                <option :value="'yearly'">yearly</option>
                            </select>
                            <div class="PT_express_checkout" v-if="personalCheckoutBtn"></div>
							<button class="btn btn-primary wizard-next"
                                    id="personalBtn"
									@click.prevent="payTabs('personal')"
                                    v-if="personalBtnShow"
									:disabled="planName=='personal' && currentPlan==planType?true:false"

							>Buy Now
                                <!--<img src='https://www.paytabs.com/seals/05.png' width="80" height="30" />-->
								<!--{{planName=='personal' && planType==currentPlan ? 'Subscribed': 'Buy Now'}}-->

							</button>
						</div>
						
						</div>
					<!--card Start-->
					<div class="planBlock card">
							<div class="planHead">
								{{rightPlan.name}}
							</div>
							<div class="planMonth corporate">
								<span>	{{rightPlan.title}} </span>
								<span>	{{rightPlan.sub_title}}</span>
							</div>
							<div class="planContentHeading">
								market
							</div>
							<div class="planContentBlock">
								<div class="planContent" v-for="item in rightPlan.points">
                                    {{item.number_points>99?'Unlimited':item.number_points}}
                                    <span>{{item.points_type}}</span>
                                    <span>{{item.point_text}}</span>
                                </div>

							</div>
                            <div v-html="rightPlan.details">

                            </div>
							<!--<div class="planContentHeading">-->
								<!--connect-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent">  20 direct email/month </div>-->
								<!--<div class="planContent">  - </div>-->
								<!--<div class="planContent">  Unlimited Wanted </div>-->
							<!--</div>-->

						    <!--<div class="planContentHeading">-->
								<!--access-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent"> Everything on Airbook </div>-->
							<!--</div>-->
						   <!--<div class="planContentHeading">-->
							   <!--FEATURES & ADD-ONS-->
							<!--</div>-->
							<!--<div class="planContentBlock">-->
								<!--<div class="planContent"> Limited features </div>-->
								<!--<div class="planContent"> No-Add-ons </div>-->
							<!--</div>-->
						<div class="buyNow">
                            <select v-model="planType">
                                <option :value="'monthly'">monthly</option>
                                <option :value="'yearly'">yearly</option>
                            </select>
                            <div class="PT_express_checkout" v-if="corporateCheckoutBtn"></div>
                            <button class="btn btn-primary wizard-next "
									@click.prevent="payTabs('corporate')"
                                    id="corporateBtn"
                                    v-if="corporateBtnShow"
									:disabled="planName=='corporate' && currentPlan==planType?true:false"
							>Buy Now
								<!--{{ planName=='corporate' && planType==currentPlan ? 'Subscribed': 'Buy Now' }}-->
							</button>
						</div>
					</div>
				</div>
			</div>


        <!--For Strip Payment gateway Modal-->

		<!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Card Details</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<cardInformation
								@planNameSuccess="emitName"
								@planTypeSuccess="emitType"
								:redirectUrl="$route.params.redirectUrl"
								:planName="planName"
								:planType="planType">
						</cardInformation>
					</div>
					&lt;!&ndash;<div class="modal-footer">&ndash;&gt;
						&lt;!&ndash;<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>&ndash;&gt;
						&lt;!&ndash;<button type="button" class="btn btn-primary">Save changes</button>&ndash;&gt;
					&lt;!&ndash;</div>&ndash;&gt;
				</div>
			</div>
		</div>-->


	</div>
</template>

<script src="./promoteList.js"></script>


