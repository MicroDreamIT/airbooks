<div class="header-wrapper">

    <search-layout-top></search-layout-top>

    <div id="Top" class="top-header-section">
        <div class="container w-container">
            <div class="top-flex-header">
                <router-link to="/" class="airbook-logo w-inline-block w--current">
                    <img src="/siddiqueAssets/images/Airbook_svg_logo.svg" width="120" alt="Airbook">
                </router-link>

                @if(Auth::check())
                <div class="header-user-menu-wrapper">
                    <div data-delay="0" class="user-drop-down w-dropdown">
                        <div class="user-menu-drop-down-toggle w-dropdown-toggle">
                            <div class="user-menu-bars"></div>
                            @if(Auth::user()->mediaString())
                            <div class="logged-in-user-image"
                                 style="background-image: url({{Auth::user()->mediaString()}})">
                            </div>
                            @else
                            <div class="logged-in-user-image">
                            </div>
                            @endif
                        </div>
                        <nav class="user-menu-drop-down-list w-dropdown-list">
                            <div class="menu-user-bio-block">
                                <div class="menu-hello">Hello!</div>
                                <div class="airbooker-name">
                                    {{auth()->user()->contact->first_name}}
                                </div>
                            </div>
                            @if(Auth::user()->hasRoleType()!='user')

                                <a href="/admin/dashboard" target="_blank" class="user-drop-down-link w-dropdown-link">
                                    Dashboard
                                </a>
                            @endif

                            @if(Auth::user()->hasRoleType()=='user')

                            <a href="/user/dashboard" class="user-drop-down-link w-dropdown-link">
                                Dashboard
                            </a>
                            <a href="/user/lead" class="user-drop-down-link w-dropdown-link">
                                My
                                Leads
                            </a>
                            <a href="/user/favourite" class="user-drop-down-link w-dropdown-link">
                                My Favorites
                            </a>
                            <a href="/user/connection" class="user-drop-down-link w-dropdown-link">
                                My Connections
                            </a>
                            <a href="/user/promote" class="user-drop-down-link promote-mode-link w-dropdown-link">
                                Promote
                                Mode
                            </a>
                            @endif

                                <a class="user-drop-down-link logout-link w-dropdown-link own-pointer"  id="click-logout">
                                    Logout
                                </a>

                                <form id="logout-form" action="/logout" method="POST" style="display: none">
                                    {{csrf_field()}}
                                </form>
                            <form action="/send-verify-email" id="verify-form" method="POST" style="display: none">
                                {{csrf_field()}}
                            </form>

                        </nav>
                    </div>
                </div>
                @endif
                    @if(Auth::guest())
                            <div class="header-sign-wrapper">
                                    <a href="/login" class="top-login w-button">{{'Log in'}}</a>
                                    <a href="/register" class="top-signup w-button">{{'Register (FREE)'}}</a>
                            </div>
                    @endif
            </div>
        </div>
    </div>
    <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar w-nav">
        <div class="w-container">
            <nav role="navigation" class="nav-menu w-nav-menu" @click="disapperMenu">
                <router-link :to="{name:'frontAircraft'}" class="nav-link w-nav-link">Aircraft</router-link>
                <router-link :to="{name:'frontEngine'}" class="nav-link w-nav-link">Engines</router-link>
                <router-link :to="{name:'frontApu'}" class="nav-link w-nav-link">apu</router-link>
                <router-link :to="{name:'frontPart'}" class="nav-link w-nav-link">parts</router-link>
                <router-link :to="{name:'frontWanted'}" class="nav-link w-nav-link">wanted</router-link>
                <router-link :to="{name:'frontNews'}" class="nav-link w-nav-link">news</router-link>
                <router-link :to="{name:'frontEvent'}" class="nav-link w-nav-link">events</router-link>
                
                <div data-delay="0" data-hover="1" class="w-dropdown">
                    <div class="nav-link toggle w-dropdown-toggle">
                        <div class="w-icon-dropdown-toggle pointer-events"></div>
                        <div>Connect</div>
                    </div>
                    <nav class="dropdown-list w-dropdown-list">
                        <router-link :to="{name:'frontContact'}" class="dropdown-link  w-dropdown-link"  > Contact </router-link>
                        <router-link :to="{name:'companies'}" class="dropdown-link last w-dropdown-link"  > Companies </router-link>
                    </nav>
                </div>
                <div data-delay="0" data-hover="1" class="w-dropdown">
                    <div class="nav-link toggle w-dropdown-toggle">
                        <div class="w-icon-dropdown-toggle pointer-events"></div>
                        <div>Info</div>
                    </div>

                    <nav class="dropdown-list w-dropdown-list">
                        <router-link :to="{name:'airports'}" class="dropdown-link  w-dropdown-link" >Airports</router-link>
                        <router-link :to="{name:'aboutAirbook'}" class="dropdown-link  w-dropdown-link"  >About Airbook</router-link>
                        <router-link :to="{name:'airbookFeatures'}" class="dropdown-link  w-dropdown-link"  > Airbook Features</router-link>
                        <router-link :to="{name:'supports'}" class="dropdown-link last w-dropdown-link"  >Help & Supports</router-link>
                    </nav>
                </div>
            </nav>
            <div class="menu-button w-nav-button">
                <div class="w-icon-nav-menu"></div>
            </div>
        </div>
    </div>
   
</div>


{{--<script>--}}
 {{--var dropdownMenuCatch = document.getElementsByClassName("w-dropdown-link");--}}
 {{--console.log(dropdownMenuCatch);--}}
{{--</script>--}}


