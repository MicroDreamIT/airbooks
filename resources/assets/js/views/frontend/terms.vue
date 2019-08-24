<template>
	<div v-if="metas">
        <search-layout></search-layout>
		<div class="asset-page-section">
			<div class="container w-container">
				<div class="terms-wrapper" v-if="sectionOne">
					<div class="heading-block general-pages">
						<h3 class="home-section-title">{{sectionOne.title}}</h3>
						<div class="line-block">
							<div class="blueline"></div>
							<div class="redline"></div>
						</div>
					</div>
					<div class="terms-updated-label"><span class="updated-terms-clock-span"></span>Last updated: {{sectionOne.updated_at | moment("MMMM DD, YYYY")}}</div>
					<div v-html="sectionOne.body">

					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {

        data(){
            return{
                sectionOne:{},

            }
        },
        created(){
            this.getData()
        },
        computed:{
            metas(){
                this.$root.setupSeo(this.$store.state.seos, 'Terms')
                return !!this.$store.state.seos.length
            },
        },
        methods:{

            getData(){
                axios.get('/ajax/cms/terms').then(res=>{
                    this.sectionOne=res.data.filter(data=> data.section=='Section One')[0]
                })
            },

        }

    }
</script>


