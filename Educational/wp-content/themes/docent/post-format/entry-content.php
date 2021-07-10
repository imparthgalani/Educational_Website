<div class="entry-summary clearfix">
    <?php 
        if ( is_single() ) {
            the_content();
        } else {
            if ( get_theme_mod( 'blog_intro_en', true ) ) { 
                if ( get_theme_mod( 'blog_post_text_limit', 220 ) ) {
                    $docent_pro_textlimit = get_theme_mod( 'blog_post_text_limit', 220 );
                    if (get_theme_mod( 'blog_intro_text_en', true )) {
                        echo wp_kses_post(docent_excerpt_max_charlength($docent_pro_textlimit));
                    }
                } else {
                    the_content();
                }
                if ( get_theme_mod( 'blog_continue_en', true ) ) { 
                    $docent_pro_continue = get_theme_mod( 'blog_continue', __('Read More','docent' ) );
                    echo '<p class="wrap-btn-style"><a class="btn btn-style" href="'.esc_url( get_permalink() ).'">'. esc_html( $docent_pro_continue ) .' <i class="fas fa-long-arrow-alt-right"></i></a></p>';
                }
                
            }
        } 
    ?>
</div> <!-- //.entry-summary -->