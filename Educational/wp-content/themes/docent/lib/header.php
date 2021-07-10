<?php
    $docent_sticky_class = '';
    if( get_theme_mod( 'header_fixed', false )){
        $docent_sticky_class = ' enable-sticky ';
    } 
?>
<header id="masthead" class="site-header header-white <?php echo esc_attr($docent_sticky_class); ?> ">  	
	<div class="container">
		<div class="primary-menu">
			<div class="row align-items-center">
				
				<?php if(!class_exists('wp_megamenu_initial_setup')) { ?>
					<div class="clearfix col-md-auto col-10">
						<div class="docent-navbar-header">
							<div class="logo-wrapper">
								
								<?php  
								if( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
									the_custom_logo();
								} else { ?>
									<a class="docent-navbar-brand" href="<?php echo esc_url(home_url()); ?>">
										<h1 class="d-inline-block mr-2"><?php echo esc_html(get_bloginfo('name'));?> </h1>
										<?php
										$description = get_bloginfo( 'description', 'display' );
										if ( $description || is_customize_preview() ) :?>
										<span><?php echo esc_html($description); ?></span>
										<?php endif; ?>
									</a>
								<?php } ?>
							</div>   
						</div> <!--/#docent-navbar-header-->   
					</div> <!--/.col-sm-2-->
				<?php } ?>

				<!-- Mobile Monu -->
				<?php if( !class_exists('wp_megamenu_initial_setup') ) { ?>
					<div class="col-md-auto col-2 ml-auto docent-menu hidden-lg-up">
						<button id="hamburger-menu" type="button" class="navbar-toggle hamburger-menu-button" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="hamburger-menu-button-open"></span>
						</button>
					</div>
					<div id="mobile-menu" class="thm-mobile-menu"> 
						<div class="collapse navbar-collapse">
							<?php 
								if ( has_nav_menu( 'primary' ) ) {
									wp_nav_menu( 
										array(
											'theme_location'    => 'primary',
											'container'         => false,
											'menu_class'        => 'nav navbar-nav',
											'fallback_cb'       => 'wp_page_menu',
											'depth'             => 3,
											'walker'            => new wp_bootstrap_mobile_navwalker()
										)
									); 
								} 
							?>
						</div>
					</div> <!-- thm-mobile-menu -->
				<?php } ?>
				

				<!-- Primary Menu -->
				<?php if( class_exists('wp_megamenu_initial_setup') ) { ?>
					<div class="col-md-12 col-lg-12 common-menu common-main-menu">
				<?php }else { ?>
					<div class="col-auto ml-auto common-menu space-wrap d-none d-lg-block">
				<?php } ?>
					<div class="header-common-menu">
						<?php if ( has_nav_menu( 'primary' ) ) { ?>
							<div id="main-menu" class="common-menu-wrap">
								<?php 
									wp_nav_menu(  
										array(
											'theme_location'  => 'primary',
											'container'       => '', 
											'menu_class'      => 'nav',
											'fallback_cb'     => 'wp_page_menu',
											'depth'            => 4,
										)
									); 
								?>  
							</div><!--/.col-sm-9-->  
						<?php } ?>
					</div><!-- header-common-menu -->
				</div><!-- common-menu -->
			</div>
		</div> 
	</div><!--/.container--> 

	<!-- Header Progress. -->
	<?php if (get_theme_mod('progress_en', true)): ?>
		<?php if (get_theme_mod('header_fixed', true)): ?>
			<div class="docent-progress">
				<progress value="0" max="1">
					<span class="progress-bar"></span>    
				</progress>
			</div>
		<?php endif ?>
	<?php endif ?>
</header> <!-- header -->