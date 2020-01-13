<template>
<div class="container-fluid">
<!-- Row -->
<div class="row">
	<div class="col-xl-12 pa-0">
		<div class="profile-cover-wrap overlay-wrap">
			<div class="profile-cover-img"  :class="'bg-gradient-'+userDetails.user.background" style="background-image:url('/dist/img/trans-bg.jpg')"></div>
			<div class="bg-overlay bg-trans-dark-30"></div>
			<div class="container profile-cover-content py-50">
				<div class="hk-row">
					<div class="col-lg-6">
						<div class="media align-items-center">
							<div class="media-img-wrap  d-flex">
								<div class="avatar">
									<img v-if="userDetails.user.images!=null" :src="userDetails.user.images" alt="user" class="avatar-img rounded-circle shadow-xl">
									<span v-else class="avatar-text shadow-xl  rounded-circle" :class="'avatar-text-'+userDetails.user.avatar">
										<span class="initial-wrap">
											<span v-if="userDetails.user.firstname">{{ userDetails.user.firstname.charAt(0)+userDetails.user.lastname.charAt(0) }}</span>
										</span>
									</span>

								</div>
							</div>
							<div class="media-body">
								<div  class="text-white text-capitalize display-6 mb-5 font-weight-400">
										{{userDetails.user.fullname }}
									
								</div>
							 	<div class="font-14 text-white">
									<span class="  "><span class="font-weight-500 pl-5" v-if="userDetails.user.usermeta">
											{{userDetails.user.usermeta.title }}  
										</span></span>
								</div>
								<!-- <div class="font-14 text-white">
									<span class="mr-5">
										<span class="font-weight-500 pr-5">
											{{userDetails.info.followers	}}
										</span>
										<span class="mr-5">Followers</span>
									</span>
									<span>
										<span class="font-weight-500 pr-5">{{userDetails.info.followings}}</span>
										<span>Following</span>
									</span>
								</div> -->
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="button-list">
							<a href="#" @click.prevent="follow(userDetails.user.id)"  class="btn  btn-wth-icon icon-wthot-bg btn-rounded" :class="(userDetails.user.follower) ? 'btn-primary' : 'btn-outline-primary' "><span class="btn-text pl-25"> {{ (userDetails.user.follower) ? 'Following' : 'Follow' }}  </span><span class="icon-label"><i class="fas " :class="(userDetails.user.follower) ? ' fa-user-check ' : 'fa-user-plus' "></i> </span></a>  
							<router-link :to="'/chats/'+userDetails.user.username" class="btn btn-dark btn-wth-icon icon-wthot-bg btn-rounded"><span class="btn-text">Message</span><span class="icon-label"><i class="icon ion-md-mail"></i> </span></router-link>
							<a href="#" class="btn btn-icon btn-icon-circle btn-indigo "><span class="btn-icon-wrap"><i class="fab fa-facebook-f"></i></span></a>
							<a href="#" class="btn btn-icon btn-icon-circle btn-sky "><span class="btn-icon-wrap"><i class="fab fa-twitter"></i></span></a>
						 
							<a href="#" aria-expanded="false" data-toggle="dropdown" class="btn dropdown-toggle btn-icon btn-icon-circle btn-dark border-0"><span class="btn-icon-wrap"><i class="fas fa-ellipsis-v"></i></span></a>

							<div role="menu" class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -165px, 0px); top: 0px; left: 0px; will-change: transform;">
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<a class="dropdown-item" href="#">Something else here</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Separated link</a>
							</div>
							 
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bg-white shadow-bottom">
			<div class="container">
				<ul class="nav nav-light nav-tabs" role="tablist">
					<li class="nav-item">
						<router-link   :to="'/user/'+this.$route.params.id" class="d-flex h-60p align-items-center nav-link" active-class="active" exact>Posts</router-link>
					</li>
					<li class="nav-item">
						<router-link   :to="'/user/'+this.$route.params.id+'/activity'" class="d-flex h-60p align-items-center nav-link" active-class="active" >Activity</router-link>
					</li>
					<li class="nav-item" v-if="localUser==this.$route.params.id">
						<router-link   :to="'/user/'+this.$route.params.id+'/edit'" class="d-flex h-60p align-items-center nav-link" active-class="active">Edit Profile</router-link>
					</li>
					<li class="nav-item">
						<a href="#" class="d-flex h-60p align-items-center nav-link">Photos</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="tab-content mt-sm-60 mt-30">
			<div class="tab-pane fade show active" role="tabpanel">
				<div class="container">
					<div class="hk-row">
						<div   :class="['Userfollowers'].includes(this.$route.name) ? 'col-lg-12' : 'col-lg-8' " >
							<router-view></router-view>
						</div>
						<div class="col-lg-4" v-if="['UserProfile','UserActivity','UserEdit'].includes(this.$route.name)" >
							<follower-list  style="margin-top: 55px !important;"></follower-list>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Row -->
</div>
</template>
<script>
	import { eventBus } from '../../app'; 
	import FollowerList from "./../Widgets/Follower/Index.vue";
	export default{
		components:{
			FollowerList
		},
		data(){
			return{
				username:this.$route.params.id,
			}
		},
		computed:{
			userDetails(){
				return this.$store.getters.profileData;
	  
			},
			localUser(){
				return localStorage.getItem('username');
			},
	 	},
		methods:{
			follow(id){
				this.$store.dispatch('follow',id)
				.then(res =>{
					this.userDetails.user.follower=res.data.follow;
					//console.log(res.data.follow);
				})
			}
		},
		created(){
			/*if (this.$store.getters.profileUser.fullname!='') {
				console.log('created');
				this.$store.dispatch('LoadProfile',this.$route.params.id);
			}
			else{
			}*/
			this.$store.dispatch('LoadProfile',this.$route.params.id)
			.then(response => {
    			//console.log(response);
    			eventBus.$emit('userProfilePosts',response.data.user.posts);
    			eventBus.$emit('EditProfile',response.data.user);
			}).catch(e => {
    			//console.log(e);
			});
 		 	 
		}
	}
</script>
<style type="text/css">
	.dropdown-toggle:after {border: none}
</style>