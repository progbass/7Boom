<?php
/**
 * 7Boom functions file
 *
 * @package WordPress
 * @subpackage 7Boom
 * @since 7Boom 1.0
 */


/******************************************************************************\
	Theme support, standard settings, menus and widgets
\******************************************************************************/

add_theme_support( 'post-formats', array( 'image', 'quote', 'status', 'link' ) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );

register_nav_menu( 'main-menu', __( '7Boom Main Navigation Menu', 'boom' ) );

if ( function_exists( 'register_sidebars' ) ) {
	register_sidebar(
		array(
			'id' => 'home-sidebar',
			'name' => __( 'Home widgets', 'boom' ),
			'description' => __( 'Shows on home page', 'boom' )
		)
	);

	register_sidebar(
		array(
			'id' => 'footer-sidebar',
			'name' => __( 'Footer widgets', 'boom' ),
			'description' => __( 'Shows in the sites footer', 'boom' )
		)
	);
}

if ( ! isset( $content_width ) ) $content_width = 650;




/**
 * Include editor stylesheets
 * @return void
 */
function boom_editor_style() {
    add_editor_style( 'css/wp-editor-style.css' );
}
add_action( 'init', 'boom_editor_style' );


add_filter( 'mce_buttons_2', 'fb_mce_editor_buttons' );
function fb_mce_editor_buttons( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}



/*
* Callback function to filter the MCE settings
*/
add_filter( 'tiny_mce_before_init', 'fb_mce_before_init' );
function fb_mce_before_init( $settings ) {

    $style_formats = array(
        array(
            'title' => 'Quote',
            'block' => 'blockquote'
        ),
        array(
            'title' => 'Nota Relacionada',
            'block' => 'div',
            'classes' => 'related'
            ),
        array(
            'title' => 'Anotacion Title',
            'block' => 'h4',
            'classes' => 'note',
        ),
        array(
            'title' => 'Anotacion Text',
            'block' => 'p',
            'classes' => 'note_text'
        ),
        array(
            'title' => 'Image Footer',
            'block' => 'p',
            'classes' => 'footer'
        )
    );

    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
}




function more_posts() {
  global $wp_query;
  return $wp_query->current_post + 1 < $wp_query->post_count;
}



function custom_excerpt_length( $string ) {
	$limit = 19;
	$excerpt = explode(' ', $string, $limit);
	if (count($excerpt) >= $limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}	
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}
add_filter( 'the_excerpt', 'custom_excerpt_length', 999 );




/******************************************************************************\
	Scripts and Styles
\******************************************************************************/

/**
 * Enqueue boom scripts
 * @return void
 */
function boom_enqueue_scripts() {
	wp_enqueue_style( 'boom-styles', get_stylesheet_uri(), array(), '1.0' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'main_js', get_template_directory_uri() . '/js/scripts.pack.js', array(), '1.0', true );


	// LOCALIZE SCRIPT (References for Ajax Functions)
	global $wp_query, $post;

	
	$query = $wp_query;
	$section = getBlogSectionName();
	if($section == 'home'){
		$exlude_post_ids = [];

		// Exclude first 3 featured posts
		$featured_args = array(
		    'posts_per_page' => 3,
		    'meta_key' => 'featuredPost-checkbox',
		    'meta_value' => 'yes'
		);
		$featured_posts = new WP_Query($featured_args);
		while($featured_posts->have_posts()):
			$featured_posts->the_post();
			array_push($exlude_post_ids, get_the_ID());
		endwhile;
		wp_reset_postdata(); 

		// Exclude 3 'Latest' Posts
		$latest_args = array(
		    'posts_per_page' => 3,
		    'post__not_in' => $exlude_post_ids
		);
		$latest_posts = new WP_Query($latest_args);
		while($latest_posts->have_posts()):
			$latest_posts->the_post();
			array_push($exlude_post_ids, get_the_ID());
		endwhile;
		wp_reset_postdata(); 

		// Get All posts, except selected posts from above
		$args = array(
		    'post__not_in' => $exlude_post_ids
		);
		$query = new WP_Query($args);


	} else if($section == 'single'){
		$args = array(
			'cat'				=> array(get_the_category($query->post->ID)[0]->term_id),
			'posts_per_page'	=> 1,
			'post__not_in'		=> array($post->ID)
		);
		$query = new WP_Query($args);


	} else if($section == 'category'){
		$args = array(
			'cat'				=> array(get_category(get_query_var( 'cat' ))->cat_ID),
			'posts_per_page'	=> 7,
			'offset'			=> 10
		);
		$query = new WP_Query($args);
	}

	$reference_object = array(
		'base'				=> get_template_directory_uri(),
		'ajaxurl'			=> admin_url( 'admin-ajax.php' ),
		'query_vars' 		=> json_encode( $query->query_vars ),
		'actual_page'		=> get_query_var('paged') > 1 ? get_query_var('paged') : 1,
		'total_pages'		=> $query->max_num_pages,
		'section'			=> $section,
		'isMobile'			=> wp_is_mobile() ? 'true' : 'false',
        'category'          => get_category($query->query_vars['cat'])->slug

	);
	wp_localize_script('main_js', 'base_reference', $reference_object );
}
add_action( 'wp_enqueue_scripts', 'boom_enqueue_scripts' );




