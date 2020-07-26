<template>
    <b-form-group
            :id="'fieldset-' + id"
            label-cols-sm="4"
            label-cols-lg="3"
            :label="label"
            :label-for="id"
            :label-align-sm="label_align"
            :aria-describedby="id + '-feedback'"
    >
        <b-form-input :id="id"
                      :name="name"
                      :type="type"
                      :value="value"
                      :state="(error === undefined ? true : error)"
                      @input="$emit('input', $event)"
                      @blur="$emit('validate')"
                      @keypress="$emit('validate')">
        </b-form-input>

        <b-form-invalid-feedback :id="id + '-feedback'">
            {{ error_text }}
        </b-form-invalid-feedback>
    </b-form-group>
</template>

<script>
    import {FormGroupPlugin, FormInputPlugin, FormPlugin } from 'bootstrap-vue'
    Vue.use(FormGroupPlugin)
    Vue.use(FormInputPlugin)
    Vue.use(FormPlugin)

    export default {
        props: {
            id: { required: true },
            type: { required: true },
            label: { required: true },
            name: { required: true },
            value: { required: true },
            error: { required: true },
            error_text: { required: true },
            label_align: { default: 'left' }
        }
    };
</script>