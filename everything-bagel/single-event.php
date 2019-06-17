
/* Customize the entry meta in the entry header (requires HTML5 theme support)*/

add_filter( 'genesis_post_info', 'event_post_info_filter');
function event_post_info_filter($post_info) {
    
$post_info = get_field ('date');
return $post_info;



}





















genesis();
