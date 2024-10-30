<?php
/*
Plugin Name: Ibexrentacar
Plugin URI: http://www.ibexrentacar.com/
Description: Plugin de WordPress para conectar tu blog con la plataforma de gestión de Ibexrentacar.
Version: 1.7
Author: Ibexestudio
Author URI: http://www.ibexrentacar.com
*/
?>
<?php function Generate_Featured_Image($image_url, $post_id, $includeMedia){ $upload_dir = wp_upload_dir(); $image_data = file_get_contents($image_url); $filename = basename($image_url); if(wp_mkdir_p($upload_dir['path'])) $file = $upload_dir['path'] . '/' . $filename; else $file = $upload_dir['basedir'] . '/' . $filename; file_put_contents($file, $image_data); $wp_filetype = wp_check_filetype($filename, null ); $attachment = array('post_mime_type' => $wp_filetype['type'],'post_title' => sanitize_file_name($filename),'post_content' => '','post_status' => 'inherit'); $attach_id = wp_insert_attachment($attachment,$file,$post_id); require_once($includeMedia); $attach_data = wp_generate_attachment_metadata($attach_id, $file); $res1 = wp_update_attachment_metadata( $attach_id, $attach_data); $res2 = set_post_thumbnail($post_id, $attach_id); add_post_meta($post_id, '_thumbnail_id', $attach_id, true);}?>