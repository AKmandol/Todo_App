<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="d-flex justify-content-between py-3 bg-light border-bottom">
                    <h1 class="text-dark fw-bold">Todo App</h1>
                    <router-link class="btn btn-dark fw-bold my-auto" to="/">
                         View All
                    </router-link>
                </div>

                <form class="mt-5">

                    <div class="mb-3">
                        <label for="name" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="name" v-model="data.name" :class="hasError('name') ? 'is-invalid' : '' ">
                        <div class="invalid-feedback" v-if="hasError('name')">{{getError('name')}}</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Task Description</label>
                        <textarea class="form-control" id="description" rows="3" v-model="data.description" :class="hasError('description') ? 'is-invalid' : '' "></textarea>
                        <div class="invalid-feedback" v-if="hasError('description')">{{getError('description')}}</div>
                    </div>

                    <div class="text-center mt-4">
                        <a type="submit" @click="saveData()" class="btn btn-success tfw-bold">Add Task</a>
                    </div>

                </form>
                

            </div>
        </div>
    </div>
</template>
<script>
export default {
   data(){
    return {
        errors:{},
        todos: [],
        

        data:{
            name: '',
            description: ''
        }
    }
   },

   methods:{

    hasError(fieldName){
        return (fieldName in this.errors);
    },

    getError(fieldName){
        return this.errors[fieldName][0];
    },
    
    async saveData(){
        try {
            const response = await axios.post('/add_task', this.data);
            this.data = {};
            this.$router.push("/");
            
        } catch (error) {

            if (error.response.status === 422) {
                for(let i in error.response.data.errors){
                    this.errors = error.response.data.errors
                }
            }
        }
        
    },
    
   },

   computed:{
    hasAnyError(){
        return Object.keys(this.errors).length > 0;
    }
   }
}
</script>