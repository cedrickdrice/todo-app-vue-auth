import $auth from './Auth.js';
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

const oTaskModule = {
    namespaced: true,
    state: {
        urls : {
            apiGetTodoList : '/api/task/list'
        },
        taskList : []
    },
    mutations: {
        setTodoList(state, oTodoList) {
            state.taskList = oTodoList;
        },
    },
    actions: {
        fetchTodoList({state, commit}) {
            return new Promise((resolve, reject) => {
                axios.get(state.urls.apiGetTodoList, $auth.getRequestHeader())
                    .then(oResponse => {
                        commit('setTodoList', oResponse.data.data.tasks);
                        resolve();
                    })
                    .catch(function () {
                        reject();
                    });
            });
        },
    }
}

export default {
    modules: {
        loginModule: oLoginModule,
        taskModule: oTaskModule,
    }
}
