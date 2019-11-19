@extends('layouts.admin')
@section('content')  
@include('common.admin-nav') 
 <!-- Dashboard start -->
 <section class="section-dashboard" >
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<div class="block-graph-cont">
					<h5>Skills on demand</h5>
					<ul>
						<li>246K</li>
						<li>
							<!-- <div id="myDiv"></div> -->
                        <img src="{{ URL::asset('images/img-graph-blue.jpg') }}" alt="">
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="block-graph-cont">
					<h5>Skills on demand</h5>
					<ul>
						<li>246K</li>
						<li>
							<!-- <div id="myDiv"></div> -->
                        <img src="{{ URL::asset('images/img-graph-purple.jpg') }}" alt="">
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="block-graph-cont">
					<h5>Skills on demand</h5>
					<ul>
						<li>246K</li>
						<li>
							<!-- <div id="myDiv"></div> -->
							<img src="{{ URL::asset('images/img-graph-green.jpg') }}" alt="">
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="block-graph-cont">
					<h5>Skills on demand</h5>
					<ul>
						<li>246K</li>
						<li>
							<!-- <div id="myDiv"></div> -->
                            <img src="{{ URL::asset('images/img-graph-blue.jpg') }}" alt="">
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="opportunity-cont">
					<ul class="list-opportunity">
						<li>
							<div class="row">
								<div class="col-lg-12">
									<h4>Skills on demand</h4>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<strong>OPPORTUNITY:</strong>
									</div>
									<div class="col-lg-2">
										<strong>START:</strong>
									</div>
									<div class="col-lg-2 text-right">
										<strong>END:</strong>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<label for="">MARKETING</label> 
										<span class="skills-cont">UX/ UI Designer</span>
									</div>
									<div class="col-lg-2">
										<span class="start-date-cont">2019-8-21</span>
									</div>
									<div class="col-lg-2 text-right">
										<span class="end-date-cont">2019-8-23</span>
									</div>
								</div>
							</div>
						</li>
					</ul>

					<ul class="list-opportunity">
						<li>
							<div class="row">
								<div class="col-lg-12">
									<h4>Most applied opportunities</h4>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<strong>OPPORTUNITY:</strong>
									</div>
									<div class="col-lg-2">
										<strong>START:</strong>
									</div>
									<div class="col-lg-2 text-right">
										<strong>END:</strong>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<label for="">MARKETING</label> 
										<span class="skills-cont">UX/ UI Designer</span>
									</div>
									<div class="col-lg-2">
										<span class="start-date-cont">2019-8-21</span>
									</div>
									<div class="col-lg-2 text-right">
										<span class="end-date-cont">2019-8-23</span>
									</div>
								</div>
							</div>
						</li>
					</ul>


					<ul class="list-opportunity">
						<li>
							<div class="row">
								<div class="col-lg-12">
									<h4>Most liked opportunities</h4>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<strong>OPPORTUNITY:</strong>
									</div>
									<div class="col-lg-2">
										<strong>START:</strong>
									</div>
									<div class="col-lg-2 text-right">
										<strong>END:</strong>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<label for="">MARKETING</label> 
										<span class="skills-cont">UX/ UI Designer</span>
									</div>
									<div class="col-lg-2">
										<span class="start-date-cont">2019-8-21</span>
									</div>
									<div class="col-lg-2 text-right">
										<span class="end-date-cont">2019-8-23</span>
									</div>
								</div>
							</div>
						</li>
					</ul>

					<ul class="list-opportunity">
						<li>
							<div class="row">
								<div class="col-lg-12">
									<h4>Most viewed opportunities</h4>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<strong>OPPORTUNITY:</strong>
									</div>
									<div class="col-lg-2">
										<strong>START:</strong>
									</div>
									<div class="col-lg-2 text-right">
										<strong>END:</strong>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="container-fluid">
								<div class="row">
									<div class="col-lg-8">
										<label for="">MARKETING</label> 
										<span class="skills-cont">UX/ UI Designer</span>
									</div>
									<div class="col-lg-2">
										<span class="start-date-cont">2019-8-21</span>
									</div>
									<div class="col-lg-2 text-right">
										<span class="end-date-cont">2019-8-23</span>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
 <!-- Dashboard end -->
@endsection