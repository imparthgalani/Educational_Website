<?php get_header(); 
    $sidebar_en_class = '';
    $enable_sidebar = get_theme_mod('enable_sidebar', false);
    if($enable_sidebar){
        $sidebar_en_class = 'sidebar-enable';
    }
?>
    <section id="main">
        <div class="single-blog-style"> 
            <div class="container single-wrapper-content">
                <div class="row">
                    <div id="content" class="site-content col-md-<?php echo esc_attr($enable_sidebar ? '8' : '12').' '.esc_attr($sidebar_en_class); ?> blog-content-wrapper" role="main">
                        <?php if ( have_posts() ) :  ?> 
                            <?php while ( have_posts() ) : the_post(); ?>
                                <?php get_template_part( 'post-format/content', get_post_format() ); ?>   
                            <?php endwhile; ?>    
                        <?php else: ?>
                        <?php get_template_part( 'post-format/content', 'none' ); ?>
                        <?php endif; ?>

                        <?php 
                            if (is_single()){ 
                                if ( get_theme_mod( 'blog_single_comment_en', true ) ) {
                                    if ( comments_open() || get_comments_number() ) { ?>
                                        <div class="blog-comments-section">  
                                        <?php comments_template();?>
                                        </div>
                                    <?php }
                                } 
                            }
                        ?>
                    </div> <!-- #content -->
                    <?php if($enable_sidebar) get_sidebar(); ?>
                </div> <!-- .row -->
            </div> <!-- .container -->
        </div> <!-- .single-blog-style -->
    </section> <!-- #main -->
<?php get_footer();

