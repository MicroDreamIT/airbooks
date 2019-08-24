export default {
    props:['searchTitleNumbers'],
    data(){
        return{
            categories:[],
            manufacturers:[],
            types:[],
            models:[],
            offerFors:[],
            status:[],
            assetType:[],
            yomFromOptions:[],
            yomToOptions:[],
            yom_start:{},
            yom_end:{},
            country:[],
            region:[],
            continent:[],
            airField:[],
            jobTitle:[],
            speciality:[],
            condition:[],
            company:[],

            categorySearch:'',
            manufacturerSearch:'',
            typeSearch:'',
            modelSearch:'',
            regionSearch:'',
            countrySearch:'',
            continentSearch:'',
            airfieldSearch:'',
            jobTitleSearch:'',
            specialitySearch:'',
            conditionSearch:'',
            companySearch:'',

            from_cycleRemaning:'0',
            to_cycleRemaning:'0',

            categorySearchItemList:[],
            manufacturerSearchItemList:[],
            typeSearchItemList:[],
            modelSearchItemList:[],
            offerForItemList:[],
            assetTypeItemList:[],
            assetStatusItemList:[],
            airfieldItemList:[],
            regionItemList:[],
            countryItemList:[],
            continentItemList:[],
            conditionItemList:[],
            statusData:[],
            jobTitleItemList:[],
            specialityItemList:[],
            companyItemList:[],
            cycleRemaningOptions:[],
            cycleRemaningOptionsTo:[],
            sideCycleCount:0,
            sideYomCount:0


        }
    },
    created(){
        this.getSideBarData()
    },
    computed:{
        categorySearchList(){

            return this.categories.filter(data=>{
                return data.name.toLowerCase().includes(this.categorySearch.toLowerCase())
            })
        },
        manufacturerSearchList(){
            return this.manufacturers.filter(data=>{
                return data.name.toLowerCase().includes(this.manufacturerSearch.toLowerCase())
            })
        },
        typeSearchList(){
            return this.types.filter(data=>{
                return data.name.toLowerCase().includes(this.typeSearch.toLowerCase())
            })
        },
        modelSearchList(){
            return this.models.filter(data=>{

                return data.name.toLowerCase().includes(this.modelSearch.toLowerCase())
            })
        },
        regionSearchList(){
            return this.region.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.regionSearch.toLowerCase())
                }

            })
        },
        countrySearchList(){
            return this.country.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.countrySearch.toLowerCase())
                }

            })
        },
        continentSearchList(){
            return this.continent.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.continentSearch.toLowerCase())
                }

            })
        },
        airfieldSearchList(){
            return this.airField.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.airfieldSearch.toLowerCase())
                }

            })
        },
        jobTitleSearchList(){
            return this.jobTitle.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.jobTitleSearch.toLowerCase())
                }

            })
        },
        specialitySearchList(){
            return this.speciality.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.specialitySearch.toLowerCase())
                }

            })
        },
        conditionSearchList(){
            return this.condition.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.conditionSearch.toLowerCase())
                }

            })
        },
        companySearchList(){
            return this.company.filter(data=>{
                if(data.id){
                    return data.name.toLowerCase().includes(this.companySearch.toLowerCase())
                }

            })
        }
    },
    mounted(){
        Event.$on('callMethod',()=>{
            this.getSearchData();
        })
    },
    methods:{
        getDataBySidebarSearch(page=1){
            this.getSideBarData(this.categorySearchItemList,
                this.manufacturerSearchItemList,
                this.typeSearchItemList,
                this.modelSearchItemList,
                this.yom_start,
                this.yom_end,
                this.offerForItemList,
                this.from_cycleRemaning,
                this.to_cycleRemaning,
                this.assetTypeItemList,
                this.regionItemList,
                this.countryItemList,
                this.continentItemList,
                this.conditionItemList,
                this.assetStatusItemList,
                this.airfieldItemList,
                this.jobTitleItemList,
                this.specialityItemList,
                this.companyItemList,
                page
            )

            this.getSearchData(this.categorySearchItemList,
                this.manufacturerSearchItemList,
                this.typeSearchItemList,
                this.modelSearchItemList,
                this.yom_start,
                this.yom_end,
                this.offerForItemList,
                this.from_cycleRemaning,
                this.to_cycleRemaning,
                this.assetTypeItemList,
                this.regionItemList,
                this.countryItemList,
                this.continentItemList,
                this.conditionItemList,
                this.assetStatusItemList,
                this.airfieldItemList,
                this.jobTitleItemList,
                this.specialityItemList,
                this.companyItemList,
                page
            )
        },

        getSearchData(category,
                      manufacturer,
                      type,
                      model,
                      yom_start,
                      yom_end,
                      offer_for,
                      cycle_remaining_from,
                      cycle_remaining_to,
                      asset_type,
                      region,country,
                      continent,
                      condition,
                      statusData,
                      airField,
                      jobTitle,
                      speciality,
                      company,
                      page

        ){

            axios.get('/ajax/'+this.$route.path.replace('/','')+'/search',{
                params:{
                    title:this.$route.query.title?this.$route.query.title.replace(/ /g,'-'):null,
                    is_active_by_user:1,
                    isActiveStatus:'Approved',
                    category:category,
                    manufacturer:manufacturer,
                    type:type,
                    model:model,
                    yom_start:yom_start,
                    yom_end:yom_end,
                    offer_for:offer_for,
                    cycle_remaining_from:cycle_remaining_from,
                    cycle_remaining_to:cycle_remaining_to,
                    asset_type:asset_type,
                    region:region,
                    country:country,
                    continent:continent,
                    condition:condition,
                    status:statusData,
                    airfield_type:airField,
                    partsSearchTitle:this.searchTitleNumbers,
                    job_title:jobTitle,
                    speciality:speciality,
                    company:company,
                    only_user_based_contact:true,
                    page:page,

                }
            }).then(res=>{
                this.searchData=res.data
                this.$emit('searchDataList', this.searchData)
            })
        },
        getSideBarData(category,
                       manufacturer,
                       type,
                       model,
                       yom_start,
                       yom_end,
                       offer_for,
                       cycle_remaining_from,
                       cycle_remaining_to,
                       asset_type,
                       region,
                       country,
                       continent,
                       condition,
                       statusData,
                       airField,
                       jobTitle,
                       speciality,
                       company,
                       page
        )
        {
            axios.get('/sidebar-search/'+this.$route.path.replace('/',''),{

                params:{
                    title:this.$route.query.title?this.$route.query.title.replace(/ /g,'-'):null,
                    is_active_by_user:1,
                    isActiveStatus:'Approved',
                    category:category,
                    manufacturer:manufacturer,
                    type:type,
                    model:model,
                    yom_start:yom_start,
                    yom_end:yom_end,
                    offer_for:offer_for,
                    cycle_remaining_from:cycle_remaining_from,
                    cycle_remaining_to:cycle_remaining_to,
                    asset_type:asset_type,
                    region:region,
                    country:country,
                    continent:continent,
                    condition:condition,
                    status:statusData,
                    airfield_type:airField,
                    partsSearchTitle:this.searchTitleNumbers,
                    job_title:jobTitle,
                    speciality:speciality,
                    company:company,
                    only_user_based_contact:true,
                    page:page,
                }
            }).then(res=>{
                this.jobTitle=res.data.jobTitle
                this.categories=res.data.categories
                this.manufacturers=res.data.manufacturers
                this.types=res.data.types
                this.models=res.data.models
                this.offerFors=res.data.offeredFor
                this.status=res.data.status
                this.country=res.data.country
                this.continent=res.data.continent
                this.region=res.data.region
                this.assetType=res.data.assetType
                this.airField=res.data.airField
                this.yom_start=res.data.yomFrom
                this.yom_end=res.data.yomTo
                this.yomFromOptions=[]
                this.yomToOptions=[]
                this.speciality=res.data.speciality
                this.condition=res.data.condition
                this.company=res.data.company

                if(this.$route.path.replace('/','')=='aircraft'){
                    if(res.data.yomFrom!=res.data.yomTo){
                        for(var i=res.data.yomFrom;i<res.data.yomTo;i++){
                            this.yomFromOptions.push({year:i,value:i})
                        }
                        for(var i=res.data.yomTo;i>res.data.yomFrom;i--){
                            this.yomToOptions.push({year:i,value:i})
                        }
                    }else{
                        this.yomFromOptions.push({year:res.data.yomFrom,value:res.data.yomFrom})
                        this.yomToOptions.push({year:res.data.yomTo,value:res.data.yomTo})
                    }
                }
                if(['engine','apu'].includes(this.$route.path.replace('/',''))){
                    if(res.data.cycleRemaning && this.sideCycleCount==0){
                        this.sideCycleCount++
                        for(var i=0;i<=res.data.cycleRemaning;i+=500){
                            this.cycleRemaningOptions.push({item:i, value:i})
                        }
                        if((this.cycleRemaningOptions[this.cycleRemaningOptions.length-1].value-res.data.cycleRemaning)<0){
                            this.cycleRemaningOptions.push({item:res.data.cycleRemaning, value:res.data.cycleRemaning})
                        }

                        this.to_cycleRemaning=res.data.cycleRemaning

                        let reverseCycleRemaningOptions = this.cycleRemaningOptions.slice().reverse()
                        this.cycleRemaningOptionsTo=reverseCycleRemaningOptions
                    }
                }




            })

        },
    }


}
