<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addButton="false"
                :tableHeadline="'Aircraft Assets'"
                :searchField="'aircrafts.title,aircrafts.msn'"
                :dropDownSearch="this.dropdownSearch"
                :modelName="'aircraft'"
                :ajax="{
                            url: url
                        }"
        >

            <template slot="items" slot-scope="props">
                <td>
                    <router-link :to="{name:'adminAircraftShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.title.replace(/-/g, ' ')}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:''}">
                        {{props.data.MSN}}
                    </router-link>
                </td>
                <!--<td>-->
                    <!--<div class="switch-button switch-button-success switch-button-xs activeSwitch" >-->
                        <!--<input-->
                                <!--type="checkbox"-->
                                <!--:checked="props.data.is_active"-->
                                <!--name="swt1"-->
                                <!--:id="props.data.id"-->
                                <!--@click.prevent="$root.changeIsBooleanStatus(props.data, 'is_active', 'App-Manufacturer')"-->
                        <!--&gt;-->
                        <!--<span><label :for="props.data.id"></label></span>-->
                    <!--</div>-->
                <!--</td>-->
                <td>
                    <select name="isActiveStatus" @change="changeActiveStatus(props.data.id, props.data.isActiveStatus)" v-model="props.data.isActiveStatus"  class="assetsApprovement">

                        <option :value="option"
                                :selected="props.data.isActiveStatus==option"
                                v-for="option in ['Pending Approval', 'Approved', 'Revise', 'Rejected']"
                        >{{option}}</option>

                    </select>
                </td>
                <td>
                    <a @click.prevent="deleteMe(props.data.id)" href="" v-if="$root.$data.deletePermission">
                        <i class="mdi mdi-delete"></i>
                    </a>
                </td>
            </template>
        </data-table-join>

    </div>
</template>

<script>
    export default {

        data() {
            return {
                dropdownSearch:[
                    {label:'Filter', column:'isActiveStatus', value:['Pending Approval','Approved','Revise','Rejected'], selected:''},
                ],
                status: null,
                url: '/ajax/aircrafts',
                columns: [
                    {name: 'Title'},
                    {name: 'MSN'},
                    {name: 'Status', nested:'aircrafts.isActiveStatus'},
                    {name: 'Action'},
                ]
            }
        },

        methods:{
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/aircraft/' + id).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            },
            changeActiveStatus(id, status){
                // console.log(id, status)
                if(status=='Revise'){
                    swal({
                        title: 'send mail to revise',
                        input: 'textarea',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'send',
                        showLoaderOnConfirm: true,
                        preConfirm: (login) => {
                            return  axios.patch('/admin/aircraft/single-update/'+id+'/isActiveStatus/edit', {value:login})
                                .then(response => {
                                    if (response.status!=200) {
                                        throw new Error(response.statusText)
                                    }
                                    return 'done'
                                })
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    }).then((result) => {
                        if (result.value) {
                            swal({
                                title: 'done'
                            })
                        }
                    })
                }else{

                    axios.patch('/admin/aircraft/single-update/'+id+'/isActiveStatus/edit', {value:status})
                        .then(res=>{
                            this.$root.successMessage({type:'success', message:'status successfully changes'})
                        })
                        .catch(err=>{

                        })

                    // this.$root.confirmationDelete().then(val => {
                    //     axios.patch('/admin/aircraft/single-update/'+id+'/isActiveStatus/edit', {value:status})
                    //         .then(res=>{
                    //             console.log(res.data)
                    //         })
                    //         .catch(err=>{
                    //
                    //         })
                    // })
                }
                // user/ajax/aircraft/single-update/{id}/{column-name}



            }
        }

    }
</script>
