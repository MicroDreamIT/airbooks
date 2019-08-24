<template>
    <div>
        <div class="card-body  card-header-contrast">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4" v-if="contact.title">
                                    <p class="cat_desc">
                                        <span>Name</span> <br>
                                        <strong>
                                            {{contact.title}} {{contact.first_name}} {{contact.last_name}}
                                        </strong>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="cat_desc">
                                        <span>Email</span> <br>
                                        <strong>
                                            {{contact.email}}
                                        </strong>
                                    </p>

                                    <p class="cat_desc" v-if="contact.gender">
                                        <span>Gender</span> <br>
                                        <strong class="capitalize">
                                            {{contact.gender}}
                                        </strong>
                                    </p>
                                </div>
                                <div class="col-md-4" v-if="contact.religion">
                                    <p class="cat_desc">
                                        <span>Religion</span> <br>
                                        <strong>
                                            {{contact.religion}}
                                        </strong>
                                    </p>

                                    <p class="cat_desc" v-if="contact.birthday">
                                        <span>Birthday</span> <br>
                                        <strong>
                                            {{contact.birthday}}
                                        </strong>
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <section class="company_detail">
                                <div class="row">
                                    <div class="col-md-4" v-if="contact.company">
                                        <p class="cat_desc">
                                            <span>Company</span> <br>
                                            <strong>
                                                {{contact.company.name}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.job_title">
                                        <p class="cat_desc">
                                            <span>Job Title</span> <br>
                                            <strong>
                                                {{contact.job_title.name}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.department">
                                        <p class="cat_desc">
                                            <span>Department</span> <br>
                                            <strong>
                                                {{contact.department.name}}
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </section>

                            <hr>

                            <section class="contact_detail">
                                <div class="row">
                                    <div class="col-md-4" v-if="contact.mobile_phone">
                                        <p class="cat_desc">
                                            <span>Mobile Phone</span> <br>
                                            <strong>
                                                {{contact.mobile_phone}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.business_phone">
                                        <p class="cat_desc">
                                            <span>Business Phone</span> <br>
                                            <strong>
                                                {{contact.business_phone}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.skype">
                                        <p class="cat_desc">
                                            <span>Skype</span> <br>
                                            <strong>
                                                {{contact.skype}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.linkedin">
                                        <p class="cat_desc">
                                            <span>Linkedin</span> <br>
                                            <strong>
                                                {{contact.linkedin}}
                                            </strong>
                                        </p>
                                    </div>

                                </div>



                            </section>


                            <hr v-if="contact.mobile_phone || contact.business_phone||
                                     contact.skype||contact.linkedin">

                            <section class="address">
                                <div class="row">
                                    <div class="col-md-4" v-if="contact.address">
                                        <p class="cat_desc">
                                            <span>Address</span> <br>
                                            <strong>
                                                {{contact.address}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.city">
                                        <p class="cat_desc">
                                            <span>City</span> <br>
                                            <strong>
                                                {{contact.city.name}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.state">
                                        <p class="cat_desc">
                                            <span>State</span> <br>
                                            <strong>{{contact.state.name}}
                                            </strong>
                                        </p>
                                    </div>

                                    <div class="col-md-4" v-if="contact.country">
                                        <p class="cat_desc">
                                            <span>Country</span> <br>
                                            <strong>
                                                {{contact.country.name}}
                                            </strong>
                                        </p>
                                    </div>

                                </div>
                            </section>

                            <hr>

                            <section class="user_settings">
                                <div class="row">
                                    <div class="col-md-4" v-if="contact.preferred_contact_method">
                                        <p class="cat_desc">
                                            <span>Preferred contact method</span><br>
                                            <strong>
                                                {{contact.preferred_contact_method}}
                                            </strong>
                                        </p>
                                    </div>
                                    <!--<div class="col-md-4" v-if="contact.creator.id">-->
                                    <!--<p class="cat_desc">-->
                                    <!--<span>Creator id</span><br>-->
                                    <!--<strong>-->
                                    <!--{{contact.creator.id}}-->
                                    <!--</strong>-->
                                    <!--</p>-->
                                    <!--</div>-->
                                    <div class="col-md-4" v-if="contact.is_published">
                                        <p class="cat_desc">
                                            <span>Published status</span><br>
                                            <strong>
                                                {{contact.is_published ? 'Yes' : 'No'}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.is_primary">
                                        <p class="cat_desc">
                                            <span>Primary Status</span><br>
                                            <strong>
                                                {{contact.is_primary ? 'Yes' : 'No'}}
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="col-md-4" v-if="contact.is_public">
                                        <p class="cat_desc">
                                            <span>Public Status</span><br>
                                            <strong>
                                                {{contact.is_public ? 'Yes' : 'No'}}
                                            </strong>
                                        </p>
                                    </div>
                                </div>

                            </section>


                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="darea" role="alert">
                        <div class="message" v-if="contact.medias">
                            <img :src="'/storage/'+contact.medias.path+'/'+contact.medias.original_file_name"
                                 class="img-fluid d-block mx-auto" >
                        </div>
                        <div class="message" v-else>
                            <img :src="'/../../../images/dummy_image.svg'" width="70px" class="img-fluid d-block mx-auto" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "userContactShow",
        data(){
            return {
                contacts:[],
                contact:{},
                is_active:1,
                sortKey:null,
                sortOrder:'asc',
                lastPage:null,
                resultPerPage:10,
                page:1,
                total:null,
                pageNumbers:1
            }
        },
        created(){
            this.show(this.$route.params.id)
        },
        methods:{

            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/contact/' + this.$route.params.id).then(response => {
                            this.$router.push({path:'/user/ajax/contact/'})
                            this.$root.alertMessage(
                                {
                                    type:'danger',
                                    message:'Contact has been deleted successfully'
                                })
                        })
                    }
                })
            },

            show(id){
                axios.get('/user/ajax/contact/'+id,{
                    params:{

                    }
                }).then(response=>{
                    this.contact = response.data
                })
            }
        }
    }
</script>


