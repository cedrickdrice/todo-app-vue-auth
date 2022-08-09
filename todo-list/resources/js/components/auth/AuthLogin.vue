<template>
    <div class="col-md-6 pt-sm-3">
        <div class="card">
            <div class="card-body">
                <h2 class="h4 mb-1">Sign in</h2>
                <hr>
                <form class="needs-validation" novalidate="">
                    <div class="input-group form-group">
                        <div class="input-group-prepend"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span></div>
                        <input
                            class="form-control"
                            v-model="LoginForm.email"
                            @keyup.stop="onLoginInput('email')"
                            type="email"
                            placeholder="Email"
                            required=""
                        >
                        <div class="invalid-feedback" :class="displayErrorMessage('email')">{{ ErrorFormResponse.email }}</div>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend"><span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span></div>
                        <input
                            class="form-control"
                            v-model="LoginForm.password"
                            @keyup.stop="onLoginInput('password')"
                            type="password"
                            placeholder="password"
                            required=""
                        >
                        <div class="invalid-feedback" :class="displayErrorMessage('password')">{{ ErrorFormResponse.password }}</div>
                    </div>
                    <hr class="mt-4">
                    <div class="text-right pt-4">
                        <button class="btn btn-primary" type="submit" @click.prevent="submitLoginForm">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
export default {
    name: "AuthLogin",
    data() {
        return {
            LoginForm: {
                email : 'admin@gmail.com',
                password : '123456'
            },
            ErrorFormResponse : {
                email: '',
                password : '',
            },
            LoginFormData : []
        }
    },
    methods: {
        ...mapActions('loginModule',['doSendLoginForm']),
        /**
         * Submit register form on api
         * @returns {Promise<void>}
         */
        async submitLoginForm() {
            this.saveLoginFormToData();
            await this.doSendLoginForm(this.LoginFormData)
                .then((response) => {
                    this.$swal({icon: 'success', title: 'Signed-in', text: 'Successfully Logged in'});
                    this.$auth.setLoginDetails(response)
                    this.$router.push({ name: 'Home'});
                })
                .catch((response) => {
                    const self = this;
                    this.$swal({icon: 'error', title: 'Oops...', text: 'Failed to Login User'});
                    $.each(response.data.message, function (key, message) {
                        self.ErrorFormResponse[key] = message[0];
                    })
                });
        },
        /**
         * save register inputs to form data
         */
        saveLoginFormToData() {
            this.LoginFormData = new FormData();
            this.LoginFormData.append('email', this.LoginForm.email);
            this.LoginFormData.append('password', this.LoginForm.password);
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
        onLoginInput(index) {
            this.ErrorFormResponse[index] = '';
        }
    }
}
</script>

<style scoped>

</style>
