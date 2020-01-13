<template>

<li class="list-group-item border-0">
	<div class="media align-items-center">
		<div class="d-flex media-img-wrap mr-15">
			<div class="avatar avatar-md">
				<img v-if="suggetedUser.images!=null" :src="suggetedUser.images" alt="user" class="avatar-img rounded-circle">
				<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+suggetedUser.avatar">
					<span class="initial-wrap">
						<span>{{ suggetedUser.firstname.charAt(0)+suggetedUser.lastname.charAt(0) }}</span>
					</span>
				</span>
			</div>
		</div>
		<div class="media-body">
			<router-link tag="span" :to="'/user/'+suggetedUser.username" class="d-block text-dark text-capitalize pointer">{{ suggetedUser.firstname }} {{ suggetedUser.lastname }} </router-link>
			<span class="d-block font-13">{{ suggetedUser.usermeta.title }}</span>
		</div>
		<a href="#" @click.prevent="followUser(suggetedUser.id)" class="text-light-40 ml-auto">
			
			<span v-if="!showLoading">
				<i v-if="!suggetedUser.follower" class="ion ion-md-add font-24"></i>
				<i v-if="suggetedUser.follower" class="text-primary ion ion-md-checkmark font-24"></i>
			</span>
			<div v-if="showLoading" class="spinner-grow spinner-grow-sm" role="status">
				<span  class="sr-only">Loading...</span>
			</div>
		</a>
	</div>
</li>

</template>
<script>
	import { eventBus } from '../../../app'; 

	export default{
		props:['user'],
		data(){
			return{
				showLoading:false,
				suggetedUser:this.user
			}
		},
		methods:{
			followUser(id){
				this.showLoading=true;
				this.$store.dispatch('follow',id)
				.then((response) => {
					if (response.data.follow==true) {
						this.suggetedUser.follower=true;
					}
					else if(response.data.follow==false){
						this.suggetedUser.follower=false;
					}
					else{
						this.suggetedUser.follower=null;
						swal("We Got an Error","You can inform us in our Feedback section with screenshots","error");
					}
					this.showLoading=false;
				})
				.catch(error => {
					swal("We Got an Error","You can inform us in our Feedback section with screenshots","error");
					console.log(error);
				})
			}
		}
	}
</script>