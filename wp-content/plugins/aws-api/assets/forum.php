<?php
/**
 * The Template Name: Forum
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>
<div class="container">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<section class="inner-pages-wrap">
		
		  <div class="row">
		  <div class="col-sm-12 forums-wrap">
		  <h3><span>All Forums</span></h3>
		  <div class="row">
		  
		 
		<?php 
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$querystr = new WP_Query(array('post_type' => 'forum', 'posts_per_page' => 4, 'orderby'=>'title', 'order' => 'ASC', 'paged'=>$paged));
//		$postdata = $querystr->posts;	
		if($querystr->have_posts()){
		?>
		<?php while($querystr->have_posts()){ $querystr->the_post(); ?>
		  <div id="post-<?php echo get_the_ID(); ?>" class="col-sm-12 forum-blk">
		  <div class="col-sm-3 padding0 forum-img"><?php twentyfifteen_post_thumbnail(); ?></div>
		  <div class="col-sm-9 padding0-rgt forum-cont">
		  <h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
	          <?php the_title(); ?></a><span>(2 Storylines)</span></h4>
		  <p><?php the_excerpt(); ?></p> 
		  <a href="<?php the_permalink() ?>"<button type="button" class="btn btn-default">Enter Forum</button></a>
		  </div>
		  </div>
		  <?php } ?>
		  <?php wp_reset_postdata(); ?>	  
		  <?php } else { ?>
		    <h2 class="center">Not Found</h2>
		    <p class="center">Sorry, but you are looking for something that isnt here.</p>
		    <?php include (TEMPLATEPATH . "/searchform.php"); ?>
		 <?php } ?>
		 <?php 
		 if (function_exists('wp_pagenavi')){wp_pagenavi( array( 'query' => $querystr ));}
		  ?>
		  </div>
		  </div>
		  
		  </section> 
		  
		  </main><!-- .site-main -->
	</div><!-- .content-area -->
	
	<div class="sidebar-section"><?php get_sidebar(); ?></div>
	</div>

<?php get_footer(); ?>
