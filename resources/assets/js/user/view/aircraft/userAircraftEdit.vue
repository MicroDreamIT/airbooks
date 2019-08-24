<template>
    <div>
        <div class="row wizard-row">
            <div class="col-md-12 fuelux">
                <div class="block-wizard">
                    <div class="wizard wizard-ux" id="wizard1">
                        <div class="steps-container">
                            <ul class="steps" style="margin-left: 0">
                                <li :class="stepOne" data-step="1">Basic<span class="chevron"></span></li>
                                <li data-step="2" :class="stepTwo">Aircraft<span class="chevron"></span></li>
                                <li data-step="3" :class="stepThree">Engines<span class="chevron"></span></li>
                                <li data-step="4" :class="stepFour">Commercial<span class="chevron"></span></li>
                                <li data-step="5" :class="stepFive">Files & Photos<span class="chevron"></span></li>
                                <li data-step="6" :class="stepSix">Custom Info<span class="chevron"></span></li>
                            </ul>
                        </div>
                        <div class="actions wizard">
                            <button class="btn btn-xs btn-prev btn-secondary" type="button"
                                    @click.prevent="goPage(count>1?count-=1:count)"><i class="icon mdi mdi-chevron-left"></i>Prev</button>
                            <button class="btn btn-xs btn-next btn-secondary" type="button" data-last="Finish"  @click.prevent="goPage(count<=5?count+=1:count)" >Next<i class="icon mdi mdi-chevron-right"></i> </button>
                        </div>
                        <div class="step-content">
                            <div :class="'step-pane'+' '+openPageActive" data-step="1">
                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" @submit.prevent="checkThisPage('form-1',2)" data-vv-scope="form-1">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Basic Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Category</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.category"
                                                        label="name"
                                                        :options="$root.$data.aircraftCategories"
                                                        @input="staticForm.aircraftManufacturer=null, $root.findManufacturers('aircraft', staticForm.category)"
                                                        name="category"
                                                        v-validate="'required'"
                                                        :class="{'is-danger': errors.has('form-1.category') }"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-1.category')" class="help is-danger">
                                                    {{ errors.first('form-1.category') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Manufacture</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.aircraftManufacturer"
                                                        label="name"
                                                        :options="$root.$data.aircraftManufacturers"
                                                        name="aircraftManufacturer"
                                                        v-validate="'required'"
                                                        :class="{'is-danger': errors.has('form-1.aircraftManufacturer') }"
                                                        @input="staticForm.aircraftType=null, $root.findType('aircraft', staticForm.aircraftManufacturer)"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-1.aircraftManufacturer')" class="help is-danger">
                                                    {{ errors.first('form-1.aircraftManufacturer') }}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Type</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.aircraftType"
                                                        label="name"
                                                        :options="$root.$data.aircraftTypes"
                                                        @input="staticForm.aircraftModel=null, $root.findModel('aircraft', staticForm.aircraftType)"
                                                        v-validate="'required'"
                                                        :class="{'is-danger': errors.has('form-1.aircraftType') }"
                                                        name="aircraftType"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-1.aircraftType')" class="help is-danger">
                                                    {{ errors.first('form-1.aircraftType') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Model</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.aircraftModel"
                                                        label="name"
                                                        :options="$root.$data.aircraftModeleds"
                                                        name="aircraftModel"
                                                        data-vv-as="aircraft model"
                                                        :class="{'is-danger': errors.has('form-1.aircraftModel') }"
                                                >
                                                </v-select>

                                                <p>
                                                    <br>
                                                    <a href="" @click.prevent="suggestModal=true" data-modal="nft-default" class=" ">Didn't find basic info? Please click here to suggest.</a>
                                                    <template v-if="suggestModal">
                                                        <suggest-modal  @suggestModalData="suggestModal=false" :fieldtype="'aircraft'"></suggest-modal>
                                                    </template>
                                                </p>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right" data-wizard="#wizard1" type="submit">Next Step</button>
                                                <button class="btn btn-secondary btn-space  own-right" @click.prevent="$router.push({name:'userAircrafts'})">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div :class="'step-pane'+secondPageActive" data-step="2">
                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate=""  @submit.prevent="checkThisPage('form-2',3)" data-vv-scope="form-2">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Aircraft Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">MSN</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="text"
                                                       v-model="staticForm.MSN"
                                                       name="MSN"
                                                       @keyup="getUppercase"
                                                       v-validate="'required'"
                                                       :class="{'form-control':true,'is-danger': errors.has('form-2.MSN') }"
                                                >
                                                <div v-show="errors.has('form-2.MSN')" class="help is-danger">
                                                    {{ errors.first('form-2.MSN') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">YOM</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <date-picker
                                                        v-model="staticForm.YOM"
                                                        :config="{format:'YYYY'}"
                                                        v-validate="'required'"
                                                        name="YOM"
                                                        :class="{'is-danger': errors.has('form-2.YOM') }"
                                                >
                                                </date-picker>
                                                <div v-show="errors.has('form-2.YOM')" class="help is-danger">
                                                    {{ errors.first('form-2.YOM') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Configuration</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.configuration"
                                                        label="name"
                                                        :options="$root.$data.configurations"
                                                        name="configuration"
                                                        :class="{'is-danger': errors.has('form-2.configuration') }"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Seating</label>
                                            <div class="col-12 col-sm-8 col-lg-6 d-flex">
                                                <input type="number"
                                                       v-model="staticForm.seating_economy"
                                                       class="form-control mr-1"
                                                       name=" "
                                                       placeholder="Y (Economy)"
                                                >
                                                <input type="number"
                                                       v-model="staticForm.seating_business"
                                                       class="form-control"
                                                       name=" "
                                                       placeholder="C (Business)"
                                                >
                                                <input type="number"
                                                       v-model="staticForm.seating_first_class"
                                                       class="form-control ml-1 "
                                                       name=" "
                                                       placeholder="F (First Class)"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Status</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.status"
                                                        :options="['Operational', 'Parking', 'Storage', 'For Tear Down']">
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row" v-for="(frm, index) in staticForm.custom">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right capitalize">
                                                <template v-if="frm.name=='tsn'||frm.name=='csn'">{{frm.name |uppercase}}</template>
                                                <template v-else-if="frm.name=='mtow'|| frm.name=='mlgw'">{{frm.name|uppercase}}{{' Kg'}}</template>
                                                <template v-else>{{ frm.name |removeACharacter('_') }}</template>
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
                                                <date-picker v-else
                                                             :name="frm.name"
                                                             v-model="frm.value"
                                                             ref="datePicker1"
                                                             class="form-control"
                                                >
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
                                                <div class="aircraft_info  ">
                                                    <select v-model="formName" class="form-control capitalize"
                                                            @change="formName!='custom'?addForms():''" >

                                                        <option :value="label" v-for="label in fixedLabel">
                                                            <template v-if="label=='tsn'||label=='csn'">{{label|uppercase}}</template>
                                                            <template v-else-if="label=='mtow'|| label=='mlgw'">{{label|uppercase}}{{' Kg'}}</template>
                                                            <template v-else>{{ label | removeACharacter('_') }}</template>

                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right"  data-wizard="#wizard1" type="submit">Next Step</button>
                                                <button class="btn btn-secondary btn-space wizard-previous  own-right" data-wizard="#wizard1" @click.prevent="goPage(1)">Previous</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div :class="'step-pane'+thirdPageActive" data-step="3">
                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Engines Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"></label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                    <input class="custom-control-input" type="checkbox" :checked="fieldDisable" @input="removeAllEngine()"><span class="custom-control-label custom-control-color">Airframe only</span>
                                                </label><br>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Engine Manufacture</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.engineManufacturer"
                                                        label="name"
                                                        :options="$root.$data.engineManufacturers"
                                                        @input="staticForm.engineType=null, $root.findType('engine', staticForm.engineManufacturer)"
                                                        name="manufacturer"
                                                        :disabled="fieldDisable"

                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Engine Type </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.engineType"
                                                        label="name"
                                                        :options="$root.$data.engineTypes"
                                                        @input="staticForm.engineModel=null, $root.findModel('engine',staticForm.engineType)"
                                                        :disabled="fieldDisable"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Engine Model </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.engineModel"
                                                        label="name"
                                                        :options="$root.$data.engineModeleds"
                                                        :disabled="fieldDisable"
                                                >
                                                </v-select>
                                                <p>
                                                    <br>
                                                    <a href="" @click.prevent="suggestModal=true" data-modal="nft-default" class=" ">Didn't find your engines? Please click here to suggest.</a>
                                                    <template v-if="suggestModal"> <suggest-modal  @suggestModalData="suggestModal=false" :categoryField="false" :fieldtype="'engine'"></suggest-modal> </template>
                                                </p>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">  </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary btn-space wizard-next own-right" data-wizard="#wizard1"  @click.prevent="goPage(4)">Next Step </button>
                                                <button class="btn btn-secondary btn-space wizard-previous own-right"   data-wizard="#wizard1" @click.prevent="goPage(2)">Previous</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div :class="'step-pane'+fourPageActive" data-step="4">
                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" @submit.prevent="checkThisPage('form-4',5)" data-vv-scope="form-4">
                                        <div class="form-group row">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Commercial Info</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Offered for </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.offer_for"
                                                        :options="['Sale', 'ACMI', 'Dry Lease', 'Wet Lease','Lease Purchase', 'Exchange','Charter']"
                                                        v-validate="'required'"
                                                        data-vv-as="offer for"
                                                        :class="{'is-danger': errors.has('form-4.offer_for') }"
                                                        name="offer_for"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-4.offer_for')" class="help is-danger">
                                                    {{ errors.first('form-4.offer_for') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" v-if="staticForm.offer_for=='Sale'">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right"> Asking price </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="number"
                                                       step="any"
                                                       v-model="staticForm.price"
                                                       name="price"
                                                       v-validate="'required'"
                                                       :class="{'form-control':true,'is-danger': errors.has('form-4.price') }"
                                                >{{'USD '}}{{staticForm.price | currency('', 2, { symbolOnLeft: false, spaceBetweenAmountAndSymbol: true }) }}
                                                <div v-show="errors.has('form-4.price')" class="help is-danger">
                                                    {{ errors.first('form-4.price') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" v-if="staticForm.offer_for=='ACMI'">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">MGH / m </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <input type="number"
                                                       v-model="staticForm.mgh"
                                                       name="mgh"
                                                       v-validate="'required'"
                                                       :class="{'form-control':true,'is-danger': errors.has('form-4.mgh') }"
                                                >
                                                <div v-show="errors.has('form-4.mgh')" class="help is-danger">
                                                    {{ errors.first('form-4.mgh') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row" v-if="['Dry Lease', 'Wet Lease','Lease Purchase', 'Exchange','Charter'].includes(staticForm.offer_for)">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">{{staticForm.offer_for}} &nbsp;terms </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <textarea v-model="staticForm.terms"
                                                          name="terms"
                                                          rows="3"
                                                          :class="{'form-control':true,'is-danger': errors.has('terms') }"
                                                >
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Availability </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <date-picker v-model="staticForm.availability"
                                                             v-validate="'required'"
                                                             name="availability"
                                                             :class="{'form-control': true, 'is-danger': errors.has('form-4.availability') }"
                                                             :config="options">

                                                </date-picker>
                                                <div v-show="errors.has('form-4.availability')" class="help is-danger">
                                                    {{ errors.first('form-4.availability') }}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Current Location </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        label="name"
                                                        v-model="staticForm.current_location"
                                                        :options="countries"
                                                >
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-left text-sm-right">Primary Contact </label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <v-select
                                                        v-model="staticForm.primary_contact"
                                                        label="first_name"
                                                        :options="this.$root.$data.contacts"
                                                        name="primary_contact"
                                                        v-validate="'required'"
                                                        data-vv-as="primary contact"
                                                        :class="{'is-danger': errors.has('form-4.primary_contact') }"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('form-4.primary_contact')" class="help is-danger">
                                                    {{ errors.first('form-4.primary_contact') }}
                                                </div>
                                            </div>
                                        </div>





                                        <div class="form-group row" v-for="(frm, index) in staticForm.custom2">
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
                                                <date-picker
                                                             :name="frm.name"
                                                             v-model="frm.value"
                                                             ref="datePicker12"
                                                             class="form-control"
                                                             :config="options"
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
                                                <div class="aircraft_info ">
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
                                                <div class="btn btn-secondary btn-space wizard-previous own-right" data-wizard="#wizard1" @click.prevent="goPage(3)">Previous</div>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div :class="'step-pane'+fivePageActive" data-step="5">
                                <div class="container p-0">
                                    <form class="form-horizontal group-border-dashed" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="">
                                        <div class="form-group row mediaArea">
                                            <div class="col-sm-7">
                                                <h3 class="wizard-title">Files & Photos</h3>
                                                <br>
                                                <button class="btn btn-primary btn-space d-inline-block" @click.prevent="$root.showMedia=true"> <i class="fas fa-upload"></i> Select or Upload Images</button>
                                                <br>
                                            </div>

                                            <div class="col-sm-12">
                                                <hr>
                                                <label>Upload Attachment & Documents</label>
                                                <vue-dropzone
                                                        ref="viewDropZone"
                                                        id="dropzone"
                                                        :options="dropzoneOptions"
                                                        v-on:vdropzone-file-added="addingEvent"
                                                        :headers="dropzoneOptions.headers"
                                                        v-on:vdropzone-removed-file="removeFile"
                                                        @vdropzone-success="vsuccess"
                                                ></vue-dropzone>

                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                                <div  class="row uploadMedia">
                                                    <div class="col-md-3"  v-for="(image, index) in $root.$data.selectedImages">
                                                        <div class="mediaAlign">
                                                            <span class="cross-media btn btn-danger" @click="$root.$data.selectedImages.splice(index, 1)">X</span>
                                                            <img :src="image.src" alt="" class="img-fluid img-thumbnail border mb-5">
                                                        </div>
                                                        <div class="footerFeatured">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" value="1" @click="$root.makeImageFeatured(image.id)" name="is_featured" :checked="image.is_featured">
                                                                <span class="custom-control-label">Featured</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="btn btn-secondary btn-space wizard-previous"   data-wizard="#wizard1" @click.prevent="goPage(4)">Previous</div>
                                                <button class="btn btn-primary btn-space wizard-next" data-wizard="#wizard1" @click.prevent="goPage(6)">Next Step</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div :class="'step-pane'+sixPageActive" data-step="6">
                                <div class="row p-0">
                                    <div class="col-lg-9">
                                        <form class="form-horizontal group-border-dashed" action="#" data-parsley-namespace="data-parsley-" data-parsley-validate="" novalidate="" @submit.prevent="updateAircraft">
                                            <div class="form-group row">
                                                <div class="col-sm-7">
                                                    <h3 class="wizard-title">Custom Info</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label text-left text-sm-right">Additional details</label>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control" rows="6" v-model="staticForm.description"  placeholder="Additional details"></textarea><br>
                                                    <!--<label class="custom-control custom-checkbox custom-control-inline own-right">-->
                                                    <!--<input class="custom-control-input" type="checkbox"><span class="custom-control-label custom-control-color">Promote Now</span>-->
                                                    <!--</label>-->
                                                    <br>
                                                    <i class="own-right">By submitting this asset, you agree to the terms and privacy policy of Airbook. </i>
                                                </div>
                                            </div>
        
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-7 d-flex justify-content-end">
                                                    <div>
                                                        <div class="btn btn-secondary btn-space wizard-previous"   data-wizard="#wizard1" @click.prevent="goPage(5)">Previous</div>
                                                        <button class="btn btn-danger btn-space wizard-next" @click.prevent="$router.push({name:'userAircrafts'})">Cancel</button>
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

    </div>
</template>

<script src="./js/userAircraftEdit.js"></script>
