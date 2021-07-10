<?php 

get_header();

# Sub header.
get_template_part('lib/sub-header'); ?>

    <section id="main" class="generic-padding">
        <div class="container">
            <div class="row">
                <div id="content" class="site-content col-md-8" role="main">
                    <?php
                        $docent_index = 1;
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post(); 
                                if ( $docent_index == '1' ) { ?>
                                    <div class="row">
                                <?php } ?>
                                    <div class="separator-wrapper col-md-4">
                                        <?php get_template_part( 'post-format/content', get_post_format() ); ?>
                                    </div>
                                <?php if ( $docent_index == (12/4 )) { ?>
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
                        <?php }
                    ?>
                   <?php
                        $docent_pro_page_numb = max( 1, get_query_var('paged') );
                        $docent_pro_max_page = $wp_query->max_num_pages;
                        echo wp_kses_post(docent_pro_pagination( $docent_pro_page_numb, $docent_pro_max_page ));  
                    ?>
                </div> <!-- .site-content -->
                <?php get_sidebar(); ?>
            </div>
        </div> <!-- .container -->
    </section> 
<?php get_footer();