function getBlogSectionName(){
	$section_name = 'home';
	if(is_home() || is_front_page()){
		$section_name = 'home';
	} else if(is_page()){
		$section_name = 'page';
	} else if(is_category()){
		$section_name = 'category';
	} else if(is_single()){
		$section_name = 'single';
	} 

	return $section_name;
}




/******************************************************************************\
	Content functions
\******************************************************************************/

/**
 * Displays meta information for a post
 * @return void
 */
function boom_post_meta() {
	if ( get_post_type() == 'post' ) {
		echo sprintf(
			__( 'Posted %s in %s%s by %s. ', 'boom' ),
			get_the_time( get_option( 'date_format' ) ),
			get_the_category_list( ', ' ),
			get_the_tag_list( __( ', <b>Tags</b>: ', 'boom' ), ', ' ),
			get_the_author_link()
		);
	}
	edit_post_link( __( ' (edit)', 'boom' ), '<span class="edit-link">', '</span>' );
}

//filter the <p> tags from the images and iFrame
function filter_ptags_on_images($content){
$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

/**
 * Wraps Embedded content on a DIV element
 * @return String
 */
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="video_container">' . $html . '</div>';
}

/**
 * Wraps Images content on a DIV element
 * @return String
 */
function content_addDivToImage( $content ) {
   $pattern = '/(<img([^>]*)>)/i';
   $replacement = '<div class="image_wrapper">$1</div>';
   $content = preg_replace( $pattern, $replacement, $content );

   return $content;
}
add_filter( 'the_content', 'content_addDivToImage' );


function wpa_category_nav_class( $classes, $item ){
    if( 'category' == $item->object ){
        $category = get_category( $item->object_id );
        $classes[] = 'menu-' . $category->slug;
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'wpa_category_nav_class', 10, 2 );








/******************************************************************************\
	FEATURED CONTENT CHECKBOX
\******************************************************************************/

function sm_custom_meta() {
	add_meta_box('sm_meta', __( 'Post Destacado', 'sm-textdomain' ), 'sm_meta_callback', 'post' );
}
function sm_meta_callback( $post ) {
    $featured = get_post_meta( $post->ID ); ?>
 
	<p>
	    <div class="sm-row-content">
	        <label for="featuredPost-checkbox">
	            <input type="checkbox" name="featuredPost-checkbox" id="featuredPost-checkbox" value="yes" <?php if ( isset ( $featured['featuredPost-checkbox'] ) ) checked( $featured['featuredPost-checkbox'][0], 'yes' ); ?> />
	            <?php _e( '¿Mostrar este artículo como post destacado?', 'sm-textdomain' )?>
	        </label>
	        
	    </div>
	</p>
 
<?php
}
add_action( 'add_meta_boxes', 'sm_custom_meta' );


function sm_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
 
	// Checks for input and saves
	if( isset( $_POST[ 'featuredPost-checkbox' ] ) ) {
	    update_post_meta( $post_id, 'featuredPost-checkbox', 'yes' );
	} else {
	    update_post_meta( $post_id, 'featuredPost-checkbox', '' );
	}
 
}
add_action( 'save_post', 'sm_meta_save' );






