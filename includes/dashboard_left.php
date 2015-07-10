<div class="col-md-3 col-sm-12 col-xs-12 no-padding-sm no-padding-xs sidebar">
	<div class="absolute-wrapper"> </div>
	<div class="side-menu">
		<nav class="navbar navbar-default" role="navigation">
			<!-- Main Menu -->
			<div class="side-menu-container">
				<ul class="nav navbar-nav">
					<li class="active"><a href="<?php echo HTTP_PATH; ?>dashboard"><span class="glyphicon glyphicon-dashboard text-danger"></span>Dashboard</a></li>
					<li class="panel panel-default" id="dropdown">
						<a data-toggle="collapse" href="#dropdown-bookings-lvl1">
							<span class="fa fa-bed text-danger"></span> Manage My Bookings<span class="caret"></span>
						</a>
						<div id="dropdown-bookings-lvl1" class="panel-collapse collapse">
							<div class="panel-body">
								<ul class="nav navbar-nav">
									<li><a href="#">List Bookings</a></li>
									<li><a href="#">Uncompleted Bookings</a></li>
									<li class="panel panel-default" id="dropdown">
										<a data-toggle="collapse" href="#dropdown-bookings-lvl2">
											<span class="fa fa-file-pdf-o"></span> Invoices<span class="caret"></span>
										</a>
										<div id="dropdown-bookings-lvl2" class="panel-collapse collapse">
											<div class="panel-body">
												<ul class="nav navbar-nav">
													<li><a href="#">Unpaid Invoices</a></li>
													<li><a href="#">List Invoices</a></li>
												</ul>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<?php if(isset($_SESSION['user']['has_hotels']) && ($_SESSION['user']['has_hotels'] == 1)){ ?>
					<li class="panel panel-default" id="dropdown">
						<a data-toggle="collapse" href="#dropdown-hotels-lvl1">
							<span class="fa fa-building-o text-danger"></span> Manage My Hotels<span class="caret"></span>
						</a>
						<div id="dropdown-hotels-lvl1" class="panel-collapse collapse">
							<div class="panel-body">
								<ul class="nav navbar-nav">
									<li><a href="<?php echo HTTP_PATH; ?>dashboard/list-hotels">List hotels</a></li>
									<li><a href="<?php echo HTTP_PATH; ?>dashboard/add-hotel/step-01">Add a Hotel</a></li>
									<li><a href="#">Uncompleted Hotel</a></li>
									<li class="panel panel-default" id="dropdown">
										<a data-toggle="collapse" href="#dropdown-hotels-lvl2">
											<span class="fa fa-file-pdf-o"></span> Invoices<span class="caret"></span>
										</a>
										<div id="dropdown-hotels-lvl2" class="panel-collapse collapse">
											<div class="panel-body">
												<ul class="nav navbar-nav">
													<li><a href="#">Unpaid Invoices</a></li>
													<li><a href="#">List Invoices</a></li>
												</ul>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
		</nav>
	</div>
</div>