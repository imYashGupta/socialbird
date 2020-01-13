<template>
	<div>
   <div class="container-fluid">
      <div class="row" v-if="!loading">
         <div class="col-xl-12 pa-0">
            <div class="profile-cover-wrap overlay-wrap" >
               <div class="profile-cover-img " :class="'bg-gradient-'+profile.background"  ></div>
               <div class="bg-overlay bg-trans-dark-30"></div>
               <div class="container profile-cover-content py-50">
                  <div class="hk-row">
                     <div class="col-lg-6">
                        <div class="media align-items-center">
                           <div class="media-img-wrap  d-flex ">
                              <div class="avatar " :class="(authuser) ?'avatar-change' : ''" @click="openFiles()">
                                 <img v-if="profile.images!=null" :src="profile.images" alt="user" class="avatar-img rounded-circle shadow-xl">
                                 <span v-else class="avatar-text shadow-xl  rounded-circle" :class="'avatar-text-'+profile.avatar">
                                    <span class="initial-wrap">
                                       <span v-if="profile.firstname">{{ profile.firstname.charAt(0)+profile.lastname.charAt(0) }}</span>
                                    </span>
                                    <div class="text-center pt-4 font-30 editclass  ">
                                        <i class="far fa-image"></i>
                                    </div>
                                 </span>
                                <input v-if="authuser" type="file" id="profile" class="d-none" @change="ImageChange" >
                              </div>
                           </div> 
                           <div class="media-body">
                              <div class="text-white text-capitalize display-6 mb-5 font-weight-400">
	                              {{profile.fullname}}
                              </div>
                              <div class="font-14 text-white"><span class="  "><span class="font-weight-500 pl-5">
                                  {{profile.usermeta.title}}
                                 </span></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="button-list">
                            <!-- <a  class="btn btn-wth-icon icon-wthot-bg btn-rounded btn-outline-primary" href="#">
                                <span class="btn-text pl-25">Follow </span>
                                <span class="icon-label"> <i class="fas fa-user-plus"> </i> </span> </a> -->
                            <follow-btn v-if="!authuser" :follow="profile.follower" :id="profile.id"></follow-btn>
                            <router-link v-if="!authuser" class="btn btn-dark btn-wth-icon icon-wthot-bg btn-rounded" :to="'/chats/'+profile.username">
                                <span class="btn-text"> Message </span> <span class="icon-label"> <i class="icon ion-md-mail"> </i> </span> </router-link>
                            <a v-if="usermeta.social.facebook!='' && usermeta.social.facebook!=null" class="btn btn-icon btn-icon-circle btn-indigo " :href="'https://facebook.com/'+usermeta.social.facebook">
                                <span class="btn-icon-wrap"> <i class="fab fa-facebook-f"> </i> </span> </a>
                            <a v-if="usermeta.social.twitter!='' && usermeta.social.twitter!=null" class="btn btn-icon btn-icon-circle btn-sky " :href="'https://twitter.com/'+usermeta.social.twitter">
                                <span class="btn-icon-wrap"> <i class="fab fa-twitter"> </i> </span> </a>
                            <a aria-expanded="false" class="btn dropdown-toggle btn-icon btn-icon-circle btn-dark border-0" data-toggle="dropdown" href="#">
                                <span class="btn-icon-wrap"> <i class="fas fa-ellipsis-v"> </i> </span> </a>
                            <div class="dropdown-menu" role="menu" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(515px, 70px, 0px);" x-placement="bottom-start">
                                <a class="dropdown-item" href="#"   @click.prevent="openBackgrounds" v-if="authuser"> Change Background </a> 
                                <a class="dropdown-item" :href="'https://instagram.com/'+usermeta.social.instagram" v-if="usermeta.social.instagram!='' && usermeta.social.instagram!=null"> Instagram </a>

                               <!--  <a class="dropdown-item" href="#"> Another action </a>
                                <a class="dropdown-item" href="#"> Something else here </a> 
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"> Separated link </a>  -->
                                 
                                <a v-if="!authuser" class="dropdown-item" href="#" @click.prevent> Report </a>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="bg-white shadow-bottom">
               <div class="container">
                  <ul role="tablist" class="nav nav-light nav-tabs">
                     <li class="nav-item"><router-link :to="'/user/'+profile.username" class="d-flex h-60p align-items-center nav-link" active-class="active" exact>Posts</router-link></li>
                     <li class="nav-item"><router-link :to="'/user/'+profile.username+'/activity'" class="d-flex h-60p align-items-center nav-link" active-class="active" exact>Activity</router-link></li>
                     <li class="nav-item" v-if="currentUser.username==this.$route.params.id"><router-link :to="'/user/'+profile.username+'/edit'" class="d-flex h-60p align-items-center nav-link" active-class="active" exact>Edit Profile</router-link></li>
                     <li class="nav-item"><router-link :to="'/user/'+profile.username+'/photos'" class="d-flex h-60p align-items-center nav-link" active-class="active" exact>Photos</router-link></li>
                  </ul>
               </div>
            </div>
            <div class="tab-content mt-sm-60 mt-30">
               <div role="tabpanel" class="tab-pane fade show active">
                  <div class="container">
                     <div class="hk-row">
                        <div class="col-lg-8" :class="['Userfollowers','Userfollowings'].includes(this.$route.name) ? 'col-lg-12' : 'col-lg-8' ">
                            <router-view></router-view>
                        </div>
                        <div class="col-lg-4" v-if="['UserPosts','UserActivity','UserEdit'].includes(this.$route.name)">
                              <follower-list></follower-list>
                              <following-list></following-list>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div v-else>
          <loader></loader>
      </div>
   </div>
   <background :currentbg="profile.background" v-if="backgroundModal"></background>
