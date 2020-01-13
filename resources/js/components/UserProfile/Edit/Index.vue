<template>
<div id="main">
	<div class="hk-pg-header mb-10">
		<div>
			<h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-person"></i></span>Edit Profile</h4>
		</div>
	</div>
	<section class="hk-sec-wrapper" v-if="user!=null">
		<h5 class="hk-sec-title" v-once>Hi {{user.firstname}}! </h5>
		<p class="mb-40">Here you can Make changes to your profile.</p>
		<div class="row">
			<div class="col-sm">
				<form>
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="firstName">First name</label>
							<input  class="form-control"  v-model="user.firstname" id="firstName" placeholder=""   type="text">
						</div>
						<div class="col-md-6 form-group">
							<label for="lastName">Last name</label>
							<input class="form-control" id="lastName" v-model="user.lastname" placeholder=""   type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="title">Title<small> (ie: Business Man,Developer,Students etc)</small>.</label>
						<input class="form-control" v-model="user.usermeta.title" id="title"   placeholder="Title" type="text">
					</div>
					<div class="row">
						<div class="col-md-5 mb-10">
							<label for="country">Country</label>
							<input   class="form-control" v-model="user.usermeta.country" id="country" placeholder="Country" type="text">
						</div>
						<div class="col-md-4 mb-10">
							<label for="city">City</label>
							<input   class="form-control" v-model="user.usermeta.city" id="city" placeholder="City" type="text">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 mt-3">
							<div class="form-group">
								<label for="basic-url">Social Profile's</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">https://facebook.com/</span>
									</div>
									<input type="text" v-model="user.usermeta.social.facebook" class="form-control" id="basic-url" aria-describedby="basic-addon3">
								</div>
								<div class="input-group mt-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">https://twitter.com/</span>
									</div>
									<input type="text" class="form-control" v-model="user.usermeta.social.twitter" id="basic-url" aria-describedby="basic-addon3">
								</div>
								<div class="input-group mt-3">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">https://instagram.com/</span>
									</div>
									<input type="text" v-model="user.usermeta.social.instagram" class="form-control" id="basic-url" aria-describedby="basic-addon3">
								</div>
							</div>
						</div>
					</div>
					<button @click.prevent="saveUser()" class="btn btn-primary" type="button" :class="(updating) ? 'disabled' : '' ">
						<span v-if="updating" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
						{{ (updating) ? 'Saving..' : 'Save Changes' }}
					</button>
				</form>
			</div>
		</div>
	</section>
	<loader v-else></loader>
</div>
</template>
<script type="text/javascript">
	import Loader from "./../../Loader/FullScreen.vue";
	export default{
 
		data(){
			return {
				user:null,
				updating:false,
			}
		},
		methods:{
			saveUser(){
				this.updating=true;
				let user={
					type:'basic',
					firstname:this.user.firstname,
					lastname:this.user.lastname,
					title:this.user.usermeta.title,
					country:this.user.usermeta.country,
					city:this.user.usermeta.city,
					social:{
						facebook:this.user.usermeta.social.facebook,
						instagram:this.user.usermeta.social.instagram,
						twitter:this.user.usermeta.social.twitter,
					},
					username:this.$route.params.id
				}

				axios.post('/api/setuser',user)
				.then(res =>{
					this.updating=false;
					this.$store.dispatch('Toast',{heading:'Success!',html:'Profile updated.'});
				})
			}
		},
		components:{
			Loader
		},
		created(){
			axios.post('/api/getuser')
			.then(res =>{
				this.user=res.data;
				//console.log(res)
			})
		}
	}
</script>