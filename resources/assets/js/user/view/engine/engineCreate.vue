<template>
    <div>
        <select-promote-modal
                :title="'Select engine promote mode'"
                :listRoute="'userEngineList'"
                :redirectUrl="'userEngineCreate'"
                @planStatus="statusChange"
        >
        </select-promote-modal>
        <div class="row wizard-row" v-if="planStatus">
            <div class="col-md-12 fuelux">
                <div class="block-wizard">
                    <div class="wizard wizard-ux" id="wizard1">
                        <div class="steps-container">
                            <ul class="steps" style="margin-left: 0">
                                <li :class="stepOne" data-step="1">Engine<span class="chevron"></span></li>
                                <li data-step="2" :class="stepTwo">Commercial<span class="chevron"></span></li>
                                <li data-step="3" :class="stepThree">Files & Photos<span class="chevron"></span></li>
                                <li data-step="4" :class="stepFour">Custom Info<span class="chevron"></span></li>
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
                                                <h3 class="wizard-title">Engine Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Catgory </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="engine.category"
                                                        :options="$root.$data.engineCategories"
                                                        label="name"
                                                        name="category"
                                                        @input="engine.manufacturer=null, $root.findManufacturers('engine', engine.category)"
                                                        v-validate="'required'"
                                                        :class="{ 'is-danger': errors.has('form-1.category') }"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-1.category')" class="help is-danger">
                                                    {{ errors.first('form-1.category') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Manufacturer </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="engine.manufacturer"
                                                        :options="$root.$data.engineManufacturers"
                                                        label="name"
                                                        name="manufacturer"
                                                        @input="engine.type=null, $root.findType('engine', engine.manufacturer)"
                                                        :class="{ 'is-danger': errors.has('form-1.manufacturer') }"
                                                        v-validate="'required'"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-1.manufacturer')" class="help is-danger">
                                                    {{ errors.first('form-1.manufacturer') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Type </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="engine.type"
                                                        :options="$root.$data.engineTypes"
                                                        label="name"
                                                        name="type"
                                                        @input="engine.model=null, $root.findModel('engine', engine.type)"
                                                        :class="{ 'is-danger': errors.has('form-1.type') }"
                                                        v-validate="'required'"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-1.type')" class="help is-danger">
                                                    {{ errors.first('form-1.type') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Model </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="engine.model"
                                                        :options="$root.$data.engineModeleds"
                                                        label="name"
                                                        name="model"
                                                        :class="{ 'is-danger': errors.has('form-1.model') }"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">ESN </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text"
                                                       v-model="engine.esn"
                                                       name="esn"
                                                       v-validate="'required'"
                                                       :class="{'form-control':true,'is-danger': errors.has('form-1.esn') }"
                                                >
                                                <div v-show="errors.has('form-1.esn')" class="help is-danger">
                                                    {{ errors.first('form-1.esn') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Cycles Remaining (CR)</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="number"
                                                       step="any"
                                                       v-model="engine.cycle_remaining"
                                                       name="cycle_remaining"
                                                       :class="{'form-control':true,'is-danger': errors.has('cycle_remaining') }"
                                                >

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Current Status</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="engine.status"
                                                        :options="['New','As removed','Overhauled','Serviceable','Repaired','Operational', 'Storage','Non serviceable', 'Tear down']"
                                                        v-validate="'required'"
                                                        label="name"
                                                        name="status"
                                                        :class="{ 'is-danger': errors.has('form-1.status') }"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-1.status')" class="help is-danger">
                                                    {{ errors.first('form-1.status') }}
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group row" v-for="(frm, index) in engine.custom">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right ">
                                                <template v-if="frm.name =='tso'">{{'TSO'}}</template>
                                                <template v-if="frm.name=='lsv_description'">{{'LSV Description'}}</template>
                                                <template v-if="frm.name=='thrust_rating'">{{'Thrust Rating'}}</template>
                                            </label>
                                            <div class="col-12 col-sm-8 col-lg-6  d-flex customFormItemAircraft">
                                                <input :type="frm.type"
                                                       :name="frm.name"
                                                       class="form-control"
                                                       v-model="frm.value"
                                                       :ref="'forms'"
                                                       v-if="frm.type=='text' || frm.type=='number'"

                                                >
                                                <v-select v-else-if="frm.type=='select'"
                                                          v-model="frm.value"
                                                          :options="frm.options"
                                                          label="name"
                                                          name="offer"
                                                          :ref="frm.name"
                                                          :class="{'is-danger': errors.has('offer') }"
                                                          style="width: 100%;"
                                                >
                                                </v-select>
                                                <date-picker else="frm.type=='date'"
                                                             :name="frm.name"
                                                             v-model="frm.value"
                                                             ref="datePicker1"
                                                             class="form-control"
                                                             v-else>
                                                </date-picker>
                                                <button @click.prevent="deleteForm(index)"
                                                        class="btn deleteBtn"
                                                >
                                                    <i data-v-7206df83="" class="icon mdi mdi-close"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <!--<button class="btn btn-secondary btn-space wizard-previous " @click.prevent=""> + Add More Field </button>-->
                                                <div class="aircraft_info">
                                                    <select v-model="formName" class="form-control capitalize"
                                                            @change="formName!='custom'?addForms():''" >

                                                        <option :value="label" v-for="label in fixedLabel">
                                                            <template v-if="label=='tso'">{{'TSO'}}</template>
                                                            <template v-if="label=='lsv_description'">{{'LSV Description'}}</template>
                                                            <template v-if="label=='thrust_rating'">{{'Thrust Rating'}}</template>

                                                        </option>
                                                    </select>

                                                </div>
                                                <p><br>
                                                    <a href="" @click.prevent="suggestModal=true" data-modal="nft-default" class=" ">Didn't find basic info? Please click here to suggest.</a>
                                                    <template v-if="suggestModal">
                                                        <suggest-modal  @suggestModalData="suggestModal=false" :fieldtype="'engine'"></suggest-modal>
                                                    </template>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right"  data-wizard="#wizard1" type="submit">Next Step</button>
                                                <div  class="btn btn-secondary btn-space wizard-previous own-right" data-wizard="#wizard1" @click.prevent="$router.push({name:'userEngineList'})">Cancel</div>
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
                                        <h3 class="wizard-title">Commercial Info</h3>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Offered for </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <v-select
                                                v-model="engine.offer_for"
                                                :options="['Sale','Lease','Lease Purchase','Exchange']"
                                                label="name"
                                                name="offer_for"
                                                :class="{ 'is-danger': errors.has('form-2.offer_for') }"
                                                v-validate="'required'"
                                        >
                                        </v-select>
                                        <div v-show="errors.has('form-2.offer_for')" class="help is-danger">
                                            {{ errors.first('form-2.offer_for') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="engine.offer_for=='Sale'">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Price </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <input type="number"
                                               step="any"
                                               v-model="engine.price "
                                               name="price"
                                               v-validate="'required'"
                                               :class="{'form-control':true,'is-danger': errors.has('form-2.price') }"
                                        >{{'USD '}}{{engine.price | currency('', 2, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true }) }}
                                        <div v-show="errors.has('form-2.price')" class="help is-danger">
                                            {{ errors.first('form-2.price') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="engine.offer_for=='Lease' || engine.offer_for=='Lease Purchase'">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right own-uppercase"> {{engine.offer_for}} Terms </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <textarea class="form-control" v-model="engine.lease_terms" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row" v-if="engine.offer_for=='Exchange'">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Exchange Terms</label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <textarea class="form-control" v-model="engine.exchange_terms" rows="2"></textarea>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Availability </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <date-picker v-model="engine.availability"
                                                     v-validate="'required'"
                                                     name="availability"
                                                     :class="{'form-control': true, 'is-danger': errors.has('form-2.availability') }"
                                                     :config="options">

                                        </date-picker>
                                        <div v-show="errors.has('form-2.availability')" class="help is-danger">
                                            {{ errors.first('form-2.availability') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Current Location </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <v-select
                                                label="name"
                                                v-model="engine.current_location"
                                                :options="countries"
                                                name="current_location"
                                                :class="{'is-danger': errors.has('form-2.current_location') }"
                                        >
                                        </v-select>
                                        <div v-show="errors.has('form-2.current_location')" class="help is-danger">
                                            {{ errors.first('form-2.current_location') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Primary Contact </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <v-select
                                                v-model="engine.primary_contact"
                                                :get-option-label="$root.getFullName"
                                                label="first_name"
                                                :options="this.$root.$data.contacts"
                                                name="primary_contact"
                                                v-validate="'required'"
                                                data-vv-as="primary contact"
                                                :class="{'is-danger': errors.has('form-2.primary_contact') }"
                                        >
                                        </v-select>
                                        <div v-show="errors.has('form-2.primary_contact')" class="help is-danger">
                                            {{ errors.first('form-2.primary_contact') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row" v-for="(frm, index) in engine.custom2">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right capitalize"> {{ frm.name | removeACharacter('_') }} </label>
                                    <div class="col-12 col-sm-8 col-lg-6  d-flex customFormItemAircraft">
                                        <input :type="frm.type"
                                               :name="frm.name"
                                               class="form-control"
                                               v-model="frm.value"
                                               :ref="'forms2'"
                                               v-if="frm.type=='text' || frm.type=='number'"

                                        >
                                        <v-select v-else-if="frm.type=='select'"
                                                  v-model="frm.value"
                                                  :options="frm.options"
                                                  label="name"
                                                  name="offer"
                                                  :ref="frm.name"
                                                  :class="{ 'is-danger': errors.has('offer') }"
                                                  style="width: 100%;"
                                        >
                                        </v-select>
                                        <date-picker else="frm.type=='date'"
                                                     :name="frm.name"
                                                     v-model="frm.value"
                                                     ref="datePicker12"
                                                     class="form-control"
                                                     v-else>
                                        </date-picker>
                                        <button @click.prevent="deleteForm2(index)"
                                                class="btn deleteBtn"
                                        >
                                            <i data-v-7206df83="" class="icon mdi mdi-close"></i>
                                        </button>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                    <div class="col-12 col-sm-8 col-lg-6">
                                        <div class="aircraft_info  ">
                                            <select v-model="formName" class="form-control capitalize"
                                                    @change="formName!='custom'?addForms():''" >

                                                <option :value="label" v-for="label in fixedLabel2">
                                                    {{ label | removeACharacter('_') }}
                                                </option>
                                            </select>
                                        </div>
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
                                    <form class="form-horizontal group-border-dashed" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="">
                                        <div class="form-group row mediaArea">
                                            <div class="col-md-12">
                                                <h3 class="wizard-title">Files & Photos</h3><br>
                                                <button class="btn btn-primary btn-space d-inline-block" @click.prevent="$root.showMedia=true"><i class="fas fa-upload"></i> Select or Upload Images </button>
                                                <br><hr>
                                                <label>Upload Attachment & Documents</label>

                                                <vue-dropzone
                                                        ref="viewDropZone"
                                                        id="dropzone"
                                                        :options="dropzoneOptions"
                                                        v-on:vdropzone-file-added="addingEvent"
                                                        :headers="dropzoneOptions.headers"
                                                        v-on:vdropzone-removed-file="removeFile"
                                                        @vdropzone-success="vsuccess"
                                                >
                                                </vue-dropzone>
                                                <hr>
                                                <div  class="row uploadMedia">

                                                    <div class="col-md-2"  v-for="(image, index) in $root.$data.selectedImages">
                                                        <div class="mediaAlign">
                                                            <span class="cross-media btn btn-danger" @click="$root.$data.selectedImages.splice(index, 1)">X</span>
                                                            <img :src="image.src" alt="" class="img-fluid mb-5">
                                                        </div>
                                                        <div class="footerFeatured">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="1" @click="$root.makeImageFeatured(image.id)" name="is_featured">
                                                                <span class="custom-control-label">Featured</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row ">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right" data-wizard="#wizard1" @click.prevent="goPage(4)">Next Step</button>
                                                <div class="btn btn-secondary btn-space wizard-previous own-right"   data-wizard="#wizard1" @click.prevent="goPage(2)">Previous</div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div :class="'step-pane'+fourPageActive" data-step="4">

                            <div class="row p-0">
                                <div class="col-lg-9">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" @submit.prevent="postEngine">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Custom Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-left text-sm-right">Additional details</label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" rows="6" v-model="engine.description"  placeholder="Additional details"></textarea><br>
                                                <!--<label class="custom-control custom-checkbox custom-control-inline own-right">-->
                                                <!--<input class="custom-control-input" type="checkbox"><span class="custom-control-label custom-control-color">Promote Now</span>-->
                                                <!--</label><br>-->
                                                <i class="own-right">By submitting this asset, you agree to the terms and privacy policy of Airbook.</i>
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-sm-11 d-flex justify-content-end">
                                                <div>
                    
                                                    <button type="submit" class="btn btn-space btn-primary pl-4 pr-4 own-right"><i class="icon mdi mdi-refresh-sync"></i> Save & New</button>
                                                    <button class="btn btn-success btn-space wizard-next own-right" data-wizard="#wizard1" @click.prevent="saveAndClose()"><i class="icon mdi mdi-save" ></i> Save & Close  </button>
                                                    <div class="btn btn-secondary btn-space wizard-previous own-right"   data-wizard="#wizard1" @click.prevent="goPage(3)">Previous</div>
                
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
        </div>
</template>

<script src="./js/engineCreate.js"></script>
