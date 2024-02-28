define([
    'uiComponent',
    'ko',
    'Josemage_Component/js/model/counter'
], function (Component, ko, Counter) {
    "use strict";

    return Component.extend({
        defaults: {
            title: ko.observable('My heading'),
            content: ko.observable('<strong>Jose</strong>'),
            counter: Counter,
        },

        initialize: function () {
            this._super();
            this.title("Jose A Hernandez").content('<strong>Sample of observables in Magento 2</strong> By Jose');
            this.content.subscribe(function () {
                const str = document.getElementById('custom_input').value;
                const digitCount = str.match(/\d/g)?.length || 0;
                Counter(digitCount);
            }, this);
            let self = this;

            setTimeout(function () {
                self.title("Jose A Hernandez");
            }, 3000);

            this.title.subscribe(function (newValue) {
                const newTitle =  "Heading value update: " + newValue;
                alert(newTitle);
            });

            this.title.extend({
                notify: 'always',
            });
        },
        onChangeInput: function () {
            let inputVal = document.getElementById('custom_input').value;
            this.content(inputVal);
        }
    });
});
