<template>
<section class="hk-sec-wrapper">
	<h5 class="hk-sec-title" v-once>Hi {{ user.firstname }}! </h5>
	<p class="mb-40">Here you can Make changes to your profile.</p>
	<div class="row">
		<div class="col-sm">
			<form>
				<div class="row">
					<div class="col-md-6 form-group">
						<label for="firstName">First name</label>
						<input  class="form-control" id="firstName" placeholder="" v-model="user.firstname" type="text">
					</div>
					<div class="col-md-6 form-group">
						<label for="lastName">Last name</label>
						<input class="form-control" id="lastName" placeholder=""  v-model="user.lastname" type="text">
					</div>
				</div>
 
				<div class="form-group">
					<label for="title">Title<small> (ie: Business Man,Developer,Students etc)</small>.</label>
					<input class="form-control" v-model="userinfo.title" id="title"   placeholder="Title" type="text">
				</div>
				<div class="row">
					<div class="col-md-5 mb-10">
						<label for="country">Country</label>
						<select v-model="userinfo.country" class="form-control custom-select d-block w-100" id="country">
							<option value="">Choose...</option>
							<option v-for="country in countries">{{country.country.country_name}}</option>
						</select>
					</div>
	 
					<div class="col-md-4 mb-10">
						<label for="city">City</label>
						<input v-model="userinfo.city" class="form-control" id="city" placeholder="" type="text">
					</div>
				</div>
				<div class="form-group mt-3">
					<label for="city">Profile Picture</label>
					<div class="fileinput fileinput-new input-group" data-provides="fileinput">
						<div class="input-group-prepend">
							<span class="input-group-text">Upload</span>
						</div>
						<div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
						<span class="input-group-append">
							<span class=" btn btn-primary btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
							<input type="file" name="..." @change="ImageChange">
						</span>
						<a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove </a>
					</span>
				</div>
			</div>
			
			
			
			<button @click.prevent="updateProfile" class="btn btn-primary" type="submit">Save Changes </button> {{this.$store.getters.profileURL}}
		</form>
	</div>
</div>
</section>
</template>
<script type="text/javascript">
	export default{
		props:['data','countries'],
		data(){
			return{
				user:this.data.user,
				extra:{
					title:'',
					country:'',
					state:'',
					city:'',
					profile:''
				}
			}
		},
		computed:{
			userinfo(){
				return this.$store.getters.user.user.usermeta;
			}
		},
		methods:{
			updateProfile(){
				let userData={
					firstname:this.user.firstname,
					lastname:this.user.lastname,
					title:this.userinfo.title,
					country:this.userinfo.country,
					state:this.userinfo.state,
					city:this.userinfo.city,
					profile:this.extra.profile,
				}
				axios.post('/api/user/'+this.$route.params.id+'/update',userData)
				.then(response => {
					console.log(userData);
					console.log(response)
				})
			},
			ImageChange(e){
				//console.log(e.target.files[0])
				var fileReader= new FileReader()
				fileReader.readAsDataURL(e.target.files[0]);
				fileReader.onload = (e) => {
					this.extra.profile=e.target.result;
				}
				//console.log(this.extra.profile)
			},
			 
		},
		created(){
		}
	}
</script>