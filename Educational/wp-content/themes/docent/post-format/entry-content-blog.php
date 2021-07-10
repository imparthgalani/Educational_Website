<!-- Single Page content -->
<div class="entry-summary clearfix">
    <?php 
        if ( is_single() ) {
            the_content();
        }
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'docent' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
        ) ); 
    ?>
</div> <!-- .entry-summary -->


