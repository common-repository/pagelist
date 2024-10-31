<?php
/*
Plugin Name: PageList
Plugin URI: 
Description: Adds paging navigation to your WordPress blog.
Version: 1.2
Author: Smyshlaev Evgeniy
Author URI: http://hide.com.ua
*/

load_plugin_textdomain('pageList', 'wp-content/plugins/'.dirname(plugin_basename(__FILE__)).'/languages');

add_action('wp_head', 'pageList_css');
function pageList_css() {
    if(@file_exists(TEMPLATEPATH.'/pageList.css')) {
        echo '<link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/pageList.css" type="text/css" media="screen" />';    
    }else{
        echo '<link rel="stylesheet" href="'.WP_PLUGIN_URL."/".dirname(plugin_basename(__FILE__)).'/skin/pageList.css" type="text/css" media="screen" />';
    };
    echo "<script type='text/javascript' src='".WP_PLUGIN_URL."/".dirname(plugin_basename(__FILE__))."/skin/pageList.js'></script>";
};

add_action('loop_end', 'pageList_main');
function pageList_main() {
    global $wpdb, $wp_query;
    if (!is_single()) {
        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
        $max_page = $wp_query->max_num_pages;
        if(empty($paged) || $paged == 0) {
            $paged = 1;
        }
        if($max_page > 1) {
            echo('<div class="pageList" id="pageList"></div>');
            echo('<div class="pageList_pages">'.__($max_page.' pages','pageList').'</div>');
            echo('<script type="text/javascript">pageList = new pageList("pageList",'.$max_page.',10,' . $paged . ',"'.dirname(clean_url(get_pagenum_link(5))).'/");</script>');
        }
    }
};
?>
