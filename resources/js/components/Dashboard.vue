<template>
<!-- Container -->
<div class="container-fluid">
    <!-- Row -->
    <div class="row">
        <div class="col-xl-12 pa-0">
            <div class="tab-content mt-sm-60 mt-30">
                <div   role="tabpanel">
                    <div class="container">
                        <div class="hk-row">
                            <div class="col-lg-8">
                            <!-- Post composer -->
                                <post-composer></post-composer>
                                
                                <posts-feed></posts-feed>
                            </div>
                            <div class="col-lg-4">  
                                <profile-widget></profile-widget>
                                <follow-suggestion></follow-suggestion>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Row -->
</div>
<!-- /Container -->
</template>
<script >
    import PostComposer from './Posts/ComposePost.vue';
    import PostsFeed from './Posts/PostsFeed.vue';
    import ProfileWidget from './Widgets/ProfileWidget.vue';
    import FollowSuggestion from './Widgets/FollowWidget/FollowSuggestion.vue';
    export default{
        components:{
            PostComposer:PostComposer,
            PostsFeed:PostsFeed,
            ProfileWidget:ProfileWidget,
            FollowSuggestion:FollowSuggestion
        },
        methods:{

        },
        created(){
            if (this.$store.state.user==null) {
                this.$store.dispatch('user').then(()=>{

                })
            }
        }

    }
</script>