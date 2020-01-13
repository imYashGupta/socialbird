<template>
<div>
	<template v-if="notification.type=='follow'">
		<a href="#" @click.prevent="readNotification(notification.id)"  class="dropdown-item" :class="(notification.read==0) ? 'bg-light' : ''">
			<div class="media">
				<div class="media-img-wrap">
					<div class="avatar-group avatar-group-overlapped">
						<div class="avatar avatar-sm">
						<avatar :avatar="{size:'sm',firstname:notification.user.firstname,lastname:notification.user.lastname,color:notification.user.avatar,image:notification.user.images}"></avatar>
						</div>
						<div class="avatar avatar-2">
							<span class="avatar-text avatar-text-success rounded-circle"><span class="initial-wrap"><span><i class="zmdi zmdi-account-add"></i></span></span>
							</span>
						</div>
					</div>
				</div>
				<div class="media-body">
					<div>
						<div class="notifications-text pl-10"><router-link class="text-dark text-capitalize" :to="'/user/'+notification.user.username">{{notification.user.fullname}}</router-link> Started Following You!</div>
						<div class="notifications-time">{{notification.created_at}}</div>
					</div>
				</div>
			</div>
		</a>
		<div class="dropdown-divider"></div>
	</template>
	<template v-if="notification.type=='react'">
		<a href="#" @click.prevent="readNotification(notification.id)" class="dropdown-item" :class="(notification.read==0) ? 'bg-light' : ''">
			<div class="media">
				<div class="media-img-wrap">
					<div class="avatar-group avatar-group-overlapped">
						<div class="avatar avatar-sm">
						<avatar :avatar="{size:'sm',firstname:notification.user.firstname,lastname:notification.user.lastname,color:notification.user.avatar,image:notification.user.images}"></avatar>
						</div>
						<div class="avatar avatar-2">
							<span class="avatar-text avatar-text-primary rounded-circle"><span class="initial-wrap"><span><i class="zmdi zmdi-favorite"></i></span></span>
							</span>
						</div>
					</div>
				</div>
				<div class="media-body">
					<div>
						<div class="notifications-text pl-10"><router-link class="text-dark text-capitalize" :to="'/user/'+notification.user.username">{{notification.user.fullname}}</router-link> Reacted on Your <router-link :to="'/post/'+notification.info.post">Post</router-link>.</div>
						<div class="notifications-time">{{notification.created_at}}</div>
					</div>
				</div>
			</div>
		</a>
		<div class="dropdown-divider"></div>
	</template>
	<template v-if="notification.type=='comment'">
		<a href="#" @click.prevent="readNotification(notification.id)" class="dropdown-item" :class="(notification.read==0) ? 'bg-light' : ''">
			<div class="media">
				<div class="media-img-wrap">
					<div class="avatar-group avatar-group-overlapped">
						<div class="avatar avatar-sm">
						<avatar :avatar="{size:'sm',firstname:notification.user.firstname,lastname:notification.user.lastname,color:notification.user.avatar,image:notification.user.images}"></avatar>
						</div>
						<div class="avatar avatar-2">
							<span class="avatar-text avatar-text-warning rounded-circle"><span class="initial-wrap"><span><i class="zmdi zmdi-comment-text"></i></span></span>
							</span>
						</div>
					</div>
				</div>
				<div class="media-body">
					<div>
						<div class="notifications-text pl-10"><router-link class="text-dark text-capitalize" :to="'/user/'+notification.user.username">{{notification.user.fullname}}</router-link> Commented on Your <router-link :to="'/post/'+notification.info.comment.post_id">Post</router-link>.</div>
						<div class="notifications-time">{{notification.created_at}}</div>
					</div>
				</div>
			</div>
		</a>
		<div class="dropdown-divider"></div>
	</template>
</div>
</template>
<script>
	import Avatar from './../Avatar.vue';
	export default{
		props:['notification'],
		components:{
			Avatar
		},
		created(){
			//console.log(this.notification)
		},
		methods:{
			readNotification(id){
				this.notification.read=1;
				axios.post('/api/notification.read',{id:id})
				.then(res=>{
					//console.log(res);
				})
			}
		}
	}
</script>
<style type="text/css" scoped="">
	.avatar-2{
		    width: 1.625rem !important;
    height: 1.625rem !important;
	}
</style>