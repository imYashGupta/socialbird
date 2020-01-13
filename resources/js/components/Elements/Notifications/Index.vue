<template>
<li class="nav-item dropdown dropdown-notifications">
                    <a class="nav-link dropdown-toggle no-caret" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ion ion-ios-notifications"></i><span class="badge-wrap"><span class="badge badge-primary badge-indicator badge-indicator-sm badge-pill pulse"></span></span></a>
                    <div class="dropdown-menu dropdown-menu-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <h6 class="dropdown-header">Notifications  </h6>
                        <div class="notifications-nicescroll-bar">
                       		<notification v-for="(notification,index) in notifications" :key="index" :notification="notification"></notification>
                        </div>
                    </div>
                </li>
</template>
<script type="text/javascript">
	import {eventBus} from  './../../../app';
	import Notification from './Notification.vue';
	export default{
		computed:{
			notifications(){
				return this.$store.getters.notifications;
			}
		},
		components:{
			Notification
		},
		created(){
			eventBus.$on('Notifications',notification => {
				var toast=new Object();
				if (notification.type=='follow') {
            		toast.html='<i class="jq-toast-icon fas  fa-user-check"></i> <a class="text-dark" href="/user/'+notification.info.user.username+'">'+notification.info.user.fullname+'</a> Started Following You!';
            		toast.type='jq-has-icon jq-toast-info';
				}
				else if(notification.type=='comment'){
					toast.html='<i class="jq-toast-icon fas fa-comments"></i> <a class="text-dark font-weight-bold" href="/user/'+notification.info.comment.user.username+'">'+notification.info.comment.user.fullname+'</a> commented on your <a class="text-primary font-weight-bold" href="/post/'+notification.info.comment.post_id+'">Post</a>';
				}
				else if(notification.type=='react'){
					toast.html='<i class="jq-toast-icon text-primary fas fa-heart"></i> <a class="text-dark font-weight-bold" href="/user/'+notification.info.user.username+'">'+notification.info.user.fullname+'</a> reacted on your <a class="text-primary font-weight-bold" href="/post/'+notification.info.post+'">Post</a>';
				}
				toast.time=10000;
				this.$store.commit('notification',notification);
        		this.$store.dispatch('Toast',toast);
			})
		}
	}
</script>