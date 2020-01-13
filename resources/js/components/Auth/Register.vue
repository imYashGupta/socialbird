<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 pa-0">
                <div class="auth-form-wrap pt-xl-0 pt-70">
                    <div class="auth-form w-xl-30 w-lg-55 w-sm-75 w-100">
                        <a class="auth-brand text-center d-block mb-20" href="#">
                            <img class="brand-img" height="100" src="dist/img/02.png" alt="brand" />
                        </a>
                        <form  @submit.prevent="register">
                            <h1 class="display-4 mb-10 text-center">Create your account!</h1>
                            <p class="mb-30 text-center">Fill the details below to Get Started!</p>
                            <!-- alerts -->
                            <div v-if="errors.error" class="alert alert-dark alert-wth-icon show  fade" role="alert">
                                <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i></span> <strong>Please check the details below and try again!</strong>
                                <ul style="list-style:inherit;"><li v-for="e in errors.errorMsgs">{{e[0]}}</li></ul>
                            </div>

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <input class="form-control" placeholder="First name" v-model="user.firstname" required="" type="text">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input class="form-control" placeholder="Last name"  v-model="user.lastname"  required="" type="text">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" v-model="user.email" type="email" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" v-model="user.password" type="password" required="">
                            </div>
                            
                            <div class="custom-control custom-checkbox mb-25">
                                <input class="custom-control-input" id="same-address" type="checkbox" checked>
                                <label class="custom-control-label font-14" for="same-address">I have read and agree to the <a href=""><u>term and conditions</u></a></label>
                            </div>
                            <button v-if="!showLoading" class="btn btn-pink btn-block" type="submit">Signup</button>
                            <button  v-else class="btn btn-pink btn-block" type="submit">Signing up.. <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>
                            
                            <p class="text-center mt-3">Already have an account? <router-link to="/login">Sign In</router-link></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    export default{
        data(){
            return{
                user:{
                    firstname:'',
                    lastname:'',
                    email:'',
                    password:''                
                },
                errors:{
                    error:false,
                    errorMsgs:''
                },
                showLoading:false
            }
        },
        methods:{
            register(){
                this.showLoading=true;

                this.$store.dispatch('register',this.user)
                .then(res => {
         
                    this.$store.dispatch('retriveToken',{
                        username:this.user.email,
                        password:this.user.password
                    })
                    .then((res) => {
                    this.showLoading=false;
                        this.$router.push('/start');
                    })
                })
                .catch(err =>  {
                    this.showLoading=false;
                    this.errors.error=true;
                    
                    this.errors.errorMsgs=Object.values(err.response.data.errors);
                    console.log(this.errors.errorMsgs);
                })
            }
        }    
    }   
</script>