/////////////////////////////////////////////////////////////
// AJAX CALLS
/////////////////////////////////////////////////////////////
function template_ajax_pagination_home() {

	// CONSTRUCT QUERY
    $query_vars = json_decode( stripslashes( $_GET['query_vars'] ), true );
    //$query_vars['paged'] = $_GET['page'];
    $query_vars['category_name'] = $_GET['category'];
    $query_vars['post_status'] = 'publish';

    // MAKE QUERY
    $posts = new WP_Query( $query_vars );
    $GLOBALS['wp_query'] = $posts;
    
    print_r($posts);

    // FORM RETURN STRING FROM SEARCH RESULTS
    if( $posts->have_posts() ) {

		$counter = 1;
        while ( $posts->have_posts() ) { 
            $posts->the_post();

			// 
    		get_template_part( 'loop', get_post_format() );

			//
			$counter++;
        }
    }
    

	//finish
    die();
}
add_action( 'wp_ajax_nopriv_ajax_pagination_home', 'template_ajax_pagination_home' );
add_action( 'wp_ajax_ajax_pagination_home', 'template_ajax_pagination_home' );


function template_ajax_pagination_single() {
	global $post;

	// CONSTRUCT QUERY
    $query_vars = json_decode( stripslashes( $_GET['query_vars'] ), true );
    $query_vars['paged'] = $_GET['page'];
    $query_vars['post_status'] = 'publish';
    

    // MAKE QUERY
    $posts = new WP_Query( $query_vars );
    $GLOBALS['wp_query'] = $posts;
    

    // FORM RETURN STRING FROM SEARCH RESULTS
    if( $posts->have_posts() ) {
		get_template_part( 'loop-single', get_post_format() );
    }
    

	//finish
    die();
}
add_action( 'wp_ajax_nopriv_ajax_pagination_single', 'template_ajax_pagination_single' );
add_action( 'wp_ajax_ajax_pagination_single', 'template_ajax_pagination_single' );


/*
function template_ajax_pagination_category() {

	// CONSTRUCT QUERY
    $query_vars = json_decode( stripslashes( $_GET['query_vars'] ), true );
    $query_vars['paged'] = $_POST['page'];
    $query_vars['post_status'] = 'publish';
    

    // MAKE QUERY
    $chronological_posts = new WP_Query( $query_vars );
    $GLOBALS['wp_query'] = $chronological_posts;
    
    ob_start();
    // FORM RETURN STRING FROM SEARCH RESULTS
    if( $chronological_posts->have_posts() ) {
        // Declare Counter
		$counter = 1;
		while( $chronological_posts->have_posts() ) : 
			// Post Loop
			include( locate_template( 'loop-category.php' ) );

			// Update Counter
			$counter++;
		endwhile;
	
		// Restore original Post Data
		wp_reset_postdata();
    }

	//
	$content = ob_get_clean();
	echo $content;

	//finish
    die();
}
add_action( 'wp_ajax_nopriv_ajax_pagination_category', 'template_ajax_pagination_category' );
add_action( 'wp_ajax_ajax_pagination_category', 'template_ajax_pagination_category' );
*/




