<template>
    <div>
        <multiselect v-model="value" tag-placeholder="Add this as new tag" placeholder="انتخاب دسترسی"
                     label="name" track-by="code" :options="options" :multiple="true" :taggable="true"
                     @tag="addTag"></multiselect>

        <pre class="language-json"><code>{{ value }}</code></pre>

    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            Multiselect
        },
        data() {
            return {
                value: [
                ],
                options: [
                ]
            }
        },
        methods: {
            fetchPermissions() {
                let data = this;
                axios.get('/admin/role/getPermission').then(res => {
                    data.options = res.data;
                });
            },
        },
        mounted: function () {
            this.fetchPermissions();
        },
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
