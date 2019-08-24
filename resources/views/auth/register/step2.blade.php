<div class="profile-page-section" >
    <div class="container w-container">
        <div class="profile-wrapper">
            <div class="profile-info-block">
                <a href="/" class="airbook-login-brand w-inline-block">
                    <img src="/siddiqueAssets/images/Airbook_svg_logo.svg" width="140" alt="Airbook Registration">
                </a>
                <div class="create-profile-heading">Hello, @{{first_name+' '+last_name}}</div>
                <div class="create-profile-sub-title">
                    Please take a minute to make your profile and let the world know you much better.
                </div>
            </div>
            <div class="profile-form-flex-wrapper">
                <div class="profile-flex-column">
                    <a href="#" class="profile-image-upload w-inline-block" :style=" {'background': profile_photo? 'url(' + profile_photo + ')' : 'url(/siddiqueAssets/images/Airbook-User-Icon.svg)'} "></a>
                    <input type="file" name="profile_photo" class="upload-photo w-button" @change="onFileChange" id="uploadMyFile">
                    <label for="uploadMyFile" class="UploadFile">Upload Photo</label>
                </div>
                <div class="profile-flex-column">
                    <div class="sign-form-block w-form" id="registerStep">
                        <div id="wf-form-Profile-Form" name="wf-form-Profile-Form"
                             data-name="Profile Form" class="sign-form">
                            <div class="profile-create-form-row w-row">
                                <div class="profile-create-column w-col w-col-4">
                                    <div class="gender-block">
                                        <div class="text-block">I&#x27;m </div>
                                          <div class="innerGender" >
                                              <input type="radio" class="maleCheck" id="maleChecked" name="gender" value="male" checked >
                                              &nbsp;<label for="maleChecked" class="common" id="labelInfoMale">
                                                  <img src="/images/standing-up-man-.svg" alt="missing">
                                              </label>
                                              <input type="radio"  class="femaleCheck" id="femaleChecked" name="gender" value="female"  >
                                              <label  for="femaleChecked" class="common" id="labelInfoFemale">
                                                  <img src="/images/girl.svg" alt=" ">
                                              </label>
                                          </div>
                                    </div>
                                </div>

                                <div class="profile-create-column w-col w-col-4">
                                    <input
                                            type="number"
                                            class="sign-field w-input"
                                            name="birthday"
                                            data-name="birthday"
                                            placeholder="Birthday (Day)"
                                            id="Birthday"
                                            value="{{old('birthday')}}"
                                            v-validate="'between:1,31'"
                                    >
                                    <div v-show="errors.has('birthday')"
                                         class="help is-danger errorGard">@{{ errors.first('birthday')|customBirthDay }}
                                    </div>
                                </div>
                                    @if ($errors->has('birthday'))
                                        <div class="errorGuard">
                                             <span class="own-error-message" role="alert">
                                                <strong>{{ $errors->first('birthday') }}</strong>
                                            </span>
                                        </div>
                                    @endif
                                <div class="profile-create-column w-col w-col-4">
                                    <input
                                            type="number"
                                            class="sign-field w-input"
                                            name="birthday-month"
                                            value="{{old('birthday-month')}}"
                                            data-name="Birthday Month"
                                            placeholder="Birthday (Month)"
                                            id="Birthday-Month"
                                            v-validate="'between:1,12'"
                                    >
                                    <div v-show="errors.has('birthday-month')"
                                         class="help is-danger errorGard">@{{ errors.first('birthday-month')|customBirthMonth }}
                                    </div>
                                    @if ($errors->has('birthday-month'))
                                        <div class="errorGuard">
                                             <span class="own-error-message" role="alert">
                                                <strong>{{ $errors->first('birthday-month') }}</strong>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                </div>

                            </div>
                            <span class="hint-message">
                               Please type and press enter if company name doesn't exist
                            </span>
                            <div class="profile-create-form-row w-row">

                                <div class="profile-create-column w-col w-col-6" style="position: relative">

                                    <v-select
                                            label="name"
                                            :options="companies"
                                            id="company"
                                            ref="company"
                                            v-model="company"
                                            required=""
                                            data-name="company"
                                            class="sign-field w-input"
                                            :taggable="true"
                                            placeholder="Company"
                                            @search="onSearch(company)"
                                    >
                                        <span slot="no-options">
                                             Please type your company name.
                                        </span>

                                    </v-select>
                                    <input type="hidden"  name="company" :value="JSON.stringify(company)">
                                    <span class="error-message-reg" v-if="!company">@{{companyErrorMessage}}</span>
                                </div>

                                <div class="profile-create-column w-col w-col-6">

                                    <v-select
                                            label="name"
                                            :options="{{\App\Title::whereIsActive(1)->get()}}"
                                            v-model="job_title"
                                            class="sign-field w-input"
                                            placeholder="Job Title"
                                    >
                                    </v-select>
                                    <input type="hidden"  name="job_title" :value="JSON.stringify(job_title)">
                                </div>
                                <div class="profile-create-column w-col w-col-6">
                                    <input type="number" class="sign-field w-input" maxlength="256"
                                           name="business_phone" data-name="Business Phone"
                                           placeholder="Business Phone" id="Business-Phone"/>
                                    @if ($errors->has('business_phone'))
                                        <div class="errorGuard">
                                             <span class="own-error-message" role="alert">
                                                <strong>{{ $errors->first('business_phone') }}</strong>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="profile-create-column w-col w-col-6">
                                    <input type="number"
                                           class="sign-field w-input" maxlength="256"
                                           name="mobile_phone"
                                           placeholder="Mobile Phone"
                                           required=""/>
                                    @if ($errors->has('mobile_phone'))
                                        <div class="errorGuard">
                                             <span class="own-error-message" role="alert">
                                                <strong>{{ $errors->first('mobile_phone') }}</strong>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="profile-create-column w-col w-col-12">
                                    <input type="text"
                                           class="sign-field w-input"
                                           maxlength="256"
                                           name="address"
                                           data-name="Address"
                                           placeholder="Address"
                                           id="Address"/>
                                    @if ($errors->has('address'))
                                        <div class="errorGuard">
                                             <span class="own-error-message" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
        
                            <div class="profile-create-form-row w-row">
                                <div class="profile-create-column w-col w-col-4">
                                    <v-select
                                            label="name"
                                            :options="{{App\Country::whereIsActive(1)->get()}}"
                                            v-model="country"
                                            id="country"
                                            class="sign-field w-input"
                                            @input="getState()"
                                            placeholder="Country"
                                    >
                                    </v-select>
                                    <input type="hidden"  name="country" :value="JSON.stringify(country)">
                                </div>

                                <div class="profile-create-column w-col w-col-4" @change="getCity()">
                                    <v-select
                                            label="name"
                                            :options="states"
                                            v-model="state"
                                            id="state"
                                            :disabled="!country"
                                            class="sign-field w-input"
                                            @input="getCity()"
                                            placeholder="State"
                                    >
                                    </v-select>
                                    <input type="hidden"  name="state" :value="JSON.stringify(state)">
                                </div>
                                <div class="profile-create-column w-col w-col-4">
                                    <v-select
                                            label="name"
                                            :options="cities"
                                            v-model="city"
                                            id="city"
                                            :disabled="!state"
                                            class="sign-field w-input"
                                            placeholder="City"

                                    >
                                    </v-select>
                                    <input type="hidden"  name="city" :value="JSON.stringify(city)">
                                </div>
                            </div>
                         
                            <div class="bottomPanel">
                                <div class="items">
                                    <button @click.prevent="cancelValidation()" class="login-button w-button">Back</button>
                                </div>
                                <div class="items">
                                    <input type="submit" value="Register"
                                           data-wait="Please wait..."
                                           @click.prevent="step2Validation()"
                                           class="login-button w-button"/>
                                </div>
                            </div>
                           
                        
    
                        </div>
                        <div class="success-message w-form-done">
                            <div>Thank you!<br>Your profile has been created.</div>
                        </div>
                        <div class="error-message w-form-fail">
                            <div>Oops! Something went wrong. Please try again later.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sign-copyright">© Airbook</div>
        </div>
    </div>
</div>


