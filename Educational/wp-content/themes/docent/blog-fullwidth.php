<?php 
/**
* Template Name: Blog Fullwidth 
*/
get_header();

# Sub header.
get_template_part('lib/sub-header'); ?>

<section id="main">
    <div class="container blog-full-container">
        <div class="row">
            <div id="content" class="site-content col-sm-12" role="main">
                <?php
                # Query for FontPage and default template. 
                if (is_front_page()) {
                    $docent_pro_paged = (get_query_var('page')) ? get_query_var('page') : 1;
                }else{
                    $docent_pro_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                }
                $docent_pro_args = array('post_type' => 'post','paged' => $docent_pro_paged);
                $docent_pro_thequery = new WP_Query($docent_pro_args);
                $docent_index = 1;
  
                $docent_col = get_theme_mod( 'blog_column', 4 );
                
                if ( $docent_pro_thequery->have_posts() ) :
                    while ( $docent_pro_thequery->have_posts() ) : $docent_pro_thequery->the_post();
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

                <?php 
                    $docent_pro_page_numb = max( 1, get_query_var('paged') );
                    $docent_pro_max_page = $docent_pro_thequery->max_num_pages;
                    echo wp_kses_post(docent_pro_pagination( $docent_pro_page_numb, $docent_pro_max_page )); 
                ?>
            </div>

        </div> <!-- .row -->
    </div><!-- .container -->
</section> 

<?php get_footer();