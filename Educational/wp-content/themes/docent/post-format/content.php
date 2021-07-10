<?php if( is_single() ): ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('docent-post docent-single-post single-content-flat'); ?>>
<?php else: ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('docent-post docent-single-post docent-index-post'); ?>>
<?php endif; ?>

    <?php if (is_single()) { ?>
        <?php if ( get_theme_mod( 'blog_author_single', true ) || get_theme_mod( 'blog_category_single', true ) || get_theme_mod( 'blog_comment_single', true ) ): ?>

            <div class="single-blog-info">
                <?php if ( get_theme_mod( 'blog_date_single', true ) ) { ?>
                    <div class="blog-date-wrapper">
                        <?php echo wp_kses_post(docent_posted_on()); ?>
                    </div>
                <?php } ?>

                <?php the_title( '<h2 class="content-item-title">', '</h2>' ); ?>
                <div class="blog-post-meta-wrap">
                    <ul class="blog-post-meta clearfix"> 
                        <?php if ( get_theme_mod( 'blog_author_single', true ) ): ?>
                            <li class="meta-author">
                                <span class="img-author">
                                    <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>"> <?php esc_html_e('By. ', 'docent'); ?><?php echo wp_kses_post(get_the_author_meta('display_name')); ?></a>
                                </span>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ( get_theme_mod( 'blog_category_single', false ) ): ?> 
                            <li class="post-category">
                                <?php echo '<span>'.esc_html__('Category ','docent').'</span>'.wp_kses_post(get_the_category_list(', ')); ?>
                            </li>
                        <?php endif; ?>

                        <?php if ( get_theme_mod( 'blog_hit_single', true ) ) { ?>
                            <li class="meta-view-count">      
                                <?php
                                    # blog Count Down   
                                    $docent_pro_visitor_count = get_post_meta( $post->ID, '_post_views_count', true);
                                    if( $docent_pro_visitor_count == '' ){ $docent_pro_visitor_count = 0; }
                                    if( $docent_pro_visitor_count >= 1000 ){
                                        $docent_pro_visitor_count = round( ($docent_pro_visitor_count/1000), 2 );
                                        $docent_pro_visitor_count = $docent_pro_visitor_count.'k';
                                    }
                                ?>
                                <span><?php echo esc_html__('View Count. ','docent'). esc_attr( $docent_pro_visitor_count ); ?></span>
                            </li>
                        <?php } ?> 

                        <?php if ( get_theme_mod( 'blog_tags_single', true ) ) { ?>
                            <?php echo wp_kses_post(get_the_tag_list('<li class="meta-tag-count">'.__('Tag','docent').' ',', ','</li>')); ?>
                        <?php } ?>

                        <?php if ( get_theme_mod( 'blog_comment_single', false ) ) { ?>
                            <li>
                                <span><?php comments_number( '0', '1', '%' ); ?><?php esc_html_e(' Comments', 'docent') ?></span>
                            </li>
                        <?php } ?> 

                    </ul>
                </div>
            </div> 
        <?php endif; ?>
    <?php } ?> 

    <?php if ( has_post_thumbnail() ){ ?>
        <div class="blog-details-img">
            <?php if( is_single() ){ ?>
                <?php the_post_thumbnail('docent-large', array('class' => 'img-fluid')); ?>
            <?php } else { ?>     
                <a class="blog-permalink" href="<?php the_permalink(); ?>"></a>
                <?php 
                    $docent_col = get_theme_mod( 'blog_column', 12 );
                    if ($docent_col == 3) { ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('docent-blog', array('class' => 'img-fluid')); ?>
                        </a> 
                    <?php }elseif ($docent_col == 4) { ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('docent-blog', array('class' => 'img-fluid')); ?>
                        </a> 
                    <?php }else{ ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('docent-large', array('class' => 'img-fluid')); ?>
                        </a> 
                    <?php }
                ?>              
            <?php } ?>
        </div>
    <?php }  ?>
        
    <div class="docent-blog-title clearfix"> 
        <?php
            if (! is_single()) { ?>
            <?php if ( get_theme_mod( 'en_blog_date', true ) || get_theme_mod( 'blog_author', false ) || get_theme_mod( 'blog_category', false ) || get_theme_mod( 'blog_comment', false ) ): ?>
            <ul class="blog-post-meta clearfix"> 
                <?php if ( get_theme_mod( 'blog_author', false ) ): ?>
                    <li class="meta-author">
                        <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>">
                            <?php esc_html_e('By ', 'docent') ?><?php echo wp_kses_post(get_the_author_meta('display_name')); ?>  
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ( get_theme_mod( 'blog_category', false ) ): ?>
                    <li class="meta-category">
                        <?php echo wp_kses_post(get_the_category_list(', ')); ?>
                    </li>
                <?php endif; ?>

                 <?php if ( get_theme_mod( 'en_blog_date', true ) ): ?>
                    <li>
                        <div class="blog-date-wrapper">
                            <?php echo wp_kses_post(docent_posted_on()); ?>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if ( get_theme_mod( 'blog_tags', false ) ) { ?>
                    <li><?php echo wp_kses_post(get_the_tag_list('<i class="far fa-tags"></i> ',', ','')); ?></li> 
                <?php } ?>
            </ul>

        <?php endif; ?>
        <?php the_title( '<h2 class="content-item-title A"><a href="'.esc_url(get_the_permalink()).'">', '</a></h2>' ); ?>
        <?php } ?>

        <div class="entry-blog">
            <?php
                if (is_single()) {
                    get_template_part( 'post-format/entry-content-blog' );
                } else {
                    get_template_part( 'post-format/entry-content' );
                }
            ?> 
        </div> <!--/.entry-meta -->
    </div>
    
</article><!--/#post-->