define(['uiComponent'], function (Component) {
    "use strict";

    return Component.extend({
        initialize: function () {
            this._super();
            alert("Jose this worked , initialized the custom component.");
        }
    });
});
