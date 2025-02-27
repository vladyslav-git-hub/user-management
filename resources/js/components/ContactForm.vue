<template>
    <div class="row justify-content-center">
        <div class="col-6">

            <form @submit.prevent="submitForm" enctype="multipart/form-data" class="">
                <div class="form-group mb-3">
                    <label>Name:</label>
                    <input class="form-control" type="text" v-model="form.name" required />
                    <small class="form-text text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                </div>

                <div class="form-group mb-3">
                    <label>Email:</label>
                    <input class="form-control" type="email" v-model="form.email" required />
                    <small class="form-text text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                </div>

                <div class="form-group mb-3">
                    <label>Phone:</label>
                    <input class="form-control" type="text" v-model="form.phone" required />
                    <small class="form-text text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                </div>

                <div class="form-group mb-3">
                    <label>Message:</label>
                    <textarea class="form-control" v-model="form.message" required></textarea>
                    <small class="form-text text-danger" v-if="errors.message">{{ errors.message[0] }}</small>
                </div>

                <div class="form-group mb-3">
                    <label>Street:</label>
                    <input class="form-control" type="text" v-model="form.street" required />
                </div>

                <div class="form-group mb-3">
                    <label>State:</label>
                    <input class="form-control" type="text" v-model="form.state" required />
                </div>

                <div class="form-group mb-3">
                    <label>Zip:</label>
                    <input class="form-control" type="text" v-model="form.zip" required />
                </div>

                <div class="form-group mb-3">
                    <label>Country:</label>
                    <input class="form-control" type="text" v-model="form.country" required />
                </div>

                <div class="form-group mb-3">
                    <label>Images (JPG only):</label>
                    <input class="form-control" type="file" @change="handleImage" accept="image/jpeg" multiple />
                    <small class="form-text text-danger" v-if="errors.images">{{ errors.images[0] }}</small>
                </div>

                <div class="form-group mb-3">
                    <label>Files (PDF only):</label>
                    <input class="form-control" type="file" @change="handleFile" accept="application/pdf" multiple />
                </div>

                <button type="submit" class="btn btn-info">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                phone: "",
                message: "",
                street: "",
                state: "",
                zip: "",
                country: "",
                images: [],
                files: []
            },
            errors: {}
        };
    },
    methods: {
        handleImage(event) {
            this.form.images = event.target.files;
        },
        handleFile(event) {
            this.form.files = event.target.files;
        },
        async submitForm() {
            let formData = new FormData();
            formData.append("name", this.form.name);
            formData.append("email", this.form.email);
            formData.append("phone", this.form.phone);
            formData.append("message", this.form.message);
            formData.append("street", this.form.street);
            formData.append("state", this.form.state);
            formData.append("zip", this.form.zip);
            formData.append("country", this.form.country);

            for (let i = 0; i < this.form.images.length; i++) {
                formData.append("images[]", this.form.images[i]);
            }

            for (let i = 0; i < this.form.files.length; i++) {
                formData.append("files[]", this.form.files[i]);
            }

            try {
                const response = await axios.post("/submit-form", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                });
                alert("Form submitted successfully!");
            } catch (error) {
                this.errors = error.response.data.errors;
            }
        }
    }
};
</script>
