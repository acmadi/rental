<?php
	$IsLogin = $this->User_model->IsLogin();
?>

<?php if ($IsLogin) { ?>
<div id="mainnav" class="navbar navbar-inverse navbar-fixed-top">
	<?php $User = $this->User_model->GetUser(); ?>
	
	<div class="navbar-inner">
		<div class="container-fluid">
			<div class="nav-collapse collapse">
				<ul id="top-nav" class="nav">
					<li><img src="<?php echo $this->config->item('base_url'); ?>/static/img/logo-lintas.png" title="LintasGPS" style="padding: 5px 0 0 0;"/></li>
					<!--
					<li><a>Selamat Datang</a></li>
					<li><a id="menuMonitor" href="#"><i class="icon-globe"></i> Peta</a></li>
					<li><a href="#" id="menuSetting"><i class="icon-wrench"></i> Seting</a></li>
					<li class="dropdown">
						<a href="#" id="reports" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-tasks"></i> Laporan<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#" id="dailyReport"><i class="icon-list"></i> Daily Report</a></li>
							<li><a href="#" id="logHistory"><i class="icon-th-list"></i> Log History</a></li>
						</ul>
					</li>
					-->
				</ul>
				<ul class="nav pull-right">
					<li class="dropdown">
						<a id="menuAdmin" href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-user"></i> <span id="username"><?php echo $User['name']; ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<!-- <li><a href="#profile" data-toggle="modal"><i class="icon-pencil"></i> Edit Profil</a></li> -->
							<li><a class="cursor Logout"><i class="icon-off"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php } else { ?>
    <div id="mainnav" class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="#" style="padding: 0 20px;">
					<img src="<?php echo $this->config->item('base_url'); ?>/static/img/logo-lintas.png" title="LintasGPS"/>
				</a>
			</div>
		</div>
    </div>
<?php } ?>