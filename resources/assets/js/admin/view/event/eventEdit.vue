<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Event</div>
            <div class="card-body">
                <form @submit.prevent="updateEvent">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"> Title *</label>
                                    <input id="name" v-model="title" type="text" name="title"
                                           :class="{'form-control': true, 'is-danger': errors.has('title') }"
                                           data-error="title is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('title')" class="help is-danger">{{ errors.first('title') }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Start Date </label>
                                    <date-picker v-model="start_date"
                                                 :class="{'form-control': true, 'is-danger': errors.has('start_date') }"
                                                 :config="options">

                                    </date-picker>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>End Date </label>
                                    <date-picker v-model="end_date"
                                                 :class="{'form-control': true, 'is-danger': errors.has('end_date') }"
                                                 :config="options">
                                    </date-picker>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group fixHeight">
                                    <label>Category*</label>
                                    <v-select
                                            v-model="category"
                                            :options="categories"
                                            label="name"
                                            name="category"
                                            :class="{ 'is-danger': errors.has('category') }"
                                            v-validate="'required'"
                                            multiple
                                    >
                                    </v-select>

                                    <div v-show="errors.has('category')" class="help is-danger">
                                        {{ errors.first('category') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Continent *</label>
                                    <v-select
                                            v-model="continent"
                                            :options="continents"
                                            label="name"
                                            name="continent"
                                            @input="getRegion"
                                            :class="{ 'is-danger': errors.has('continent') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('continent')" class="help is-danger">
                                        {{ errors.first('continent') }}
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Region *</label>
                                    <v-select
                                            v-model="region"
                                            :options="regions"
                                            label="name"
                                            name="region"
                                            @input="getCountry"
                                            :class="{ 'is-danger': errors.has('region') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('region')" class="help is-danger">
                                        {{ errors.first('region') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country</label>
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
                                    <label>State</label>
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
                                    <label>City</label>
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
                                    <label> Website </label>
                                    <input v-model="website" type="text" name="website"
                                           :class="{'form-control': true, 'is-danger': errors.has('website') }"
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Location (Latitude and Longitude)</label>
                                    <input v-model="location" type="text" name="location"
                                           :class="{'form-control': true, 'is-danger': errors.has('location') }"
                                    >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Event Address </label>
                                    <input v-model="address" type="text" name="address"
                                           :class="{'form-control': true, 'is-danger': errors.has('address') }"

                                    >

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Details</label>
                                    <vue-ckeditor
                                            v-model="details"
                                            :config="config"
                                    />
                                    <!--<wysiwyg v-model="details" />-->
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image</label>
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
                                    <input class="custom-control-input" type="radio" v-model="is_active" name="is_active" :value="true"><span class="custom-control-label">Publish</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="is_active" name="is_active" :value="false"><span class="custom-control-label">Inactive</span>
                                </label>

                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-lg-start">
                                    <button class="btn btn-space btn-primary "
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-save"></i>  Update
                                    </button>
                                    <button class="btn btn-space btn-danger "
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

<script src="./js/eventEdit.js"></script>



