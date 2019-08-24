<template>
	<div>
		<div class="be-left-sidebar text-info">
			<div class="left-sidebar-wrapper"><a class="left-sidebar-toggle" href="#">Dashboard</a>
				<div class="left-sidebar-spacer">
					<div class="left-sidebar-scroll">
						<div class="left-sidebar-content" id="sideBarVue">
							<ul class="sidebar-elements">
								<li class="scrollable">
									<router-link :to="{name:'userDashboard'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-home"></i>
										<span>Dashboard</span>
									</router-link>
								</li>

								<li class="scrollable">
									<router-link :to="{name:'userAircrafts'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-airplane"></i>
										<span>Aircraft</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userEngineList'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon fab fa-empire pointer" style="font-size: 14px;"></i>
										<span>Engines</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userApuList'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-battery-flash"></i>
										<span>APU's</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userPartsList'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon fas fa-cogs" style="font-size: 14px;"></i>
										<span>Parts</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userWantedIndex'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon fas fa-hand-holding-heart" style="font-size: 14px;"></i>
										<span>Wanted</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userContacts'}" data-toggle="tooltip" data-placement="right"
												 title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-accounts-list-alt"></i>
										<span>Contacts</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userLeadList'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-ticket-star"></i>
										<span>Leads</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userConnectionList'}" data-toggle="tooltip" data-placement="right"
									             title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-link"></i>
										<span>Connections</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userFavouriteList'}" data-toggle="tooltip" data-placement="right"
												 title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-favorite"></i>
										<span>Favourites</span>
									</router-link>
								</li>
								<li class="scrollable">
									<router-link :to="{name:'userPromoteList'}" data-toggle="tooltip" data-placement="right"
												 title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-money"></i>
										<span>Promote Mode</span>
									</router-link>
								</li>

								<li class="scrollable">
									<router-link :to="{name:'userCompanyEdit'}" data-toggle="tooltip" data-placement="right"
												 title="" data-original-title="Dashboard">
										<i class="icon mdi mdi-home"></i>
										<span>My Company</span>
									</router-link>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="progress-widget">
					<div class="progress-data d-flex justify-content-center flex-wrap">

						<span class="name"> Copyright &nbsp; </span>
						<span> © {{date.getFullYear()}} Airbook</span><br>
                        <span>V:1.0.2</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        data(){
          return{
              date:new Date(),
          }
        },
        name: "user-sidebar",
        methods: {
            toogleNav(e) {
                let target = e.target
                let parentElm = target.parentElement
                let parentElmClassList = parentElm.classList
                if(_.includes(parentElmClassList, 'parent')){
                    if (_.includes(parentElmClassList, 'open')) {
                        parentElmClassList.remove('open')
                    } else {
                        this.removeOpenClass()
                        parentElmClassList.add('open')
                    }
                }
            },

            removeOpenClass() {
                let elm = document.getElementsByClassName('parent');
                for (let i = 0; i < elm.length; i++) {
                    elm[i].classList.remove('open')
                }
            }
        }
    }
</script>

