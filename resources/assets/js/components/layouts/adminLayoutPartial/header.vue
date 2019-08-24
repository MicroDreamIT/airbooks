<template>
	<div>
		<nav class="navbar navbar-expand fixed-top be-top-header" id="nav-header">
			<div class="container-fluid">
				<div class="be-navbar-header">
					<router-link :to="{name:'adminHome'}" class="navbar-brand"></router-link>
					<a class="be-toggle-left-sidebar" href="#" @click="toggleNav()">
					<span class="icon mdi mdi-menu"></span></a>
				</div>
				<div class="be-right-navbar">
					<ul class="nav navbar-nav float-right be-user-nav">
						<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
                                <img :src="$root.$data.user.contact.medias ?
                                $root.getMediaPathFromObject($root.$data.user.contact.medias) : '/images/user.svg'">
                                <!--<span class="user-name">Túpac Amaru</span>-->
                            </a>
							<div class="dropdown-menu" role="menu">
								<div class="user-info">
									<div class="user-name" v-if="$root.$data.user.contact">{{ $root.$data.user.contact | fullName }}</div>
									<div class="user-position online">Available</div>
								</div>

                                <router-link :to="{name:'accountSetting'}" class="dropdown-item">
                                <span class="icon mdi mdi-face"></span>
                                    Account
                                </router-link>
								<a class="dropdown-item" href="" @click.prevent="logout">
									<span class="icon mdi mdi-power"></span>Logout</a>
								<form id="logout-form" action="/logout" method="POST" style="display: none">
                                    &nbsp;&nbsp;<input type="hidden" name="_token" :value="csrf"/>
								</form>
							</div>
						</li>
					</ul>
					<div class="page-title">
						<img src="/admin2/img/favi.svg" class="removable_brand" alt="Airbook">
					</div>
					<ul class="nav navbar-nav float-right be-icons-nav">
                        <li class="nav-item dropdown">
                            <form class="form-inline" style="padding-top: 20px">
                                <a href="/" target="_blank" class="btn btn-sm btn-info text-white mr-2">
                                    <i class="mdi mdi-globe"></i> Visit Site
                                </a>

                                <a href="#" class="btn btn-sm btn-secondary text-white" @click="$root.showMedia=true">
                                    <span class="icon mdi mdi-upload"></span>
                                </a>
                            </form>

                        </li>
						<!--<li class="nav-item dropdown nav-setting-sp"><a  class="nav-link be-toggle-right-sidebar" href="#" role="button" aria-expanded="false"><span class="icon mdi mdi-settings"></span></a></li>-->
						<!--<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="icon mdi mdi-notifications"></span><span class="indicator"></span></a>-->
							<!--<ul class="dropdown-menu be-notifications">-->
								<!--<li>-->
									<!--<div class="title">Notifications<span class="badge badge-pill">3</span></div>-->
									<!--<div class="list">-->
										<!--<div class="be-scroller ps-container ps-theme-default" data-ps-id="5609f10c-8b16-dc3f-711c-a4dc70d86439">-->
											<!--<div class="content">-->
												<!--<ul>-->
													<!--<li class="notification notification-unread"><a href="#">-->
														<!--<div class="image"><img src="/assets/img/avatar2.png" alt="Avatar"></div>-->
														<!--<div class="notification-info">-->
															<!--<div class="text"><span class="user-name">Jessica Caruso</span> accepted your invitation to join the team.</div><span class="date">2 min ago</span>-->
														<!--</div></a></li>-->
													<!--<li class="notification"><a href="#">-->
														<!--<div class="image"><img src="/assets/img/avatar3.png" alt="Avatar"></div>-->
														<!--<div class="notification-info">-->
															<!--<div class="text"><span class="user-name">Joel King</span> is now following you</div><span class="date">2 days ago</span>-->
														<!--</div></a></li>-->
													<!--<li class="notification"><a href="#">-->
														<!--<div class="image"><img src="/assets/img/avatar4.png" alt="Avatar"></div>-->
														<!--<div class="notification-info">-->
															<!--<div class="text"><span class="user-name">John Doe</span> is watching your main repository</div><span class="date">2 days ago</span>-->
														<!--</div></a></li>-->
													<!--<li class="notification"><a href="#">-->
														<!--<div class="image"><img src="/assets/img/avatar5.png" alt="Avatar"></div>-->
														<!--<div class="notification-info"><span class="text"><span class="user-name">Emily Carter</span> is now following you</span><span class="date">5 days ago</span></div></a></li>-->
												<!--</ul>-->
											<!--</div>-->
											<!--<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>-->
									<!--</div>-->
									<!--<div class="footer"> <a href="#">View all notifications</a></div>-->
								<!--</li>-->
							<!--</ul>-->
						<!--</li>-->
						<!--<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="icon mdi mdi-apps"></span></a>-->
							<!--<ul class="dropdown-menu be-connections">-->
								<!--<li>-->
									<!--<div class="list">-->
										<!--<div class="content">-->
											<!--<div class="row">-->
												<!--<div class="col"><a class="connection-item" href="#"><img src="/assets/img/github.png" alt="Github"><span>GitHub</span></a></div>-->
												<!--<div class="col"><a class="connection-item" href="#"><img src="/assets/img/bitbucket.png" alt="Bitbucket"><span>Bitbucket</span></a></div>-->
												<!--<div class="col"><a class="connection-item" href="#"><img src="/assets/img/slack.png" alt="Slack"><span>Slack</span></a></div>-->
											<!--</div>-->
											<!--<div class="row">-->
												<!--<div class="col"><a class="connection-item" href="#"><img src="/assets/img/dribbble.png" alt="Dribbble"><span>Dribbble</span></a></div>-->
												<!--<div class="col"><a class="connection-item" href="#"><img src="/assets/img/mail_chimp.png" alt="Mail Chimp"><span>Mail Chimp</span></a></div>-->
												<!--<div class="col"><a class="connection-item" href="#"><img src="/assets/img/dropbox.png" alt="Dropbox"><span>Dropbox</span></a></div>-->
											<!--</div>-->
										<!--</div>-->
									<!--</div>-->
									<!--<div class="footer"> <a href="#">More</a></div>-->
								<!--</li>-->
							<!--</ul>-->
						<!--</li>-->
					</ul>
				</div>
			</div>
		</nav>
	</div>
</template>

<script>
    export default {
        data(){
          return{
              csrf: ''
          }
        },
        mounted(){
         this.csrf=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        },
        methods:{
            toggleNav(){
                if(!this.$root.$data.navTogglar){
                    this.$root.$data.navTogglar = 'be-collapsible-sidebar-collapsed'
                }
				else{
                    this.$root.$data.navTogglar = null
				}
	            $(".removable_brand").toggleClass('opacityEnable');
			},
			logout(){
                document.getElementById('logout-form').submit();
			}
		}
    }
</script>


