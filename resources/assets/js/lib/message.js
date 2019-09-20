window._ = require('lodash');

export default {
    message(type, data, el) {
        let messages = [];
        
        if (_.isString(data))
            messages = [data];
        else
            messages = _.flattenDeep(Object.values(data));

        let messages_alert = $(`<div class="alert alert-${type}"></div>`);
        let messages_ul = $('<ul class="mb-0"></ul>');
        for (const m of messages) {
            messages_ul.append(`<li>${m}</li>`);
        }
        messages_alert.append(messages_ul);
        $(el).html(messages_alert);
    },
    error(data, el = '#messages-js') {
        return this.message('danger', data, el);
    },
    success(data, el = '#messages-js') {
        return this.message('success', data, el);
    },
}