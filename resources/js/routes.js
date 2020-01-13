//auth 
import Login from './components/auth/Login.vue';
import Register from './components/auth/Register.vue';
import Start from './components/auth/Start.vue';
import Logout from './components/auth/Logout.vue';
//pages
import Dashboard from './components/Dashboard.vue';
import UserProfile from './components/Profile/UserProfile.vue';
	import UserProfilePosts from './components/Profile/PostTab/UserPosts.vue';
	import UserActivity from './components/Profile/ActivityTab/index.vue';
	import UserEdit from './components/Profile/EditTab/Index.vue';
	
import Chat from './components/Chat/Chat.vue';
 	import ChatIndex from './components/Chat/ChatBox/Index.vue';
 	import Conversation from './components/Chat/ChatBox/ChatBox.vue';
import Post from './components/Pages/Post/Index.vue'
	import PostEdit from './components/Pages/Post/Edit.vue'
import Error404 from './components/pages/Errors/404.vue';
import ChangeLog from './components/pages/Misc/ChangeLog.vue';
import About from './components/pages/Misc/About.vue';
import UserProfileNew from "./components/UserProfile/Index.vue";
	import UserProfilePostsNew from "./components/UserProfile/Posts/Index.vue";
	import UserActivityNew from "./components/UserProfile/Activity/Index.vue";
	import UserEditNew from "./components/UserProfile/Edit/Index.vue";
	import followers from './components/UserProfile/followers/Index.vue';
	import followings from './components/UserProfile/followings/Index.vue';
	import UserPhotos from './components/UserProfile/Photos/Index.vue';
	import noti from './components/Pages/NotiTest/Index.vue';
import Feedback from './components/Pages/Feedback/Index.vue';
import Search from './components/Search/Index.vue';

export const routes  =[
	{
		path:'/',
		component:Dashboard,
		name:'home',
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/login',
		component:Login,
		name:'login',
		meta:{
			guests:true
		}
	},
	{
		path:'/register',
		component:Register,
		name:'register',
		meta:{
			guests:true
		}
	},
	{
		path:'/start',
		component:Start,
		name:'start',
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/changeLog',
		component:ChangeLog,
			meta:{
			requiresAuth:true
		}
	},
	{
		path:'/about',
		component:About,
		name:'about'
	},
	{
		path:'/dashboard',
		component:Dashboard,
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/logout',
		component:Logout,
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/chats',
		component:Chat,
		children:[
			{name:'chatindex',path:'/',component:ChatIndex},
			{name:'chat',path:':id',component:Conversation,name:'chatUser'}
		],
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/post/:id',
		name:'singlePost',
		component:Post,
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/post/:id/edit',
		name:'singlePostEdit',
		component:PostEdit,
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/404',
		name:'error404',
		component:Error404,
	},
	{
		path:'/user/:id',
		component:UserProfileNew,
		children:[
			{path:'',component:UserProfilePostsNew,name:"UserPosts"},
			{path:'activity',component:UserActivityNew,name:"UserActivity"},
			{name:'Userfollowers' ,path: 'followers', component: followers },
			{name:'Userfollowings' ,path: 'followings', component: followings },
			{name:'UserEdit' ,path: 'edit', component: UserEditNew},
			{name:'UserPhotos' ,path: 'photos', component: UserPhotos},

		]
	},
	{
		path:'/feedback',
		component:Feedback,
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'/search',
		component:Search,
		name:'search',
		meta:{
			requiresAuth:true
		}
	},
	{
		path:'*',
		name:'error404',
		component:Error404,
	},
 
];

