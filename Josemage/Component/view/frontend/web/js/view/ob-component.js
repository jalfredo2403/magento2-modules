define([
    'uiComponent',
    'ko'
], function (Component, ko) {
    "use strict";

    return Component.extend({
        defaults: {
            title: ko.observable('My heading'),
            content: ko.observable('<strong>Jose</strong>'),
            counter: ko.observable(0)
        },

        initialize: function () {
            this._super();
            this.title("Jose A Hernandez").content('<strong>Sample of observables in Magento 2</strong> By Jose');
            this.content.subscribe(function () {
                this.counter(
                    document.getElementById('custom_input').value.length
                );
            }, this);
        },
        onChangeInput: function () {
            let inputVal = document.getElementById('custom_input').value;
            this.content(inputVal);
        }
    });
});
