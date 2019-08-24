<template>
    <div style="width: 100%;">
        <br>
        <form @submit.prevent="updateAirport">
        <div class="airportEdit">

            <div class="column">
                <div class="form-group">
                    <label for="name"> Name *</label>
                    <input id="name"
                           v-model="name"
                           type="text"
                           name="name"
                           :class="{'form-input': true, 'is-danger': errors.has('name') }"
                           data-error="name is required."
                           v-validate="'required'"
                    >
                    <div v-show="errors.has('name')" class="help is-danger">{{ errors.first('name') }}
                    </div>
                </div>
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
            <div class="column">
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
                <div class="form-group">
                    <label>Timezone</label>
                    <v-select
                            v-model="timezone"
                            :options="timezones"
                            label="key"
                            name="timezone"
                            :class="{ 'form-input': errors.has('timezone') }"
                    >
                    </v-select>
            
                </div>
                <div class="form-group">
                    <label> IATA Code</label>
                    <input v-model="iata_code"
                           type="text"
                           name="iata_code"
                           :class="{'form-input': true, 'is-danger': errors.has('iata_code') }"
                           data-error="Iata is required."
                           v-validate="'required'"
                    >
                    <div v-show="errors.has('iata_code')" class="help is-danger">
                        {{ errors.first('iata_code') }}
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="form-group">
                    <label> ICAO Code</label>
                    <input v-model="icao_code"
                           type="text"
                           name="icao_code"
                           :class="{'form-input': true, 'is-danger': errors.has('icao_code') }"
                           data-error="Icao is required."
                           v-validate="'required'"
                    >
                    <div v-show="errors.has('icao_code')" class="help is-danger">
                        {{ errors.first('icao_code') }}
                    </div>
                </div>
                <div class="form-group">
                    <label> Longitude</label>
                    <input v-model="longitude"
                           type="number"
                           step="any"
                           name="longitude"
                           :class="{'form-input': true, 'is-danger': errors.has('longitude')}"
                           data-error="Please Input Number."
                           v-validate="'decimal'"
                    >
                    <div v-show="errors.has('longitude')" class="help is-danger">
                        {{ errors.first('longitude') }}
                    </div>
                </div>
                <div class="form-group">
                    <label> Latitude</label>
                    <input v-model="latitude"
                           type="number"
                           step="any"
                           name="latitude"
                           :class="{'form-input': true, 'is-danger': errors.has('latitude') }"
                           data-error="Please Input Number."
                           v-validate="'decimal'"
                    >
                    <div v-show="errors.has('latitude')" class="help is-danger">
                        {{ errors.first('latitude') }}
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start flex-wrap padding-20">
            <button class="pagination-button w-button  "
                    type="submit"
                    :disabled="buttonDisabled"
            >
                Update
            </button>
            <button class="footer-sign-button signup w-button"
                    @click.prevent="$parent.closeAirportModal()"
                    style="margin-left:10px;"
            >

                Cancel
            </button>
        </div>
        </form>
    </div>

</template>

<script>
    export default {
        props:{
            id:{
                type:Number,
                default:()=>0
            },
            pageType:{
                type:String,
                default:()=>''
            }

        },
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
            this.edit()
            this.timeZoneCreate()
        },
        methods: {
            edit(){
                axios.get('/forntend/airport/edit/'+this.id).then(response => {
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
                    this.buttonDisabled=true
                    if (result) {
                        axios.patch('/forntend/airport/'+ this.id , {

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
                            if(this.pageType='airports'){
                                this.$parent.getData(1)
                            }
                            this.buttonDisabled=false
                            this.$root.alertMessage(response.data.message)
                            this.$parent.closeAirportModal()
                            this.$validator.reset()

                        }).catch(error => {
                            if (error.response){
                                let err
                                let errs = error.response.data.errors
                                for (err in errs) {
                                    this.errors.add({
                                        'field': err,
                                        'msg': errs[err][0]
                                    })
                                }
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

<style scoped>
    .is-danger{
        color:red;
    }
</style>



