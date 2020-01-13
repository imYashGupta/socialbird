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
						<form @submit.prevent="login()">
							<h1 class="display-4 text-center mb-10">Welcome Back :)</h1>
							<p class="text-center mb-30">Sign in to your account and enjoy unlimited perks.</p>
							<div v-if="error" class="alert alert-dark alert-wth-icon show  fade" role="alert">
								<span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i></span> <span v-html="errorMsg"> </span>
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Email" type="email" v-model="email" required="">
							</div>
							<div class="form-group">
								<div class="input-group">
									<input class="form-control" placeholder="Password" type="password" v-model="password" required="">
									<div class="input-group-append">
										<span class="input-group-text"><span class="feather-icon"><i data-feather="eye-off"></i></span></span>
									</div>
								</div>
							</div>
							<div class="custom-control custom-checkbox mb-25">
								<input class="custom-control-input" id="same-address" type="checkbox" checked>
								<label class="custom-control-label font-14" for="same-address">Keep me logged in</label>
							</div>
                                <button  v-if="!showLoading" class="btn btn-pink btn-block" type="submit">Login
                                </button>
                                <button  v-else class="btn btn-pink btn-block" type="submit">Loging In <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                </button>
							<p class="font-14 text-center mt-15">Having trouble logging in?</p>
							
							<p class="text-center">Do have an account yet? <router-link to="/register">Sign Up</router-link></p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>
<script>
	import { eventBus } from '../../app'; 
    export default{
        data(){
            return{
                email:'',
                password:'',
                error:false,
                errorMsg:'',
                showLoading:false
            };
        },
        methods:{
            login(){
                this.showLoading=true;
                this.$store.dispatch('retriveToken',{
                    username:this.email,
                    password:this.password
                })
                .then((res) => {

                	this.$store.dispatch('user')
                	.then(res => {
                        this.showLoading=false;
                    	this.$router.push('/dashboard');
                	})

                })
                .catch((err) => {
                        this.showLoading=false;
                	console.log('err in login')
                    this.error=true;
                    if (err.response.data.error=="invalid_request") {
                        this.errorMsg="Please fill all the required fields!";
                    }
                    else if(err.response.data.error=="invalid_credentials"){
                        this.errorMsg="The given credentials were incorrect! Please try again.";
                    }
                    else{
                        this.errorMsg="Unknown Error! Please report this to <a href='mailto:hello@YashGupta.work'>hello@YashGupta.work</a>";
                    }
                    console.log(err.response.data);
                })

            }
        },
        created(){
        	eventBus.$on('logout',() => {
        		//console.log('logout');
        		this.$store.commit('deleteData');
        	});

        	 
        }
    }

</script>