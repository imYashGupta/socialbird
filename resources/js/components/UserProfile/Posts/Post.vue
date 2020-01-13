<template>
	<div class="card-columns card-column-1 ">
    <div class="card card-profile-feed mb-0 rounded-bottom-0 shadow-sm shadow-hover-lg mt-3">
        <div class="card-header card-header-action">
            <div class="media align-items-center">
                <div class="media-img-wrap d-flex mr-10">
                       <avatar :avatar="{size:'md',firstname:post.user.firstname,lastname:post.user.lastname,color:post.user.avatar,image:post.user.images}"></avatar>
                </div>
                <div class="media-body">
                    <div class="text-capitalize font-weight-500 text-dark pointer"> {{post.user.fullname}} </div>
                    <div class="font-13"> {{post.created_at}} </div> 
                </div>
            </div>
            <div class="d-flex align-items-center card-action-wrap">
                <div class="inline-block dropdown">
                    <a aria-expanded="false" class="dropdown-toggle no-caret" data-toggle="dropdown" href="#" role="button"> <i class="ion ion-ios-more"> </i> </a> <div class="dropdown-menu dropdown-menu-right">
                        <router-link class="dropdown-item" :to="'/post/'+post.id"> View </router-link> 
                        <template v-if="currentUser.username==post.user.username">
                        	<router-link class="dropdown-item" :to="'/post/'+post.id+'/edit'"> Edit </router-link> 
                        	<a class="dropdown-item" href="#" @click.prevent="deletePost()"> Delete  </a> 
                        </template>
                    	<template v-else>
                            <follow-dropdown-btn :isFollower="post.user.follower" :id="post.user.id"></follow-dropdown-btn>
                             
                    	</template>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text mb-30"> {{post.body}} </p>
                <div class="card" v-if="post.images==1">
                    <div class="position-relative">
                        <img data-action="zoom"  class="card-img-top rounded d-block" :src="'/images/posts/'+post.media.image[0].name" alt="Card image cap">
                    </div>
                </div>
        </div>
        <div class="card-footer justify-content-between">
            <div>
                <react-btn :id="post.id" :reacts="post.reacts_count" :isliked="post.isLiked" ></react-btn>
            </div>
            <div>
                <a href="#" @click.prevent="post.options.showComments=!post.options.showComments"> {{post.comments_count}} comments </a>
            </div>
        </div>
    </div>
   	<comments v-if="post.options.showComments" :id="post.id" ></comments>
</div>
</template>
<script type="text/javascript">
    import avatar from './../../Elements/Avatar.vue';
	import ReactBtn from './../../Elements/ReactBtn.vue';
	import {helper} from './../../../helper';
	import {eventBus} from './../../../app';
	import Comments from './Comments/Index.vue';
    import FollowDropdownBtn from './../../Elements/FollowBtnDropDown.vue'


	export default{
		components:{
			avatar,Comments,ReactBtn,FollowDropdownBtn
		},
		props:['post','index'],
		computed:{
		    currentUser(){
            	return this.$store.getters.user.user;
         	}
     	},
		methods:{
			deletePost(){
				swal({
					title: "Are you sure?",
					text: "Once deleted, you will not be able to recover this Post!",
					icon: "warning",
					buttons: true,
					dangerMode: true,
				})
				.then((willDelete) => {
					if (willDelete) {
						helper.API.DeletePost(this.post.id)
						.then(res => {
							swal("Poof! Your Post has been deleted!", {
								icon: "success",
					    	});
					    	eventBus.$emit('PostDeleted',this.index);
						})
					}
				});
			}
		}
	}
</script>