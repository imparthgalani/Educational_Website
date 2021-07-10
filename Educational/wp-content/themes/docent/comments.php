<?php
/* This comments template */
if ( post_password_required() )
    return;
?>
<div id="comments" class="comments-area comments">
    
    <?php if ( have_comments() ) : ?>
        
        <h3 class="comments-title">
            <?php
            $docent_comments_number = get_comments_number();
            if ( '1' === $docent_comments_number ) {
                /* translators: %s: post title */
                printf( esc_html( 'One comment on &ldquo;%s&rdquo;', 'comments title', 'docent' ), esc_html(get_the_title()) );
            } else {
                printf(
                /* translators: 1: number of comments, 2: post title */
                        esc_html(
                            '%1$s comment on &ldquo;%2$s&rdquo;',
                            '%1$s comments on &ldquo;%2$s&rdquo;',
                            esc_html($docent_comments_number),
                            'comments title',
                            'docent'
                        ),
                    esc_html(number_format_i18n( $docent_comments_number )),
                    esc_html(get_the_title())
                );
            }
            ?>
	    </h3><!-- .comments-title -->

        <ul class="comment-list">
            <?php
                wp_list_comments( array(
                    'style'       => 'ul',
                    'short_ping'  => true,
                    'callback' => 'docent_comment',
                    'avatar_size' => 80
                ) );
            ?>
        </ul><!-- .comment-list -->
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h1 class="screen-reader-text section-heading"><?php esc_html_e( 'Comment navigation', 'docent' ); ?></h1>
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'docent' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'docent' ) ); ?></div>
            </nav><!-- .comment-navigation -->
        <?php endif; // Check for comment navigation ?>
        <?php if ( ! comments_open() && get_comments_number() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'docent' ); ?></p>
        <?php endif; ?>
    <?php endif; // have_comments() ?>

    <?php
        $docent_pro_commenter  = wp_get_current_commenter();
        $docent_pro_req        = sanitize_email(get_option( 'require_name_email' ));
        $docent_pro_aria_req   = ( $docent_pro_req ? " aria-required='true'" : '' );
        $docent_pro_fields     =  array(
            'author'    => '<div class="col6 col6-input"><input id="author" name="author" type="text" placeholder="'. esc_attr__( 'Name', 'docent' ) .'" value="" size="30"' . esc_attr($docent_pro_aria_req) . '/>',
            'email'     => '<input id="email" name="email" type="text" placeholder="'. esc_attr__( 'Email', 'docent' ) .'" value="" size="30"' . esc_attr($docent_pro_aria_req) . '/>',
            'url'       => '<input id="url" name="url" type="text" placeholder="'. esc_attr__( 'Website url', 'docent' ) .'" value="" size="30"/></div>',
        );
        $docent_pro_comments_args = array(
            'fields'                    =>  $docent_pro_fields,
            'class_form'                => 'comment-form clearfix',
            'title_reply'               => __('Write a comment', 'docent'),
            'comment_notes_before'      => '',
            'comment_notes_after'       => '',
            'comment_field'             => '<div class="col6"><textarea id="comment" placeholder="'. esc_attr__( 'Comment', 'docent' ) .'" name="comment" aria-required="true"></textarea></div>',
            'label_submit'              => __( 'Send Comment', 'docent' ), 
        );
        ob_start();
        comment_form($docent_pro_comments_args);
    ?>
</div>