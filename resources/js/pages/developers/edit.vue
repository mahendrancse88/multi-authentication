<template>
    <div>
        <div class="row">
            <div class="col-lg-8 m-auto">
                <card  :title="$t('Edit Developer')">
                    <div class="row">
                        <div class="col-md-6">
                              <div v-if="errors.length > 0" class="alert alert-danger">{{this.errors[0]}}</div>
                            <form @submit.prevent="updateDevelopers">
                                <div class="form-group">
                                    <label>Avatar</label>
                                
                                    <input type="file" v-on:change="onChange" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" v-model="developer.first_name">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" v-model="developer.last_name">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" v-model="developer.email">
                                </div>
                                <div class="form-group">
                                    <label>Phone no</label>
                                    <input type="text" class="form-control" v-model="developer.phone_no">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" v-model="developer.address">
                                </div>
                                <button type="submit" class="btn btn-primary">Edit developer</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <img  v-if="developer.avatar" :src="'../..' + developer.avatar" height="70" width="90" alt="">
                        </div>
                    </div>     
                </card>
            </div>    
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                developer: {
                },
                errors:[]
            }
        },
        created() {
            this.axios
                .get(`/api/developers/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.developer = response.data;
                     console.log(response.data);
                });
        },
        methods: {
            onChange(e) {
                this.file = e.target.files[0];
            },
            updateDevelopers() {
                let data = new FormData();
                this.errors =[];
                if(this.developer.first_name == '' ){
                   this.errors.push('First name required');
                   return false;
                }
                else if(this.developer.last_name == '' ){
                   this.errors.push('Last name required');
                   return false;
                }
                else if(this.developer.email == '' ){
                   this.errors.push('Email required');
                   return false;
                }
                else if(this.developer.phone_no == '' ){
                   this.errors.push('Phone No required');
                   return false;
                }
                else if(this.developer.address == '' ){
                   this.errors.push('Address required');
                   return false;
                }
                data.append("first_name", this.developer.first_name);
                data.append("last_name", this.developer.last_name);
                data.append("email", this.developer.email);
                data.append("phone_no", this.developer.phone_no);
                data.append("address", this.developer.address);
                if (this.file){
                data.append("file", this.file);
                }
                 const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                 this.loading = true;
                this.axios
                    .post(`/api/developers/update/${this.$route.params.id}`, data, config)
                    .then((response) => {
                        this.$router.push({ name: 'developers.all' })
                    })
                    .catch(error => {
                        
                        if(error.response.data.errors.email.length == 1){
                        this.errors.push(error.response.data.errors.email[0]) ; 
                        }
                        else {
                             this.errors.push(error.response.data.errors) ; 
                        }
                        console.log(this.errors);
                        })
                    ;
            }
        }
    }
</script>