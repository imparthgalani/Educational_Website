<?php
    $docent_pro_output = ''; 
    $docent_pro_sub_img = array();
    $docent_pro_subtext = ''; 
    global $post;


    if(!function_exists('docent_pro_call_sub_header')){
        function docent_pro_call_sub_header(){
            $banner_img = get_theme_mod( 'sub_header_banner_img', false );
            $banner_color = get_theme_mod( 'sub_header_banner_color', '#fff' );
            if( $banner_img ){
                $docent_pro_output = 'style="background-image:url('.esc_url( $banner_img ).');background-size: cover; background-position: 50% 50%;"';
                return $docent_pro_output;
            }else{
                $docent_pro_output = 'style="background-color:'.esc_attr( $banner_color ).';"';
                return $docent_pro_output;
            }
        }
    }
    
    if( isset($post->post_name) ){
        if(!empty($post->ID)){
            if(function_exists('rwmb_meta')){
                $docent_pro_image_attached     = esc_attr(get_post_meta( $post->ID , 'docent_subtitle_images', true ));
                $docent_pro_subtitle_bg_color  = esc_attr(get_post_meta( $post->ID , 'docent_subtitle_bg_color', true ));
                if(!empty($docent_pro_image_attached)){
                    $docent_pro_sub_img = wp_get_attachment_image_src( $docent_pro_image_attached , 'blog-full'); 
                    $docent_pro_output = 'style="background-image:url('.esc_url($docent_pro_sub_img[0]).');background-size: cover;background-position: 50% 50%;"';
                    if(empty($docent_pro_sub_img[0])){
                        $docent_pro_output = docent_pro_call_sub_header();
                    }
                }elseif($docent_pro_subtitle_bg_color){
                    $docent_pro_output = 'style="background:'.$docent_pro_subtitle_bg_color.'"';
                }else{
                    $docent_pro_output = docent_pro_call_sub_header();
                }
                
               if( get_post_meta(get_the_ID(),"themeum_sub_title_text",true) ){
                    $docent_pro_subtext = get_post_meta(get_the_ID(),"themeum_sub_title_text",true);
               }   
            }else{
                $docent_pro_output = docent_pro_call_sub_header();
            } 
        }else{
            $docent_pro_output = docent_pro_call_sub_header();
        }
    }else{
        $docent_pro_output = docent_pro_call_sub_header();
    }

?>

<div class="subtitle-cover sub-title" <?php print wp_kses_post($docent_pro_output);?>>
    <div class="container docent">
        <div class="row docent-row">
            <div class="col-12 text-center wrap">
                <?php
                    global $wp_query;
                    if(isset($wp_query->queried_object->name)){
                        if (get_theme_mod( 'header_title_enable', true )) {
                            if(get_post_type() == 'courses'){
                                echo '<h2 class="page-leading">'. esc_html($wp_query->queried_object->name) .'</h2>';
                            }else {
                                echo '<h2 class="page-leading">'.wp_kses_post(get_the_title()).'</h2>';
                            }
                        }
                    } else{
                        if( is_search() ){
                            if (get_theme_mod( 'header_title_enable', true )) {
                                $docent_pro_text = '';
                                $docent_pro_first_char = __('Search','docent');
                                if( isset($_GET['s'])){ 
                                    $docent_pro_text = sanitize_text_field(wp_unslash($_GET['s'])); 
                                }
                                echo '<h2 class="page-leading">'.wp_kses_post($docent_pro_first_char).': '.wp_kses_post($docent_pro_text).'</h2>';
                            }
                        }
                        else if( is_home() ){
                            if (get_theme_mod( 'header_title_enable', true )) {
                                if (get_theme_mod( 'header_title_text', __('Blog', 'docent') )){
                                    echo '<h2 class="page-leading">'. esc_html(get_theme_mod( 'header_title_text',__('News & Blog','docent') ) ).'</h2>';
                                }
                            }
                        } 
                        else if( is_single()){
                            if (get_theme_mod( 'subtitle_enable', true )) {
                                if (get_theme_mod( 'header_subtitle_text', '' )){
                                    echo '<h2 class="page-leading">'. esc_html(get_theme_mod( 'header_subtitle_text','' )).'</h2>';
                                }
                            }
                        } 
                        else{
                            if (get_theme_mod( 'header_title_enable', true )) {
                                echo '<h2 class="page-leading">'.esc_html(get_the_title()).'</h2>';
                                if($docent_pro_subtext){
                                    echo '<p class="page-leading-bottom">'.esc_html($docent_pro_subtext).'</p>';
                                }
                            }
                        }
                    } 
                ?>

                <!-- News & Blog -->
            </div>
        </div>
    </div>
</div>
