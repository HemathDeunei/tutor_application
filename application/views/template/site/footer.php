 <!-- Footer -->
<section class="footer" id="footer_sec">
    <a href="#" class="back-to-top show" title="Move to top"><i class="glyphicon glyphicon-menu-up"></i></a>
    <div class="container">
        <?php if(strip_tags($this->config->item('site_settings')->bottom_section) == "On") { ?>
        <div class="row footer-help-bar">
            <div class="col-md-12">
                <?php if($this->ion_auth->is_tutor() && !is_inst_tutor($this->ion_auth->get_user_id())) { ?>
                <a class="footer-help"><?php echo get_languageword('Need help finding a student');?></a>
                <a href="<?php echo URL_HOME_SEARCH_STUDENT_LEADS; ?>" class="btn btn-footer"> <i class="fa fa-pencil"></i> <?php echo get_languageword('Find Student Leads');?></a>
                <?php } else if($this->ion_auth->is_student()) { ?>
                <a href="<?php echo URL_HOME_SEARCH_TUTOR; ?>" class="footer-help"><?php echo get_languageword('Need help finding a tutor?');?></a>
                <a href="<?php if($this->ion_auth->is_student()) echo URL_STUDENT_POST_REQUIREMENT; else echo URL_AUTH_LOGIN; ?>" class="btn btn-footer"> <i class="fa fa-pencil"></i> <?php echo get_languageword('Post Your Requirement');?></a>
                <?php } else echo '&nbsp;'; ?>

                <?php if(isset($this->config->item('site_settings')->land_line) && $this->config->item('site_settings')->land_line != '') { ?>
                <span class="footer-contact"> <a href="tel:<?php echo $this->config->item('site_settings')->land_line; ?>"><i class="fa fa-phone"></i> <?php echo get_languageword('Feel_free_to_call_us_anytime_on');?>  <strong><?php echo $this->config->item('site_settings')->land_line;?></strong></a></span>
                <?php } ?>
                <hr class="footer-hr-big">
            </div>
        </div>
        <?php } ?>
        <?php if(strip_tags($this->config->item('site_settings')->footer_section) == "On") {

                if(strip_tags($this->config->item('site_settings')->get_app_section) == "Off")
                    $col_size = 12;
                else
                    $col_size = 9;
            ?>
       
        <?php } ?>
        <?php if(strip_tags($this->config->item('site_settings')->primary_footer_section) == "On") { ?>
        <div class="row footer-copy-bar">
            <div class="col-md-12">
                <hr class="footer-hr">

                <?php if(isset($this->config->item('site_settings')->designed_by) && $this->config->item('site_settings')->designed_by != '') { ?>
              
                <?php } ?>


                <ul class="social-share">
                    <?php if(isset($this->config->item('social_settings')->facebook) && $this->config->item('social_settings')->facebook != '') { ?>
                    <li class="fb-color"><a href="<?php echo $this->config->item('social_settings')->facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <?php } ?>
                    <?php if(isset($this->config->item('social_settings')->twitter) && $this->config->item('social_settings')->twitter != '') { ?>
                    <li ><a class="tw-color" href="<?php echo $this->config->item('social_settings')->twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <?php } ?>
                    <?php if(isset($this->config->item('social_settings')->linkedin) && $this->config->item('social_settings')->linkedin != '') { ?>
                    <li><a class="li-color" href="<?php echo $this->config->item('social_settings')->linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                    <?php } ?>
                    <?php if(isset($this->config->item('social_settings')->pinterest) && $this->config->item('social_settings')->pinterest != '') { ?>
                    <li class="pi-color"><a href="<?php echo $this->config->item('social_settings')->pinterest;?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                    <?php } ?>

                    <?php if(isset($this->config->item('social_settings')->google) && $this->config->item('social_settings')->google != '') { ?>
                    <li class="gp-color"><a href="<?php echo $this->config->item('social_settings')->google;?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    <?php } ?>
                    <?php if(isset($this->config->item('social_settings')->instagram) && $this->config->item('social_settings')->instagram != '') { ?>
                    <li class="ig-color"><a href="<?php echo $this->config->item('social_settings')->instagram;?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    <?php } ?>
                    <?php if(isset($this->config->item('social_settings')->youtube) && $this->config->item('social_settings')->youtube != '') { ?>
                    <li class="yt-color"><a href="<?php echo $this->config->item('social_settings')->youtube;?>" target="_blank"><i class="fa fa-youtube-play"></i></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
    </div>

</section>
<!-- Ends Footer -->




<!-- Script files -->
<?php
//neatPrint($this->config->item('site_settings'));
if(isset($grocery) && $grocery == TRUE)
{
?>
<!--Image CRUD scripts-->
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?php
}
else
{
?>
<script src="<?php echo URL_FRONT_JS;?>jquery.js"></script>

<link rel="stylesheet" href="<?php echo URL_FRONT_CSS;?>jquery-ui.css">
<script src="<?php echo URL_FRONT_JS;?>jquery-ui.js"></script>
<script>
  $( function() {
    $( ".custom_accordion" ).accordion({
        heightStyle: "content"
    });
  });
</script>
<?php
}
?>

<?php if(isset($texteditor) && $texteditor == TRUE) { ?>
<script src="<?php echo base_url(); ?>assets/grocery_crud/texteditor/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>assets/grocery_crud/texteditor/ckeditor/adapters/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/grocery_crud/js/jquery_plugins/config/jquery.ckeditor.config.js"></script>
<?php } ?>
<?php if(!empty($activemenu) && $activemenu == "sell_courses_online") { ?>
<script> 
//Add/Remove Fields Dynamically - Start
function append_field(max_fields, wrapper_id, add_button_id, appending_div, lbl_txt1, lbl_txt2, field_name1, field_name2)
{

    var wrapper         = $("#"+wrapper_id); //Fields wrapper
    var add_button      = $("#"+add_button_id); //Add button ID
    var cls             = "";
    var attrs           = "";


    var i = ($('#'+wrapper_id+' .'+appending_div).length) + 1; //text box count

    if(i < max_fields) { //max input box allowed
        i++; //text box increment
        $(wrapper).append('<div class="row '+appending_div+'" id="'+appending_div+i+'"><div class="col-sm-5 "><label>'+lbl_txt1+' '+i+'</label><input type="text" name="'+field_name1+'[]" class="form-control" /></div> <div class="col-sm-2 "><label>Source Type</label><select name="source_type[]" id="source_type_'+i+'" class="form-control cls-source_type"><option value="url">URL</option><option value="file">File</option></select></div> <div class="col-sm-4 "><label>'+lbl_txt2+' '+i+'</label><div class="cls-source" id="source_'+i+'"><input type="text" name="'+field_name2+'[]" class="form-control" /></div></div> <div class="col-sm-1"><label>&nbsp;</label><span title="<?php echo get_languageword('remove_this'); ?>" class="btn btn-danger" id="'+i+'" onclick="remove_field(\''+wrapper_id+'\', this.id, \''+appending_div+'\', \''+lbl_txt1+'\', \''+lbl_txt2+'\', \''+field_name1+'\', \''+field_name2+'\');" ><i class="fa fa-minus"></i></span></div></div> '); //add input box
    }

}




function remove_field(wrapper_id, remove_button_id, appending_div, lbl_txt1, lbl_txt2, field_name1, field_name2)
{

    $('#'+appending_div+remove_button_id).remove();

    sort_appended_fields(wrapper_id, appending_div, lbl_txt1, lbl_txt2, field_name1, field_name2);

}





function sort_appended_fields(wrapper_id, appending_div, lbl_txt1, lbl_txt2, field_name1, field_name2)
{

    var field_val       = "";
    var div_field_id    = "";
    var selector        = $('#'+wrapper_id+' .'+appending_div);
    var i               = 1;


    $(selector).each(function() {

        i++;

        div_field_id    = appending_div+i;


        $(this).attr('id', div_field_id);
        $(this).find('label:first').text(lbl_txt1+' '+i);
        $(this).find('label').eq(2).text(lbl_txt2+' '+i);
        $(this).find('span:first').attr('id', i);
        $(this).find('.cls-source_type').attr('id', 'source_type_'+i);
        $(this).find('.cls-source').attr('id', 'source_'+i);

    });

}
//Add/Remove Fields Dynamically - End

$(document).on('change', '.cls-source_type', function() {

    var ref = $(this);
    var sno = ref.attr('id').split('_')[2];
    var refval = ref.val();

    if(refval == "file") {

        $('#source_'+sno).html('<input type="file" name="lesson_file[]" class="form-control" />');

    } else {

        $('#source_'+sno).html('<input type="text" name="lesson_url[]" class="form-control" />');
    }


});



$(document).on('click', '.delete-icon-grocery', function() {

    return confirm("<?php echo get_languageword('Are you sure that you want to delete this record?'); ?>");
});

</script>
<?php } ?>



<!--Bootstrap Page-->
<script src="<?php echo URL_FRONT_JS;?>bootstrap.min.js"></script>
<!--Profile Page-->
<script src="<?php echo URL_FRONT_JS;?>marquee.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>flatpickr.min.js"></script>

<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>select2.min.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>owl.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>jRate.min.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>jquery.magnific-popup.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>jquery.smartmenus.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>jquery.smartmenus.bootstrap.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>flexgrid.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>countUp.js"></script>
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>jquery.dataTables.min.js"></script>
<!-- Custom Script -->
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>main.js"></script>

<!--Gallery-->
<script type="text/javascript" src="<?php echo URL_FRONT_JS;?>fileinput.min.js"></script>

<?php
//if($current_controller == 'home' && $current_method == 'contact_us')
//{
?>

<!--COntact us page-->
<!--script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-h5q6y2eBfFV5X7QV6Z5mrFFU2s97XJs&sensor=false"></script>
<script>
$(document).ready(function () {
    "use strict";

    function e() {
        var e = {
                center: a,
                zoom: 10,
                /*scrollwheel:!0*/
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [{
                    featureType: "landscape",
                    stylers: [{
                        hue: "#FFBB00"
                }, {
                        saturation: 43.400000000000006
                }, {
                        lightness: 37.599999999999994
                }, {
                        gamma: 1
                }]
            }, {
                    featureType: "road.highway",
                    stylers: [{
                        hue: "#FFC200"
                }, {
                        saturation: -61.8
                }, {
                        lightness: 45.599999999999994
                }, {
                        gamma: 1
                }]
            }, {
                    featureType: "road.arterial",
                    stylers: [{
                        hue: "#FF0300"
                }, {
                        saturation: -100
                }, {
                        lightness: 51.19999999999999
                }, {
                        gamma: 1
                }]
            }, {
                    featureType: "road.local",
                    stylers: [{
                        hue: "#FF0300"
                }, {
                        saturation: -100
                }, {
                        lightness: 52
                }, {
                        gamma: 1
                }]
            }, {
                    featureType: "water",
                    stylers: [{
                        hue: "#0078FF"
                }, {
                        saturation: -13.200000000000003
                }, {
                        lightness: 2.4000000000000057
                }, {
                        gamma: 1
                }]
            }, {
                    featureType: "poi",
                    stylers: [{
                        hue: "#00FF6A"
                }, {
                        saturation: -1.0989010989011234
                }, {
                        lightness: 11.200000000000017
                }, {
                        gamma: 1
                }]
            }]

            },
            t = new google.maps.Map(document.getElementById("tutors_map"), e),
            s = {
                url: "assets/front/images/logo_google_map.png"
            },
            o = new google.maps.Marker({
                position: a,
                map: t,
                icon: s,
                animation: google.maps.Animation.BOUNCE
            });
        o.setMap(t);
        var n = new google.maps.InfoWindow({
            content: "<strong><?php echo $this->config->item('site_settings')->address; ?> <br> <?php echo strip_tags($this->config->item('site_settings')->city); ?>, <?php echo $this->config->item('site_settings')->state; ?> <?php echo $this->config->item('site_settings')->zipcode; ?></strong>"
        });
        google.maps.event.addListener(o, "click", function () {
            n.open(t, o)
        })
    }
    var a;
    a = new google.maps.LatLng("17.4459764", "78.38607860000002"), google.maps.event.addDomListener(window, "load", e), a = new google.maps.LatLng("17.4459764", "78.38607860000002")
});
</script-->

<?php //} ?>

<script>
    $(function() {
        $(".stu-certificate").attr("target", "_blank");
    });
</script>

<?php
if($this->config->item('seo_settings')->google_analytics) {
    echo $this->config->item('seo_settings')->google_analytics;
}
?>

</body>

</html>
