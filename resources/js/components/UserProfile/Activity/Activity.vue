<template>
<div >
	<template v-if="activity.type=='follow'">
		<div class="media">
			<div class="media-img-wrap">
				<div class="avatar avatar-sm">
					<img v-if="activity.user.images!=null" :src="activity.user.images" alt="user" class="avatar-img rounded-circle">
					<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+activity.user.avatar">
						<span class="initial-wrap">
							<span v-if="activity.user.firstname">{{ activity.user.firstname.charAt(0)+activity.user.lastname.charAt(0) }}</span>
						</span>
					</span>
				</div>
			</div>
			<div class="media-body pb-0">
				<div>
					<span class="d-block mb-5"><span class="font-weight-500 text-dark text-capitalize">{{ activity.user.fullname }}</span><span class="pl-5">Started Follow <span class="font-weight-500 text-dark text-capitalize">{{ activity.info.user.fullname }}</span></span></span>
					<span class="d-block font-13 mb-30">{{ activity.created_at }}</span>
				</div>
				<div class="card d-inline-block w-sm-360p mb-0">
					<div class="card-body">
						<div class="d-flex flex-wrap">
							<div class="avatar mr-25 avatar-md ">
								<img v-if="activity.info.user.images!=null" :src="activity.info.user.images" alt="user" class="avatar-img rounded-circle">
								<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+activity.info.user.avatar">
									<span class="initial-wrap">
										<span v-if="activity.info.user.firstname">{{ activity.info.user.firstname.charAt(0)+activity.info.user.lastname.charAt(0) }}</span>
									</span>
								</span>
							</div>
							<div class="w-65">
								<h6 class="mb-5">{{ activity.info.user.fullname }}</h6>
								<p>{{ activity.info.user.usermeta.title }}</p>
							</div>
						</div>
					</div>
					<div class="card-footer text-muted justify-content-between">
						<div>Followed By<span class="text-dark"> {{ activity.info.followerCount }} People</span></div>
						<button v-if="activity.info.user.id!=this.$store.state.user.user.id" class="btn btn-xs btn-primary ml-15 w-sm-100p" @click="follow(activity.info.user.id)">  <span v-if="spinner" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
  <span class="sr-only">Loading...</span>{{(activity.info.user.follower) ? 'Following' : 'Follow'}}</button>
					</div>
				</div>
			</div>
		</div>
	</template>
	<template v-if="activity.type=='react'">
		<div class="media">
			<div class="media-img-wrap">
				<div class="avatar avatar-sm">
					<img v-if="activity.user.images!=null" :src="activity.user.images" alt="user" class="avatar-img rounded-circle">
					<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+activity.user.avatar">
						<span class="initial-wrap">
							<span v-if="activity.user.firstname">{{ activity.user.firstname.charAt(0)+activity.user.lastname.charAt(0) }}</span>
						</span>
					</span>
				</div>
			</div>
			<div class="media-body pb-0">
				<div class="d-flex align-items-start">
					<div>
						<span class="d-block mb-5"><span class="font-weight-500 text-dark text-capitalize">{{ activity.user.fullname }}</span><span class="pl-5">liked a </span><router-link :to="'/post/'+activity.info.post.id">Post</router-link></span>
						<span class="d-block font-13 mb-30">{{activity.created_at}}</span>
					</div>
					<!-- 	<button class="btn btn-sm btn-primary ml-auto">View Post</button> -->
				</div>
				<div class="card d-inline-block w-100 mb-0">
					<div class="card-body">
						<div class="d-flex flex-wrap">
							<div class="avatar mr-25 avatar-sm ">
								<img v-if="activity.info.post.user.images!=null" :src="activity.info.post.user.images" alt="user" class="avatar-img rounded-circle">
								<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+activity.info.post.user.avatar">
									<span class="initial-wrap">
										<span v-if="activity.info.post.user.firstname">{{ activity.info.post.user.firstname.charAt(0)+activity.info.post.user.lastname.charAt(0) }}</span>
									</span>
								</span>
							</div>
							<div class="w-75">
								<h6 class="mb-5">{{ activity.info.post.user.fullname }}</h6>
								<p>{{ activity.info.post.body }}</p>
							</div>
						</div>
					</div>
					<div class="card-footer justify-content-between">
						<div>
							<a href="#" @click.prevent="reacts(activity.info.post.id)"  class="text-muted">
								<i class=" text-primary  fa-heart"  :class="(activity.info.post.isLiked) ? 'fas' : 'far'"></i> 
								
								<div v-if="spinner" class="spinner-grow spinner-grow-sm" role="status">
									<span class="sr-only">Loading...</span>
								</div>
								<span v-else>
									{{activity.info.post.reacts_count}}
								</span>
							</a>
						</div>
						<div>
							<router-link :to="'/post/'+activity.info.post.id"  href="#" class="text-muted">{{activity.info.post.comments_count}} comments</router-link>
						</div>
					</div>
				</div>
			</div>
		</div>
	</template>
	<template v-if="activity.type=='comment'">
		<div class="media">
			<div class="media-img-wrap">
				<div class="avatar avatar-sm">
					<img v-if="activity.user.images!=null" :src="activity.user.images" alt="user" class="avatar-img rounded-circle">
					<span v-else class="avatar-text  rounded-circle" :class="'avatar-text-'+activity.user.avatar">
						<span class="initial-wrap">
							<span v-if="activity.user.firstname">{{ activity.user.firstname.charAt(0)+activity.user.lastname.charAt(0) }}</span>
						</span>
					</span>
				</div>
			</div>
			<div class="media-body">
				<div>
					<span class="d-block mb-5"><span class="font-weight-500 text-dark text-capitalize">{{activity.user.fullname}}</span><span class="pl-5">Commented on a <router-link :to="'/post/'+ activity.info.comment.post_id">Post</router-link>.</span></span>
					<div class="card d-inline-block w-100 mb-0">
						<div class="card-body">
							<div class="d-flex flex-wrap">
								<div class="w-100">
									<p>{{ activity.info.comment.comment }}</p>
								</div>
							</div>
						</div>
					</div>
					<span class="d-block font-13">{{activity.created_at}}</span>
				</div>
			</div>
		</div>
	</template>
</div>
</template>
<script type="text/javascript">
	import {helper} from './../../../helper'
	export default{
		props:['activity'],
		data(){
			return{
				spinner:false,
			}
		},
		methods:{
			follow(id){
				this.spinner=true;
				this.$store.dispatch('follow',id)
				.then(res => {
					this.activity.info.user.follower=res.data.follow;
					this.spinner=false;
				})
			},
			reacts(PostID){ 
				this.spinner=true;
				helper.API.React(PostID)
				.then(res => {
					if (res.data.res==0) {
						this.activity.info.post.reacts_count--;
						this.activity.info.post.isLiked=false;

					}
					if (res.data.res==1) {
						this.activity.info.post.reacts_count++;
						this.activity.info.post.isLiked=true;
					}
					this.spinner=false;
				})
			}
		}
	}
</script>