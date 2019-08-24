<template>
        <div class="page-search-section" data-ix="show-float-search" :style="newStyles">
            <div class="container w-container">
                <div class="page-search-wrapper">
                    <div class="home-seach-form-block w-form">
                        <form id="wf-form-Home-Asset-Search" name="wf-form-Home-Asset-Search" data-name="Home Asset Search"
                              class="home-search-form" @submit.prevent="search()" method="get">
                            <select id="Asset-Select-2" name="Asset-Select-2" data-name="Asset Select 2" v-model="searchKey"
                                    class="main-search-select page-select w-select" @change="focusInput()" :style="$route.name =='home'?{'background': '#2173B9!important'}:''" required>
                                <option value="">Select</option>
                                <option value="aircraft">Aircraft</option>
                                <option value="engine">Engines</option>
                                <option value="apu">APU</option>
                                <option value="parts">Parts</option>
                                <option value="wanted">Wanted</option>
                                <option value="airport">Airports</option>
                                <option value="contact">People</option>
                                <option value="company">Companies</option>
                            </select>
                            <input type="text" class="main-search-field page-field w-input" ref="searchNow"
                                   maxlength="256" name="Keyword-2" data-name="Keyword 2"
                                   placeholder="Enter keyword" id="Keyword-2" v-model="searchValue">

                            <input type="submit" value="" data-wait="Please wait..."
                                   class="main-search-button page-search-button w-button"
                                   :style="$route.name=='home'?{'background': '#2173B9!important'}:''"
                            >
                        </form>
                        <div class="w-form-done">
                            <div>Thank you! Your submission has been received!</div>
                        </div>
                        <div class="w-form-fail">
                            <div>Oops! Something went wrong while submitting the form.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
<script>
    export default {
        props:[
            'styleProperty'
        ],
        data() {
            return {
                searchKey:'',
                searchValue:'',
                newStyles:{

                },
                routeName:[
                    'aircraft',
                    'engine',
                    'apu',
                    'parts',
                    'wanted',
                    'contact',
                    'airport',
                    'contact',
                    'company'
                ]
            }
        },

        created(){


            if(this.$route.name =='home'){
                this.newStyles.borderBottom=0
                this.newStyles.padding = 0 + ' ' + 0
            }

            const [key]=this.$route.path.replace('/','').split('/')
            this.getSearchKey(key)


            if(this.$route.query.title){
                this.searchValue=this.$route.query.title.replace('-', ' ')
            }

        },

        methods:{
            search(){
                if(['airport', 'company', 'contact'].includes(this.searchKey)){
                    this.$router.push('/'+this.searchKey + '?title=' + this.searchValue)
                    this.$parent.$refs.sideBarRef.getSideBarData()

                }else{
                    this.$router.push('/'+this.searchKey + '?title=' + this.searchValue.replace(/ /g, '-') )
                    this.$parent.$refs.sideBarRef.getSideBarData()
                }

            },
          focusInput(){
              this.$refs.searchNow.focus()
          },
            getSearchKey($data){
                if(this.routeName.includes($data)){
                    this.searchKey=$data
                }else{
                    this.searchKey=''
                }
            }
        }
    }
</script>
