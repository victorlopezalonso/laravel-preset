import axios from 'axios';
import ENV from '../env';

export default {

    install: (Vue) => {
        Vue.prototype.api = {
            get(uri, data) {
                return this.call('get', uri, data)
            },
            post(uri, data) {
                return this.call('post', uri, data)
            },
            put(uri, data) {
                return this.call('put', uri, data)
            },
            patch(uri, data) {
                return this.call('patch', uri, data)
            },
            delete(uri, data) {
                return this.call('delete', uri, data)
            },
            multipart(uri, data) {
                let formData = new FormData();

                for (let param in data) {
                    if (data[param] !== null && data[param] !== undefined) {

                        //If is a file or a a value
                        if (data[param] instanceof File || !(data[param] instanceof Object)) {
                            formData.append(param, data[param]);
                        } else {
                            for (let arrayParam in data[param]) {
                                formData.append(param + '[' + arrayParam + ']', data[param][arrayParam]);
                            }
                        }
                    }
                }

                return this.call('post', uri, formData)
            },
            call(method, uri, data) {

                Event.$emit('showLoading');

                return new Promise((resolve, reject) => {

                    axios({
                        method: method,
                        url: '/v' + ENV.api.version + ENV.api.nameSpace + uri,
                        headers: {
                            'Accept': 'application/json',
                            'apikey': ENV.headers.apiKey,
                            'language': localStorage.getItem('language') ? localStorage.getItem('language') : ENV.headers.language
                        },
                        data: data,
                        validateStatus() {
                            return true;
                        }
                    }).then(response => {

                        if (ENV.debug) {
                            console.log(response.data)
                        }

                        Event.$emit('closeLoading');

                        if (response.status < 200 || response.status >= 400) {
                            // if (response.status === 401) {
                            //     this.logout();
                            // }
                            throw response.data ? response.data.message : 'Service error';
                        }

                        resolve(response.data);

                    }).catch(error => {

                        Event.$emit('closeLoading');
                        console.log(error);

                        Event.$emit('showModal', error);
                    })

                })
            }
        }
    }
};
