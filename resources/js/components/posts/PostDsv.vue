<template>
<div>
    <div class="container">
        <div class="row">
        <div v-for="(image, index) in arrayImages">
            <div class="col-sm-3 col-xm-3">
            <img class="preview" :src="image">
            <button type="button" @click=deleteImage(index) class="btn btn-primary btn-sm">Удалить</button>
            </div>
        </div>
        </div>
    </div>
                <div class="row">
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Example file input</label>
                        <input type="file" class="form-control-file" @change="previewImage">
                    </div>
                </div>
</div>


</template>
<script>

    export default {
        components:
            {
            },
        data: function () {
            return {
                imageData: "",
                hasImage: false,
                image: null,
                arrayImages: [],
            }
        },

        methods: {
            setImage: function(output) {
                this.hasImage = true;
                this.image = output;
                this.arrayImages.push();
                console.log(this.image);
            },
            deleteImage: function (id) {
                this.arrayImages.splice(id, 1);
                console.log(id);
            },



          previewImage: function(event) {
            // Reference to the DOM input element
            var input = event.target;
            console.log('dsv')
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                // create a new FileReader to read this image and convert to base64 format
                var reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                this.imageData = input.files[0]
                reader.onload = (e) => {
                    // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                    // Read image as base64 and set to imageData
                    this.arrayImages.push(e.target.result);
                    // this.arrayImages.push(input.files[0]);
                }
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(input.files[0]);
            }

            }

        }
    }


</script>

<style>

.file-upload-form, .image-preview {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    padding: 20px;
}
img.preview {
    width: 200px;
    background-color: white;
    border: 1px solid #DDD;
    padding: 5px;
}

</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>