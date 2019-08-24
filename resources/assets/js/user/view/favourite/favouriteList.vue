<template>
    <div class="card card-table">
        <data-table-user
                ref="dataTable"
                :search="true"
                :columns="columns"
                :tableHeadline="'Favourites'"
                :searchField="'favouritable.title'"
                :addButton="false"

                :ajax="{
                        url: url
                    }"
        >
            <template slot="items" slot-scope="props">
                <td>
                    <template v-if="props.data.favouritable">
                        <a href="" @click.prevent="goToFavourite(props.data.favouritable)" class="own-underline">
                            {{getTitleByData(props.data)|filterTitle}}
                        </a>
                    </template>
                </td>
                <td>
                    <div class="adjustAction">
                        <a @click.prevent="deleteMe(props.data.favouritable)" href="">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    </div>
                </td>
            </template>
        </data-table-user>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                url: '/ajax/favourite',
                columns: [
                    {name: 'Title'},
                    {name: 'Action'},
                ]
            }
        },
        methods: {

            deleteMe(data) {
                this.$root.confirmationDelete().then(val => {
                    if (val) {
                        axios.delete('/user/ajax/favourite/' + data.id,{
                            data:data,
                        }).then(response => {
                            var dataTable = this.$refs.dataTable
                            dataTable.getResult();
                            this.$root.alertMessage(response.data.message)
                        });
                    }
                });
            },
            goToFavourite(data){

                window.open('/'+data.modelType+'/'+data.linkify, '_blank')
            },
            getTitleByData(value){
                if(value){
                    let withFor = value.favouritable_type.replace(/[-_.]/g,' ')
                    let whereIsForIndex
                    whereIsForIndex = withFor.indexOf('\\')
                    let model =(withFor.substring(whereIsForIndex+1)).toLocaleLowerCase()
                    if(['aircraft','engine','apu','wanted','news','event'].includes(model)){
                        return value.favouritable.title
                    }else if(['company','airport'].includes(model)){
                        return value.favouritable.name
                    }else{
                        return value.favouritable.first_name+' '+value.favouritable.last_name
                    }
                }
            }
        }

    }
</script>
