<template>
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 pa-0">
                <div class="auth-form-wrap pt-xl-0 pt-70">
                    <div class="auth-form w-xl-45 w-lg-55 w-sm-75 w-100">
                        <a class="auth-brand text-center d-block mb-20" href="#">
                            <img class="brand-img" height="100" src="dist/img/02.png" alt="brand" />
                        </a>
                        <h1 class="display-4 mb-10 text-center">Just One more step!</h1>
                            <p class="mb-30 text-center">We need some details about you.</p>
                         <section class="hk-sec-wrapper">
                 
                            <div class="row">
                                <div class="col-sm">
                                    <form>
                                        <div class="form-row">
                                            <div class="col-md-8 mb-10">
                                                <label for="validationDefault01">Birth date</label>
                                                <input type="date" class="form-control" id="validationDefault01"   v-model="user.date" required="" max="2005-01-01">
                                            </div> 
                                       
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-10">
                                                <label for="validationDefault03">Country</label>
                                                <input type="text" v-model="user.country" class="form-control" id="validationDefault03" placeholder="Country"  required="">
                                            </div>
                                            <div class="col-md-3 mb-10">
                                                <label for="validationDefault04">State</label>
                                                <input type="text" class="form-control" v-model="user.state" id="validationDefault04" placeholder="State" required="">
                                            </div>
                                         	<div class="col-md-3 mb-10">
                                                <label for="validationDefault03">City</label>
                                                <input type="text" class="form-control" id="validationDefault03" v-model="user.city" placeholder="City" required="">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary float-right" @click.prevent="submit" type="submit">Done!</button>
                                    </form>

                                </div>
                            </div>


                        </section>

                        <div class="alert alert-dark alert-wth-icon alert-dismissible fade show" role="alert" v-if="showError">
                                        <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i></span>Please fill the details below to continue!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script type="text/javascript">
	export default{
		data(){
			return{
				user:{
					country:'',
					state:'',
					city:'',
					date:'2000-01-01'
				},
				showError:false,
			}
		},
		methods:{
			submit(){
				if (this.user.country!='' && this.user.state!='' && this.user.city!='' && this.user.date!='') {
					this.showError=false;
					axios.post('/api/user.startinfo',this.user)
					.then(res=>{
						//console.log('Welcome');
                        this.$router.push('/dashboard');
					})
					.catch(err=>{

					});
				}
				else{
					this.showError=true;
				}
			}
		},
		created(){
			if ("geolocation" in navigator) {
				var vue=this;
				navigator.geolocation.getCurrentPosition(function(position) {
  					$.ajax({
  					  	url: '//api.opencagedata.com/geocode/v1/json?key=14535bcbcc9c47b1b01466c1ceadaea9&q='+encodeURIComponent(position.coords.latitude + ',' + position.coords.longitude)+'&pretty=1&no_annotations=1',
  					  	type: 'GET',
  					  	dataType: 'json',

  					  })
  					  .done(function(res) {
  					  	vue.user.country=res.results[0].components.country;
  					  	
  					  	vue.user.state=res.results[0].components.state;
  					  })
  					  .fail(function() {
  					  	console.log("error");
  					  	 document.location.reload(true);
  					  })
 
  					    
				});
			}  

		 	//console.log(navigator.geolocation)
		}
	}
</script>