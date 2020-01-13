<template>
<div class="container mt-25">
	<div class="hk-pg-header mb-10"><div><h4 class="hk-pg-title"><span class="pg-title-icon"><i class="ion ion-ios-list"></i></span>Change Logs</h4></div> <div class="d-flex  "><router-link  tag="button" to="/" class="btn btn-light btn-sm  ">Home</router-link></div></div>
	<div class="card card-lg">
		<h6 class="card-header text-primary">20 Sept,2019 (v6.0) <small class="text-dark">Current Version	</small></h6>
		<div class="card-body">
			<ul class="pl-3">
				<li>Option to add media like images in post</li>
				<li>Seprate tab for photo in user profile.</li>
				<li>Bugs fixes and UI improvement</li>
			</ul>
		</div>
	</div>
	<div class="card card-lg">
		<h6 class="card-header">10 Sept,2019 (v5.0) </h6>
		<div class="card-body">
			<ul class="pl-3">
				<li>Real timeNotifications Added for Comment on post,reacts and Follow.</li>
				<li>Option to see list of follower and following added</li>
				<li>Bugs fixes and UI improvement</li>
			</ul>
		</div>
	</div>
	<div class="card card-lg">
		<h6 class="card-header" id="current">25 Aug,2019 (v4.0) </h6>
		<div class="card-body">
			<ul class="pl-3">
				<li>Activity Tab added in user page,logs are for reaction and comments on other user posts and follows.</li>
				<li>Feed Got Dynamic with 1 more option i.e Explore view all post of website form all user </li>
				<!-- <li>Post Filter added on Feed , filter posts by data to Asc,desc order(more to come).</li> -->
				<li>Bugs fixes and UI improvement</li>
			</ul>
		</div>
	</div>
	<div class="card card-lg">
		<h6 class="card-header  ">15 Aug,2019 (v3.0)    </h6>

		<div class="card-body">
			<ul class="pl-3">
				<li>Real time chat added users can now communicate with each other.</li>
				<li>Real time message notification added.</li>
				<li>Widget added on feed page (user profile, follow suggestions)</li>
				<li>404( Page not found) page added for unknown url</li>
				<li>Bugs fixes and UI improvement</li>
			</ul>
		</div>
	</div>
	<div class="card card-lg">
		<h6 class="card-header">2 Aug,2019 (v2.0) </h6>
		<div class="card-body">
			<ul class="pl-3">
				<li>Profile page Added.</li>
				<li>Edit or update user profile.</li>
				<li>Follow system introduce.</li>
				<li>Post View option added on post(seprate page for post).</li>
				<li>Bugs fixes and UI improvement</li>

			</ul>
		</div>
	</div>
	<div class="card card-lg">
		<h6 class="card-header">26 July,2019 (v1.0) </h6>
		<div class="card-body">
			<ul class="pl-3">
				<li>Application initialize with authentication.</li>
				<li>Posts are now can be created.</li>
				<li>Feed Created, can see other user posts and yours.</li>
				<li>Edit and delete button introduce for post.</li>
				<li>Comment introduce with compose,edit delete on post.</li>
				<li>Heart Reaction's Introduce on post.</li>
				<li>reaction view modal added.</li>
				<li>Bugs fixes and UI improvement</li>

			</ul>
		</div>
	</div>
</div>
</template>
<script type="text/javascript">
	export default{
		created(){
			window.location.hash='current';
		}
	}
</script>
<style type="text/css" scoped="">
	li{
		list-style: circle;
	}
</style>