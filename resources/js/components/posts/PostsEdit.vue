<template>
<div>
    <div class="form-group">
        <router-link to="/" class="btn btn-default">Back</router-link>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Create new post</div>
        <div class="panel-body">
        <div class="col-md-6">
            <form v-on:submit="saveForm(post.id)">
                <input type="hidden" name="_token" :value="csrf">
                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label class="control-label">Название</label>
                        <input type="text" v-model="post.title" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="image-preview" v-if="hasImage == false">
                        <img class="preview" :src="postImage(post.image)">
                    </div>
                    <image-uploader
                        :autoRotate=true
                        outputFormat="file"
                        :preview=true
                        :className="['fileinput', { 'fileinput--loaded' : hasImage }]"
                        capture="environment"
                        accept="video/*,image/*"
                        doNotResize="['gif', 'svg']"
                        @input="setImage"
                      ></image-uploader>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                            <multiselect
                                v-model="selectedCategory"
                                :options="categories"
                                track-by="id"
                                label="title"
                                >
                            </multiselect>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                            <multiselect
                                v-model="selectedTags"
                                :options="tags"
                                label="title"
                                track-by="title"
                                :multiple="true"
                                >
                            </multiselect>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 form-group">
                      <label>Дата:</label></br>
                        <date-picker v-model="post.date" lang="ru" valueType="format"></date-picker>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Полный текст</label>
                        <textarea v-model="post.content" cols="30" rows="10" class="form-control" ></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        <button class="btn btn-success">Create</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>

</div>

</template>
<script>

    import Multiselect from 'vue-multiselect'
    import DatePicker from 'vue2-datepicker'
    export default {
        components:
            {
                Multiselect,
                DatePicker
            },
        data: function () {
            return {
                categories: [],
                tags: [],
                selTags: [],
                post: {
                },
                imageData: "",
                hasImage: false,
                image: null,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },

        mounted() {


            var app = this;
            axios.get('/api/admin/vposts/' + this.$route.params.id + '/edit/')
                .then(function (resp) {
                    app.post = resp.data.post
                    app.categories = resp.data.categories
                    app.tags = resp.data.tags
                    app.selTags = resp.data.selTags
                    app.post.tags_id = app.selTags.map(tags => tags.id);


                })
                .catch(function (resp) {
                    alert("Could not load posts");
                });
        },

        computed: {
            selectedCategory: {
                get() {
                   return this.categories.find(category_id => this.post.category_id === category_id.id);
                },
                set(val){
                    this.post.category_id = val.id;
                }
            },

          selectedTags: {
                get() {
                   return this.post.tags;
                },
                set(val){
                    this.post.tags_id = val.map(tags => tags.id);
                    this.post.tags = val.map(tags => tags);
                }
        },

        },

        methods: {
            saveForm(id) {
                event.preventDefault();
                let app = this;
                const config = {
                    headers: { 'Content-type': 'multipart/form-data' }
                }
                let formData = new FormData();

                formData.append('image', app.image)
                formData.append('post', JSON.stringify(app.post))
                formData.append('_method', 'PATCH')

                axios.post('/api/admin/vposts/' + id, formData, config)
                .then(function(response) {
                    app.$router.push({path: '/'});
                }).catch(error => {
                    console.log(error.message);
                })
            },
            setImage: function(output) {
                this.hasImage = true;
                this.image = output;
            },

            postImage: function (pic) {
                return '/uploads/'+pic
            },



          previewImage: function(event) {
            // Reference to the DOM input element
            var input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                // create a new FileReader to read this image and convert to base64 format
                var reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                this.imageData = input.files[0]
                reader.onload = (e) => {
                    // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                    // Read image as base64 and set to imageData
                    this.imageData = input.files[0];
                }
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(input.files[0]);
            }

            }

        },

    }

</script>

<style>

.file-upload-form, .image-preview, .fileinput {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    padding: 20px;
}
.preview, .img-preview  {
    width: 200px;
    background-color: white;
    border: 1px solid #DDD;
    padding: 5px;
    margin: 15px;
}

</style>

<!-- <style src="vue-multiselect/dist/vue-multiselect.min.css"></style> -->