<template>
    <div>
        <vue-select
            label="name"
            :options="tags"
            :value.sync="selectedTags"
            placeholder="Select Tag(s)"
            multiple
            taggable
            @option:created="createTag"
            >
        </vue-select>
        <select v-show="false" name="tagList[]" multiple>
            <option v-for="option in selectedTags" :value="option.name" v-text="option.id" selected></option>
        </select>
    </div>
</template>

<script>
    import VueSelect from "vue-select";

    export default {
        props: ['post'],

        components: { VueSelect },

        data() {
            return {
                tags: [],
                selectedTags: [],
                endpoint: '/tags',
            };
        },

        created() {
            axios.get(this.endpoint)
                .then(response => {
                    this.tags = response.data;
                    this.selectedTags = this.post ? this.post.tags : [];
                });
        },

        methods: {
            createTag(data) {
                axios.post(this.endpoint, data)
                    .then(({ data }) => {
                        this.tags.push(data);
                        this.selectedTags.forEach(tag => tag.name == data.name ? tag.id = data.id : null);
                    });
            }
        }
    };
</script>

<style>
</style>
