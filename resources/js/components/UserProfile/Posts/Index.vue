<template>
	<div id="main">
		<div class="hk-pg-header mb-10">
			<div>
				<h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-today"></i></span> Wall</h4>
			</div>
		</div>
			<post-composer v-if="currentUser.username==this.$route.params.id"></post-composer>
				<template v-if="DOMloaded">
					 
					<div v-if="posts.length==0" class="card card-lg"><div class="card-body"><div > <div>This user don't have any Posts.. </div></div></div></div>
					<post v-else  v-for="(post,index) in posts" :key="index" :post="post" :index="index"></post>
				</template>
				<template v-else>
					<loader></loader>
				</template>
		<react-modal></react-modal>
	</div>
</template>
<script type="text/javascript">
	import PostComposer from './PostComposer.vue'
	import Post from './Post.vue'
	import Loader from './../../Loader/FullScreen.vue';
	import {eventBus} from  './../../../app';
    import ReactModal from './../../Elements/ReactsModal/Index.vue';
	 
	export default{
		components:{
			PostComposer,Post,Loader,ReactModal
		},
		data(){
			return{
				DOMloaded:false,
				posts:[],
				showReactModal:false
			}
		},
		computed:{
		    currentUser(){
            	return this.$store.getters.user.user;
         	}
     	},
		created(){
			axios.post('/api/posts.'+this.$route.params.id)
			.then(res => {
				this.posts=res.data.data;
				this.DOMloaded=true;
			});
			//Remove Post From Main Feed;
			eventBus.$on('PostDeleted',index => {
				this.posts.splice(index,1);
			})

			eventBus.$on('AddPost',post => {
				this.posts.unshift(post);
				//console.log(post)
			})




		}
	}
</script>
<style type="text/css">
	.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>