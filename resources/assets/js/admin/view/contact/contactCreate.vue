<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Contact</div>
            <div class="card-body">
                <form @submit.prevent="postContact('contact')" data-vv-scope="contact">
                    <div class="controls">
                        <h4>Personal Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Title</label>
                                    <v-select
                                            v-model="contact.title"
                                            :options="['Mr','Mrs','Ms']"
                                            name="title"
                                            :class="{ 'is-danger': errors.has('contact.title') }"
                                    >
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First Name *</label>
                                    <input id="first_name"
                                           v-model="contact.first_name"
                                           type="text"
                                           name="first_name"
                                           :class="{
                                               'form-control': true,
                                               'is-danger': errors.has('contact.first_name')
                                           }"
                                           data-error="first name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('contact.first_name')"
                                         class="help is-danger">
                                        {{ _.replace( _.replace(errors.first('contact.first_name'), '_', ' ') , '_', ' ') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="last_name">Last Name *</label>
                                <input id="last_name"
                                       v-model="contact.last_name"
                                       type="text"
                                       name="last_name"
                                       :class="{'form-control': true, 'is-danger': errors.has('contact.last_name') }"
                                       data-error="last name is required."
                                       v-validate="'required'"
                                >
                                <div v-show="errors.has('contact.last_name')" class="help is-danger">
                                    {{ _.replace(errors.first('contact.last_name'), '_', ' ') }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input id="email" v-model="contact.email" type="email" name="email"
                                           :class="{'form-control': true, 'is-danger': errors.has('contact.email') }"
                                           data-error="email is required."
                                           v-validate="'required|email'"
                                    >
                                    <div
                                            v-show="errors.has('contact.email')"
                                            class="help is-danger">
                                        {{ errors.first('contact.email') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Birthday
                                    </label>
                                    <input :class="{'form-control': true, 'is-danger':birthDayErrorMessage }"
                                           type="text"
                                           name="birthday"
                                           v-mask="'99-99'"
                                           id="birthday"
                                           v-model="contact.birthday"
                                           placeholder="DD/MM">

                                    <span class="help is-danger">{{birthdayValidation}}{{birthDayErrorMessage}}</span>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Gender
                                    </label>
                                    <v-select
                                            v-model="contact.gender"
                                            :options="['Male','Female']"
                                            name="gender"
                                            :class="{'is-danger': errors.has('contact.title') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('contact.gender')"
                                            class="help is-danger">
                                        {{ errors.first('contact.gender') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4>Company Info</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                               <div class="form-group">
                                   <label>
                                       Job Title
                                   </label>
                                   <v-select
                                           name="job_title"
                                           v-model="contact.job_title"
                                           :options="this.job_titles"
                                           label="name"
                                   >
                                   </v-select>
                               </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Department
                                    </label>
                                    <v-select
                                            label="name"
                                            name="department"
                                            v-model="contact.department"
                                            :options="this.departments"
                                    >
                                    </v-select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Company Name
                                    </label>
                                    <v-select
                                            label="name"
                                            name="company"
                                            v-model="contact.company"
                                            :options="companies"
                                            :class="{'is-danger': errors.has('contact.company') }"
                                    >
                                    </v-select>
                                </div>
                            </div>

                        </div>


                        <h4>Address Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" v-model="contact.address" class="form-control"
                                           :class="{'form-control': true, 'is-danger': errors.has('contact.address') }"
                                           data-error="last name is required."
                                           name="address"
                                    >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        Country*
                                    </label>
                                    <v-select
                                            label="name"
                                            v-model="contact.country"
                                            :options="this.countries"
                                            name="country"
                                            @input="getState()"
                                            :class="{'is-danger': errors.has('contact.country') }"
                                            v-validate="'required'">
                                    </v-select>
                                    <div v-show="errors.has('contact.country')"
                                         class="help is-danger">
                                        {{ errors.first('contact.country') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        State
                                    </label>
                                    <v-select
                                            label="name"
                                            v-model="contact.state"
                                            :options="this.states" name="state"
                                            @input="getCity()"
                                    >
                                    </v-select>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        City
                                    </label>
                                    <v-select
                                            label="name"
                                            v-model="contact.city"
                                            :options="this.cities"
                                            name="city"
                                            :class="{'is-danger': errors.has('contact.city') }"
                                          >
                                    </v-select>

                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Business phone
                                    </label>
                                    <input type="number" class="form-control" v-model="contact.business_phone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Mobile phone
                                    </label>
                                    <input type="number" class="form-control" v-model="contact.mobile_phone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Preferred contact method
                                    </label>

                                    <v-select
                                            label="name"
                                            name="preferred_contact_method"
                                            v-model="contact.preferred_contact_method"
                                            :options="[
                                                'Email',
                                                'Phone',
                                                'Both'
                                            ]"

                                            :class="{'is-danger': errors.has('contact.preferred_contact_method') }"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('contact.preferred_contact_method')"
                                         class="help is-danger">
                                        {{ errors.first('contact.preferred_contact_method') }}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Skype
                                    </label>
                                    <input type="text" class="form-control" v-model="contact.skype">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Linkedin
                                    </label>
                                    <input type="text" class="form-control" v-model="contact.linkedin">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>
                                        Religion
                                    </label>
                                    <v-select
                                            name="religion"
                                            :options="[
                                                'Islam',
                                                'Judaism',
                                                'Christianity',
                                                'Hinduism',
                                                'Buddhism',
                                                'Sikhism',
                                                'Confucianism',
                                                'Shinto',
                                                'Taoism',
                                                'Other'
                                            ]"
                                            v-model="contact.religion"
                                            :class="{'is-danger': errors.has('contact.religion') }"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('contact.religion')"
                                         class="help is-danger">
                                        {{ errors.first('contact.religion') }}
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">

                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input :class="contact.is_primary ?'custom-control-input is-valid': 'custom-control-input is-invalid'" type="checkbox" v-model="contact.is_primary" :checked="false">
                                        <span class="custom-control-label custom-control-color">Primary</span>
                                    </label>

                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input :class="contact.is_public ?'custom-control-input is-valid': 'custom-control-input is-invalid'" type="checkbox" v-model="contact.is_public" :checked="false">
                                        <span class="custom-control-label custom-control-color">Public</span>
                                    </label>

                                    <label class="custom-control custom-checkbox custom-control-inline">
                                        <input :class="contact.is_published ?'custom-control-input is-valid': 'custom-control-input is-invalid'" type="checkbox" v-model="contact.is_published" :checked="false">
                                        <span class="custom-control-label custom-control-color">Published</span>
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label>Photo</label>
                                <div class="form-group">
                                    <vue-dropzone
                                            ref="viewDropZone"
                                            id="dropzone"
                                            :options="dropzoneOptions"
                                            v-on:vdropzone-file-added="addingEvent"
                                            v-on:vdropzone-removed-file="removeFile">

                                    </vue-dropzone>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-start flex-wrap">
                                    <button class="btn btn-space btn-primary pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                            @click.prevent="saveAndClose"
                                    >
                                        <i class="icon mdi mdi-save"></i> Save & Close
                                    </button>
                                    <button class="btn btn-space btn-success pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-refresh-sync"></i> Save & New
                                    </button>
                                    <button class="btn btn-space btn-danger pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                            @click.prevent="cancel"
                                    >
                                        <i class="icon mdi mdi-close"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script src="./contactCreate.js"></script>
