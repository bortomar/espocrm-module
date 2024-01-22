define("custom:find-contacts", ["action-handler"], function (Dep) {
    return Dep.extend({
        actionFindContacts: function (data, e) {

            Espo.Ajax.getRequest("Autocrm/" + this.view.model.id).then(
                (response) => {
                    console.log(response);
                }
            );
        },

        initFindContacts: function () {
            this.controlActionVisibility();

            this.view.listenTo(
                this.view.model,
                "change:status",
                this.controlActionVisibility.bind(this)
            );
        },

        controlActionVisibility: function () {
            if (
                ~["Converted", "Dead", "Recycled"].indexOf(
                    this.view.model.get("status")
                )
            ) {
                this.view.hideActionItem("findContacts");

                return;
            }

            this.view.showActionItem("findContacts");
        },
    });
});
