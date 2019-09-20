require('core-js');
window._ = require('lodash');
window.NProgress = require('nprogress');
window.message = require('./lib/message').default;

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.Vue = require('vue');
window.moment = require('moment');
require('moment/locale/fr.js');

let pascalToKebab = s => {
    return s.replace(/\.?([A-Z]+)/g, (_, y) => {
        return '-' + y.toLowerCase()
    }).replace(/^-/, '');
};

import * as Components from '@glitchbl/vue-bootstrap-components';

for (const key in Components) {
    const Component = Components[key];
    const name = `vc-${pascalToKebab(key)}`;
    Vue.component(name, Component);
}

Vue.mixin({
    filters: {
        formatNumber(value) {
            if (value === null || isNaN(value)) return 'Invalid number';
            let number = String(value);
            let dec = 0;
            if (number.indexOf('.') !== -1) {
                [number, dec] = [number.split('.')[0], parseInt(number.split('.')[1])];
                if (number === '')
                    number = 0;
                if (dec > 0 && dec < 10) {
                    dec = '0' + dec;
                }
            }
            number = number.replace(/(.)(?=(\d{3})+$)/g,'$1 ');
            if (dec > 0)
                number += `,${dec}`;
            return number;
        },
        formatDate(value) {
            return moment(value).format('L');
        },
    },
});

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

let handleAxiosError = error => {
    let response = error.response;
    error.validation = {};
    if (response) {
        if (response.status === 422) {
            message.error(response.data);
            NProgress.done();
            error.validation = response.data;
            return Promise.reject(error);
        } else if (response.status === 401) {
            document.location.reload();
            return Promise.reject(error);
        } else if (response.status === 419 && response.config && !response.config.__isRetryRequest) {
            return new Promise((resolve, reject) => {
                axios.get('/')
                .then(({data}) => {
                    const wrapper = document.createElement('div');
                    wrapper.innerHTML = data;

                    let token =  wrapper.querySelector('meta[name=csrf-token]').getAttribute('content');

                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
                    document.querySelector('meta[name=csrf-token]').setAttribute('content', token);

                    error.config.__isRetryRequest = true;
                    error.config.headers['X-CSRF-TOKEN'] = token;
                    resolve(axios(error.config));
                })
                .catch(error => {
                    NProgress.done();
                    reject(error);
                });
            });
        }
    }

    NProgress.done();
    message.error(['Une erreur est survenue.', 'Veuillez nous excuser pour la gêne occasionnée.']);
    console.error(error);
    return Promise.reject(error);
}

axios.interceptors.request.use(config => {
    NProgress.start();
    return config;
  }, error => {
    return Promise.reject(error);
});

axios.interceptors.response.use(response => {
    NProgress.done();
    return response;
  }, error => {
    return handleAxiosError(error);
});

window.goBack = event => {
    event.preventDefault();
    window.history.back();
}

window.generateId = function() {
    let i = 0;
    return () => i++;
}();

window.jsonToFormData = json => {
    let data = new FormData();
    let appendToFormData = (value, key = '') => {
        if (_.isArray(value) || _.isPlainObject(value)) {
            if (_.isEmpty(value)) {
                if (key != '')
                    appendToFormData('', key);
            } else {
                _.forEach(value, (v, i) => {
                    if (key === '')
                        appendToFormData(v, i);
                    else
                        appendToFormData(v, `${key}[${i}]`);
                });
            }
        } else {
            if (value === null)
                data.append(key, '');
            else if (value === false)
                data.append(key, 0);
            else if (value === true)
                data.append(key, 1);
            else
                data.append(key, value);
        }
    }
    appendToFormData(json);
    return data;
}
