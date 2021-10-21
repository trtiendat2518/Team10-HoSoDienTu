@extends('lecturer.layout');
@section('lecturer-content')
<!-- app-content-->
<div class="app-content  my-3 my-md-5 toggle-content">
	@if (Session::get('admin_id'))
		<div class="side-app" style="padding-top: 0px;">
			<!-- page-header -->
			<div class="page-header">
				<ol class="breadcrumb"><!-- breadcrumb -->
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active" aria-current="page">Dashboard 01</li>
				</ol><!-- End breadcrumb -->
				<div class="ml-auto">
					<div class="input-group">
						<a  class="btn btn-primary text-white mr-2"  id="daterange-btn">
							<span>
								<i class="fa fa-calendar"></i> Events Settings
							</span>
							<i class="fa fa-caret-down"></i>
						</a>
						<a href="#" class="btn btn-secondary text-white" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Rating">
							<span>
								<i class="fa fa-star"></i>
							</span>
						</a>
					</div>
				</div>
			</div>
			<!-- End page-header -->

			<div class="row">
				<div class="col-md-12">
					<div class="owl-carousel owl-carousel2 owl-theme mb-5">
						<div class="item">
							<div class="card mb-0">
								<div class="row">
									<div class="col-4">
										<div class="feature">
											<div class="fa-stack fa-lg fa-2x icon bg-primary-transparent">
												<i class="si si-briefcase  fa-stack-1x text-primary"></i>
											</div>
										</div>
									</div>
									<div class="col-8">
										<div class="card-body p-3  d-flex">
											<div>
												<p class="text-muted mb-1">Total Income</p>
												<h2 class="mb-0 text-dark">18,367K</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="card mb-0">
								<div class="row">
									<div class="col-4">
										<div class="feature">
											<div class="fa-stack fa-lg fa-2x icon bg-success-transparent">
												<i class="si si-drawer fa-stack-1x text-success"></i>
											</div>
										</div>
									</div>
									<div class="col-8">
										<div class="card-body p-3  d-flex">
											<div>
												<p class="text-muted mb-1">Total Profit</p>
												<h2 class="mb-0 text-dark">35%</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="card mb-0">
								<div class="row">
									<div class="col-4">
										<div class="feature">
											<div class="fa-stack fa-lg fa-2x icon bg-pink-transparent">
												<i class="si si-layers fa-stack-1x text-pink"></i>
											</div>
										</div>
									</div>
									<div class="col-8">
										<div class="card-body p-3  d-flex">
											<div>
												<p class="text-muted mb-1">Total Revenue</p>
												<h2 class="mb-0 text-dark">3,548K</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="card mb-0">
								<div class="row">
									<div class="col-4">
										<div class="feature">
											<div class="fa-stack fa-lg fa-2x icon bg-warning-transparent">
												<i class="si si-chart fa-stack-1x text-warning"></i>
											</div>
										</div>
									</div>
									<div class="col-8">
										<div class="card-body p-3  d-flex">
											<div>
												<p class="text-muted mb-1">Total Sales</p>
												<h2 class="mb-0 text-dark">9,756</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card card-bgimg br-7">
						<div class="row">
							<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
								<div class="card-body text-center">
									<h5 class="text-white">Today</h5>
									<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">863</h2>
									<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
								<div class="card-body text-center">
									<h5 class="text-white">Yesterday</h5>
									<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">1,364</h2>
									<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
								<div class="card-body text-center">
									<h5 class="text-white">Last Week</h5>
									<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">3,876</h2>
									<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
								<div class="card-body text-center">
									<h5 class="text-white">Last Month</h5>
									<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">8,547</h2>
									<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
								<div class="card-body text-center">
									<h5 class="text-white">Last 6Months</h5>
									<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">12,976</h2>
									<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
								</div>
							</div>
							<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
								<div class="card-body text-center">
									<h5 class="text-white">Last Year</h5>
									<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">24,844</h2>
									<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-7 col-lg-12 col-md-12">
					<div class="card">
						<div class="card-header custom-header">
							<div>
								<h3 class="card-title">Click  Conversion</h3>
								<h6 class="card-subtitle">Overview of Latest Month</h6>
							</div>
							<div class="card-options">
								<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									<span class="fa fa-ellipsis-v"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right" role="menu">
									<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
									<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
									<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
									<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
								</ul>
							</div>
						</div>
						<div class="card-body">
							<div>
								<canvas id="conversion" class="chart-drop"></canvas>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-xl-3 col-lg-6 col-sm-6">
									<div class="text-center mt-0">
										<h5 class="mb-1 text-muted">Total Users</h5>
										<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">1,653</h2>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6 col-sm-6">
									<div class="text-center mt-4 mt-sm-0">
										<h5 class="mb-1 text-muted">Total Leads</h5>
										<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">639</h2>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6 col-sm-6">
									<div class="text-center mt-4 mt-lg-0">
										<h5 class="mb-1 text-muted">Total Trials</h5>
										<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">12,765</h2>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6 col-sm-6">
									<div class="text-center mt-4 mt-lg-0">
										<h5 class="mb-1 text-muted">Total Wins</h5>
										<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">24</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl-5 col-lg-12 col-md-12">
					<div class="card">
						<div class="card-header custom-header">
							<div>
								<h3 class="card-title">Active Users</h3>
								<h6 class="card-subtitle">Users</h6>
							</div>
							<div class="card-options">
								<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									<span class="fa fa-ellipsis-v"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right" role="menu">
									<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
									<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
									<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
									<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
								</ul>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-4">
									<div class="chart-circle mt-2 mb-2" data-value="0.80" data-thickness="10" data-color="#1753fc">
										<div class="chart-circle-value"><div class="fs-2">80% </div></div>
									</div>
								</div>
								<div class="col-md-8">
									<h4 class="mb-5">Active Users</h4>
									<div class="mb-5">
										<h5 class="mb-2 d-block">
											<span class="fs-16"><b>74,526</b> Email Accounts</span>
											<span class="float-right">80%</span>
										</h5>
										<div class="progress progress-md h-1">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-80"></div>
										</div>
									</div>
									<div class="mb-0">
										<h5 class="mb-2 d-block">
											<span class="fs-16"><b>14,526</b> Requests</span>
											<span class="float-right">30%</span>
										</h5>
										<div class="progress progress-md h-1">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger w-30"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-8">
									<h4 class="mb-5">Deactive Users</h4>
									<div class="mb-5">
										<h5 class="mb-2 d-block">
											<span class="fs-16"><b>7,325</b> Email Accounts</span>
											<span class="float-right">20%</span>
										</h5>
										<div class="progress progress-md h-1">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-20"></div>
										</div>
									</div>
									<div class="mb-0">
										<h5 class="mb-2 d-block">
											<span class="fs-16"><b>1,425</b> Directly</span>
											<span class="float-right">30%</span>
										</h5>
										<div class="progress progress-md h-1">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger w-1"></div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="chart-circle mt-2" data-value="0.30" data-thickness="10" data-color="#e34a42">
										<div class="chart-circle-value"><div class="fs-2">30% </div></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-4 col-lg-12 col-md-12">
					<div class="card">
						<div class="card-header custom-header">
							<div>
								<h3 class="card-title">Top Ongoing Projects</h3>
								<h6 class="card-subtitle">Overview this Month</h6>
							</div>
							<div class="card-options">
								<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									<span class="fa fa-ellipsis-v"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right" role="menu">
									<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
									<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
									<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
									<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
								</ul>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="list-group projects-list">
								<a href="#" class="list-group-item list-group-item-action flex-column align-items-start border-top-0">
									<div class="d-flex w-100 justify-content-between">
										<h5 class="mb-1 font-weight-sembold">PSD Projects</h5>
										<small class="text-danger"><i class="fa fa-caret-down mr-1"></i>5 days ago</small>
									</div>
									<p class="mb-0 text-dark">Started:17-02-2019</p>
									<small class="text-muted">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</small>
								</a>
								<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
									<div class="d-flex w-100 justify-content-between">
										<h5 class="mb-1 font-weight-sembold">Wordpress Projects</h5>
										<small class="text-success"><i class="fa fa-caret-up mr-1"></i>2 days ago</small>
									</div>
									<p class="mb-0 text-dark">Started:15-02-2019</p>
									<small class="text-muted">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</small>
								</a>
								<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
									<div class="d-flex w-100 justify-content-between">
										<h5 class="mb-1 font-weight-sembold">HTML & CSS3 Projects</h5>
										<small class="text-danger"><i class="fa fa-caret-down mr-1"></i>1 days ago</small>
									</div>
									<p class="mb-0 text-dark">Started:26-02-2019</p>
									<small class="text-muted">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</small>
								</a>
								<a href="#" class="list-group-item list-group-item-action flex-column align-items-start br-br-7 br-bl-7">
									<div class="d-flex w-100 justify-content-between">
										<h5 class="mb-1 font-weight-sembold">Java Projects</h5>
										<small class="text-success"><i class="fa fa-caret-up mr-1"></i>10 days ago</small>
									</div>
									<p class="mb-0">Started:06-02-2019</p>
									<small>Donec id elit non mi porta gravida at eget metus.</small>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-8 col-lg-12 col-md-12">
					<div class="card">
						<div class="card-header custom-header">
							<div>
								<h3 class="card-title">Acquisitions by Campaign</h3>
								<h6 class="card-subtitle">Overview of all Campaign</h6>
							</div>
							<div class="card-options d-none d-sm-block">
								<div class="btn-group btn-sm">
									<button type="button" class="btn btn-light btn-sm">
										<span class="">Today</span>
									</button>
									<button type="button" class="btn btn-light btn-sm">
										<span class="">Month</span>
									</button>
									<button type="button" class="btn btn-light btn-sm">
										<span class="">Year</span>
									</button>
								</div>
							</div>
						</div>
						<div class="card-body p-0">
							<div class="row">
								<div class="col-xl-6 col-md-12">
									<div class="card-body">
										<h4 class="mb-1 text-center">CPC Campaign</h4>
										<div id="morrisBar8" class="chartsh chart-dropshadow"></div>
									</div>
								</div>
								<div class="col-xl-6 col-md-12">
									<div class="card-body">
										<h4 class="mb-4 text-center">CTC Campaign</h4>
										<div>
											<canvas id="lineChart1" class=""></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-4">
									<div class="mb-5 mb-lg-0">
										<h4 class="mb-4 d-block">
											<span class="fs-16">CPC Campagin 01</span>
											<span class="float-right font-weight-bold">50%</span>
										</h4>
										<div class="progress progress-md h-1">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-50"></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="mb-5 mb-lg-0">
										<h4 class="mb-4 d-block">
											<span class="fs-16">CPC Campagin 02</span>
											<span class="float-right font-weight-bold">25%</span>
										</h4>
										<div class="progress progress-md h-1">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary w-25"></div>
										</div>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="mb-0 mb-md-0">
										<h4 class="mb-4 d-block">
											<span class="fs-16">CPC Campagin 03</span>
											<span class="float-right font-weight-bold">15%</span>
										</h4>
										<div class="progress progress-md h-1">
											<div class="progress-bar progress-bar-striped progress-bar-animated bg-yellow w-15"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header ">
							<h3 class="card-title ">Projects</h3>
							<div class="card-options">
								<button id="add__new__list" type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Add a new Project</button>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table card-table table-striped table-vcenter table-outline table-bordered text-nowrap ">
								<thead>
									<tr>
										<th scope="col" class="border-top-0">ID</th>
										<th scope="col" class="border-top-0">Project Name</th>
										<th scope="col" class="border-top-0">Backend</th>
										<th scope="col" class="border-top-0">Deadline</th>
										<th scope="col" class="border-top-0">Team Members</th>
										<th scope="col" class="border-top-0">Edit Project Details </th>
										<th scope="col" class="border-top-0">list info</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th scope="row">1</th>
										<td>At vero eos et accusamus et iusto odio</td>
										<td>PHP</td>
										<td>15/11/2018</td>
										<td>15 Members</td>
										<td>
											<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
											<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
										</td>
										<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
									</tr>
									<tr>
										<th scope="row">2</th>
										<td>voluptatum deleniti atque corrupti quos</td>
										<td>Angular js</td>
										<td>25/11/2018</td>
										<td>12 Members</td>
										<td>
											<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
											<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
										</td>
										<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
									</tr>
									<tr>
										<th scope="row">3</th>
										<td>dignissimos ducimus qui blanditiis praesentium </td>
										<td>Java</td>
										<td>5/12/2018</td>
										<td>20 Members</td>
										<td>
											<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
											<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
										</td>
										<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
									</tr>
									<tr>
										<th scope="row">4</th>
										<td>deleniti atque corrupti quos dolores  </td>
										<td>Phython</td>
										<td>14/12/2018</td>
										<td>10 Members</td>
										<td>
											<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
											<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
										</td>
										<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
									</tr>
									<tr>
										<th scope="row">5</th>
										<td>et quas molestias excepturi sint occaecati</td>
										<td>Phython</td>
										<td>4/12/2018</td>
										<td>17 Members</td>
										<td>
											<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
											<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
										</td>
										<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="card">
						<div class="card-header custom-header">
							<div>
								<h3 class="card-title">Products Details</h3>
								<h6 class="card-subtitle">Over of this week</h6>
							</div>
							<div class="card-options">
								<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
									<span class="fa fa-ellipsis-v"></span>
								</a>
								<ul class="dropdown-menu dropdown-menu-right" role="menu">
									<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
									<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
									<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
									<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
								</ul>
							</div>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered text-nowrap mb-0">
									<thead>
										<tr>
											<th>Product ID</th>
											<th>Product</th>
											<th>Product Cost</th>
											<th>Payment Mode</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><a href="#">PRO12345</a></td>
											<td>Mi LED Smart TV 4A 80</td>
											<td>$14,500</td>
											<td>Online Payment</td>
											<td><span class="badge badge-success">Available</span></td>
										</tr>
										<tr>
											<td><a href="#">PRO8765</a></td>
											<td>Thomson R9 122cm (48 inch) Full HD LED TV </td>
											<td>$30,000</td>
											<td>Cash on delivered</td>
											<td><span class="badge badge-primary">Available</span></td>
										</tr>
										<tr>
											<td><a href="#">PRO54321</a></td>
											<td>Vu 80cm (32 inch) HD Ready LED TV</td>
											<td>$13,200</td>
											<td>Online Payment</td>
											<td><span class="badge badge-warning">Limited</span></td>
										</tr>
										<tr>
											<td><a href="#">PRO97654</a></td>
											<td>Micromax 81cm (32 inch) HD Ready LED TV</td>
											<td>$15,100</td>
											<td>Cash on delivered</td>
											<td><span class="badge badge-danger">No stock</span></td>
										</tr>
										<tr>
											<td><a href="#">PRO4532</a></td>
											<td>HP 200 Mouse &amp; Wireless Laptop Keyboard </td>
											<td>$5,987</td>
											<td>Online Payment</td>
											<td><span class="badge badge-danger">No stock</span></td>
										</tr>
										<tr>
											<td><a href="#">PRO6789</a></td>
											<td>Digisol DG-HR3400 Router </td>
											<td>$11,987</td>
											<td>Cash on delivered</td>
											<td><span class="badge badge-success">Available</span></td>
										</tr>
										<tr>
											<td><a href="#">PRO4567</a></td>
											<td>Dell WM118 Wireless Optical Mouse</td>
											<td>$4,700</td>
											<td>Online Payment</td>
											<td><span class="badge badge-secondary">Available</span></td>
										</tr>
										<tr>
											<td><a href="#">PRO32156</a></td>
											<td>Dell 16 inch Laptop Backpack </td>
											<td>$678</td>
											<td>Cash On delivered</td>
											<td><span class="badge badge-cyan">Limited</span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@elseif (Session::get('lecturer_id'))
		@foreach ($check_role as $check)
			@if ($check->lecturer_role==1 || $check->lecturer_role==2)
				<div class="side-app" style="padding-top: 0px;">
					<!-- page-header -->
					<div class="page-header">
						<ol class="breadcrumb"><!-- breadcrumb -->
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">Dashboard 01</li>
						</ol><!-- End breadcrumb -->
						<div class="ml-auto">
							<div class="input-group">
								<a  class="btn btn-primary text-white mr-2"  id="daterange-btn">
									<span>
										<i class="fa fa-calendar"></i> Events Settings
									</span>
									<i class="fa fa-caret-down"></i>
								</a>
								<a href="#" class="btn btn-secondary text-white" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Rating">
									<span>
										<i class="fa fa-star"></i>
									</span>
								</a>
							</div>
						</div>
					</div>
					<!-- End page-header -->

					<div class="row">
						<div class="col-md-12">
							<div class="owl-carousel owl-carousel2 owl-theme mb-5">
								<div class="item">
									<div class="card mb-0">
										<div class="row">
											<div class="col-4">
												<div class="feature">
													<div class="fa-stack fa-lg fa-2x icon bg-primary-transparent">
														<i class="si si-briefcase  fa-stack-1x text-primary"></i>
													</div>
												</div>
											</div>
											<div class="col-8">
												<div class="card-body p-3  d-flex">
													<div>
														<p class="text-muted mb-1">Total Income</p>
														<h2 class="mb-0 text-dark">18,367K</h2>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="card mb-0">
										<div class="row">
											<div class="col-4">
												<div class="feature">
													<div class="fa-stack fa-lg fa-2x icon bg-success-transparent">
														<i class="si si-drawer fa-stack-1x text-success"></i>
													</div>
												</div>
											</div>
											<div class="col-8">
												<div class="card-body p-3  d-flex">
													<div>
														<p class="text-muted mb-1">Total Profit</p>
														<h2 class="mb-0 text-dark">35%</h2>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="card mb-0">
										<div class="row">
											<div class="col-4">
												<div class="feature">
													<div class="fa-stack fa-lg fa-2x icon bg-pink-transparent">
														<i class="si si-layers fa-stack-1x text-pink"></i>
													</div>
												</div>
											</div>
											<div class="col-8">
												<div class="card-body p-3  d-flex">
													<div>
														<p class="text-muted mb-1">Total Revenue</p>
														<h2 class="mb-0 text-dark">3,548K</h2>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="card mb-0">
										<div class="row">
											<div class="col-4">
												<div class="feature">
													<div class="fa-stack fa-lg fa-2x icon bg-warning-transparent">
														<i class="si si-chart fa-stack-1x text-warning"></i>
													</div>
												</div>
											</div>
											<div class="col-8">
												<div class="card-body p-3  d-flex">
													<div>
														<p class="text-muted mb-1">Total Sales</p>
														<h2 class="mb-0 text-dark">9,756</h2>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-bgimg br-7">
								<div class="row">
									<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
										<div class="card-body text-center">
											<h5 class="text-white">Today</h5>
											<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">863</h2>
											<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
										<div class="card-body text-center">
											<h5 class="text-white">Yesterday</h5>
											<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">1,364</h2>
											<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
										<div class="card-body text-center">
											<h5 class="text-white">Last Week</h5>
											<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">3,876</h2>
											<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
										<div class="card-body text-center">
											<h5 class="text-white">Last Month</h5>
											<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">8,547</h2>
											<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
										<div class="card-body text-center">
											<h5 class="text-white">Last 6Months</h5>
											<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">12,976</h2>
											<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
										</div>
									</div>
									<div class="col-xl-2 col-lg-6 col-sm-6 pr-0 pl-0">
										<div class="card-body text-center">
											<h5 class="text-white">Last Year</h5>
											<h2 class="mb-2 mt-3 fs-2 text-white mainvalue">24,844</h2>
											<div><i class="si si-graph mr-1 text-danger"></i><span class="text-white">Sales</span></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-7 col-lg-12 col-md-12">
							<div class="card">
								<div class="card-header custom-header">
									<div>
										<h3 class="card-title">Click  Conversion</h3>
										<h6 class="card-subtitle">Overview of Latest Month</h6>
									</div>
									<div class="card-options">
										<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
											<span class="fa fa-ellipsis-v"></span>
										</a>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
											<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
											<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
											<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div>
										<canvas id="conversion" class="chart-drop"></canvas>
									</div>
								</div>
								<div class="card-footer">
									<div class="row">
										<div class="col-xl-3 col-lg-6 col-sm-6">
											<div class="text-center mt-0">
												<h5 class="mb-1 text-muted">Total Users</h5>
												<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">1,653</h2>
											</div>
										</div>
										<div class="col-xl-3 col-lg-6 col-sm-6">
											<div class="text-center mt-4 mt-sm-0">
												<h5 class="mb-1 text-muted">Total Leads</h5>
												<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">639</h2>
											</div>
										</div>
										<div class="col-xl-3 col-lg-6 col-sm-6">
											<div class="text-center mt-4 mt-lg-0">
												<h5 class="mb-1 text-muted">Total Trials</h5>
												<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">12,765</h2>
											</div>
										</div>
										<div class="col-xl-3 col-lg-6 col-sm-6">
											<div class="text-center mt-4 mt-lg-0">
												<h5 class="mb-1 text-muted">Total Wins</h5>
												<h2 class="mb-0 mt-2 fs-2 text-dark mainvalue">24</h2>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-5 col-lg-12 col-md-12">
							<div class="card">
								<div class="card-header custom-header">
									<div>
										<h3 class="card-title">Active Users</h3>
										<h6 class="card-subtitle">Users</h6>
									</div>
									<div class="card-options">
										<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
											<span class="fa fa-ellipsis-v"></span>
										</a>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
											<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
											<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
											<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-4">
											<div class="chart-circle mt-2 mb-2" data-value="0.80" data-thickness="10" data-color="#1753fc">
												<div class="chart-circle-value"><div class="fs-2">80% </div></div>
											</div>
										</div>
										<div class="col-md-8">
											<h4 class="mb-5">Active Users</h4>
											<div class="mb-5">
												<h5 class="mb-2 d-block">
													<span class="fs-16"><b>74,526</b> Email Accounts</span>
													<span class="float-right">80%</span>
												</h5>
												<div class="progress progress-md h-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-80"></div>
												</div>
											</div>
											<div class="mb-0">
												<h5 class="mb-2 d-block">
													<span class="fs-16"><b>14,526</b> Requests</span>
													<span class="float-right">30%</span>
												</h5>
												<div class="progress progress-md h-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger w-30"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-8">
											<h4 class="mb-5">Deactive Users</h4>
											<div class="mb-5">
												<h5 class="mb-2 d-block">
													<span class="fs-16"><b>7,325</b> Email Accounts</span>
													<span class="float-right">20%</span>
												</h5>
												<div class="progress progress-md h-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-20"></div>
												</div>
											</div>
											<div class="mb-0">
												<h5 class="mb-2 d-block">
													<span class="fs-16"><b>1,425</b> Directly</span>
													<span class="float-right">30%</span>
												</h5>
												<div class="progress progress-md h-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger w-1"></div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="chart-circle mt-2" data-value="0.30" data-thickness="10" data-color="#e34a42">
												<div class="chart-circle-value"><div class="fs-2">30% </div></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-4 col-lg-12 col-md-12">
							<div class="card">
								<div class="card-header custom-header">
									<div>
										<h3 class="card-title">Top Ongoing Projects</h3>
										<h6 class="card-subtitle">Overview this Month</h6>
									</div>
									<div class="card-options">
										<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
											<span class="fa fa-ellipsis-v"></span>
										</a>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
											<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
											<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
											<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
										</ul>
									</div>
								</div>
								<div class="card-body p-0">
									<div class="list-group projects-list">
										<a href="#" class="list-group-item list-group-item-action flex-column align-items-start border-top-0">
											<div class="d-flex w-100 justify-content-between">
												<h5 class="mb-1 font-weight-sembold">PSD Projects</h5>
												<small class="text-danger"><i class="fa fa-caret-down mr-1"></i>5 days ago</small>
											</div>
											<p class="mb-0 text-dark">Started:17-02-2019</p>
											<small class="text-muted">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</small>
										</a>
										<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
											<div class="d-flex w-100 justify-content-between">
												<h5 class="mb-1 font-weight-sembold">Wordpress Projects</h5>
												<small class="text-success"><i class="fa fa-caret-up mr-1"></i>2 days ago</small>
											</div>
											<p class="mb-0 text-dark">Started:15-02-2019</p>
											<small class="text-muted">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</small>
										</a>
										<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
											<div class="d-flex w-100 justify-content-between">
												<h5 class="mb-1 font-weight-sembold">HTML & CSS3 Projects</h5>
												<small class="text-danger"><i class="fa fa-caret-down mr-1"></i>1 days ago</small>
											</div>
											<p class="mb-0 text-dark">Started:26-02-2019</p>
											<small class="text-muted">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</small>
										</a>
										<a href="#" class="list-group-item list-group-item-action flex-column align-items-start br-br-7 br-bl-7">
											<div class="d-flex w-100 justify-content-between">
												<h5 class="mb-1 font-weight-sembold">Java Projects</h5>
												<small class="text-success"><i class="fa fa-caret-up mr-1"></i>10 days ago</small>
											</div>
											<p class="mb-0">Started:06-02-2019</p>
											<small>Donec id elit non mi porta gravida at eget metus.</small>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-8 col-lg-12 col-md-12">
							<div class="card">
								<div class="card-header custom-header">
									<div>
										<h3 class="card-title">Acquisitions by Campaign</h3>
										<h6 class="card-subtitle">Overview of all Campaign</h6>
									</div>
									<div class="card-options d-none d-sm-block">
										<div class="btn-group btn-sm">
											<button type="button" class="btn btn-light btn-sm">
												<span class="">Today</span>
											</button>
											<button type="button" class="btn btn-light btn-sm">
												<span class="">Month</span>
											</button>
											<button type="button" class="btn btn-light btn-sm">
												<span class="">Year</span>
											</button>
										</div>
									</div>
								</div>
								<div class="card-body p-0">
									<div class="row">
										<div class="col-xl-6 col-md-12">
											<div class="card-body">
												<h4 class="mb-1 text-center">CPC Campaign</h4>
												<div id="morrisBar8" class="chartsh chart-dropshadow"></div>
											</div>
										</div>
										<div class="col-xl-6 col-md-12">
											<div class="card-body">
												<h4 class="mb-4 text-center">CTC Campaign</h4>
												<div>
													<canvas id="lineChart1" class=""></canvas>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-4">
											<div class="mb-5 mb-lg-0">
												<h4 class="mb-4 d-block">
													<span class="fs-16">CPC Campagin 01</span>
													<span class="float-right font-weight-bold">50%</span>
												</h4>
												<div class="progress progress-md h-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary w-50"></div>
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="mb-5 mb-lg-0">
												<h4 class="mb-4 d-block">
													<span class="fs-16">CPC Campagin 02</span>
													<span class="float-right font-weight-bold">25%</span>
												</h4>
												<div class="progress progress-md h-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary w-25"></div>
												</div>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="mb-0 mb-md-0">
												<h4 class="mb-4 d-block">
													<span class="fs-16">CPC Campagin 03</span>
													<span class="float-right font-weight-bold">15%</span>
												</h4>
												<div class="progress progress-md h-1">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-yellow w-15"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header ">
									<h3 class="card-title ">Projects</h3>
									<div class="card-options">
										<button id="add__new__list" type="button" class="btn btn-sm btn-primary " data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Add a new Project</button>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table card-table table-striped table-vcenter table-outline table-bordered text-nowrap ">
										<thead>
											<tr>
												<th scope="col" class="border-top-0">ID</th>
												<th scope="col" class="border-top-0">Project Name</th>
												<th scope="col" class="border-top-0">Backend</th>
												<th scope="col" class="border-top-0">Deadline</th>
												<th scope="col" class="border-top-0">Team Members</th>
												<th scope="col" class="border-top-0">Edit Project Details </th>
												<th scope="col" class="border-top-0">list info</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row">1</th>
												<td>At vero eos et accusamus et iusto odio</td>
												<td>PHP</td>
												<td>15/11/2018</td>
												<td>15 Members</td>
												<td>
													<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
													<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
												</td>
												<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
											</tr>
											<tr>
												<th scope="row">2</th>
												<td>voluptatum deleniti atque corrupti quos</td>
												<td>Angular js</td>
												<td>25/11/2018</td>
												<td>12 Members</td>
												<td>
													<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
													<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
												</td>
												<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
											</tr>
											<tr>
												<th scope="row">3</th>
												<td>dignissimos ducimus qui blanditiis praesentium </td>
												<td>Java</td>
												<td>5/12/2018</td>
												<td>20 Members</td>
												<td>
													<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
													<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
												</td>
												<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
											</tr>
											<tr>
												<th scope="row">4</th>
												<td>deleniti atque corrupti quos dolores  </td>
												<td>Phython</td>
												<td>14/12/2018</td>
												<td>10 Members</td>
												<td>
													<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
													<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
												</td>
												<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
											</tr>
											<tr>
												<th scope="row">5</th>
												<td>et quas molestias excepturi sint occaecati</td>
												<td>Phython</td>
												<td>4/12/2018</td>
												<td>17 Members</td>
												<td>
													<a class="btn btn-sm btn-primary" href="#"><i class="fa fa-edit"></i> Edit</a>
													<a class="btn btn-sm btn-danger" href="#"><i class="fa fa-trash"></i> Delete</a>
												</td>
												<td><a class="btn btn-sm btn-info" href="#"><i class="fa fa-info-circle"></i> Details</a> </td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12">
							<div class="card">
								<div class="card-header custom-header">
									<div>
										<h3 class="card-title">Products Details</h3>
										<h6 class="card-subtitle">Over of this week</h6>
									</div>
									<div class="card-options">
										<a href="" class="mr-4 text-default" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
											<span class="fa fa-ellipsis-v"></span>
										</a>
										<ul class="dropdown-menu dropdown-menu-right" role="menu">
											<li><a href="#"><i class="si si-plus mr-2"></i>Add</a></li>
											<li><a href="#"><i class="si si-trash mr-2"></i>Remove</a></li>
											<li><a href="#"><i class="si si-eye mr-2"></i>View</a></li>
											<li><a href="#"><i class="si si-settings mr-2"></i>More</a></li>
										</ul>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-bordered text-nowrap mb-0">
											<thead>
												<tr>
													<th>Product ID</th>
													<th>Product</th>
													<th>Product Cost</th>
													<th>Payment Mode</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><a href="#">PRO12345</a></td>
													<td>Mi LED Smart TV 4A 80</td>
													<td>$14,500</td>
													<td>Online Payment</td>
													<td><span class="badge badge-success">Available</span></td>
												</tr>
												<tr>
													<td><a href="#">PRO8765</a></td>
													<td>Thomson R9 122cm (48 inch) Full HD LED TV </td>
													<td>$30,000</td>
													<td>Cash on delivered</td>
													<td><span class="badge badge-primary">Available</span></td>
												</tr>
												<tr>
													<td><a href="#">PRO54321</a></td>
													<td>Vu 80cm (32 inch) HD Ready LED TV</td>
													<td>$13,200</td>
													<td>Online Payment</td>
													<td><span class="badge badge-warning">Limited</span></td>
												</tr>
												<tr>
													<td><a href="#">PRO97654</a></td>
													<td>Micromax 81cm (32 inch) HD Ready LED TV</td>
													<td>$15,100</td>
													<td>Cash on delivered</td>
													<td><span class="badge badge-danger">No stock</span></td>
												</tr>
												<tr>
													<td><a href="#">PRO4532</a></td>
													<td>HP 200 Mouse &amp; Wireless Laptop Keyboard </td>
													<td>$5,987</td>
													<td>Online Payment</td>
													<td><span class="badge badge-danger">No stock</span></td>
												</tr>
												<tr>
													<td><a href="#">PRO6789</a></td>
													<td>Digisol DG-HR3400 Router </td>
													<td>$11,987</td>
													<td>Cash on delivered</td>
													<td><span class="badge badge-success">Available</span></td>
												</tr>
												<tr>
													<td><a href="#">PRO4567</a></td>
													<td>Dell WM118 Wireless Optical Mouse</td>
													<td>$4,700</td>
													<td>Online Payment</td>
													<td><span class="badge badge-secondary">Available</span></td>
												</tr>
												<tr>
													<td><a href="#">PRO32156</a></td>
													<td>Dell 16 inch Laptop Backpack </td>
													<td>$678</td>
													<td>Cash On delivered</td>
													<td><span class="badge badge-cyan">Limited</span></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@else
				<div class="side-app" style="padding-top: 0px;">
					<img src="{{ asset('public/lecturer/images/notice.png') }}" alt="">
				</div>
			@endif
		@endforeach
	@endif
</div>
<!-- End app-content-->
@endsection