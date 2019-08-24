<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

               <li>
                   <router-link :to="{name:'frontAircraft'}" tag="a" :class="'nav-link'" >
                       Aircraft
                   </router-link>
               </li>


                <li class="nav-item">
                    <router-link :to="{name:'frontEngine'}" tag="a" :class="'nav-link'" >
                        Engine
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name:'frontApu'}" tag="a" :class="'nav-link'" >
                        Apu
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name:'frontParts'}" tag="a" :class="'nav-link'" >
                        Parts
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name:'frontWanted'}" tag="a" :class="'nav-link'" >
                        Wanted
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name:'frontNews'}" tag="a" :class="'nav-link'" >
                        News
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name:'frontEvent'}" tag="a" :class="'nav-link'" >
                        Event
                    </router-link>
                </li>

                <li class="nav-item">
                    <router-link :to="{name:'frontContact'}" tag="a" :class="'nav-link'" >
                        Contact
                    </router-link>
                </li>



                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>