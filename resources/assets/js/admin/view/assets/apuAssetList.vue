<template>
    <div class="card card-table">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :addButton="false"
                :tableHeadline="'APU Assets'"
                :searchField="'apus.title,apus.serial_number'"
                :dropDownSearch="this.dropdownSearch"
                :modelName="'apu'"
                :ajax="{
                            url: url
                        }"
        >
            <template slot="items" slot-scope="props">

                <td>
                    <router-link :to="{name:'adminApuShow', params:{id:props.data.id+'-'+props.data.title}}">
                        {{props.data.title.replace(/-/g, ' ')}}
                    </router-link>
                </td>
                <td>
                    <router-link :to="{name:''}">
                        {{props.data.serial_number}}
                    </router-link>
                </td>
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
                status: null,
                dropdownSearch:[
                    {label:'Filter',column:'isActiveStatus', value:['Pending Approval','Approved','Revise','Rejected'], selected:''},
                ],
                url: '/ajax/apu',
                columns: [
                    {name: 'Title'},
                    {name: 'SN', nested:'apus.serial_number'},
                    {name: 'Status', nested:'apus.isActiveStatus'},
                    {name: 'Action'},

                ]
            }
        },
        methods:{
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
                            return  axios.patch('/admin/apu/single-update/'+id+'/isActiveStatus/edit', {value:login})
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

                    axios.patch('/admin/apu/single-update/'+id+'/isActiveStatus/edit', {value:status})
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



            },
            deleteMe(id) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/apu/' + id).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            },
        }

    }
</script>
