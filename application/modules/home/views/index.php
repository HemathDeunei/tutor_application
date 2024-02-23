
<!-- Header #homepage -->
    <section class="header-homepage">
        <div class="container">
            <div class="row header-margin">
                <div class="col-sm-12">
                    <h1 class="hero-title"><?php echo get_languageword('Explore').' - '.get_languageword('Enrich').' - '.get_languageword('Excel');?></h1>
                    <p class="hero-tag"><?php echo get_languageword('Everything you need in order to find the')?> <strong><?php echo get_languageword('right'); ?></strong> <?php echo get_languageword('class for you');?></p>
                </div>
                <?php if(!$this->ion_auth->is_tutor()) { ?>
                <div class="col-sm-12">
                    <!-- Home Search form -->
                    <?php 
                          if(!empty($location_opts) || !empty($course_opts)): 
                            $this->load->view('sections/search_section_home', array('location_opts' => $location_opts, 'course_opts' => $course_opts), false);
                         endif;
                    ?>
                    <!-- Home Search form -->
                </div>
                <?php } ?>
                <div class="col-sm-12">
                    <img src="<?php echo URL_FRONT_IMAGES;?>headericons.png" alt="" class="img-responsive">
                </div>
            </div>
        </div>
    </section>
    <!-- Ends Header #homepage -->

    <!-- Advantages #homepage -->
    <?php if(strip_tags($this->config->item('site_settings')->advantages_section) == "On") {
            echo $this->config->item('sections')->Advantages_Section;

         } ?>
    <!-- Ends Advantages #homepage -->


    <!-- Our-Popular #homepage -->
    <?php if(!empty($popular_courses)) { ?>
    <section class="our-popular">
        <div class="container">
            <div class="row-margin">
                <div class="row ">
                    <div class="col-sm-12 ">
                        <h2 class="heading"><?php echo get_languageword('our_popular_courses'); ?></h2>
                    </div>

                    <?php foreach ($popular_courses as $key => $courses) { 

                            $category = explode('_', $key);

                            //Category Details
                            $category_id   = $category[0];
                            $category_slug = $category[1];
                            $category_name = $category[2];

                        ?>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="pop-list">
                            <a href=<?php echo URL_HOME_ALL_COURSES.'/'.$category_slug;?> class="link-all"><?php echo get_languageword('see_all'); ?></a>
                            <h3 class="heading-line" title="<?php echo $category_name; ?>"><?php echo $category_name; ?></h3>
                            <ul>
                                <?php foreach ($courses as $key => $value) {

                                        $course   = explode('_', $value);
                                        //Course Details
                                        $course_id   = $course[0];
                                        $course_slug = $course[1];
                                        $course_name = $course[2];

                                 ?>
                                    <li><a href="<?php echo URL_HOME_SEARCH_TUTOR.'/'.$course_slug;?>" title="<?php echo $course_name; ?>"><?php echo $course_name; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>

                    <?php } ?>

                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="mtop4">
                            <a href="<?php echo URL_HOME_ALL_COURSES; ?>" class="btn-link"><?php echo get_languageword('check_all_courses'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <!-- Ends Our-Popular #homepage -->


  

  

    <!-- How-it-works #homepage -->
    <?php $about_us_how_it_works = $this->base_model->get_page_how_it_works(); 

        if(!empty($about_us_how_it_works)) {

            echo $about_us_how_it_works[0]->description;
        }
    ?>
    <!-- Ends How-it-works #homepage -->



  

    <?php if(!empty($home_tutor_ratings)) {?>
     <section class="weekly-top-rated">
        <div class="team">
        
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section_title_container text-center">
                        <h2 class="section_title"><?php echo get_languageword('weekly_top_tutors');?></h2>
                        <div class="section_subtitle"></div>
                    </div>
                </div>
            </div>

            <div class="row team_row">

                <!-- Team Item -->
                <?php 
                $i=1;
                foreach($home_tutor_ratings as $rating) {
                    if ($i==5)
                        break;
                            $hlink = URL_HOME_TUTOR_PROFILE.'/'.$rating->slug;

                            $fblink     = !empty($rating->facebook) ? $rating->facebook : $hlink;
                            $twilink    = !empty($rating->twitter) ? $rating->twitter : $hlink;
                            $linkd      = !empty($rating->linkedin) ? $rating->linkedin : $hlink;

                        ?>
                <div class="col-lg-3 col-md-6 team_col">
                    <div class="team_item">
                        <div class="team_image"><img src="<?php echo get_tutor_img($rating->photo, $rating->gender); ?>" alt="Tutor Image"></div>
                        <div class="team_body">
                            <div class="team_title"><a href="<?php echo $hlink;?>"><?php echo $rating->username;?></a></div>
                            <div class="team_subtitle"><?php echo $rating->qualification;?></div>
                            <div class="social_list">
                                <ul>

                                    <li><a href="<?php echo $fblink;?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                                    <li><a href="<?php echo $twilink;?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>

                                    <li><a href="<?php echo $linkd;?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i++;
            } ?>
            </div>

        </div>

        </div>
    </section>

    <!-- Ends Top-rated slider -->
<?php } ?>




 <!-- Latest Blogs Start-->
 <?php 
     
if (!empty($latest_blogs)) {?>
<!-- Latest blogs slider -->

 <?php } ?>   
<!-- Latest Blogs End-->






    <!-- Call-to-register -->

    <!-- Call-to-register -->


<link rel="stylesheet" href="<?php echo URL_FRONT_CSS;?>jquery.raty.css">
<!---05-12-2018-start---->
<?php if (isset($jquery_min)) {?>
<script src="<?php echo URL_FRONT_JS;?>jquery.js"></script>
<?php } ?>
<!---05-12-2018-start---->
<script src="<?php echo URL_FRONT_JS;?>jquery.raty.js"></script>
<script>

    /****** Tutor Avg. Rating  ******/
   $('div.top_tutor_rating').raty({

    path: '<?php echo RESOURCES_FRONT;?>raty_images',
    score: function() {
      return $(this).attr('data-score');
    },
    readOnly: true
   });

   
</script>