/////////////////////////////////////////////////////////////
// ADD DOUBLECLICK FOR PUBLISHERS (DFP)
/////////////////////////////////////////////////////////////
function add_DFP(){ ?>
	
	<script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
	<script>
	  var googletag = googletag || {};
	  googletag.cmd = googletag.cmd || [];
	</script>

	<script>
	  var ad_home_billboard,
	  	  ad_mobile_box;

	  googletag.cmd.push(function() {
          
          
	  	<?php
	  	if( !wp_is_mobile() ){ ?>
	  	    // googletag.defineSlot('/94465771/7boom_Billboard_all', [[728, 90], [970, 250]], 'div-gpt-ad-1503949356736-0').addService(googletag.pubads());
	  		
            // googletag.defineSlot('/94465771/7boom_Billboard_9am', [[728, 90], [970, 250]], 'div-gpt-ad-1503949678961-0').addService(googletag.pubads());
            // googletag.defineSlot('/94465771/7boom_Billboard_6pm', [[970, 250], [728, 90]], 'div-gpt-ad-1503949716909-0').addService(googletag.pubads());
            // googletag.defineSlot('/94465771/7boom_Billboard_8pm', [[728, 90], [970, 250]], 'div-gpt-ad-1503949802451-0').addService(googletag.pubads());
            
        <?php
		} else { ?>
            googletag.defineSlot('/94465771/7boom_m_Boxbanner_All', [[300, 250], [300, 300]], 'div-gpt-ad-1503950138877-0').addService(googletag.pubads());
        
            // googletag.defineSlot('/94465771/7boom_m_Boxbanner_9am', [[300, 300], [300, 250]], 'div-gpt-ad-1503950165993-0').addService(googletag.pubads());
            // googletag.defineSlot('/94465771/7boom_m_Boxbanner_6pm', [[300, 300], [300, 250]], 'div-gpt-ad-1503950188173-0').addService(googletag.pubads());
            // googletag.defineSlot('/94465771/7boom_m_Boxbanner_8pm', [[300, 300], [300, 250]], 'div-gpt-ad-1503950213186-0').addService(googletag.pubads());
          
          <?php
        } ?>

	  	// googletag.defineSlot('/94465771/7boom_Boxbanner_1_All', [[300, 250], [300, 300]], 'div-gpt-ad-1503949907122-0').addService(googletag.pubads());   
        // googletag.defineSlot('/94465771/7boom_Boxbanner_2_All', [[300, 300], [300, 250]], 'div-gpt-ad-1503950030022-0').addService(googletag.pubads());   
	    
        // googletag.defineSlot('/94465771/7boom_Boxbanner_1_9am', [[300, 250], [300, 300]], 'div-gpt-ad-1503949935630-0').addService(googletag.pubads());
        // googletag.defineSlot('/94465771/7boom_Boxbanner_2_9am', [[300, 250], [300, 300]], 'div-gpt-ad-1503950060345-0').addService(googletag.pubads());
        // googletag.defineSlot('/94465771/7boom_Boxbanner_1_6pm', [[300, 250], [300, 300]], 'div-gpt-ad-1503949960322-0').addService(googletag.pubads());
        // googletag.defineSlot('/94465771/7boom_Boxbanner_2_6pm', [[300, 250], [300, 300]], 'div-gpt-ad-1503950079788-0').addService(googletag.pubads());
        // googletag.defineSlot('/94465771/7boom_Boxbanner_1_8pm', [[300, 250], [300, 300]], 'div-gpt-ad-1503949983999-0').addService(googletag.pubads());
        // googletag.defineSlot('/94465771/7boom_Boxbanner_2_8pm', [[300, 250], [300, 300]], 'div-gpt-ad-1503950105552-0').addService(googletag.pubads());
          
	    googletag.pubads().enableSingleRequest();
	    //googletag.pubads().disableInitialLoad();
	    googletag.enableServices();
	  });
	</script>

<?php
}
add_action('wp_head', 'add_DFP');
/////////////////////////////////////////////////////////////
// END DOUBLECLICK FOR PUBLISHERS (DFP)
/////////////////////////////////////////////////////////////








/////////////////////////////////////////////////////////////
// ADD COMSCORE TAG (FOOTER)
/////////////////////////////////////////////////////////////
function add_comScore(){ ?>

	<!-- Begin comScore Inline Tag 1.1302.13 -->
	<script type="text/javascript" language="JavaScript1.3" src="http://b.scorecardresearch.com/c2/9734177/ct.js"></script>
	<!-- End comScore Inline Tag -->

<?php
}
add_action('wp_footer', 'add_comScore');
/////////////////////////////////////////////////////////////
// END COMSCORE TAG
/////////////////////////////////////////////////////////////
        







/////////////////////////////////////////////////////////////
// ADD GOOGLE ANALYTICS (FOOTER)
/////////////////////////////////////////////////////////////
function add_GoogleAnalyticsTag(){ ?>
    <!-- Begin Google Analytics Tag -->
	<script>
         (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
         (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
         m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
         })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
         ga('create', 'UA-36293587-1', 'auto');
         ga('send', 'pageview');
    </script>
    <!-- End Google Analytics Tag -->

<?php
}
add_action('wp_footer', 'add_GoogleAnalyticsTag');
/////////////////////////////////////////////////////////////
// END GOOGLE ANALYTICS 
/////////////////////////////////////////////////////////////


        
