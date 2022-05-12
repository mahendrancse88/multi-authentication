<template>
    <div>
        <div class="row">
        <div class="col-lg-12 m-auto">
        <h3 class="text-right">
             <router-link :to="{name: 'developers.add'}" class="btn btn-primary">Add Developer
                        </router-link>
        </h3><br/>
        <card  :title="$t('Developer Lists')">  
        <select v-model="select" style="margin-bottom:10px" @change="deleteDeveloperAll">
        <option value="">Select</option>
        <option value="">Delete All</option>
        </select>  
        <table class="table table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>
            
                <input type="checkbox" @click="select_all_via_check_box" v-model="all_select"> 

                            <span> {{ all_select == true ? 'Uncheck All' : "Select All" }} </span>
                </th>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Avatar</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="developer in developers" :key="developer.id">
                <td><input type="checkbox" v-model="deleteItems" :value="`${developer.id}`"></td>
                <td>{{ developer.id }}</td>
                <td>{{ developer.first_name }}</td>
                <td>{{ developer.last_name }}</td>
                 <td>{{ developer.email }}</td>
                <td>{{ developer.phone_no }}</td>
                 <td>{{ developer.address }}</td>
                <td><img v-if="developer.avatar" :src="'..' + developer.avatar" height="70" width="90" alt=""></td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'developers.edit', params: { id: developer.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteDeveloper(developer.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        </card>
    </div>
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                developers: [],
                select: '',
                deleteItems: [],
                all_select: false
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/developers')
                .then(response => {
                    this.developers = response.data;
                });
        },
        methods: {
            deleteDeveloper(id) {
                this.axios
                    .delete(`http://localhost:8000/api/developers/delete/${id}`)
                    .then(response => {
                        let i = this.developers.map(item => item.id).indexOf(id); // find index of your object
                        this.developers.splice(i, 1)
                    });
            },
            select_all_via_check_box(){
                if(this.all_select == false){
                    this.all_select = true
                    this.developers.forEach(user => {
                      this.deleteItems.push(user.id)
                    });
                }else{
                    this.all_select = false
                    this.deleteItems = []
                }
            },
            deleteDeveloperAll(){
                  this.axios.post('/api/developersAll/delete/'+this.deleteItems)
                     .then((response) => {
                        this.developers =[]
                        this.deleteItems = []
                        this.all_select == true ? 
                             this.all_select = false : this.all_select = true;
                     })
            }
        }
    }
</script>