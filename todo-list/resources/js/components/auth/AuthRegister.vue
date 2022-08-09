<template>
    <div class="col-md-6 pt-5 pt-sm-3">
        <div class="card">
            <div class="card-body">
                <h2 class="h4 mb-3">No account? Sign up</h2>
                <form class="needs-validation" novalidate="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-fn">Full name</label>
                                <input
                                    v-model="RegisterForm.name"
                                    @keyup.stop="onRegisterInput('name')"
                                    class="form-control"
                                    type="text" required="" id="reg-fn"
                                >
                                <div class="invalid-feedback" :class="displayErrorMessage('name')">{{ ErrorFormResponse.name }}</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-email">E-mail Address</label>
                                <input
                                    v-model="RegisterForm.email"
                                    @keyup.stop="onRegisterInput('email')"
                                    class="form-control"
                                    type="email"
                                    id="reg-email"
                                >
                                <div class="invalid-feedback" :class="displayErrorMessage('email')">{{ ErrorFormResponse.email }}</div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="reg-password">password</label>
                                <input
                                    v-model="RegisterForm.password"
                                    @keyup.stop="onRegisterInput('password')"
                                    class="form-control"
                                    type="password"
                                    id="reg-password">
                                <div class="invalid-feedback" :class="displayErrorMessage('password')">{{ ErrorFormResponse.password }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button class="btn btn-primary" type="submit" @click.prevent="submitRegisterForm">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    name: "AuthRegister",
    data() {
        return {
            RegisterForm: {
                name : '',
                email: '',
                password : ''
            },
            ErrorFormResponse : {
                name : '',
                email: '',
                password : '',
            },
            RegisterFormData : []
        }
    },
    methods: {
        ...mapActions('loginModule',['doSendRegisterForm']),
        /**
         * Submit register form on api
         * @returns {Promise<void>}
         */
        async submitRegisterForm() {
            this.saveRegisterFormToData();
            await this.doSendRegisterForm(this.RegisterFormData)
                .then(() => {
                    this.$swal({icon: 'success', title: 'Signed-Up', text: 'Successfully Registered'});
                    this.resetSignUpForm();
                })
                .catch((response) => {
                    const self = this;
                    this.$swal({icon: 'error', title: 'Oops...', text: 'Failed to Register User'});
                    $.each(response.data.message, function (key, message) {
                        self.ErrorFormResponse[key] = message[0];
                    })
                });
        },
        /**
         * reset sign up inputs
         */
        resetSignUpForm() {
            this.RegisterForm = {
                name : '',
                email: '',
                password : ''
            }
        },
        /**
         * save register inputs to form data
         */
        saveRegisterFormToData() {
            this.RegisterFormData = new FormData();
            this.RegisterFormData.append('name', this.RegisterForm.name);
            this.RegisterFormData.append('email', this.RegisterForm.email);
            this.RegisterFormData.append('password', this.RegisterForm.password);
        },
        /**
         * display error message
         * @param index
         * @returns {string}
         */
        displayErrorMessage(index) {
            let errorResponses = this.ErrorFormResponse;
            return (errorResponses[index].length > 0) ? 'd-block' : '';
        },
        /**
         * Keyup event handler
         * @param index
         */
        onRegisterInput(index) {
            this.ErrorFormResponse[index] = '';
        }
    }
}
</script>

<style scoped>

</style>
