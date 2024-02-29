<!-- News Scroller  -->
<?php 
		$this->load->model('home_model');

		$scroll_news = $this->home_model->get_scroll_news();

		if(!empty($scroll_news)) {
?>

<?php } ?>
<!-- News Scroller  -->