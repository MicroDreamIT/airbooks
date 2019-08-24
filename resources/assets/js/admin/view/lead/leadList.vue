<template>
    <div class="card card-table custom-title-adjust">
        <data-table-join
                ref="dataTable"
                :search="true"
                :columns="columns"
                :tableHeadline="'Leads'"
                :searchField="'leads.title'"
                :addButton="false"

                :ajax="{
                        url: url
                    }"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <template v-if="props.data.leadable">
                        <a :href="'/'+props.data.leadable.modelType+'/'+props.data.leadable.linkify" target="_blank" class="own-underline">
                            {{getTitleByData(props.data)|filterTitle}}
                        </a>
                    </template>
                </td>
                <td>
                    <template v-if="props.data.user">
                        <template v-if="props.data.user.contact">
                            <a :href="'/'+props.data.user.contact.modelType+'/'+props.data.user.contact.linkify" target="_blank" class="own-underline">
                                {{props.data.user.contact|fullName}}
                            </a>
                        </template>
                    </template>


                </td>
                <td>
                    <template v-if="props.data.user">
                        <template v-if="props.data.user.contact">
                            <template v-if="props.data.user.contact.company">
                                <a :href="'/company/'+props.data.user.contact.company.linkify" target="_blank" class="own-underline">
                                    {{props.data.user.contact.company.name}}
                                </a>
                            </template>
                        </template>
                    </template>

                </td>
                <td>
                    <a href="" @click.prevent>
                        {{props.data.lead_status}}
                    </a>
                </td>
                <td>
                    <a href="" @click.prevent>
                        {{props.data.created_at|moment('DD/MM/YYYY')}}
                    </a>
                </td>
                <td class="leads-action">
                        <div class="adjustAction">
                            <a @click.prevent="callLeadLIst(props.data)"  href="" v-if="$root.$data.editPermission">
                                <i class="mdi mdi-eye"></i>
                            </a>
                        </div>
                        <div class="adjustAction">
                            <a @click.prevent="deleteMe(props.data)" href="" v-if="$root.$data.deletePermission">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>
                </td>
            </template>
        </data-table-join>

        <div v-if="leadList" class="lead-List-Modal">

            <div class="card w-50 lead-list-area">
                <div class="card-header ">
                    Lead Deatils
                </div>
                <div class="card-body pl-4 pr-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex flex-column">
                            <span>Lead Title</span>
                            <span>{{getTitleByData(modelInfo)|filterTitle}}</span>
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <span>Contact</span>
                            <span>{{modelInfo.leadable.user.contact|fullName}}</span>
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <span>Company</span>
                            <span>{{modelInfo.leadable.user.contact.company.name}}</span>
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <span>Status</span>
                            <span>{{modelInfo.lead_status}}</span>
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <span>Date</span>
                            <span>{{modelInfo.created_at|moment('DD/MM/YYYY')}}</span>
                        </li>
                        <li class="list-group-item d-flex flex-column">
                            <span>Message</span>
                            <span>{{modelInfo.message}}</span>
                        </li>

                    </ul>
                </div>
                <div class="card-footer text-muted">
                    <button class="btn btn-primary float-right mb-2" @click.prevent="closeLeads">Close</button>

                </div>
                <p></p>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                modelInfo:{},
                leadList:false,
                url: '/ajax/lead',
                columns: [
                    {name: 'Lead Title',nested:'title'},
                    {name: 'Contact',nested:'contact'},
                    {name: 'Company',nested:'company'},
                    {name: 'Status',nested:'lead_status'},
                    {name: 'Date',nested:'created_at'},
                    {name: 'Action'},
                ]
            }
        },

        methods: {

            callLeadLIst(item){
                this.leadList = true
                let catchBody = document.getElementsByTagName("body")[0];
                catchBody.style='overflow:hidden;'
                this.modelInfo=item;
//                if(item.lead_status=='Unread'){
//                    axios.patch('/admin/lead/'+ item.id, item).then(res=>{
//                        var dataTable = this.$refs.dataTable
//                        dataTable.getResult();
//                    })
//                }


            },
            closeLeads(){
                this.leadList = false
                let catchBody = document.getElementsByTagName("body")[0];
                catchBody.style='overflow:visible;'
            },

            deleteMe(data) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/admin/lead/' + data.id,{
                            data:data,
                        }).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            },

            getTitleByData(value){
                if(value){
                    let withFor = value.leadable_type.replace(/[-_.]/g,' ')
                    let whereIsForIndex
                    whereIsForIndex = withFor.indexOf('\\')
                    let model =(withFor.substring(whereIsForIndex+1)).toLocaleLowerCase()
                    if(['aircraft','engine','apu','wanted','news','event'].includes(model)){
                        return value.leadable.title
                    }else if(['company','airport'].includes(model)){
                        return value.leadable.name
                    }else{
                        return value.leadable.first_name+' '+value.leadable.last_name
                    }
                }
            }

        }

    }
</script>
