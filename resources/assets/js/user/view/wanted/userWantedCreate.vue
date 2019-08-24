<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">My Wanted</div>
            <div class="card-body">
                <form @submit.prevent="postWanted()">
                    <div class="">
                            <div class="form-group">
                                <label>Wanted Asset *</label>
                                <v-select v-model="wanted.type"
                                          :options="['aircraft', 'engine', 'apu', 'parts']"
                                          @input="$root.findManufacturers(wanted.type, null)"
                                          name="type"
                                          :class="{'capitalize':true,'is-danger': errors.has('type') }"
                                          v-validate="'required'"
                                >
                                </v-select>
                                <div v-show="errors.has('type')" class="help is-danger">
                                    {{ errors.first('type') }}
                                </div>
                            </div>
                    </div>
    
                   <div  v-if="wanted.type">
                       <!---------for APU---------->
                       <div class="apu d-flex flex-wrap p-0 row" v-if="wanted.type=='apu'">
                           <div class="col-md-4 ">
                               <div class="form-group ">
                                   <label>APU manufacturer</label>
                                   <v-select v-model="wanted.apuManufacturer"
                                             :options="$root.$data.apuManufacturers"
                                             label="name"
                                             name="apuManufacturer"
                                             @input="wanted.apuType =null, $root.findType('apu', wanted.apuManufacturer)"
                                             :class="{'is-danger': errors.has('apuManufacturer') }"
                                             v-validate="'required'"
                                   >
                                   </v-select>
                                   <div v-show="errors.has('apuManufacturer')" class="help is-danger">
                                       {{ errors.first('apuManufacturer') }}
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label>APU Type</label>
                                   <v-select
                                           v-model="wanted.apuType"
                                           :options="$root.$data.apuTypes"
                                           label="name"
                                           name="aircraftType"
                                           @input="wanted.apuModel =null, $root.findModel('apu',wanted.apuType)"
                                           :class="{'is-danger': errors.has('aircraftType') }"
                                           v-validate="'required'"
                                   >
                                   </v-select>
                                   <div v-show="errors.has('aircraftType')" class="help is-danger">
                                       {{ errors.first('aircraftType') }}
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <label>APU Model</label>
                                   <v-select v-model="wanted.apuModel"
                                             :options="$root.$data.apuModeleds"
                                             label="name"
                                             name="apuModel"
                                             :class="{'is-danger': errors.has('apuModel') }"
                                   >
                                   </v-select>

                               </div>
                           </div>
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <label>Part Number</label>
                                   <input type="text" v-model="wanted.part_number"
                                          name="part_number"
                                          :class="{'form-control':true,'is-danger': errors.has('part_number') }"
                                          v-validate="'required'"
                                   >
                               </div>
                               <div v-show="errors.has('part_number')" class="help is-danger">
                                   {{ errors.first('part_number') }}
                               </div>
                           </div>
                       </div>
                       <!---------for Aircraft---------->
                       <div class="aircraft d-flex flex-wrap p-0 row" v-if="wanted.type=='aircraft'">
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <label>Aircraft manufacturer</label>
                                   <v-select
                                           v-model="wanted.aircraftManufacturer"
                                           :options="$root.$data.aircraftManufacturers"
                                           label="name"
                                           name="aircraftManufacturer"
                                           @input="wanted.aircraftType =null, $root.findType('aircraft', wanted.aircraftManufacturer)"
                                           :class="{'is-danger': errors.has('aircraftManufacturer') }"
                                           v-validate="'required'"
                                   >
                                   </v-select>
                                   <div v-show="errors.has('aircraftManufacturer')" class="help is-danger">
                                       {{ errors.first('aircraftManufacturer') }}
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label>Aircraft type</label>
                                   <v-select
                                           v-model="wanted.aircraftType"
                                           :options="$root.$data.aircraftTypes"
                                           label="name"
                                           name="aircraftType"
                                           @input="wanted.aircraftModel =null, $root.findModel('aircraft',wanted.aircraftType)"
                                           :class="{'is-danger': errors.has('aircraftType') }"
                                           v-validate="'required'"
                
                                   >
                                   </v-select>
                                   <div v-show="errors.has('aircraftType')" class="help is-danger">
                                       {{ errors.first('aircraftType') }}
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <label>Aircraft model</label>
                                   <v-select
                                           v-model="wanted.aircraftModel"
                                           :options="$root.$data.aircraftModeleds"
                                           label="name"
                                           name="aircraftModel"
                                           :class="{'is-danger': errors.has('aircraftModel') }"
                                   >
                                   </v-select>
                               </div>
                           </div>
                           <div class="col-md-4 ">
                               <div class="form-group">
                               <label>
                                   YOM
                               </label>
                               <date-picker
                                       v-model="wanted.yom"
                                       :config="{format:'YYYY'}"
                                       v-validate="'required'"
                                       name="yom"
                                       :class="{'is-danger': errors.has('yom') }"
                               >
                               </date-picker>
                               <div v-show="errors.has('yom')" class="help is-danger">
                                   {{ errors.first('yom') }}
                               </div>
                               </div>
                           </div>
                       </div>

                       <!---------for Engine ---------->
                       <div class="aircraft d-flex flex-wrap row" v-if="wanted.type=='engine'">
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <label>Engine manufacturer</label>
                                   <v-select
                                           v-model="wanted.engineManufacturer"
                                           :options="$root.$data.engineManufacturers"
                                           label="name"
                                           @input="wanted.engineType =null, $root.findType('engine',wanted.engineManufacturer)"
                                           name="engineManufacturer"
                                           :class="{'is-danger': errors.has('engineManufacturer') }"
                                           v-validate="'required'"
                                   >
                                   </v-select>
                                   <div v-show="errors.has('engineManufacturer')" class="help is-danger">
                                       {{ errors.first('engineManufacturer') }}
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4">
                               <div class="form-group">
                                   <label>Engine type</label>
                                   <v-select v-model="wanted.engineType"
                                             :options="$root.$data.engineTypes"
                                             label="name"
                                             @input="wanted.engineModel=null, $root.findModel('engine',wanted.engineType)"
                                             name="engineType"
                                             :class="{'is-danger': errors.has('engineType') }"
                                             v-validate="'required'"
                                   >
                                   </v-select>
                                   <div v-show="errors.has('engineType')" class="help is-danger">
                                       {{ errors.first('engineType') }}
                                   </div>
                               </div>
                           </div>
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <label>Engine model</label>
                                   <v-select v-model="wanted.engineModel"
                                             :options="$root.$data.engineModeleds"
                                             label="name"
                                             name="engineModel"
                                             :class="{'is-danger': errors.has('engineModel') }"
                                   >
                                   </v-select>
                               </div>
                           </div>
                       </div>
                       <!---------for Parts ---------->
                       <div class="parts d-flex flex-wrap row" v-if="wanted.type=='parts'">
                           <div class="col-md-4 ">
                               <div class="form-group">
                                   <label>
                                       Part Number
                                   </label>
                                   <input type="text"
                                          v-model="wanted.part_number"
                                          name="part_number"
                                          :class="{'form-control':true,'is-danger': errors.has('part_number') }"
                                          v-validate="'required'">
                                   <div v-show="errors.has('part_number')" class="help is-danger">
                                       {{ errors.first('part_number') }}
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
              
                
                <div class="d-flex flex-wrap row" >

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Primary contact</label>
                                <v-select
                                        v-model="wanted.primary_contact"
                                        :options="$root.$data.contacts"
                                        :get-option-label="$root.getFullName"
                                        label="first_name"
                                        name="primary_contact"
                                        data-vv-as="primary contact"
                                        :class="{'is-danger': errors.has('primary_contact') }"
                                        v-validate="'required'"
                                >
                                </v-select>
                                <div v-show="errors.has('primary_contact')" class="help is-danger">
                                    {{ errors.first('primary_contact') }}
                                </div>
                            </div>
            
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Location</label>
                                <v-select
                                        v-model="wanted.country"
                                        :options="countries"
                                        label="name"
                                        name="country"
                                        data-vv-as="country"
                                        :class="{'is-danger': errors.has('country') }"
                                        v-validate="'required'"
                                >
                                </v-select>
                                <div v-show="errors.has('country')" class="help is-danger">
                                    {{ errors.first('country') }}
                                </div>
                            </div>

                        </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Wanted By</label>
                            <date-picker v-model="wanted.wanted_by"
                                         :class="{'form-control': true, 'is-danger': errors.has('wanted_by') }"
                                         :config="options">

                            </date-picker>
                        </div>

                    </div>
                    <div class="col-md-4 " v-if="wanted.type=='aircraft'">
                        <div class="form-group">
                            <label>Wanted terms</label>

                            <v-select v-model="wanted.terms"

                                      :options="['ACMI', 'Dry Lease', 'Charter', 'Lease Purchase', 'Outright Purchase']"
                                        name="terms"
                                        :class="{'is-danger': errors.has('terms') }"
                                        v-validate="'required'">

                            </v-select>
                            <div v-show="errors.has('terms')" class="help is-danger">
                                {{ errors.first('terms') }}
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4 " v-if="wanted.type=='apu' || wanted.type=='engine'">
                        <div class="form-group">
                            <label>Wanted terms</label>

                            <v-select v-model="wanted.terms"

                                      :options="['Outright Purchase', 'Lease', 'Lease Purchase', 'Exchange', 'Part out']"
                                      name="terms"
                                      :class="{'is-danger': errors.has('terms') }"
                                      v-validate="'required'">

                            </v-select>
                            <div v-show="errors.has('terms')" class="help is-danger">
                                {{ errors.first('terms') }}
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4" v-if="wanted.type=='parts'">
                        <div class="form-group">
                            <label>Wanted terms</label>

                            <v-select v-model="wanted.terms"

                                      :options="['Cash', 'Exchange']"
                                      name="terms"
                                      :class="{'is-danger': errors.has('terms') }"
                                      v-validate="'required'">

                            </v-select>
                            <div v-show="errors.has('terms')" class="help is-danger">
                                {{ errors.first('terms') }}
                            </div>
                        </div>

                    </div>
                        <div class="col-md-12">
                
                            <div class="form-group">
                                <label>Comments</label>
                                <textarea v-model="wanted.comments"
                                          class="form-control"
                                          rows="3">
                                    </textarea>
                            </div>
                        </div>
                </div>
                <!--<div class="col-md-12">-->
                    <!--<div class="d-flex flex-wrap">-->
                        <!--<div class="row">-->
                            <!--<section class="dynamic-field">-->
                    <!---->
                                <!--<button @click.prevent="showCustom=true" class="btn btn-space btn-primary pl-4 pr-4 mb-3 ">-->
                                    <!--<i class="icon mdi mdi-plus pr-1"></i>-->
                                     <!--Add Custom Field-->
                                <!--</button>-->
                                <!--<br>-->
                                <!--<div v-if="showCustom">-->
                                    <!--<input type="text"-->
                                           <!--v-model="formLabel"-->
                                           <!--@keyup.enter="addCustom()"-->
                                           <!--placeholder="Custom label" autofocus class="form-control">-->
                                   <!---->
                                    <!--<br>-->
                                <!--</div>-->
                    <!---->
                                <!--<button type="submit" @click.prevent="addCustom()"-->
                                        <!--v-if="formLabel && showCustom" class="btn btn-space btn-primary mb-3 pl-3 pr-3 ">-->
                                    <!--<i class="icon mdi mdi-plus pr-1"></i>-->
                                    <!--Add Field-->
                                <!--</button>-->
     <!---->
    <!---->
                              <!--<div class="col-md-12 d-flex flex-wrap justify-content-start mt-3 mb-3 pl-0 pr-0">-->
                                  <!--<div v-for="(form, index) in wanted.custom" v-if="wanted.custom.length" class="  form-inline customFormItem ml-0 mr-4  p-0">-->

                                      <!--<label class="pt-2 pb-2 pr-2 pl-2 ">{{form.label}}</label>-->
                                      <!--<input type="text" :name="form.name" v-model="form.value" class="form-control ">-->

                                      <!--<button  class="btn deleteBtn" @click.prevent="deleteForm(index)"><i data-v-7206df83="" class="icon mdi mdi-close"></i></button>-->
                                  <!--</div>-->
                              <!--</div>-->
                              <!---->
                            <!---->
                <!---->
                            <!--</section>-->
                        <!--</div>-->
                        <!---->
                    <!--</div>-->
                <!--</div>-->
                <div class="col-md-12 row">
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
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                requestField: {},
                showCustom: false,
                formLabel: null,
                countries:[],
                wanted: {
                    custom: []
                },
                buttonDisabled: false,
                options: {
                    format: 'DD-MM-YYYY',
                    useCurrent: true,
                },

            }
        },
        created(){
            axios.get('/user/ajax/wanted/create')
                .then(res=>{
                    this.wanted.primary_contact=res.data.user
                    this.countries=res.data.countries
                })
        },
        methods: {
            saveAndClose(){
            
            },
            addCustom() {
                if (this.formLabel && this.formLabel) {
                    this.wanted.custom.push({label: this.formLabel, type: 'text', name: this.formLabel})
                    this.formName = null
                    this.formLabel = null
                }
            },
            deleteForm(index){
                this.wanted.custom.splice(index, 1)
            },
            postWanted(val){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.post('/user/ajax/wanted',
                            this.wanted
                        ).then(response=>{
                            this.wanted={
                                yom: new Date(),
                                custom: []
                            },
                                this.buttonDisabled=false,
                                this.$validator.reset(),
                                this.$root.successMessage(response.data)
                                val==='redirect'?this.$router.push({path:'/user/wanted'}):''

                        }).catch(error=>{
                            let err
                            let errs = error.response.data.errors
                            for (err in errs){
                                this.errors.add({
                                    'field':err,
                                    'msg':errs[err][0]
                                })
                            }
                        })
                    }
                })
            },
            saveAndClose(){
                this.postWanted('redirect')
            },
            cancel(){
                this.$router.push({path:'/user/wanted'})
            }

        }
    }
</script>


