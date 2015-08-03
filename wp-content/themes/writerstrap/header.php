<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WriterStrap
 * @since WP WriterStrap 1.1
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="shortcut icon" href="<?php echo of_get_option('fav_uploader'); ?>"/>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>	
	<nav class="navbar navbar-default">		
	<div class="container">
		<div class="row">
			<div class="site-navigation-inner col-12">
				<div class="navbar">
				    <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
				    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				    </button>
				
				    <!-- Your site title as branding in the menu -->
				    <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php if(of_get_option('logo_uploader')=='') 
						echo bloginfo( 'name' );
					  else { ?>
						<img src="<?php echo of_get_option('logo_uploader'); ?>">	
					<?php } ?>
					</a>
				    
					<ul class="nav pull-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li>
						  </li>
                          <?php get_search_form(); ?>
                        </ul>
                      </li>
                    </ul>
					
				    <!-- The WordPress Menu goes here -->
				       <?php wp_nav_menu(
			                array(
			                    'theme_location' => 'primary',
			                    'container_class' => 'nav-collapse collapse navbar-responsive-collapse',
			                    'menu_class' => 'nav navbar-nav',
			                    'fallback_cb' => '',
			                    'menu_id' => 'main-menu',
			                    'walker' => new wp_bootstrap_navwalker()
			                )
			            ); ?>
				
				
				</div><!-- .navbar -->
			</div>
		</div>
	</div><!-- .container -->
</nav><!-- .site-navigation -->
	
	
<header id="masthead" class="site-header" role="banner">
	<div class="container">
		<?php if(of_get_option('costom_header')) { ?>
		<div class="blogimage">
		<img src="<?php echo of_get_option('costom_header'); ?>" alt="<?php echo bloginfo( 'name' ); ?>"/>
		</div>
		<?php } ?>
		
		<?php if(of_get_option('custom_call')) { ?>
		<a href="<?php echo esc_url(of_get_option('custom_call')); ?>" class="callaut-btn">Read More </a>		
		<?php } ?>
		
		<h1><?php echo of_get_option('custom_heading' , 'Wecome to the Blog'); ?></h1>
		<?php if(of_get_option('custom_desc')) { ?>
		<p>
		<?php echo of_get_option('custom_desc'); ?>
		</p>
		<?php } ?>
		<div class="clear"></div>
		</div>
</header><!-- #masthead -->

<div class="main-content">	
	<div class="container" id="content">
		<div class="row">
			<div class="main-content-inner col-12 col-lg-8">

