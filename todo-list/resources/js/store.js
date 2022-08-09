const oLoginModule = {
    namespaced: true,
    state: {
        urls: {
            postSendRegisterForm          : '/api/auth/register',
            postSendLoginForm           : '/api/auth/login',
        },
        token : [],
        loggedUser : []
    },
    mutations: {
        fetchLoggedUser(state, oLoggedUser) {
            state.loggedUser = oLoggedUser;
        },
        fetchAccessToken(state, oAccessToken) {
            state.token = oAccessToken;
        },
    },
    actions: {
        doSendLoginForm: function ({state, commit}, oLoginForm) {
            return new Promise((resolve, reject) => {
                axios.post(state.urls.postSendLoginForm, oLoginForm)
                    .then(oResponse => {
                        resolve(oResponse);
                    })
                    .catch((response) => {
                        reject(response.response);
                    });
            });
        },
        doSendRegisterForm: function ({state, commit}, oRegisterForm) {
            return new Promise((resolve, reject) => {
                axios.post(state.urls.postSendRegisterForm, oRegisterForm)
                .then(oResponse => {
                    console.log(oResponse);
                    resolve();
                })
                .catch((response) => {
                    reject(response.response);
                });
            });
        }
    }
}

export default {
    modules: {
        loginModule: oLoginModule
    }
}
