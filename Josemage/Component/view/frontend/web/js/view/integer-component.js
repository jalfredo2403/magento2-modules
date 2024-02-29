define([
    'uiComponent',
    'Josemage_Component/js/model/counter'
], function (Component, Counter) {
    "use strict";

    return Component.extend({
        defaults: {
            countInteger: Counter
        }
    });
});
