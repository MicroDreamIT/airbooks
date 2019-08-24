<template>
	<div>
		<nav class="navbar navbar-expand fixed-top be-top-header" id="nav-header">
			<div class="container-fluid">
				<div class="be-navbar-header">
					<router-link :to="{name:'userDashboard'}" class="navbar-brand"></router-link>
					<a class="be-toggle-left-sidebar" href="#" @click="toggleNav()">
						<span class="icon mdi mdi-menu"></span></a>
				</div>
				<div class="be-right-navbar">
					<ul class="nav navbar-nav float-right be-user-nav">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
							<img :src="$root.$data.user.contact.medias ?
							$root.getMediaPathFromObject($root.$data.user.contact.medias) : '/images/user.svg'"
									alt="Avatar"/>
									<!--<span class="user-name">Túpac Amaru</span>-->
							</a>
							<div class="dropdown-menu" role="menu">
								<div class="user-info">
									<div class="user-name" v-if="$root.$data.user.contact">{{ $root.$data.user.contact | fullName }}</div>
									<div class="user-position online">Available</div>
								</div>
								<router-link :to="{name:'userContacts'}" class="dropdown-item">
									<span class="icon mdi mdi-face"></span>
									Account
								</router-link>
								<router-link class="dropdown-item" to="/user/settings">
									<span class="icon mdi mdi-settings"></span>
									Settings
								</router-link>
                                <router-link :to="{name:'userPaymentHistory'}" class="dropdown-item">
                                    <span class="icon mdi mdi-money"></span>
                                    Payment History
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
								<a href="/" target="_blank" class="btn btn-sm btn-info text-white">
									<i class="mdi mdi-globe"></i> Visit Site
								</a>

								&nbsp;&nbsp
								<a href="#" class="btn btn-sm btn-secondary text-white" @click="$root.showMedia=true">
									<span class="icon mdi mdi-upload"></span>
								</a>
							</form>

                        </li>
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
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
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

