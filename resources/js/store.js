import { eventBus } from './app'; 
export default{
	state:{
		token: localStorage.getItem('access_token') || null,
		tempReg:{},
		posts:null,
		user:{user:{username:''}},
		profileUser:{
			user:{
				info:{followings: '', followers: '0'},
				user:{fullname:''}
			}
		},
		chats:null,
		currentUser:{},
		//profilePage
		followers:[],
		followings:[],
		UserProfile:{usermeta:{}},
		UserLoaded:false,
		 
	},
	getters:{
		loggedIn(state){
			return state.token!==null;
		},
		posts(state){
			return state.posts;
		},
		user(state){
			return state.user;
		},
		notifications(state){
			return state.user.notifications;
		},
		profileData(state){
			return state.profileUser.user;
		},
		profileURL(){
       		 return '/images/profile/account/';
      	},
      	chats(state){
      		return state.chats;
      	},
      	authuser(state){
      		return state.currentUser;
      	},
      	followers(state){
      		return state.followers;
      	},
      	GetUserProfile(state){
      		return state.UserProfile;
      	},
      	GetUserProfileMeta(state){
      		return state.UserProfile.usermeta;
      	},
      	GetUserFollowers(state){
      		return state.followers;
      	},
      	GetUserFollowings(state){
      		return state.followings;
      	},
      	isUserLoaded(state){
      		return state.UserLoaded;
      	}

	},
	mutations:{
		UserLoaded(state,data){
			state.UserLoaded=data;
		},
		notification(state,notification){
			state.user.notifications.unshift(notification);
		},
		followers(state,data){
			//state.followers.username=data.username;
			state.followers=data.data;
		},
		chats(state,data){
			state.chats=data;
		},
		userCoverDetail(state,data){
	 		state.profileUser=data;
		},
		addFollow(state){
			state.user.info.followings++;
		},
		removeFollow(state){
			state.user.info.followings--;
		},
		addReact(state,index){
			state.posts[index].reacts_count++;
			state.posts[index].isLiked=true;
		},
		removeReact(state,index){
			state.posts[index].reacts_count--;
			state.posts[index].isLiked=false;
		},
		updatePost(state,data){
			//console.log(data);
			state.posts[data.index].body=data.body;
		},
		deletePost(state,index){
			state.posts.splice(index,1);
			state.user.info.posts--;

		},
		addPostToFeed(state,data){
			state.posts.unshift(data[0]);
			state.user.info.posts++;
		},
		fetchPosts(state,data){
			state.posts=data;
		},
		retriveToken(state,token){
			state.token=token
		},
		destroyToken(state){
			state.token=null;
			eventBus.$emit('logout');
			
		},
		deleteData(state){
			state.user=null;
			state.posts=null;
		},
		user(state,data){
			state.user=data;
			state.currentUser=data.user;
			eventBus.$emit('userdata');
		},
		addComment(state,index){
			state.posts[index].comments_count++;
		},
		deleteComment(state,index){
			state.posts[index].comments_count--;
		},
		SaveUserProfile(state,data){
			state.UserProfile=data;
		},
		SaveUserFollowers(state,data){
			state.followers=data;
		},
		SaveUserFollowings(state,data){
			state.followings=data;
		},
		setTempReg(state,data){
			state.tempReg.email=data.email;
			state.tempReg.pwd=data.pwd;
		},
	},
	actions:{
		LoadUserProfile(context,username){
			return new Promise((resolve, reject) => {
				axios.get('/api/u/'+username)
				.then(res =>{
					//console.log(res.data);
					resolve(res)
					context.commit('SaveUserProfile',res.data.user);
					context.commit('SaveUserFollowers',res.data.followers);
					context.commit('SaveUserFollowings',res.data.followings);
				})
				.catch(err => {
					reject(err)
				})
			});	
		},
		FollowerList(context,data){
			return new Promise((resolve, reject) => {
				axios.post('/api/follower.list',data)
				.then(res =>{
					resolve(res);	
					//console.log(this.$route.params.id);
					//context.commit('followers',{data:res.data.followers,username:data.username});
				})
				.catch(err =>{
					reject(err);
				})
			});
		},
		Toast(context,data){
			 
			var type=(data.type==null) ? 'jq-toast-primary' : data.type;
			 
			$.toast({
	            heading: data.heading || null,
				text: data.html,
				position: 'bottom-right',
				loaderBg:'#f68daf',
				class: type,
				hideAfter: data.time || 5000,
				stack: 6,
				showHideTransition: 'fade'
	        });
			return false;
		},
		chats(context){
			return new Promise((resolve,reject) => {
				axios.post('/api/chat.heads')
				.then(response => {
					resolve(response);
			 
					context.commit('chats',response.data);
				})
				.catch(err=>{
					reject(err);
				})
			})
		},
		validateUsername(context,username){
			return new Promise((resolve,reject) => {
				axios.post('/api/user/validate',{username:username})
				.then(response => {
					resolve(response);
				})
				.catch(err=>{
					reject(err);
				})
			})
		},
		LoadProfile(context,username){
			return new Promise((resolve,reject)=>{
				axios.get('/api/user/'+username)
					.then(res => {
						context.commit('userCoverDetail',res.data);
						//console.log(res.data)
						resolve(res);
					})
					.catch(er => {
						reject(er)
					})
			});
		},
		follow(context,id){
			return new Promise((resolve,reject) => {
				axios.post('/api/follow',{following:id})
				.then(response => {
					resolve(response);
					if (response.data.follow==true) {
						context.commit('addFollow');
					}
					else if(response.data.follow==false){
						context.commit('removeFollow');
					}
					else{
						return;	
					}
				})
				.catch(error => {
					reject(error);
				})
			})
		},
		react(context,data){
			return new Promise((resolve,reject) => {
				axios.post('/api/react',{postID:data.id})
				.then(response => {
					const react=response.data.res;
					var index=data.index;
					if (react==1) {
						context.commit('addReact',index);
					}
					else{
						context.commit('removeReact',index);
					}
					resolve(response);

				})
				.catch((error) => {
					reject(error);
				})
			})
		},
		updatePost(context,data){
			return new Promise((resolve,reject) => {
				axios.defaults.headers.common["Authorization"] = 'Bearer ' + context.state.token;
				axios.post('/api/post.update',{body:data.body,id:data.data.id})
				.then(response => {
					resolve(response);
					context.commit('updatePost',{body:data.body,index:data.data.index});
				})
				.catch(error => {

				});
			});
		},
		deletePost(context,data){
			return new Promise((resolve,reject) => {
				axios.defaults.headers.common["Authorization"] = 'Bearer ' + context.state.token;
				axios.post('/api/post.delete',{id:data.id})
				.then(response => {
					context.commit('deletePost',data.index);
					resolve(response);
				})
				.catch(error => {
					reject(error);
				});
			});
		},
		fetchPosts(context,data){
			return new Promise((resolve,reject) => {
				axios.defaults.headers.common["Authorization"] = 'Bearer ' + context.state.token;
				axios.post('/api/post.feed',{mode:data.mode})
				.then(response => {
					resolve(response)
					context.commit('fetchPosts',response.data.posts);
				})
				.catch(error => {
					reject(error);
					
					console.log(error);
				})
			});
		},
		ComposePost(context,data){
			return new Promise((resolve,reject) => {
				axios.defaults.headers.common["Authorization"] = 'Bearer ' + context.state.token;
				axios.post('/api/post.compose',{body:data})
				.then(res => {
					resolve(res);
					context.commit('addPostToFeed',res.data.post);
				})
				.catch(err => {
					reject(err);
					console.log(err)
				})
			});
		},
		user(context){
			return new Promise((resolve,reject) => {
					// Get user
					axios.defaults.headers.common["Authorization"] = 'Bearer ' + context.state.token;
					axios.post('/api/user')
					.then((response) =>{
						localStorage.setItem('username',response.data.user.username)
						context.commit('user',response.data);
						context.commit('UserLoaded',true);
						resolve(response);
					})
			});
		},
		retriveToken(context,credentials){
			return new Promise((resolve,reject) => {
				axios.post('api/login',{username:credentials.username,password:credentials.password})
				.then(res => {
					const token = res.data.access_token;
					localStorage.setItem('access_token',token);
					context.commit('retriveToken',token);
					resolve(res);
				})
				.catch(er => {
					reject(er);
				});
			});
		},
		destroyToken(context){
			if (context.getters.loggedIn) {
				return new Promise((resolve,reject) => {
					axios.defaults.headers.common["Authorization"] = 'Bearer ' + context.state.token;
					axios.post('/api/logout')
					.then(response => {
						localStorage.removeItem('access_token');
						localStorage.removeItem('username');
						localStorage.removeItem('user');
						localStorage.removeItem('post');
						
						context.commit('destroyToken'); 
						 
						resolve(response);
					})
					.catch(error => {
						reject(error);
					 	
						localStorage.removeItem('access_token');
						context.commit('destroyToken'); 
					});
				});
			}
		},
		register(context,details){
			return new Promise((resolve,reject) => {
				axios.post('/api/register',details)
				.then(response => {
					resolve(response); 
				})
				.catch(error => {
					 
					reject(error)
				})
			})
		}		
	}
}