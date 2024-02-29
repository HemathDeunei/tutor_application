<?php $this->load->view('template/site/header'); ?>


<!-- Dashboard section  -->
<section class="dashboard-section">
	<div class="container">
		<div class="row offcanvas offcanvas-right row-margin">
		   <div class="col-xs-8 col-sm-4 sidebar-offcanvas" id="sidebar">
				<?php $this->load->view('template/site/student-template-leftmenu'); ?>
				<!-- /.panel-group -->
			</div>
			<div class="col-xs-12 col-sm-8 dashboard-content ">
				<!-- breadcrumb -->
				<ol class="breadcrumb dashcrumb">
					<li><a href="<?php echo base_url();?>student/index"><?php echo get_languageword('Home');?></a></li>
					<li class="active"><?php if(isset($pagetitle)) echo $pagetitle?></li>
				</ol>
				<!-- breadcrumb ends -->
				<?php $this->load->view($content); ?>
			</div>
		</div>
	</div>
</section>
<!-- Dashboard section  -->

<?php $this->load->view('template/site/footer'); ?>