<template>
    <b-form-group
            :id="'fieldset-' + id"
            label-cols-sm="4"
            label-cols-lg="3"
            :label="label"
            :label-for="id"
            label-align-sm="label_align"
            :aria-describedby="id + '-feedback'"
    >
        <b-form-select
                :value="value"
                :name="name"
                :state="(error === undefined ? true : error)"
                @input="$emit('input', $event); $emit('validate')">
            <b-form-select-option v-for="option in options" :key="option.id" :value="option.id">{{ option.name }}</b-form-select-option>
        </b-form-select>

        <b-form-invalid-feedback id="currency-id-feedback">
            {{ error_text }}
        </b-form-invalid-feedback>
    </b-form-group>
</template>

<script>
    import {FormGroupPlugin, FormSelectPlugin, FormPlugin } from 'bootstrap-vue'
    Vue.use(FormGroupPlugin)
    Vue.use(FormSelectPlugin)
    Vue.use(FormPlugin)

    export default {
        props: {
            id: { required: true },
            label: { required: true },
            name: { required: true },
            value: { required: true },
            error: { required: true },
            error_text: { required: true },
            label_align: { default: 'left' },
            options: { required: true },
        }
    };
</script>