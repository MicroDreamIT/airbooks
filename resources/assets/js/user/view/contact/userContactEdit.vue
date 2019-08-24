<template>
    <div>

        <div class="row wizard-row">
            <div class="col-md-12 fuelux">
                <div class="block-wizard">
                    <div class="wizard wizard-ux" id="wizard1">
                        <div class="steps-container">
                            <ul class="steps" style="margin-left: 0">
                                <li :class="stepOne" data-step="1">Personal<span class="chevron"></span></li>
                                <li data-step="2" :class="stepTwo">Company<span class="chevron"></span></li>
                                <li data-step="3" :class="stepThree">Address<span class="chevron"></span></li>
                                <li data-step="4" :class="stepFour">Contact<span class="chevron"></span></li>
                            </ul>
                        </div>
                        <div class="actions wizard">
                            <button class="btn btn-xs btn-prev btn-secondary" type="button"
                                    @click.prevent="goPage(count>1?count-=1:count)"><i class="icon mdi mdi-chevron-left"></i>Prev</button>
                            <button class="btn btn-xs btn-next btn-secondary" type="button" data-last="Finish"  @click.prevent="goPage(count<=3?count+=1:count)" >Next<i class="icon mdi mdi-chevron-right"></i> </button>
                        </div>
                        <div class="step-content">
                            <div :class="'step-pane'+openPageActive" data-step="1">
                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate=""  @submit.prevent="checkThisPage('form-1',2)" data-vv-scope="form-1">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Personal Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Title </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="contact.title"
                                                        :options="['Mr','Mrs','Ms']"
                                                        name="title"
                                                        :class="{ 'is-danger': errors.has('form-1.title') }"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">First Name </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input id="first_name"
                                                       v-model="contact.first_name"
                                                       type="text"
                                                       name="first_name"
                                                       :class="{'form-control': true,'is-danger': errors.has('form-1.first_name')}"
                                                       data-error="first name is required."
                                                       v-validate="'required'"
                                                >
                                                <div v-show="errors.has('form-1.first_name')"
                                                     class="help is-danger">
                                                    {{ _.replace( _.replace(errors.first('form-1.first_name'), '_', ' ') , '_', ' ') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Last Name </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input id="last_name"
                                                       v-model="contact.last_name"
                                                       type="text"
                                                       name="last_name"
                                                       :class="{'form-control': true, 'is-danger': errors.has('form-1.last_name') }"
                                                       data-error="last name is required."
                                                       v-validate="'required'"
                                                >
                                                <div v-show="errors.has('form-1.last_name')" class="help is-danger">
                                                    {{ _.replace(errors.first('form-1.last_name'), '_', ' ') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Gender</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="contact.gender"
                                                        :options="['Male','Female']"
                                                        name="gender"
                                                        :class="{'not-clearable': true,'is-danger': errors.has('contact.title') }"
                                                        v-validate="'required'"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right"  data-wizard="#wizard1" type="submit">Next Step</button>
                                                <div  class="btn btn-secondary btn-space wizard-previous own-right" data-wizard="#wizard1" @click.prevent="$router.push({name:'userContacts'})">Cancel</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div :class="'step-pane'+secondPageActive" data-step="2">
                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" @submit.prevent="checkThisPage('form-2',3)" data-vv-scope="form-2">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Company Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Company </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        label="name"
                                                        name="company"
                                                        v-model="contact.company"
                                                        :options="this.companies"
                                                        :class="{'is-danger': errors.has('contact.company') }"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Job Title </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        name="job_title"
                                                        v-model="contact.job_title"
                                                        :options="this.job_titles"
                                                        label="name"
                                                        :class="{'is-danger': errors.has('contact.job_title') }"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Department </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        label="name"
                                                        name="department"
                                                        v-model="contact.department"
                                                        :options="this.departments"
                                                        :class="{'is-danger': errors.has('contact.department') }"
                                                >
                                                </v-select>
                                            </div>
                                        </div>



                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right" data-wizard="#wizard1" type="submit">Next Step</button>
                                                <div class="btn btn-secondary btn-space wizard-previous own-right"   data-wizard="#wizard1" @click.prevent="goPage(1)">Previous</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div :class="'step-pane'+thirdPageActive" data-step="3">

                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" @submit.prevent="checkThisPage('form-3',4)" data-vv-scope="form-3">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Address Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Country </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        label="name"
                                                        v-model="contact.country"
                                                        :options="countries"
                                                        name="country"
                                                        @input="contact.country.id !=contact.country_id?[contact.state=null,contact.city=null]:null,getState()"
                                                        :class="{'is-danger': errors.has('form-3.country') }"
                                                        v-validate="'required'">
                                                </v-select>
                                                <div v-show="errors.has('form-3.country')"
                                                     class="help is-danger">
                                                    {{ errors.first('form-3.country') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">State </label>
                                            <div class="col-12 col-sm-8 col-lg-6">

                                                <v-select
                                                        label="name"
                                                        v-model="contact.state"
                                                        :options="this.states" name="state"
                                                        @input="contact.state?contact.state.id !=contact.state_id?contact.city=null:null:null,getCity()"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">City </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        label="name"
                                                        v-model="contact.city"
                                                        :options="this.cities"
                                                        name="city"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Address </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" v-model="contact.address" class="form-control"
                                                       :class="{'form-control': true, 'is-danger': errors.has('contact.address') }"
                                                       name="address"
                                                >

                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right" data-wizard="#wizard1" type="submit">Next Step</button>
                                                <div class="btn btn-secondary btn-space wizard-previous own-right"   data-wizard="#wizard1" @click.prevent="goPage(2)">Previous</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div :class="'step-pane'+fourPageActive" data-step="4">

                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" @submit.prevent="updateContact('form-4')" data-vv-scope="form-4">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Contact Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Email</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input id="email" v-model="contact.email" type="email" name="email" disabled
                                                       :class="{'form-control': true, 'is-danger': errors.has('form-4.email') }"
                                                       data-error="email is required."
                                                       v-validate="'required|email'"
                                                >
                                                <div v-show="errors.has('form-4.email')"
                                                     class="help is-danger">
                                                    {{ errors.first('form-4.email') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Business Phone</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="number"
                                                       class="form-control"
                                                       name="business_phone"
                                                       v-model="contact.business_phone"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Mobile Phone</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="number" class="form-control" v-model="contact.mobile_phone">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Skype</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" class="form-control" v-model="contact.skype">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Linkdin</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text" class="form-control" v-model="contact.linkedin">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-7 d-flex justify-content-end">
                                                <div>
                                                    <div class="btn btn-secondary btn-space wizard-previous"   data-wizard="#wizard1" @click.prevent="goPage(3)">Previous</div>
                                                    <button class="btn btn-danger btn-space wizard-next" @click.prevent="$router.push({name:'userEngineList'})">Cancel</button>
                                                    <button class="btn btn-primary btn-space wizard-next" data-wizard="#wizard1" type="submit"><i class="icon mdi mdi-save" ></i>Update</button>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-3">
                                    <div class="card mt-5">
                                        <div class="card-header error-messege">
                                            <div class="text-danger" v-for="item in sErrors">{{item[0]}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script src="./userContactEdit.js"></script>
