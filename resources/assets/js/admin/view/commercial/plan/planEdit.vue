<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Airbook Plan</div>
            <div class="card-body">
                <form @submit.prevent="updatePlan">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12 d-flex flex-wrap p-0">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input id="name" v-model="name" type="text" name="name"
                                               :class="{'form-control': true, 'is-danger': errors.has('name') }"
                                               data-error="name is required."
                                               v-validate="'required'"
                                        >
                                        <div v-show="errors.has('name')" class="help is-danger">
                                            {{ errors.first('name') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Title *</label>
                                        <input v-model="title" type="text" name="title"
                                               :class="{'form-control': true, 'is-danger': errors.has('title') }"
                                               data-error="title is required."
                                               v-validate="'required'"
                                        >
                                        <div v-show="errors.has('title')" class="help is-danger">
                                            {{ errors.first('title') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Sub Title </label>
                                        <input v-model="sub_title" type="text" name="sub_title"
                                               :class="{'form-control': true, 'is-danger': errors.has('sub_title') }"

                                        >
                                    </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Price *</label>
                                        <input v-model="price" type="number" step="any" name="price"
                                               :class="{'form-control': true, 'is-danger': errors.has('price') }"
                                               data-error="price is required."
                                               v-validate="'required'"
                                        >
                                        <div v-show="errors.has('price')" class="help is-danger">
                                            {{ errors.first('price') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Position *</label>
                                        <v-select
                                                v-model="position"
                                                :options="['Left', 'Center', 'Right']"
                                                name="position"
                                                :class="{ 'is-danger': errors.has('position') }"
                                                v-validate="'required'"
                                        >
                                        </v-select>
                                        <div v-show="errors.has('position')" class="help is-danger">
                                            {{ errors.first('position') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4>Plan Details</h4>
                                <hr>
                                <div class="col-md-12 p-0" v-for="(point,index) in pointsData">
                                    <div class="row">
                                        <div class="col-md-4  ">
                                            <div class="form-group">
                                                <label>Asset type </label>
                                                <v-select
                                                        v-model="point.points_type"
                                                        :options="pointOption"
                                                        label="name"
                                                        name="pointsType"
                                                        :class="{ 'is-danger': errors.has('points_type') }"
                                                >
                                                </v-select>
                                                <div v-show="errors.has('point.points_type')" class="help is-danger">
                                                    {{ errors.first('point.points_type') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 ">
                                            <div class="form-group">
                                                <label>Number of Asset</label>
                                                <input v-model="point.number_points" type="number"
                                                       name="number_points"
                                                       :class="{'form-control': true, 'is-danger': errors.has('point.number_points') }"
                                                >
                                                <div v-show="errors.has('point.number_points')" class="help is-danger">
                                                    {{ errors.first('point.number_points') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="form-group">

                                                <label>Point Text</label>
                                                <input v-model="point.point_text" type="text"
                                                       name="point"
                                                       :class="{'form-control': true, 'is-danger': errors.has('point.point_text') }"
                                                >
                                            </div>

                                        </div>
                                        <div class="col-md-1"  v-if="index!=0">
                                            <button style="height: 47px;" class="btn btn-space btn-danger pr-1 ml-1"
                                                    type="submit"
                                                    @click.prevent="removeRow(index)"
                                            >
                                                <i class="icon mdi mdi-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <button
                                                class="btn btn-space btn-primary pl-2 pr-2"
                                                type="submit"
                                                :disabled="buttonDisabled"
                                                @click.prevent="addRow"

                                        > Add More
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <h4>Other Details</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <vue-ckeditor
                                                v-model="details"
                                                :config="config"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-check mt-4">
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input"
                                           type="radio"
                                           v-model="is_active"
                                           name="is_active"
                                           :value="1">
                                    <span class="custom-control-label">
                                        Publish
                                    </span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input class="custom-control-input"
                                           type="radio"
                                           v-model="is_active"
                                           name="is_active"
                                           :value="0">
                                    <span class="custom-control-label">
                                        Inactive
                                    </span>
                                </label>

                            </div>

                            <div class="col-md-12">
                                <div class="d-flex justify-content-lg-start">
                                    <button class="btn btn-space btn-primary "
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-save"></i>  Update
                                    </button>
                                    <button class="btn btn-space btn-danger "
                                            :disabled="buttonDisabled"
                                            @click.prevent="cancel"
                                    >
                                        <i class="icon mdi mdi-close"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                sError:{},
                name:null,
                is_active:1,
                buttonDisabled:false,
                price:null,
                title:null,
                position:null,
                details:null,
                sub_title:null,
                pointOption: ['Aircraft', 'Engine', 'Apu', 'Part', 'Wanted'],
                pointsData: [],
                config: {
                    toolbar: [
                        { name: 'document', items: [ 'Source', '-', 'Preview',] },
                        { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-',
                            'Undo', 'Redo' ] },
                        { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },

                        '/',
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike',
                            'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                        { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent',
                            'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                            'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                        { name: 'insert', items: [ 'base64image'] },
                        '/',
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                    ],

                    height: 200
                }
            }
        },
        created(){
            this.show(this.$route.params.id)
        },
        methods:{
            addRow() {
                this.pointsData.push({points_type: null, number_points: 0, point_text: null})
            },
            removeRow(index) {
                this.pointsData.splice(index,1)
            },
            show(id){

                axios.get('/admin/commercial/plan/'+id+'/edit').then(response=>{
                    this.name = response.data.name
                    this.title = response.data.title
                    this.sub_title = response.data.sub_title
                    this.price = response.data.price
                    this.position=response.data.position
                    this.details=response.data.details
                    this.pointsData = response.data.points
                    this.is_active = response.data.is_active
                })
            },
            cancel(){
                this.$router.push({path:'/admin/commercial/plan'})
            },
            updatePlan(){
                this.$validator.validateAll().then((result)=>{
                    if (result){
                        axios.patch('/admin/commercial/plan/'+this.$route.params.id,{
                            name:this.name,
                            title:this.title,
                            sub_title:this.sub_title,
                            price:this.price,
                            position:this.position,
                            points:this.pointsData,
                            details:this.details,
                            is_active:this.is_active
                        }).then(response=>{
                            this.buttonDisabled=true
                            this.$root.successMessage(response.data.message)
                            this.buttonDisabled=false
                            this.$validator.reset()
                            this.$router.push({path:response.data.redirection})
                        }).catch(error=>{
                            let err
                            let errs = error.response.data.errors
                            for (err in errs){
                                this.errors.add({
                                    'field':err,
                                    'msg':errs[err][0]
                                })
                            }
                        })
                    }
                })
            }
        }
    }
</script>
