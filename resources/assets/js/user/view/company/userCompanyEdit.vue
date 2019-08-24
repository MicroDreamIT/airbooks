<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Company</div>
            <div class="card-body">
                <form @submit.prevent="updateCompany">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="form_name">Name *</label>
                                    <input id="form_name"
                                           v-model="name"
                                           type="text"
                                           disabled
                                           name="name"
                                           :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-md-8">
                                <div class="form-group fixHeight">
                                    <label>Specialty *</label>
                                    <v-select
                                            v-model="speciality"
                                            :options="specialities"
                                            label="name"
                                            name="speciality"
                                            :class="{ 'is-danger': errors.has('speciality') }"
                                            v-validate="'required|min:2'"
                                            multiple
                                    >
                                    </v-select>
                                    <div v-show="errors.has('speciality')" class="help is-danger">
                                        {{ errors.first('speciality') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Business Number</label>
                                    <input
                                            v-model="businessNumber"
                                            type="number"
                                            name="business_number"
                                            :class="{'form-control': true, 'is-danger': errors.has('business_number') }"
                                            v-validate="'min:9'"

                                    >
                                    <div v-show="errors.has('business_number')" class="help is-danger">{{ errors.first('business_number') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input
                                            v-model="website"
                                            type="text"
                                            name="website"
                                            :class="{'form-control': true, 'is-danger': errors.has('website') }"
                                            v-validate="'url'"

                                    >
                                    <div v-show="errors.has('website')" class="help is-danger">{{ errors.first('website') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address </label>
                                    <input
                                            v-model="address"
                                            type="text"
                                            name="address"
                                            :class="{'form-control': true, 'is-danger': errors.has('address') }"
                                            v-validate="'min:8'"

                                    >
                                    <div v-show="errors.has('address')" class="help is-danger">{{ errors.first('address') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country </label>
                                    <v-select
                                            v-model="country"
                                            :options="countries"
                                            label="name"
                                            name="country"
                                            @input="getState"
                                            :class="{ 'is-danger': errors.has('country') }"
                                    >
                                    </v-select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>State </label>
                                    <v-select
                                            v-model="state"
                                            :options="states"
                                            label="name"
                                            name="state"
                                            @input="getCity"
                                            :class="{ 'is-danger': errors.has('state') }"
                                    >
                                    </v-select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City </label>
                                    <v-select
                                            v-model="city"
                                            :options="cities"
                                            label="name"
                                            name="city"
                                            :class="{ 'is-danger': errors.has('city') }"
                                    >
                                    </v-select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>P.O.Box</label>
                                    <input
                                            v-model="poBox"
                                            type="text"
                                            name="po_box"
                                            :class="{'form-control': true, 'is-danger': errors.has('po_box') }"
                                            v-validate="'min:4'"

                                    >
                                    <div v-show="errors.has('po_box')" class="help is-danger">{{ errors.first('po_box') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Zipcode/Postal Code</label>
                                    <input
                                            v-model="zipcode"
                                            type="text"
                                            name="zip_cod"
                                            :class="{'form-control': true, 'is-danger': errors.has('zip_code') }"
                                            v-validate="'min:3'"

                                    >
                                    <div v-show="errors.has('zip_code')" class="help is-danger">{{ errors.first('zip_code') }}
                                    </div>
                                </div>
                            </div>-->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>RFQ Email</label>
                                    <input
                                            v-model="rfq_email"
                                            type="email"
                                            name="rfq_email"
                                            :class="{'form-control': true, 'is-danger': errors.has('rfq_email') }"
                                            v-validate="'required|email'"

                                    >
                                    <div v-show="errors.has('rfq_email')" class="help is-danger">{{ errors.first('rfq_email')|removeUnderScore}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>AOG Email</label>
                                    <input
                                            v-model="aog_email"
                                            type="email"
                                            name="aog_email"
                                            :class="{'form-control': true, 'is-danger': errors.has('aog_email') }"
                                            v-validate="'email'"

                                    >
                                    <div v-show="errors.has('aog_email')" class="help is-danger">{{ errors.first('aog_email')|removeUnderScore }}
                                    </div>
                                </div>
                            </div>



                            <!--<div class="col-md-12">
                                <div class="form-group">
                                    <label>Profile</label>
                                    <textarea class="form-control"
                                              rows="6"
                                              name="profile"
                                              v-model="profile"
                                              :class="{'form-control': true, 'is-danger': errors.has('profile') }"
                                              v-validate="'min:3|max:1000'"
                                    ></textarea>
                                    <div v-show="errors.has('profile')" class="help is-danger">{{ errors.first('profile') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <vue-dropzone
                                            ref="viewDropZone"
                                            id="dropzone"
                                            :options="dropzoneOptions"
                                            v-on:vdropzone-file-added="addingEvent"
                                            v-on:vdropzone-removed-file="removeFile"
                                    >

                                    </vue-dropzone>
                                    <div v-show="errors.has('image')" class="help is-danger">
                                        {{ errors.first('image') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 form-check mt-1">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="is_active" name="is_active"
                                           :value="1"><span class="custom-control-label">Publish</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="is_active" name="is_active"
                                           :value="0"><span class="custom-control-label">Inactive</span>
                                </label>

                            </div>-->
                            <div class="col-md-12">
                                <div class="d-flex justify-content-start flex-wrap">
                                    <button class="btn btn-space btn-primary pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-save"></i> Update & Close
                                    </button>
                                    <!--<button class="btn btn-space btn-danger pl-4 pr-4"-->
                                            <!--:disabled="buttonDisabled"-->
                                            <!--@click.prevent="cancel"-->
                                    <!--&gt;-->
                                        <!--<i class="icon mdi mdi-close"></i> Cancel-->
                                    <!--</button>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script src="./companyEdit.js"></script>
