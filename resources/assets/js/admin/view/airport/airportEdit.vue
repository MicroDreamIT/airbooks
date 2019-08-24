<template>
    <div>

        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Airport</div>
            <div class="card-body">
                <form @submit.prevent="updateAirport">

                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"> Name *</label>
                                    <input id="name" v-model="name" type="text" name="name"
                                           :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                           data-error="name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Airfield Type*</label>
                                    <v-select
                                            v-model="airfield"
                                            :options="airfields"
                                            label="name"
                                            name="airfield"
                                            :class="{ 'is-danger': errors.has('airfield') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>

                                    <div v-show="errors.has('airfield')" class="help is-danger">
                                        {{ errors.first('airfield') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Country *</label>
                                    <v-select
                                            v-model="country"
                                            :options="countries"
                                            label="name"
                                            name="country"
                                            @input="getState"
                                            :class="{ 'is-danger': errors.has('country') }"
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
                                    <label>State *</label>
                                    <v-select
                                            v-model="state"
                                            :options="states"
                                            label="name"
                                            name="state"
                                            @input="getCity"
                                            :class="{ 'is-danger': errors.has('state') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('state')" class="help is-danger">
                                        {{ errors.first('state') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>City*</label>
                                    <v-select
                                            v-model="city"
                                            :options="cities"
                                            label="name"
                                            name="city"
                                            :class="{ 'is-danger': errors.has('city') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>

                                    <div v-show="errors.has('city')" class="help is-danger">
                                        {{ errors.first('city') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Timezone</label>
                                    <v-select
                                            v-model="timezone"
                                            :options="timezones"
                                            label="key"
                                            name="timezone"
                                            :class="{ 'is-danger': errors.has('timezone') }"

                                    >
                                    </v-select>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> IATA Code</label>
                                    <input v-model="iata_code" type="text" name="iata_code"
                                           :class="{'form-control': true, 'is-danger': errors.has('iata_code') }"
                                           data-error="Iata is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('iata_code')" class="help is-danger">
                                        {{ errors.first('iata_code') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> ICAO Code</label>
                                    <input v-model="icao_code" type="text" name="icao_code"
                                           :class="{'form-control': true, 'is-danger': errors.has('icao_code') }"
                                           data-error="Icao is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('icao_code')" class="help is-danger">
                                        {{ errors.first('icao_code') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Latitude</label>
                                    <input v-model="latitude" type="number" step="any" name="latitude"
                                           :class="{'form-control': true, 'is-danger': errors.has('latitude') }"
                                           data-error="Please Input Number."
                                           v-validate="'decimal'"

                                    >
                                </div>
                                <div v-show="errors.has('latitude')" class="help is-danger">
                                    {{ errors.first('latitude') }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Longitude</label>
                                    <input v-model="longitude" type="number" step="any" name="longitude"
                                           :class="{'form-control': true, 'is-danger': errors.has('longitude')}"
                                           data-error="Please Input Number."
                                           v-validate="'decimal'"
                                    >
                                </div>

                                <div v-show="errors.has('longitude')" class="help is-danger">
                                    {{ errors.first('longitude') }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Sunrise </label>
                                    <date-picker
                                            v-model="sunrise"
                                            :show-hours="true"
                                            :class="{'form-control': true, 'is-danger': errors.has('sunrise') }"
                                            :config="options">

                                    </date-picker>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label> Sunset </label>
                                    <date-picker v-model="sunset"
                                                 :class="{'form-control': true, 'is-danger': errors.has('sunset') }"
                                                 :config="options"></date-picker>
                                </div>
                            </div>

                            <div class="col-md-12 form-check mt-1">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="is_active"
                                           name="is_active" :value="true"><span
                                        class="custom-control-label">Publish</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input" type="radio" v-model="is_active"
                                           name="is_active" :value="false"><span
                                        class="custom-control-label">Inactive</span>
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

<script>
    export default {

        data() {
            return {
                sError: {},
                name: null,
                airfield: null,
                city: null,
                state: null,
                country: null,
                iata_code: null,
                icao_code: null,
                latitude: null,
                longitude: null,
                timezone: null,
                is_active: true,
                cities: [],
                states: [],
                countries: [],
                airfields: [],
                timezones: [],
                buttonDisabled: false,
                sunrise: null,
                sunset: null,
                airport:[],
                options: {
                    format: 'HH:mm',
                    useCurrent: true,
                }
            }
        },

        created(){
            this.edit(this.$route.params.id)
            this.timeZoneCreate()
        },
        methods: {
            edit(id){
                axios.get('/admin/airport/'+id+'/edit').then(response => {
                    this.countries=response.data.countries
                    this.state=response.data.states
                    this.city=response.data.cities
                    this.airport=response.data.airport
                    this.airfields = response.data.airfields,
                    this.name=response.data.airport.name,
                    this.airfield=response.data.airport.airfield,
                    this.city=response.data.airport.city,
                    this.state=response.data.airport.city.state,
                    this.country=response.data.airport.city.state.country,
                    this.iata_code=response.data.airport.iata_code,
                    this.icao_code=response.data.airport.icao_code,
                    this.latitude=response.data.airport.latitude,
                    this.longitude=response.data.airport.longitude,
                    this.timezone=response.data.airport.time_zone,
                    this.sunrise=response.data.airport.sunrise,
                    this.sunset=response.data.airport.sunset,
                    response.data.airport.is_active==0? this.is_active = false : this.is_active = true
                })
            },
            updateAirport() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        axios.patch('/admin/airport/'+ this.$route.params.id , {

                            name: this.name,
                            airfield_type_id: this.airfield.id,
                            city_id: this.city.id,
                            country_id: this.country.id,
                            state_id: this.state.id,
                            iata_code: this.iata_code,
                            icao_code: this.icao_code,
                            latitude: this.latitude,
                            longitude: this.longitude,
                            time_zone: this.timezone,
                            sunrise: this.sunrise,
                            sunset: this.sunset,
                            is_active: this.is_active
                        }).then(response => {
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data.message)
                            this.buttonDisabled=false
                            this.$validator.reset()
                            this.$router.push({path:response.data.redirection})
                        }).catch(error => {
                            let err
                            let errs = error.response.data.errors
                            for (err in errs) {
                                this.errors.add({
                                    'field': err,
                                    'msg': errs[err][0]
                                })
                            }
                        })
                    }
                })
            },
            getState(){
                if(this.country) {
                    axios.get('/getStateNameByCountry', {
                        params: {
                            country_id: this.country.id
                        }
                    }).then(response => {
                        this.states = response.data
                        this.airport.city.state.country.id == this.country.id ?
                            this.state = this.airport.city.state :
                            this.state = null
                    })
                }
            },
            cancel(){
                this.$router.push({path:'/admin/airport'})
            },
            timeZoneCreate(){
                let timezones=[]
                for(let i=-11; i<=11; i++){
                    if([i]>=0){
                        if([i]==0){
                            timezones.push('GMT '+[i]+':00')
                            timezones.push('GMT+'+[i]+':30')
                        }else{
                            timezones.push('GMT+'+[i]+':00')
                            timezones.push('GMT+'+[i]+':30')
                        }
                    }else{
                        timezones.push('GMT'+[i]+':00')
                        timezones.push('GMT'+[i]+':30')
                    }
                }
                this.timezones=timezones
            },
            getCity(){
                if (this.state) {
                    axios.get('/getCityNameByState',{
                        params:{
                            state_id:this.state.id
                        }
                    }).then(response=>{
                        this.cities=response.data
                        this.airport.city.state.id==this.state.id?
                            this.city = this.airport.city:
                            this.city=null
                    })
                }

            }
        }
    }


</script>



