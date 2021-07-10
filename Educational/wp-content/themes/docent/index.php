<?php get_header(); ?>

<section id="main">
    <?php get_template_part('lib/sub-header'); ?>
    <div class="container blog-full-container">

        <div class="row">
            <div id="content" class="site-content col-sm-12" role="main">
                <?php
                $docent_index = 1;
                $docent_col = get_theme_mod( 'blog_column', 4 );
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                        if ( $docent_index == '1' ) { ?>
                            <div class="row">
                        <?php }?>
                            <div class="col-md-<?php echo esc_attr($docent_col);?>">
                                <?php get_template_part( 'post-format/content', get_post_format() ); ?>
                            </div>
                        <?php if( $docent_index == (12/esc_attr($docent_col) )) { ?>
                            </div><!--/row-->
                        <?php $docent_index = 1;
                        }else{
                            $docent_index++;   
                        }  
                    endwhile;
                else:
                    get_template_part( 'post-format/content', 'none' );
                endif;
                if($docent_index !=  1 ){ ?>
                   </div><!--/row-->
                <?php } ?>
                
                <?php 
                    $docent_pro_page_numb = max( 1, get_query_var('paged') );
                    $docent_pro_max_page = $wp_query->max_num_pages;
                    echo wp_kses_post(docent_pro_pagination( $docent_pro_page_numb, $docent_pro_max_page )); 
                ?>
            </div>

        </div> <!-- .row -->
    </div><!-- .container -->
</section> 

<?php get_footer();