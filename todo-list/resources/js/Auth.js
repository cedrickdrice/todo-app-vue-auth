import axios from 'axios';
const Auth = {
    accessToken : '',
    setLoginDetails (response) {
        localStorage.setItem('token', JSON.stringify({
            access_token: response.data.data.access_token,
            expires_in: response.data.data.expires_in
        }));
        window.localStorage.setItem('user', JSON.stringify(response.data.data.user));
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.data.access_token;
        this.accessToken = response.data.data.access_token;
    },
    check () {
        let sAccessToken = localStorage.getItem('token');
        if (sAccessToken === null) {
            return false;
        }
        let objectToken = JSON. parse(sAccessToken);
        return (new Date(objectToken.expires_in * 1000) > new Date());
    },
    logout () {
        // window.localStorage.clear();
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');
        this.user = null;
    }
};

export default Auth
