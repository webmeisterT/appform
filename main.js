var app = new Vue({
    el: '#app',
    data: {
        errorMsg: "",
        successMsg: "",
        showModal: false,
        showEditModal: false,
        showDeleteModal: false,
        users:[],
        newUser: {name: "", email: "",phone: ""},
        currentUser: {}
    },
    mounted: function () {
        this.getAllUsers();
    },
    methods: {
        getAllUsers(){
            axios.get("process").then(function(response){
                if (response.data.error){
                    app.errorMsg = reponse.data.message;
                }
                else{
                    // app.users = response.data.users;
                    app.users = [...response.data.users];
                }
            });
        },
        addUser(){
            // var formData = app.toFormData(app.newUser);
            axios.post("process", app.newUser).then(function(response){
                app.newUser = {name: "",email: "",phone: ""};
                if (response.data.error){
                    app.errorMsg = reponse.data.message;
                }
                else{
                    app.successMsg = response.data.message;
                    app.getAllUsers;
                }
            });
        },
        updateUser(){
            // var formData = app.toFormData(app.currentUser);
            axios.put("process", app.currentUser).then(function(response){
                app.currentUser = {};
                if (response.data.error){
                    app.errorMsg = reponse.data.message;
                }
                else{
                    app.successMsg = response.data.message;
                    app.getAllUsers;
                }
            });
        },
        deleteUser(){
            // var formData = app.toFormData(app.currentUser);
            axios.delete(`process?${app.currentUser.id}`).then(function(response){
                app.currentUser = {};
                if (response.data.error){
                    app.errorMsg = reponse.data.message;
                }
                else{
                    app.successMsg = response.data.message;
                    app.getAllUsers;
                }
            });
        },
        // toFormData(obj){
        //     var fd = new FormData();
        //     for(var i in obj){
        //         fd.append(i,obj[i]);
        //     }
        //     return fd;
        // },
        selectUser(user){
            app.currentUser = user;
        },
        clearMsg(){
            app.errorMsg = "";
            app.successMsg = "";
        }
    }
})