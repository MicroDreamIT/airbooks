<template>
    <div>
        <div class="modal-container modal-effect-1 modal-show cusmodal" id="nft-default">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close modal-close" type="button" data-dismiss="modal" aria-hidden="true"><span
                            @click.prevent="$emit('suggestModalData', false)" class="mdi mdi-close"></span></button>
                </div>
                <div class="text-center">
                    <h3>Suggest {{fieldtype|capitalize}} Information</h3>
                    <hr>
                </div>
                <div class="modal-body">
                    <p align="center" class="text-danger">{{message}}</p>
                    <form class="pr-5 pl-5" @submit.prevent="postSuggest">
                        <div class="form-group row mt-2" v-if="categoryField">
                            <label class="col-3 col-lg-2 col-form-label text-right">Category</label>
                            <div class="col-9 col-lg-10">
                                <input class="form-control" type="text" v-model="category">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 col-lg-2 col-form-label text-right">Manufacture</label>
                            <div class="col-9 col-lg-10">
                                <input class="form-control" type="text" v-model="manufacturer">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 col-lg-2 col-form-label text-right">Type</label>
                            <div class="col-9 col-lg-10">
                                <input class="form-control" type="text" v-model="type">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3 col-lg-2 col-form-label text-right">Model</label>
                            <div class="col-9 col-lg-10">
                                <input class="form-control" type="text" v-model="model">
                            </div>
                        </div>
                        <div class="form-group row">
	                        <label class="col-3 col-lg-2 col-form-label text-right"> </label>
                            <div class="col-9 col-lg-10">
                                <p class="own-right">
	                                <button class="btn btn-space btn-secondary"
	                                        @click.prevent="$emit('suggestModalData', false)">Cancel
	                                </button>
                                    <button class="btn btn-space btn-primary" type="submit">Submit</button>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            categoryField: {
                type: Boolean,
                default: () => true
            },
            fieldtype: {
                type: String,
                default: () => ''
            }

        },
        data() {
            return {
                suggestModal: false,
                category: '',
                manufacturer: '',
                type: '',
                model: '',
                message: '',
            }
        },
        methods: {
            postSuggest() {
                if (this.category || this.manufacturer || this.type || this.model) {
                    axios.post('/user/ajax/suggestion', {
                        category: this.category,
                        manufacturer: this.manufacturer,
                        type: this.type,
                        model: this.model,
                        entity_type: this.fieldtype
                    }).then(response => {
                        this.message = ""
                        this.category = ''
                        this.manufacturer = ''
                        this.type = ''
                        this.model = ''
                        this.$root.successMessage(response.data)
                        console.log(response.data)
                        this.$emit('suggestModalData', false)

                    })
                } else {
                    this.message = "Please select at least one field"
                }
            }
        }

    }
</script>
