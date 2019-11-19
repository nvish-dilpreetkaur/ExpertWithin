<div class="col-md-12 col-sm-12">
@php $messageOne = isset($messageOne)? $messageOne:"" @endphp

	@if ($message = Session::get('success'))

	<div class="modal" id="success">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content success-modal">
	      <div class="modal-header">
	        <i class="fa fa-check" aria-hidden="true"></i>
	      </div>
	      <div class="modal-body">
	        <h4>Success</h4>
	        <p class="success-text">{{ $message }}</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger success-btn" data-dismiss="modal">Got it</button>
	      </div>
	    </div>
	  </div>
	</div>
	<script type="text/javascript">
	   $('#success').modal({show:true});
	</script>
	@endif

	@if ($message = Session::get('error'))
	<div class="alert alert-danger alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
	  <strong>{{ $message }}</strong>
	</div>
	@endif

	@if (session('status'))
		<div class="modal" id="success">
		<div class="modal-dialog modal-lg">
			<div class="modal-content success-modal">
			<div class="modal-header">
			<i class="fa fa-check" aria-hidden="true"></i>
			</div>
			<div class="modal-body">
			<h4>Success</h4>
			<p class="success-text">{{ session('status') }}</p>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-danger success-btn" data-dismiss="modal">Got it</button>
			</div>
			</div>
		</div>
		</div>
		<script type="text/javascript">
			$('#success').modal({show:true});
		</script>
	@endif

	@if ($message = Session::get('warning'))
	<div class="alert alert-warning alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		<strong>{{ $message }}</strong>
	</div>
	@endif


	@if ($message = Session::get('info'))
	<div class="alert alert-info alert-block">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		<strong>{{ $message }}</strong>
	</div>
	@endif


	@if ($errors->any())
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>	
		Please check the form below for errors
	</div>
	@endif

	@if($messageOne=='')
		<div class="modal front-msg-model" id="ajaxsuccess">
			<div class="modal-dialog modal-lg">
				<div class="modal-content success-modal">
				<div class="modal-header">
					<i class="fa fa-check" aria-hidden="true"></i>
				</div>
				<div class="modal-body">
					<h4>Success</h4>
					<p class="success-text">{{ $message }}</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger success-btn" data-dismiss="modal">Got it</button>
				</div>
				</div>
			</div>
		</div>

	@endif

	@if($messageOne!='')
		<div class="col-md-12 col-sm-12">
    	<div class="modal show" id="success" aria-modal="true" style="padding-right: 0px; display: block;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content success-modal">
                <div class="modal-header">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </div>
                <div class="modal-body">
                    <h4>Success</h4>
                    <p class="success-text">{{$messageOne}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger success-btn" data-dismiss="modal">Got it</button>
                </div>
            </div>
        </div>
    </div>
	</div>
	@endif
	
	 
</div>

