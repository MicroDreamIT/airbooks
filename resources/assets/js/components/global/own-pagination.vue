<template>
    <div>
        <div class="pagination-block" v-if="setPage">
            <button  :class="{'pagination-button w-button':true, 'own-btn-disabled':currentPage==1}"
                     :disabled="currentPage==1" @click.prevent="goToPrevious()">Previous</button>

            <button :class="{'pagination-button w-button':true, 'own-btn-disabled':currentPage==lastPage}"
                    :disabled="currentPage==lastPage" @click.prevent="goToNext()">Next</button>
        </div>

        <div class="no-results-block" v-if="showNoMatchText">
            <div class="no-result-exclamation"></div>
            <div class="no-results-message">
                We couldn't find results to match your search.
                Please try again with different keywords.
            </div>
        </div>

    </div>
</template>

<script>

    export default {
        props:['pagination-data'],
        data() {
            return {
                currentPage:1,
                lastPage:1,
                showNoMatchText:false
            }

        },
        computed:{
            setPage(){
                if(this.paginationData.current_page){
                    if(!this.paginationData.data.length){
                        this.showNoMatchText=true
                        return false
                    }

                    this.currentPage=this.paginationData.current_page
                    this.lastPage=this.paginationData.last_page
                    this.showNoMatchText=false
                    return true
                }


            }
        },
        methods:{
            goToNext(){
//                this.$parent.getData(true,this.currentPage+1)
                this.$parent.$refs.sideBarRef.getDataBySidebarSearch(this.currentPage+1)
            },
            goToPrevious(){
//                this.$parent.getData(currentPage-1)
                this.$parent.$refs.sideBarRef.getDataBySidebarSearch(this.currentPage-1)
            }
        }
    }
</script>