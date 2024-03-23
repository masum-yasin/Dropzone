<script>
import vueDropzone from "dropzone-vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    components: {
        vueDropzone,
    },
    setup() {
        const form = useForm({
            files: [], // Store multiple files in an array
        });

        const submit = () => {
            // Add CSRF token to form data
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            form.files.forEach(file => formData.append('files[]', file));

            // Post form data
            fetch('/file/upload', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Files uploaded successfully!");
                    form.reset();
                } else {
                    alert("File upload failed: " + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert("File upload failed!");
            });
        };

        return {
            form,
            submit,
            dropzoneOptions: {
                url: "/file/upload", // Set to "#" because we're handling upload manually
                thumbnailWidth: 150,
                maxFilesize: 10240,
                headers: { "My-Awesome-Header": "header value" },
                addRemoveLinks: true, // Optional: Adds remove links for each file
                uploadMultiple: true, // Enable multiple file uploads
            },
        };
    },
};
</script>

<!-- <script>
import vueDropzone from "dropzone-vue3";
import { useForm } from "@inertiajs/vue3";

export default {
    components: {
        vueDropzone,
    },
    setup() {
        const form = useForm({
            files: [], // Store multiple files in an array
        });

        const submit = () => {
            form.post(route("file.upload"), {
                onSuccess: (response) => {
                    alert(response.data.message); // Show success message from the server
                    form.reset();
                },
                onError: () => {
                    alert("File upload failed!");
                },
            });
        };

        return {
            form,
            submit,
            dropzoneOptions: {
                url: "/file/upload",
                thumbnailWidth: 150,
                maxFilesize: 10240,
                headers: { "My-Awesome-Header": "header value" },
                addRemoveLinks: true, // Optional: Adds remove links for each file
                uploadMultiple: true, // Enable multiple file uploads
                // You can add more Dropzone options as needed
            },
        };
    },
};
</script> -->


<template>
    <div class="container">
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <h3>Dropzone File Upload</h3>
            <vue-dropzone
                ref="myVueDropzone"
                id="dropzone"
                v-model:files="form.files"
                :options="dropzoneOptions"
            />
        </form>
    </div>
</template>

<style></style>
