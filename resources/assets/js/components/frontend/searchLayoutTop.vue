<template>
	<div class="topSearch">
		<div  class="float-search-section" data-ix="scroll-search-initial-view"  id="searchBar" style="display:none" @scroll.native="$root.handleScroll">
			<div class="container w-container">
				<div class="float-search-wrapper">
					<div class="float-search-block w-form">
						<form id="wf-form-Float-Search" name="wf-form-Float-Search" data-name="Float Search" class="float-search-form"  @submit.prevent="search()" method="get">
							<div class="float-search-ab-logo"></div>
							<select id="Float-Search-Select-2" name="Float-Search-Select-2"   data-name="Float Search Select 2" required v-model="searchKey"
							        class="main-search-select page-select w-select" @change="focusInput()">
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
							       :style="$route.name=='home'?{'background': '#2173b9'}:''"
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

		watch:{
            '$route'(to, form){
                const [key]=this.$route.path.replace('/','').split('/')
                this.getSearchKey(key)
			}
		},
		created(){
            const [key]=this.$route.path.replace('/','').split('/')
            this.getSearchKey(key)
		},

        methods:{
            search(){

                if(['airport', 'company', 'contact'].includes(this.searchKey)){
                    this.$router.push('/'+this.searchKey + '?title=' + this.searchValue)
                    Event.$emit('callMethod')
                }else{
                    this.$router.push('/'+this.searchKey + '?title=' + this.searchValue.replace(/ /g, '-') )
                    Event.$emit('callMethod')
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
