<template>
    <div>
        <div class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <div class="row be-datatable-header card-header">
                <div class="col-md-12 d-flex justify-content-between" id="adjustHeader">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="cateTitle">{{tableHeadline}}</div>
                    </div>
                    <div class="aircraftAssetsSection">
                        <div v-if="this.dropDownSearch.length>0" class="selectedArea">
                            <div v-for="(dropdown, index) in dropDownSearch" class="d-flex justify-content-center align-items-center">
                                <label class="control-label" style="text-transform: capitalize;    padding-top: 4px;">{{dropdown.label}}</label>
                                <select :name="dropdown.column" v-model="dropDownSearch[index].selected" @change="getResult()" class="assetSelection">
                                    <option value="">All Assets</option>
                                    <option :value="option" v-for="option in dropdown.value">{{option}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group input-search dataTables_filter  mr-2" v-if="search && $root.$data.showPermission" id="catSearch">
                            <input class="form-control form-control-sm" type="text" v-model="searchValue" placeholder="Search" @keyup="getResult(page = 1)">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary">
                                    <i class="icon mdi mdi-search"></i>
                                </button>
                            </span>
                        </div>
                        <template v-if="addButton && $root.$data.createPermission">
                            <router-link :to="{name:addLink}" class="btn btn-primary  pt-1 pb-1 pl-5 pr-5 mr-2"> <i class="icon mdi mdi-plus pr-1"></i> Add </router-link>
                        </template>

                        <div class="btn-group">
                            <span class="icon mdi mdi-more-vert dropdown-toggle moreVert"
                                  data-toggle="dropdown"
                                  aria-haspopup="true"
                                  aria-expanded="false">
                            </span>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button" @click.prevent="doExport">Export</button>
                                <label for="import" class="adminImport dropdown-item"> Import </label>
                                <form id="importForm" method="post" :action="'/admin/import/data/'+modelName" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" :value="csrf"/>
                                    <input type="file" name="file" id="import" class="importFile" @input="doImport">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row be-datatable-body" v-if="dataList.length">
                <div class="col-sm-12" style="overflow-x: auto;" v-if="$root.$data.showPermission">
                    <table class="table table-striped table-hover table-fw-widget dataTable no-footer table_block" id="table1"
                           role="grid" aria-describedby="table1_info">
                        <thead>
                        <tr role="row">
                            <th v-for="(column, index) in columns" class="sorting"
                                tabindex="0"
                                rowspan="1"
                                colspan="1"
                                :id="column.field"
                                :nest = 'column.nested'
                                @click="onClickColumn">
                                {{column.name}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="data in dataList">
                            <slot name="items" v-bind:data="data">
                            </slot>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="center-screen" v-else>
                <atom-spinner :color="'#4285f4'"></atom-spinner>
            </div>
            <div class="row be-datatable-footer">
                <div class="col-sm-5 d-flex align-items-center flex-wrap" id="bottomAdjust">
                    <div class="dataTables_length">
                        <label>Show
                            <select style="text-align-last: center; height: 24px;" name="table1_length" id="resultPerPage"
                                    aria-controls="table1"
                                    class="form-control form-control-sm customShown" @change="onChangePerPage">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select> Entries &nbsp;</label>
                    </div>
                    <div class="dataTables_info" id="table1_info" role="status" aria-live="polite"  v-if="$root.$data.showPermission">
                        ( Showing {{from}} to
                        {{to}}
                        of {{total}} )
                    </div>
                </div>
                <div class="col-sm-7" id="adjustPagination">
                    <div class="dataTables_paginate paging_simple_numbers mt-1" v-if="paging">
                        <ul class="pagination">
                            <li :class="{'paginate_button': true, 'page-item':true, 'previous':true, 'disabled':(current_page === 1)}"
                                id="table1_previous">
                                <a tabindex="0" class="page-link" @click="getResult(current_page - 1)">Previous</a>
                            </li>
                            <template v-for="page in last_page">
                                <li :class="{'paginate_button': true, 'page-item':true, 'active':(page === current_page)}"
                                    v-if="Math.abs(page - current_page) < 3">
                                    <a tabindex="0" class="page-link" @click="getResult(page)">{{page}}</a>
                                </li>
                            </template>
                            <li :class="{'paginate_button': true, 'page-item':true, 'next':true, 'disabled':(current_page === last_page)}"
                                id="table1_next">
                                <a tabindex="0" class="page-link" @click="getResult(current_page + 1)">Next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    export default {

        props: {


            data: {
                type: Array,
                default: () => []
            },
            columns: {
                type: Array,
                default: () => []
            },

            ajax: {
                type: Object,
                default: () => {
                }
            },
            paging: {
                type: Boolean,
                default: () => true
            },
            scrollX: {
                type: Boolean,
                default: () => false
            },
            scrollY: {
                type: Boolean,
                default: () => false
            },
            select: {
                type: Boolean,
                default: () => false
            },
            search: {
                type: Boolean,
                default: () => false
            },
            sorting: {
                type: Boolean,
                default: () => true
            },
            addLink: {
                type: String,
                default: () => ''
            },
            tableHeadline:{
                type:String,
                default:()=>''
            },
            searchField:{
                type:String,
                default:()=>''
            },
            dropDownSearch:{
                type:Array,
                default:()=>[]
            },
            addButton:{
                type:Boolean,
                default:()=>true
            },
            modelName:{
                type:String,
                default:()=>''
            },
            typeName:{
                type:String,
                default:()=>''
            }

        },
        mounted(){
            this.csrf=document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        },
        data() {
            return {
                csrf: '',
                dataList: [],
                columnList: [],
                sortName: 'id',
                sortOrder: 'desc',
                current_page: 1,
                last_page: 0,
                per_page: 0,
                total: 0,
                path: '',
                from: 0,
                to: 0,
                pageLimit: 10,
                resultPerPage: 10,
                options: [
                    {id: 1, label: 'foo'},
                    {id: 3, label: 'bar'},
                    {id: 2, label: 'baz'},
                ],
                selected: {id: 3, label: 'bar'},
                searchValue:null,
            }
        },

        computed:{

        },

        created() {
            if (_.isEmpty(this.ajax)) {
                this.dataList = this.data
            } else {
                this.getResult()
            }
        },
        methods: {
            onClickColumn(e) {
                if (this.sorting) {

                    let sortname = $(e.target).text().trim().toLowerCase().replace(' ', '_')

                    let nest = e.target.getAttribute('nest')

                    if(nest){
                        sortname = nest
                    }

                    this.sortName = sortname != 'action' ? sortname : 'id'
//                    this.sortName = e.target.id
                    if (e.target.classList[0] === 'sorting') {
                        e.target.classList.remove('sorting')
                        e.target.classList.add('sorting_asc')
                        this.sortOrder = 'asc'
                    } else if (e.target.classList[0] === 'sorting_asc') {
                        e.target.classList.remove('sorting_asc')
                        e.target.classList.add('sorting_desc')
                        this.sortOrder = 'desc'
                    } else if (e.target.classList[0] === 'sorting_desc') {
                        e.target.classList.remove('sorting_desc')
                        e.target.classList.add('sorting_asc')
                        this.sortOrder = 'asc'
                    }
                    this.removeAllSorting(e.target.parentElement.childNodes, e)
                    this.getResult()
                }
            },
            removeAllSorting(childList, e) {
                for (var i = 0; i < childList.length; i++) {
                    if (childList[i].id === e.target.id) continue
                    childList[i].classList.remove('sorting_asc')
                    childList[i].classList.remove('sorting_desc')
                    childList[i].classList.add('sorting')
                }
            },
            getResult(page = 1) {
                this.current_page = page
                if (!_.isEmpty(this.ajax)) {
                    axios.get(this.ajax.url, {
                        params: {
                            sortName: this.sortName=='status'?'is_active':this.sortName,
                            sortOrder: this.sortOrder,
                            paging: this.paging,
                            page: page,
                            resultPerPage: this.resultPerPage,
                            searchKey: this.searchField,
                            searchValue: this.searchValue,
                            dropDownSearch:this.dropDownSearch.length>0?JSON.stringify(this.dropDownSearch):null
                        }
                    }).then(response => {
                        if (this.paging) {
                            this.dataList = response.data.data
                            this.current_page = response.data.current_page
                            this.last_page = response.data.last_page
                            this.per_page = response.data.per_page
                            this.total = response.data.total
                            this.path = response.data.path
                            this.from = response.data.from
                            this.to = response.data.to
                        } else {
                            this.dataList = response.data
                        }
                    });
                }
            },
            onChangePerPage() {
                this.resultPerPage = document.getElementById('resultPerPage').value;
                this.getResult()
            },
            doExport(){
                if(['manufacturer','news','event'].includes(this.modelName)){
                    window.location = '/admin/with-pivot/export/'+this.modelName+'/'+this.typeName;
                }else{
                    window.location = '/admin/export/'+this.modelName+'/'+this.typeName;
                }
            },
            doImport(){
                let formElement=document.getElementById('importForm')
                formElement.submit();
            }

        }
    }
</script>

<style scoped>

    .btn{
        line-height: 25px;
    }

</style>
