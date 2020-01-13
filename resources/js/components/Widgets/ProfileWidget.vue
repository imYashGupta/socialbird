<template>
<div v-if="isUserLoaded" class="card card-profile-feed shadow-sm shadow-hover-lg mt-3 mt-md-0">
	<div   class="card-header card-header-action">
		<div class="media align-items-center">
			<div class="media-img-wrap d-flex mr-10">
				<div class="avatar avatar-md">
				<img v-if="user.user.images!=null" :src="user.user.images" alt="user" class="avatar-img rounded-circle">
				<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+user.user.avatar">
					<span class="initial-wrap">
						<span>{{ user.user.firstname.charAt(0)+user.user.lastname.charAt(0) }}</span>
					</span>
				</span>
				</div>
			</div>
			<div class="media-body">
				<router-link :to="'/user/'+user.user.username" tag="div" class="text-capitalize font-weight-500 text-dark pointer"> 
					 {{user.user.firstname+' '+user.user.lastname}}
				</router-link>
				<div class="font-13 ml-1">{{user.user.usermeta.title}}</div>
			</div>
		</div>
		<div class="d-flex align-items-center card-action-wrap">
			<div class="inline-block dropdown">
				<a class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="ion ion-ios-settings"></i></a>
				<div class="dropdown-menu dropdown-menu-right">
					<router-link class="dropdown-item" :to="'/user/'+user.user.username">Profile</router-link>
					<router-link class="dropdown-item" :to="'/user/'+user.user.username+'/activity'">Activity</router-link>
					<router-link class="dropdown-item" :to="'/user/'+user.user.username+'/edit'">Edit Profile</router-link>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Settings</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row text-center">
		<div class="col-4 border-right pr-0">
			<div class="pa-15">
				<span class="d-block display-6 text-dark mb-5">{{ user.info.posts }}</span>
				<router-link :to="'/user/'+user.user.username" class="d-block text-capitalize text-muted font-14">Posts</router-link>
			</div>
		</div>
		<div class="col-4 border-right px-0">
			<div class="pa-15">
				<span class="d-block display-6 text-dark mb-5">{{ user.info.followers }}</span>
				<router-link :to="'/user/'+user.user.username+'/followers'" class="d-block text-capitalize text-muted font-14">followers</router-link>
			</div>
		</div>
		<div class="col-4 pl-0">
			<div class="pa-15">
				<span class="d-block display-6 text-dark mb-5">{{ user.info.followings }}</span>
				<router-link :to="'/user/'+user.user.username+'/followings'" class="d-block text-capitalize text-muted font-14">followings</router-link>
			</div>
		</div>
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item"><span><i class="ion ion-md-calendar font-18 text-light-20 mr-10"></i><span>Joined on:</span></span><span class="ml-5 text-dark">{{user.user.joinon}}</span></li>
		<li v-if="user.user.usermeta.city!='' || user.user.usermeta.country!=''" class="list-group-item"><span><i class="ion ion-md-pin font-18 text-light-20 mr-10"></i><span>From:</span></span><span class="ml-5 text-dark">{{user.user.usermeta.city}},{{user.user.usermeta.country}}</span></li>
	<!-- 	<li class="list-group-item"><span><i class="ion ion-md-calendar font-18 text-light-20 mr-10"></i><span>birthday:</span></span><span class="ml-5 text-dark">Oh, Canada</span></l	i>
		<li class="list-group-item"><span><i class="ion ion-md-briefcase font-18 text-light-20 mr-10"></i><span>Worked at:</span></span><span class="ml-5 text-dark">Companey</span></li>
		<li class="list-group-item"><span><i class="ion ion-md-home font-18 text-light-20 mr-10"></i><span>Lives in:</span></span><span class="ml-5 text-dark">San Francisco, CA</span></li> -->
	</ul>
</div>
</template>
<script>
	import { eventBus } from '../../app'; 

	export default{
		data(){
			return{
				userData:'',
				DOMloaded:false,
			};
		},
		computed:{
			user(){
				return this.$store.getters.user;
			},
			isUserLoaded(){
				return this.$store.getters.isUserLoaded;
			}
		},
	}
</script>