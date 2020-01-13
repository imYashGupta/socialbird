<template>
<div class="col-lg-4 col-md-6 col-sm-12">
	<div class="card shadow-xl shadow-hover mb-20">
		<div class="card-img card-img-bg text-white text-center -" :class="'bg-gradient-'+user.following.background" style="background-image: url(/dist/img/cropper.jpg);">
			<div class="card-img-overlay text-white bg-trans-dark-25">
				<div class="avatar ">
					<img v-if="user.following.images!=null" :src="user.following.images" alt="user" class="avatar-img rounded-circle shadow-xl">
					<span v-else class="avatar-text shadow-xl  rounded-circle" :class="'avatar-text-'+user.following.avatar">
						<span class="initial-wrap">
							<span v-if="user.following.firstname">{{ user.following.firstname.charAt(0)+user.following.lastname.charAt(0) }}</span>
						</span>
					</span>				
				</div>
					<router-link :to="'/user/'+user.following.username" class="card-title text-white mb-0 mt-10 h5 d-block">{{user.following.fullname}}</router-link>
					<p class="card-text"><small class="text-white">{{user.following.usermeta.title}}</small></p>
					<p class="mt-3 mb-3">{{user.followings.follower}} Follower | {{user.followings.following}} following</p>
					<follow-btn type="icon" :follow="user.following.follower" :id="user.following.id"></follow-btn>
				</div>
			</div>
		</div>
	</div>
	</template>
	<script type="text/javascript">
		import FollowBtn from './../../Elements/FollowBtn.vue';
		export default{
			props:['user'],
			components:{
				FollowBtn
			},
			created(){
				//console.log(this.user);
			},
		}
	</script>