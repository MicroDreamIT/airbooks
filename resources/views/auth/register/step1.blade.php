            <div class="registerAdjust">
                    <div>
                        <input style=" width: 98%;" type="text" class="sign-field register-left-side w-input"
                               maxlength="256" v-model="first_name" name="first_name"
                               placeholder="First Name" id="First-Name"  v-validate="'required'" value="{{old('first_name')}}">
                            <div v-show="errors.has('first_name')" class="help is-danger errorGard">@{{ errors.first('first_name')|removeUnderScore }}</div>
                    </div>

                 <div>
                    <input type="text" style=" width: 99%;" class="sign-field register-right-side w-input" maxlength="256" name="last_name"
                           data-vv-name="last_name"
                           data-name="Last Name" v-model="last_name" placeholder="Last Name" id="Last-Name" v-validate="'required'" value="{{old('last_name')}}">
                        <div v-show="errors.has('last_name')" class="help is-danger errorGard">@{{ errors.first('last_name')|removeUnderScore }}</div>
                 </div>


            </div>
            @if ($errors->has('first_name'))
                <div class="errorGuard">
                     <span class="own-error-message" role="alert">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                </div>
            @endif
            @if ($errors->has('last_name'))
                <div class="errorGuard">
                    <span class="own-error-message" role="alert">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                </div>
            @endif



        <input type="email" class="sign-field w-input" maxlength="256" name="email" required
               data-name="Email Address" placeholder="Email" id="Email-Address" v-validate="'required|email'" value="{{old('email')}}">
        <div class="error-adjustment">
            <div style="flex:1;">
                <span v-show="errors.has('email')" class="help is-danger">@{{ errors.first('email')|customEmailMessage }}</span>
            </div>
        </div>


        @if ($errors->has('email'))
            <div class="errorGuard">
                  <span class="own-error-message" role="alert">
                         <strong>{{ $errors->first('email') }}</strong>
                  </span>
            </div>
        @endif
        <input type="password"
               class="sign-field w-input"
               maxlength="256"
               name="password"
               data-name="Password"
               placeholder="Password"
               id="Password"
               required
               v-validate="'required|min:6'"
        >
        <div class="error-adjustment">
            <div style="flex:1;">
                <span v-show="errors.has('password')" class="help is-danger">@{{ errors.first('password')|removeUnderScore }}</span>
            </div>
        </div>

        @if ($errors->has('password'))
            <div class="errorGuard">
                <span class="own-error-message" role="alert">
                     <strong>{{ $errors->first('password') }}</strong>
               </span>
            </div>
        @endif


