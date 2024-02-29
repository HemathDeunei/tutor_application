<?php $this->load->view('template/site/header', $grocery_output); ?>



<!-- Dashboard section  -->
<section class="dashboard-section">
	<div class="container">
		<div class="row offcanvas offcanvas-right row-margin">
		   <div class="col-xs-8 col-sm-4 sidebar-offcanvas" id="sidebar">
				<?php $this->load->view('template/site/institute-template-leftmenu'); ?>
				<!-- /.panel-group -->
			</div>
			<div class="col-xs-12 col-sm-8 dashboard-content ">
				<!-- breadcrumb -->
				<ol class="breadcrumb dashcrumb">
					<li><a href="#"><?php echo get_languageword('home'); ?></a></li>
					<li class="active"> <?php if(!empty($pagetitle)) echo $pagetitle; ?></li>
					<?php if(!empty($activesubmenu)) { ?>
						<li class="active"> <?php echo get_languageword($activesubmenu); ?></li>
					<?php } ?>
				</ol>
				<!-- breadcrumb ends -->

				<?php 

					echo $this->session->flashdata('message');

					if(!empty($course_data)) { 

						$this->load->view('institute/enrolled_students_list', array('course_data' => $course_data));
					  }
				  ?>

				<?php if(isset($grocery_output->output)) echo $grocery_output->output; ?>

			</div>
		</div>
	</div>
</section>
<!-- Dashboard section  -->
<?php $this->load->view('template/site/footer', $grocery_output); ?>