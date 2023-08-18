<template>
    <div>
        
        <div class="container">
            <div class="row">

                <div class="col-8 mx-auto">
                    <div class="d-flex justify-content-between py-3 bg-light border-bottom">
                        <h1 class="text-dark fw-bold">Todo App</h1>
                        <router-link class="btn btn-success fw-bold my-auto" to="/add">
                            Add
                        </router-link>
                    </div>

                    <table class="table table-hover table-bordered text-center">

                        <thead> 
                            <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Task Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr v-for="(data,i) in todos" :key="i">
                                <td>{{ ++i }}</td>
                                <td>{{ data.name }}</td>
                                <td>{{ data.description }}</td>
                                <td>
                                    <a @click="viewModal(data,i)" class="btn btn-secondary btn-sm mx-2 my-auto fw-bold">View</a>
                                    <a @click="editTask(data,i)" class="btn btn-primary btn-sm mx-2 my-auto fw-bold">Edit</a>
                                    <a @click="deleteTask(data,i)" class="btn btn-danger btn-sm mx-2 my-auto fw-bold">Delete</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>

                <!-- View modal -->
                <div class="col-7 mx-auto border p-0" v-if="view">
                    <h5 class="py-3 text-success fw-bold border-bottom bg-light text-center">View Modal</h5>
                    <table class="table table-hover table-bordered text-center">

                        <thead> 
                            <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td>{{ viewData.name }}</td>
                                <td>{{ viewData.description }}</td>
                                <td>
                                    <a @click="view = false" class="btn btn-secondary btn-sm mx-2 my-auto fw-bold">Close</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <!-- EDIT modal -->
                <div class="col-7 p-0 mx-auto" v-if="edit">
                    <h5 class="py-3 text-primary fw-bold border-bottom bg-light text-center">Edit Modal</h5>
                    <table class="table table-hover table-bordered text-center">

                        <thead> 
                            <tr>
                            <th scope="col">Task Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" v-model="editData.name">
                                </td>
                                <td>
                                    <input type="text" class="form-control" v-model="editData.description">
                                </td>
                                <td>
                                    <a @click="update()" class="btn btn-success btn-sm mx-2 my-auto fw-bold">Update</a>
                                    <a @click="edit = false" class="btn btn-secondary btn-sm mx-2 my-auto fw-bold">Close</a>
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</template>
<script>
export default {
   data(){
    return {
        todos: [],

        viewData: {
            name: "",
            description: "",
        },
        view: false,

        editData: {
            name: "",
            description: "",
            id: "",
        },
        edit: false,
        editingIndex: '',        

        deleteData:{
            id:''
        },
        deletingIndex: '',
    }
   },

   methods: {

    async getData(){
        try {
            const response = await axios.get('/get_all_task');
            this.todos = response.data;
        } catch (error) {
            console.error(error);
        }
    },

    async deleteTask(data,i){

        this.deleteData.id = data.id;
        this.deletingIndex = i-1;
        //console.log(id)

        try {
            const response = await axios.post('/delete_task', this.deleteData);
            this.todos.splice( this.deletingIndex,1);
        } catch (error) {

            if (error.response.status === 422) {
                for(let i in error.response.data.errors){
                    this.errors = error.response.data.errors
                }
            }
        }
        
    },

    viewModal(data,i){
        this.edit = false;
        this.view = true;
        this.viewData.name = data.name;
        this.viewData.description = data.description;
    },

    editTask(data,i){
        this.view = false;
        this.edit = true;
        this.editingIndex = i;
        this.editData.name = data.name;
        this.editData.description = data.description;
        this.editData.id = data.id;
    },

    async update(){
        //console.log(this.editData)

        try {
            const response = await axios.post('/update_task', this.editData);
            this.todos[this.editingIndex-1].name = this.editData.name;
            this.todos[this.editingIndex-1].description = this.editData.description;
            
            this.editData = {};
            this.edit = false;
        } catch (error) {

            if (error.response.status === 422) {
                for(let i in error.response.data.errors){
                    this.errors = error.response.data.errors
                }
            }
        }

    },

   },

   mounted(){
     this.getData();
   }
}
</script>