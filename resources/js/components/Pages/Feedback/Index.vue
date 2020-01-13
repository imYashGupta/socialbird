<template>
<div class="container mt-25">
	<div class="hk-pg-header mb-10">
		<div>
			<h4 class="hk-pg-title">
			<span class="pg-title-icon">
				<i class="ion ion-ios-heart-half">
				</i>
			</span>
			Feedback
			</h4>
		</div>
		<div class="d-flex ">
			<router-link tag="button" to="/" class="btn btn-light btn-sm ">
			Home
			</router-link>
		</div>
	</div>
	<section class="hk-sec-wrapper">
		<h5 class="hk-sec-title">Send your Feedback</h5>
		<p class="mb-40">Report bugs and suggest any improvement.</p>
		<div class="row">
			<div class="col-sm">
				<form @submit.prevent="sendFeedback()"  id="feedbackform">
					<div class="form-group mb-0">
						<div class="fileinput input-group fileinput-new" data-provides="fileinput">
							<div class="input-group-prepend">
								<span class="input-group-text">Screenshot or Image</span>
							</div>
							<div class="form-control text-truncate" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
							<span class="input-group-append">
								<span class=" btn btn-primary btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span>
								<input type="hidden" value="" name="..."><input type="file" name="image">
							</span>
							<a href="#" class="btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a>
						</span>
					</div>
				</div>
				<div class="form-group mt-3">
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">Your Message</span>
						</div>
						<textarea required="" class="form-control" name="message"  ></textarea>
					</div>
				</div>
				<hr>
				<button class="btn btn-primary" ref="submitBtn" type="submit">
					Submit feedback   
					<span v-if="sendingFeedback" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
				</button>
			</form>
			<div v-if="feedbackSent===true" class="alert alert-inv alert-inv-primary alert-wth-icon alert-dismissible fade show mt-3" role="alert">
                <span class="alert-icon-wrap"><i class="zmdi zmdi-check-circle"></i></span><strong>Thanks!</strong> Your Feedback has been sent successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div v-if="feedbackSent===false" class="alert alert-inv alert-inv-danger alert-wth-icon alert-dismissible fade show mt-3" role="alert">
                <span class="alert-icon-wrap"><i class="zmdi zmdi-bug"></i></span><strong>Oops Error!</strong> Please Check all Fields,Message is required and Images must not be more then 2MB.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
		</div>
	</div>
</section>
</div>
</template>
<script type="text/javascript">
	export default{
		data(){
			return{
				sendingFeedback:false,
				feedbackSent:null,
			}
		},
		methods:{
			sendFeedback(){
				this.sendingFeedback=true;
				$(this.$refs["submitBtn"]).attr('disabled','');
				let data=new FormData($("#feedbackform")[0]);
				axios.post('/api/feedback.submit',data)
				.then(res => {
					$(this.$refs["submitBtn"]).removeAttr('disabled','');	
					this.sendingFeedback=false;
					this.feedbackSent=true;
					$("#feedbackform")[0].reset();

				})	
				.catch(err => {
					console.log(err)
					this.sendingFeedback=false;
					this.feedbackSent=false;
					$(this.$refs["submitBtn"]).removeAttr('disabled','');	

				})
			}
		}
	}
</script>