</div>
</template>
<script type="text/javascript">
    import FollowerList from "./../Widgets/Follower/Index.vue";
    import FollowingList from "./../Widgets/Following/Index.vue";
    import background from './Edit/BackgroundModal/Index.vue'
    import {eventBus} from  './../../app';
    import FollowBtn from './../Elements/FollowBtn.vue'
    import Loader  from './../Loader/FullScreen.vue';

	export default{
		components:{
			FollowerList,FollowingList,background,FollowBtn,Loader

		},
        data(){
            return {
                title:'',
                backgroundModal:false,
                profileImage:null,
                loading:true,
            }
        },
        computed:{
             profile(){
                return this.$store.getters.GetUserProfile;
             },
             usermeta(){
                return this.$store.getters.GetUserProfileMeta;
             },
             currentUser(){
                return this.$store.getters.user.user;
             },
             authuser(){
                return this.$store.getters.user.user.username==this.profile.username;
             }
 
        },
          methods:{
                openBackgrounds(){
                    this.backgroundModal=true;
                    setTimeout(_=>{
                        $('.bd-bg-modal').modal('show');
                    },100);
                },
                openFiles(){
                    if (this.authuser) {
                        document.getElementById('profile').click();
                    }
                    else{
                        return false;
                    }
                },
                ImageChange(e){
                    var vue=this;
                   // console.log(e.target.files[0])
                    var fileReader= new FileReader()
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.profile.images=e.target.result;
                        axios.post('/api/user/update.image',{image:e.target.result})
                        .then(res=>{
                            //console.log(res)
                            let data={
                                heading:'Success!',
                                html:'Profile Picture Updated!',
                                type:'jq-toast-success'
                            }
                            this.$store.dispatch('Toast',data);
                        })
                        .catch(er =>{
                             this.profile.images=null;
                            let data={
                                heading:'Error!',
                                html:'Bad Method Exception. Contact support!',
                                type:'jq-toast-danger'
                            }
                            this.$store.dispatch('Toast',data);
                        })

                    }
                }
            },
	        created(){
			    let username=this.$route.params.id;
			    if (username!=this.$store.getters.GetUserProfile.username) {
				    this.$store.dispatch('LoadUserProfile',username)
                    .then(res => {
                        this.loading=false;
                    })
			    }else{
                    this.loading=false;
                }

                eventBus.$on('changeBackground',bg => {
                    this.profile.background=bg;
                })
                eventBus.$on('saveBackground',_ => {
                    axios.post('/api/user/update.background',{username:this.$route.params.id,background:this.profile.background})
                    .then(res=>{
                        //console.log(res)
                    })
                });

                
		    }
	}
</script>
<style type="text/css" >
  .avatar-change:hover{
    opacity: 0.5;
    cursor: pointer;
  }

  .editclass{
    display: none;
  }
      .avatar-change:hover .initial-wrap{
      display: none;
    }
    .avatar-change:hover .editclass{
      display: block !important;
    }
</style>