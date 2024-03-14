<div class="panel-group dashboard-menu" id="accordion">
<div class="dashboard-profile">
	<?php 
		  $user_id = $this->ion_auth->get_user_id();

	?>
	<div class="media media-team">
		<a href="<?php echo base_url();?>student/index">
			<figure class="imghvr-zoom-in">
				<img class="media-object  img-circle" src="<?php echo get_student_img($my_profile->photo, $my_profile->gender); ?>" alt="<?php echo $my_profile->first_name;?> <?php echo $my_profile->last_name;?>">
				<figcaption></figcaption>
			</figure>
			<h4><?php echo $my_profile->first_name;?> <?php echo $my_profile->last_name;?></h4>
			<p><?php echo get_languageword('User Login');?>: <?php echo date('d/m/Y H:i:s',$my_profile->last_login );?></p>
			<p><?php echo get_languageword('net_credits');?>: <strong><?php echo get_user_credits($user_id);?></strong>

                <span class="pull-right"><?php echo get_languageword('per_credit_value');?>: <strong><?php echo get_system_settings('currency_symbol').get_system_settings('per_credit_value');?></strong></span></p>
		</a>
	</div>
</div>
<div class="dashboard-menu-panel">
<div class="dashboard-link"><a <?php if(isset($activemenu) && $activemenu == 'dashboard') echo 'class="active"';?> href="<?php echo URL_STUDENT_INDEX ?>"><i class="fa fa-tachometer"></i><?php echo get_languageword('Dashboard');?></a></div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
		<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
			<i class="fa fa-search"></i><?php echo get_languageword('Bookings');?>
		</a>
	</h4>
	</div>
	<!--/.panel-heading -->
	<div id="collapseOne" class="panel-collapse <?php if(isset($activemenu) && $activemenu == 'enquiries') echo 'collapse in'; else echo 'collapse';?>">
		<div class="panel-body">
			<ul class="dashboard-links">
				<li <?php if(isset($activesubmenu) && $activesubmenu == 'all') echo 'class="active"';?>><a href="<?php echo URL_STUDENT_ENQUIRIES;?>"><?php echo get_languageword('All')?> </a></li>
				<li <?php if(isset($activesubmenu) && $activesubmenu == get_languageword('pending')) echo 'class="active"';?>><a href="<?php echo URL_STUDENT_ENQUIRIES;?>/pending"><?php echo get_languageword('pending'); ?> </a></li>
				
			</ul>
		</div>
		<!--/.panel-body -->
	</div>
	<!--/.panel-collapse -->
</div>
<!-- /.panel -->



<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
		<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapsePackages">
			<i class="fa fa-archive"></i><?php echo get_languageword('Packages')?>
		</a>
	</h4>
	</div>
	<!--/.panel-heading -->
	<div id="collapsePackages" class="panel-collapse <?php if(isset($activemenu) && $activemenu == 'packages') echo 'collapse in'; else echo 'collapse';?>">
		<div class="panel-body">
			<ul class="dashboard-links">
				<li <?php if(isset($activesubmenu) && $activesubmenu == 'list_packages') echo 'class="active"';?>><a href="<?php echo URL_STUDENT_LIST_PACKAGES ?>"><?php echo get_languageword('List Packages');?> </a></li>
				<li <?php if(isset($activesubmenu) && $activesubmenu == 'mysubscriptions') echo 'class="active"';?>><a href="<?php echo URL_STUDENT_SUBSCRIPTIONS ?>"><?php echo get_languageword('My Subscriptions');?> </a></li>
			</ul>
		</div>
		<!--/.panel-body -->
	</div>
	<!--/.panel-collapse -->
</div>
<!-- /.panel -->





<div class="dashboard-link"><a <?php if(isset($activemenu) && $activemenu == 'user_credit_transactions') echo 'class="active"';?> href="<?php echo URL_STUDENT_CREDITS_TRANSACTION_HISTORY;?>"><i class="fa fa-calendar"></i><?php echo get_languageword('credits_Transactions');?><span class="hidden-xs"> <?php echo get_languageword('History')?> </span></a></div>

<!-- /.panel -->
<div class="panel panel-default">

	<!--/.panel-heading -->
	<div id="collapse-Payment" class="panel-collapse collapse">
		<div class="panel-body">
			<ul class="dashboard-links">
				<li><a href="<?php echo base_url();?>student/personal-info">Personnel Information </a></li>
				<li><a href="<?php echo base_url();?>student/profile-information">Profile Information </a></li>
				<li><a href="<?php echo base_url();?>student/update-contact-info">Contact Information</a></li>
			</ul>
		</div>
		<!--/.panel-body -->
	</div>
	<!--/.panel-collapse -->
</div>
<!-- /.panel -->



<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
		<a class="<?php if(isset($activemenu) && $activemenu == 'account') echo ''; else echo 'collapsed';?>" data-toggle="collapse" data-parent="#accordion" href="#collapse-Account">
			<i class="fa fa-user"></i><?php echo get_languageword('Account');?>
		</a>
	</h4>
	</div>
	<!--/.panel-heading -->
	<div id="collapse-Account" class="panel-collapse <?php if(isset($activemenu) && $activemenu == 'account') echo 'collapse in'; else echo 'collapse';?>">
		<div class="panel-body">
			<ul class="dashboard-links">
				<li <?php if(isset($activesubmenu) && $activesubmenu == 'personal_info') echo 'class="active"';?>><a href="<?php echo URL_STUDENT_PERSONAL_INFO ?>"><?php echo get_languageword('Personnel Information')?> </a></li>
				<li <?php if(isset($activesubmenu) && $activesubmenu == 'profile_information') echo 'class="active"';?>><a href="<?php echo URL_STUDENT_PROFILE_INFO ?>"><?php echo get_languageword('Profile Information');?> </a></li>
				<li <?php if(isset($activesubmenu) && $activesubmenu == 'update_contact_info') echo 'class="active"';?>><a href="<?php echo URL_STUDENT_CONTACT_INFO ?>"><?php echo get_languageword('My Address');?></a></li>
				<li <?php if(isset($activesubmenu) && $activesubmenu == 'change_password') echo 'class="active"';?>><a href="<?php echo URL_AUTH_CHANGE_PASSWORD ?>"><?php echo get_languageword('Change Password');?></a></li>
			</ul>
		</div>
		<!--/.panel-body -->
	</div>
	<!--/.panel-collapse -->
	<div class="dashboard-link"><a href="<?php echo base_url();?>auth/logout"><i class="fa fa-sign-out"></i><?php echo get_languageword('Logout');?></a></div>
</div>
<!-- /.panel -->
</div>
</div>