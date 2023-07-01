const app = Vue.createApp({
    data: () => ({
        editorBusy: false,
        nonCorrectInput: false,
        editId: -1,
        inputValue: "",
        sortings: [
            "Ascending numbers",
            "Descending numbers",
            "In alphabetical order",
            "In reverse alphabetical order",
        ],
    }),
    methods: {
        activeEditing(event, item) {
            if (this.editorBusy) {
                event.preventDefault();
                return;
            } 
            this.editorBusy = true;
            this.editId = item.data_id;
            event.target.closest("li").querySelector(".itemInput").value = item.name;
        },
        cancelRenaming() {
            this.editorBusy = false;
            this.editId = -1;
        },
        checkInputValue(event, name) {
            if (!this.checkNameValidity(name)) {
                event.preventDefault();
                this.alertInvalidName();
            }
        },
        checkNameValidity(name) {
            const re = /[^ ]+/;
            return re.test(name);
        },
        alertInvalidName() {
            this.nonCorrectInput = true;
        },
        redirectToRoute(url) {
            window.location.href = url;
        }
    },
});

app.mount("#app");