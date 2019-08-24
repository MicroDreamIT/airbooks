<template>
    <div>
        <div class="card card-border-color card-border-color-primary">
            <div class="card-header card-header-divider">Parts</div>
            <div class="card-body">
                <form @submit.prevent="postParts">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Part Number *</label>
                                    <input v-model="parts.part_number" type="text" name="part_number"
                                           :class="{'form-control': true, 'is-danger': errors.has('part_number') }"
                                           data-error="name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('part_number')" class="help is-danger">
                                        {{ errors.first('part_number') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Alternate Part Numbers </label>
                                    <input v-model="parts.alternate_part_number" type="text" name="alternate_part_number"
                                           :class="{'form-control': true, 'is-danger': errors.has('alternate_part_number') }"
                                    >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Condition *</label>
                                    <v-select
                                            v-model="parts.condition"
                                            :options="conditions"
                                            label="name"
                                            name="condition"
                                            :class="{ 'is-danger': errors.has('condition') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('condition')" class="help is-danger">
                                        {{ errors.first('condition') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Quantity *</label>
                                    <input v-model="parts.quantity" type="number" name="quantity"
                                           :class="{'form-control': true, 'is-danger': errors.has('quantity') }"
                                           data-error="name is required."
                                           v-validate="'required'"
                                    >
                                    <div v-show="errors.has('quantity')" class="help is-danger">
                                        {{ errors.first('quantity') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Primary Contact *</label>
                                    <v-select
                                            v-model="parts.primary_contact"
                                            :options="$root.$data.contacts"
                                            :get-option-label="$root.getFullName"
                                            label="first_name"
                                            name="primary_contact"
                                            :class="{ 'is-danger': errors.has('primary_contact') }"
                                            v-validate="'required'"
                                    >
                                    </v-select>
                                    <div v-show="errors.has('primary_contact')" class="help is-danger">
                                        {{ errors.first('primary_contact') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" v-model="parts.description" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex flex-wrap justify-content-start mt-2  ">
                                <div v-for="(frm, index) in parts.custom" class="form-inline customFormItem ml-0 mr-4  p-0">
                                    <label class="pt-2 pb-2 pr-2 pl-2 "> {{ frm.name | removeACharacter('_') }} </label>
                                    <input :type="frm.type"
                                           :name="frm.name"
                                           class="form-control"
                                           v-model="frm.value"
                                           :ref="'forms'"
                                           v-validate="'required'"
                                           v-if="frm.type=='text' || frm.type=='number'">

                                    <v-select v-if="frm.type=='select'"
                                              v-model="frm.value"
                                              :options="frm.options"
                                              label="name"
                                              name="offer"
                                              :ref="'forms'"
                                              :class="{ 'is-danger': errors.has('offer') }"
                                              v-validate="'required'"
                                    >
                                    </v-select>


                                    <date-picker v-if="frm.type=='date'"
                                                 :name="frm.name"
                                                 v-model="frm.value"
                                                 ref="datePicker1"
                                                 class="form-control"
                                                 v-else>
                                    </date-picker>
                                    <button @click.prevent="deleteForm(index)"
                                            class="btn deleteBtn"
                                    >
                                        <i class="icon mdi mdi-close"></i>
                                    </button>
                                </div>
                            </div>

                            <div class=" col-md-12  ">
                                <div class="custom_form_add">
                                    <select v-model="formName" class="form-control"
                                            @change="formName!='custom'?addForms():''" >

                                        <option :value="label" v-for="label in fixedLabel">
                                            {{ label | removeACharacter('_') }}
                                        </option>

                                    </select>
                                    <div v-if="formName=='custom'">
                                        <input type="text"
                                               v-model="formLabel"
                                               @keyup.enter="addForms()"
                                               placeholder="custom label" autofocus class="form-control mt-3">
                                    </div>

                                    <button type="submit" @click.prevent="addForms()"
                                            v-if="formLabel && formName" class="btn btn-space btn-primary mt-2 pl-3 pr-3 ">
                                        <i class="icon mdi mdi-plus pr-1"></i>  Add Field
                                    </button>
                                </div>
                            </div>
    
                            
                            <div class="col-md-12 mt-3">
                                <div class="d-flex justify-content-start flex-wrap">
                                    
                                    <button class="btn btn-space btn-primary pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                            @click.prevent="saveAndClose"
                                    >
                                        <i class="icon mdi mdi-save"></i> Save & Close
                                    </button>
                                    <button class="btn btn-space btn-success pl-4 pr-4"
                                            type="submit"
                                            :disabled="buttonDisabled"
                                    >
                                        <i class="icon mdi mdi-refresh-sync"></i> Save & New
                                    </button>
                                    <button class="btn btn-space btn-danger pl-4 pr-4"
                                            type="submit"
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

<script src="./js/partsCreate.js"></script>

