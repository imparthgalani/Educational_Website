<?php get_header(); ?>

<section id="main">
    <?php get_template_part('lib/sub-header'); ?>
    <div class="container blog-full-container">
        <div class="row">
            <div id="content" class="site-content col-sm-8" role="main">
                <?php
                $docent_index = 1;
                $docent_col = get_theme_mod( 'blog_column', 12 );     
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        if ( $docent_index == '1' ) { ?>
                            <div class="row">
                        <?php }?>
                            <div class="col-md-<?php echo esc_attr($docent_col);?>">
                                <?php get_template_part( 'post-format/content', get_post_format() ); ?>
                            </div>
                        <?php if ( $docent_index == (12/esc_attr($docent_col) )) { ?>
                            </div><!--/row-->
                        <?php $docent_index = 1;
                        }else{
                            $docent_index++;   
                        }  
                    endwhile;
                else:
                    get_template_part( 'post-format/content', 'none' );
                endif;
                wp_reset_postdata();
                if($docent_index !=  1 ){ ?>
                   </div><!--/row-->
                <?php } ?>

                <?php global $wp_query;
                    $docent_pro_page_numb = max( 1, get_query_var('paged') );
                    $docent_pro_max_page = $wp_query->max_num_pages;
                    echo wp_kses_post(docent_pro_pagination( $docent_pro_page_numb, $docent_pro_max_page ));  
                ?>
            </div>

            <?php 
                get_sidebar(); 
                $docent_pro_action_title = get_theme_mod('blog_calltoaction_title');
                $docent_pro_action_subtitle = get_theme_mod('blog_calltoaction_subtitle');
                $docent_pro_button_one = get_theme_mod('blog_button_one');
                $docent_pro_button_two = get_theme_mod('blog_button_two');
                $docent_pro_btn_url1 = get_theme_mod('blog_button_url');
                $docent_pro_btn_url2 = get_theme_mod('blog_button_url2');
            ?>

            <?php if (get_theme_mod('enable_call_to_action', true) == 'true'): ?>     
                <div class="col-md-12 call-to-action">
                    <div class="row">
                        <div class="col-md-6 col-lg-7"> 
                            <h3 class="support-title"><?php echo esc_html($docent_pro_action_title); ?></h3>
                            <h2 class="title-self"><?php echo esc_html($docent_pro_action_subtitle); ?></h2>
                        </div>
                        <div class="col-md-6 col-lg-5 text-right">
                            <?php if ($docent_pro_btn_url1): ?>
                                <a href="<?php echo esc_url($docent_pro_btn_url1); ?>" class="btn"><?php echo esc_html($docent_pro_button_one); ?></a> 
                            <?php endif ?>
                            <?php if ($docent_pro_btn_url2): ?>
                                <a href="<?php echo esc_url($docent_pro_btn_url2); ?>" class="btn btn2"><?php echo esc_html($docent_pro_button_two); ?></a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            
        </div> <!-- .row -->
    </div><!-- .container -->
</section> 
<?php get_footer();