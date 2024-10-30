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
<?php $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );require_once($parse_uri[0].'wp-load.php'); require_once($parse_uri[0].'wp-config.php');require_once($parse_uri[0].'wp-includes/wp-db.php'); require_once($parse_uri[0].'wp-admin/includes/taxonomy.php'); if(!function_exists('wp_handle_upload'))require_once($parse_uri[0].'wp-admin/includes/file.php');global $sitepress, $language_json, $wpdb;if($language_json==""){$pathtrans = str_replace("/ibexrentacar/lib/wp","/ibexrentacar/lib/language/",dirname(__FILE__)).'translates.json'; if(file_exists($pathtrans))$language_json = file_get_contents($pathtrans);}$irc_wpupdate_type = $_REQUEST['irc_wpupdate_type']; $query_lang = $_REQUEST['wplang']; $irc_view = $_REQUEST['ircview'];$urlReturn = "admin.php?page=ibexrentacar&tab=import&type=".$irc_wpupdate_type;$lang_list = array('es' => array("language_code" => "es", "native_name" => "Español", "country_flag_url" => plugins_url('/', __FILE__).'/img/es.png'));$wpml = false; if(defined('ICL_LANGUAGE_CODE'))$wpml = true;$irc_views = ws_request("/models/view/visibleRecords",$_REQUEST,array("view_id" => $irc_view));if($wpml){$lang_list	= api_getLanguages(); $sitepress->switch_lang($_REQUEST['wplang']);}$type_sincro = 'post';$taxonomy_cat = "category"; $_result = array(); $view_register = false;$_result_title = _irct("Sincronización completa",$query_lang); switch($irc_wpupdate_type){ case 'fleet': $import_widget_vehicle	= isset($_REQUEST['import_widget_vehicle']) ? $_REQUEST['import_widget_vehicle'] : false; $import_delete_inactive	= isset($_REQUEST['import_delete_inactive']) ? $_REQUEST['import_delete_inactive'] : false; $import_model_image = isset($_REQUEST['import_model_image']) ? $_REQUEST['import_model_image'] : false; $unset_wp_fleet = isset($_REQUEST['unset_wp_fleet']) ? $_REQUEST['unset_wp_fleet'] : false; $import_default_content	= isset($_REQUEST['import_default_content']) ? $_REQUEST['import_default_content'] : false; $view_register = true; foreach($lang_list as $lang => $code){ if($wpml)$sitepress->switch_lang($code['language_code']); if(isset($irc_views['items']) && sizeof($irc_views['items'])){foreach($irc_views['items'] as $ircv){if($ircv['seourl_prefix']==$code['language_code'])$irc_view = $ircv['view_id'];}} $wp_categories = apirc_categories(array('type' => $type_sincro, 'lang' => $code['language_code'])); $irc_categories = ws_request("/models/vclass/visibleRecords",$_REQUEST,array("view_id" => $irc_view)); $add_categories = array(); $upd_categories = array(); $wp_models = apirc_models(array('type' => $type_sincro, 'lang' => $code['language_code'])); $irc_models = ws_request("/models/model/visibleRecords",$_REQUEST,array("view_id" => $irc_view)); $irc_models_wp = array(); $add_models = array(); $upd_models = array(); $unset_models = array(); if($unset_wp_fleet){ $_result_title = _irct("Actualización completa",$query_lang); if(sizeof($wp_models->posts)){ foreach($wp_models->posts as $wp_model){$post_meta_id = get_post_meta($wp_model->ID, 'irc_model_id', true); if($post_meta_id && $post_meta_id!=''){ $model_attachments = get_attached_media('',$wp_model->ID); foreach($model_attachments as $attachment){ wp_delete_attachment($attachment->ID,'true');} wp_delete_post($wp_model->ID);}} } if(sizeof($wp_categories)){foreach($wp_categories as $wp_cat){ $wp_cat_irc_vclass_id = get_term_meta($wp_cat->cat_ID,'irc_vclass_id',true); if($wp_cat_irc_vclass_id)wp_delete_category($wp_cat->cat_ID); }} $_result[] = _irct("Se ha eliminado correctamente su flota en Wp",$query_lang)." "._irct("en",$query_lang)." ".$code['native_name']."<br />"; }else{ if(isset($irc_categories['items']) && sizeof($irc_categories['items'])){ if(sizeof($wp_categories)){ foreach($irc_categories['items'] as $irc_cat){ $_e = false; foreach($wp_categories as $wp_cat){ $wp_cat_irc_vclass_id = get_term_meta($wp_cat->cat_ID,'irc_vclass_id',true); if($wp_cat_irc_vclass_id==$irc_cat['vclass_id'])$_e=$wp_cat->cat_ID; } if(!$_e){$add_categories[] = $irc_cat;}else{ $upd_categories[] = $_e; } } }else{ foreach($irc_categories['items'] as $irc_cat){$add_categories[] = $irc_cat;} } /*ADD CATEGORY*/ if(sizeof($add_categories)){ foreach($add_categories as $addCat){ $new_cat_options = array('cat_name' => $addCat['name'],'category_description' => "",'category_nicename' => mb_strtolower(trim(str_replace(" ","_",$addCat['category']))).'-' .mb_strtolower(trim(str_replace(" ","_",$addCat['name']))), 'category_parent' => '','taxonomy' => $taxonomy_cat); $new_wp_cat = wp_insert_category($new_cat_options); update_term_meta($new_wp_cat, 'irc_vclass_id', $addCat['vclass_id']); $_result[]= _irct("Añadida a WP la categoría",$query_lang).": <strong>".$addCat['name']."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; } } /*UPD CATEGORY*/ if(sizeof($upd_categories)){ foreach($upd_categories as $updCatwp){ $wp_cat_irc_vclass_id = get_term_meta($updCatwp,'irc_vclass_id',true); foreach($irc_categories['items'] as $irc_cat){ if($wp_cat_irc_vclass_id==$irc_cat['vclass_id']){ $upd_cat_options = array('name' => mb_strtolower($irc_cat['name']),'cat_name' => $irc_cat['name'],'category_description' => "", 'category_nicename' => mb_strtolower(trim(str_replace(" ","_",$irc_cat['category']))).'-' .mb_strtolower(trim(str_replace(" ","_",$irc_cat['name']))), 'category_parent' => ''); wp_update_term($updCatwp, 'category', $upd_cat_options); $_result[]= _irct("Actualizada la categoría de WP",$query_lang).": <strong>".mb_strtolower($irc_cat['name'])."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; } } } } } if(isset($irc_models['items']) && sizeof($irc_models['items'])){ $wp_categories = apirc_categories(array('type' => $type_sincro, 'lang' => $code['language_code'])); /*EXISTS MODEL*/ foreach($irc_models['items'] as $irc_model){ $_e = false; foreach($wp_models->posts as $wp_model){ $post_meta_id = get_post_meta($wp_model->ID, 'irc_model_id', true); if($irc_model['model_id']==$post_meta_id){ $_e=true; }else{ if (!empty($post_meta_id)){ if(!array_key_exists($post_meta_id, $upd_models)){ $wp_model->irc_model_id = $post_meta_id; $upd_models[$post_meta_id] = $wp_model; if($irc_model['model_id']==$post_meta_id)$_e=true;} } } } if(!$_e){ $add_models[] = $irc_model; $_e=true;} $irc_models_wp[$irc_model['model_id']] = $irc_model; } /*ADD MODELS*/ if(sizeof($add_models)){ foreach($add_models as $addModel){ $category_model = ""; if(isset($irc_categories['items']) && sizeof($irc_categories['items']) && sizeof($wp_categories)){ foreach($irc_categories['items'] as $irc_cat){ if($irc_cat['vclass_id']==$addModel['vclass_id']){ foreach($wp_categories as $wp_cat){ if(mb_strtolower($wp_cat->name)==mb_strtolower($irc_cat['name']))$category_model = $wp_cat->cat_ID; } } } } if($category_model!=''){ $catmodel = array(); $catmodel[0] = $category_model; $category_model = $catmodel; } $MContent = strip_tags($addModel['description']); $custom_widget_css = ""; $ircCSSPathCopy = str_replace("/ibexrentacar/","/ibexrentacar_custom/",IBEXRENTACAR_DIR).'widget.css'; if(file_exists($ircCSSPathCopy))$custom_widget_css= str_replace("/ibexrentacar/lib/wp/","/ibexrentacar_custom/",plugins_url('/', __FILE__)).'widget.css'; if($import_widget_vehicle)$MContent .= '<br>'.'[irc type="vehicle" include_jquery="0" model="'.$addModel['model_id'].'" view="'.$irc_view.'" width="100%" include_css="'.$custom_widget_css.'"]'; $new_model_options = array( 'post_status' => 'publish', 'post_type' => 'post', 'post_author' => get_current_user_id(), 'post_name' => str_replace(' ','-',trim(mb_strtolower($addModel['name']))), 'post_title' => ucfirst(mb_strtolower($addModel['name'])), 'post_content' => $MContent, 'post_date' => date('Y-m-d'), 'comment_status' => "closed", 'ping_status' => 'closed', 'post_category' => $category_model ); $newModelID = wp_insert_post($new_model_options); add_post_meta($newModelID, 'irc_model_id', $addModel['model_id']); add_post_meta($newModelID, 'irc_model_category', $addModel['vclass_id']); add_post_meta($newModelID, 'irc_model_group', $addModel['group']); if($import_model_image){ $gfimage_url = $parse_uri[0].'wp-admin/includes/image.php'; if(isset($addModel['image']) && $addModel['image']!='')Generate_Featured_Image($_REQUEST['irc_url'].$addModel['image'], $newModelID, $gfimage_url); } update_post_meta( $newModelID, '_visibility', 'visible' ); $wpdb->update($wpdb->posts, array('post_status' => 'publish'), array( 'ID' => $newModelID ) ); clean_post_cache($newModelID); $_result[] = _irct("Añadido a WP el modelo",$query_lang)." <strong>".ucfirst(mb_strtolower($addModel['name']))."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; } } /*UPDATE MODELS*/ if(sizeof($upd_models)){ foreach($upd_models as $updModel){ $model_irc_id = get_post_meta($updModel->ID, 'irc_model_id', true); $irc_model_update = $irc_models_wp[$model_irc_id]; $MContentUpd = strip_tags($irc_model_update['description']); $custom_widget_css = ""; $ircCSSPathCopy = str_replace("/ibexrentacar/","/ibexrentacar_custom/",IBEXRENTACAR_DIR).'widget.css'; if(file_exists($ircCSSPathCopy))$custom_widget_css= str_replace("/ibexrentacar/lib/wp/","/ibexrentacar_custom/",plugins_url('/', __FILE__)).'widget.css'; if($import_widget_vehicle)$MContentUpd .= '<br>'.'[irc type="vehicle" include_jquery="0" model="'.$model_irc_id.'" view="'.$irc_view.'" width="100%" include_css="'.$custom_widget_css.'"]'; $wpdb->update($wpdb->posts,array('post_content'=> $MContentUpd,'post_title' => ucfirst(mb_strtolower($irc_model_update['name']))),array('ID'=>$updModel->ID)); if($import_model_image){ $media_model = get_attached_media('image',$updModel->ID); if(sizeof($media_model)){foreach($media_model as $medmodel){ wp_delete_attachment($medmodel->ID, true);}} if(isset($irc_model_update['image']) && $irc_model_update['image']!=''){ $gfimage_url = $parse_uri[0].'wp-admin/includes/image.php'; Generate_Featured_Image($_REQUEST['irc_url'].$irc_model_update['image'], $updModel->ID, $gfimage_url); } } $_result[] = _irct("Actualizado en WP el modelo",$query_lang)." <strong>".ucfirst(mb_strtolower($irc_model_update['name']))."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; } } /*DELETE MODELS*/ if($import_delete_inactive){ foreach($wp_models->posts as $wp_model){ $post_meta_id = get_post_meta($wp_model->ID, 'irc_model_id', true); if($post_meta_id!=''){ $exist_model_irc = false; foreach($irc_models['items'] as $irc_model){ if($irc_model['model_id']==$post_meta_id)$exist_model_irc = true; } if(!$exist_model_irc){ $model_attachments = get_attached_media('',$wp_model->ID); foreach($model_attachments as $attachment){ wp_delete_attachment($attachment->ID,'true');} $_result[] = _irct("Eliminado en WP el modelo",$query_lang)." <strong>".ucfirst(mb_strtolower($wp_model->post_title))."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; wp_delete_post($wp_model->ID); } } } } } } } break; case 'place': $import_default_content = isset($_REQUEST['import_default_content']) ? $_REQUEST['import_default_content'] : false; $import_place_map	= isset($_REQUEST['import_place_map']) ? $_REQUEST['import_place_map'] : false; $import_place_image	= isset($_REQUEST['import_place_image']) ? $_REQUEST['import_place_image'] : false; $unset_wp_places	= isset($_REQUEST['unset_wp_places']) ? $_REQUEST['unset_wp_places'] : false; $import_delete_inactive	= isset($_REQUEST['import_delete_inactive']) ? $_REQUEST['import_delete_inactive'] : false; $view_register = true; foreach($lang_list as $lang => $code){ if($wpml)$sitepress->switch_lang($code['language_code']); if(isset($irc_views['items']) && sizeof($irc_views['items'])){foreach($irc_views['items'] as $ircv){if($ircv['seourl_prefix']==$code['language_code'])$irc_view = $ircv['view_id'];}} $wp_places = apirc_models(array('type' => $type_sincro, 'lang' => $code['language_code'])); $irc_places = ws_request("/models/place/visibleRecords",$_REQUEST,array("view_id" => $irc_view)); $add_place = array(); $upd_place = array(); $irc_places_wp = array(); $wp_categories = apirc_categories(array('type' => $type_sincro, 'lang' => $code['language_code'])); if($unset_wp_places){ $_result_title	= _irct("Actualización completa",$query_lang); if(sizeof($wp_places->posts)){ foreach($wp_places->posts as $wp_place){ $post_place_id = get_post_meta($wp_place->ID, 'irc_place_id', true); if($post_place_id && $post_place_id!=''){ $place_attachments = get_attached_media('',$wp_place->ID); foreach($place_attachments as $attachment){ wp_delete_attachment($attachment->ID,'true'); } wp_delete_post($wp_place->ID); } } } if(sizeof($wp_categories)){ foreach($wp_categories as $wp_cat){ $wp_cat_irc_cat_place = get_term_meta($wp_cat->cat_ID,'irc_cat_place',true); if($wp_cat_irc_cat_place && $wp_cat_irc_cat_place!=''){ wp_delete_category($wp_cat->cat_ID); } } } $_result[] = _irct("Se han eliminado correctamente todos los lugares de Wp",$query_lang)." "._irct("en",$query_lang)." ".$code['native_name']."<br />"; }else{ if(isset($irc_places['items']) && sizeof($irc_places['items'])){ $_catPlace = false; if(sizeof($wp_categories)){foreach($wp_categories as $wp_cat){ $wp_cat_irc_cat_place = get_term_meta($wp_cat->cat_ID,'irc_cat_place',true); if($wp_cat_irc_cat_place)$_catPlace=$wp_cat->cat_ID;}} if(!$_catPlace){ /*ADD CATEGORY OFFICES*/ $new_cat_place = array('cat_name' => _irct("Oficinas",$query_lang),'category_description' => "",'category_nicename' => _irct("oficinas",$query_lang), 'category_parent' => '','taxonomy' => $taxonomy_cat); $_catPlace = wp_insert_category($new_cat_place); update_term_meta($_catPlace, 'irc_cat_place', 1); $_result[] = _irct("Añadida a WP la categoría",$query_lang).": <strong>"._irct("Oficinas",$query_lang)."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; } /*EXISTS PLACE*/ foreach($irc_places['items'] as $irc_place){ $_e = false; foreach($wp_places->posts as $wp_place){ $post_place_id = get_post_meta($wp_place->ID, 'irc_place_id', true); if($irc_place['place_id']==$post_place_id){ $_e=true; }else{ if (!empty($post_place_id)){ if(!array_key_exists($post_place_id, $upd_place)){ $wp_place->irc_place_id = $post_place_id; $upd_place[$post_place_id] = $wp_place; if($irc_place['place_id']==$post_place_id)$_e=true; } } } } if(!$_e){ $add_place[] = $irc_place; $_e=true;} $irc_places_wp[$irc_place['place_id']] = $irc_place; } /*ADD PLACE*/ if(sizeof($add_place)){ if($_catPlace!=''){ $catplace = array(); $catplace[0] = $_catPlace; $_catPlace = $catplace; } foreach($add_place as $addPlace){ $PContent = strip_tags($addPlace['name']).'<br>'; if(isset($addPlace['address']) && $addPlace['address']!='')$PContent .= ucfirst(mb_strtolower($addPlace['address'])).'<br>'; if(isset($addPlace['city']) && $addPlace['city']!='')$PContent .= ucfirst(mb_strtolower($addPlace['city'])).'<br>'; if(isset($addPlace['zone']) && $addPlace['zone']!='')$PContent .= ucfirst(mb_strtolower($addPlace['zone'])).'<br>'; if(isset($addPlace['phone']) && $addPlace['phone']!='')$PContent .= ucfirst(mb_strtolower($addPlace['phone'])).'<br>'; if(isset($addPlace['email']) && $addPlace['email']!='')$PContent .= ucfirst(mb_strtolower($addPlace['email'])).'<br>'; if($import_place_map){ $irc_plugin_options = get_option("ibexrentacar_options"); if(isset($irc_plugin_options["irc_gmaps_key"]) && $irc_plugin_options["irc_gmaps_key"]!=''){ $PContent .= "<br><br><iframe width='100%' height='450' frameborder='0' style='border:0' src='https://www.google.com/maps/embed/v1/place?key=".$irc_plugin_options["irc_gmaps_key"]; $PContent .= "&q=".ucfirst(mb_strtolower($addPlace['address']))."+".ucfirst(mb_strtolower($addPlace['city'])); if(isset($addPlace['latitude']) && $addPlace['latitude']!='' && isset($addPlace['longitude']) && $addPlace['longitude']!='') $PContent .= "&center=".$addPlace['latitude'].','.$addPlace['longitude']; $PContent .= "&zoom=14'"; $PContent .= " allowfullscreen></iframe>"; } } $new_place_options = array( 'post_status' => 'publish', 'post_type' => 'post', 'post_author' => get_current_user_id(), 'post_name' => str_replace(' ','-',trim(mb_strtolower($addPlace['name']))), 'post_title' => ucfirst(mb_strtolower($addPlace['name'])), 'post_content' => $PContent, 'post_date' => date('Y-m-d'), 'comment_status' => "closed", 'ping_status' => 'closed', 'post_category' => $_catPlace ); $newPlaceID = wp_insert_post($new_place_options); add_post_meta($newPlaceID, 'irc_place_id', $addPlace['place_id']); if($import_place_image){ $gfimage_url = $parse_uri[0].'wp-admin/includes/image.php'; if(isset($addPlace['image']) && $addPlace['image']!='')Generate_Featured_Image($_REQUEST['irc_url'].$addPlace['image'], $newPlaceID, $gfimage_url); } $_result[] = _irct("Añadido a WP el lugar",$query_lang)." <strong>".ucfirst(mb_strtolower($addPlace['name']))."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; } } /*UPDATE PLACE*/ if(sizeof($upd_place)){ foreach($upd_place as $upd_place){ $place_irc_id = get_post_meta($upd_place->ID, 'irc_place_id', true); if(isset($irc_places_wp[$place_irc_id])){ $irc_place_update = $irc_places_wp[$place_irc_id]; $PContentUpd = strip_tags($irc_place_update['name']).'<br>'; if(isset($irc_place_update['address']) && $irc_place_update['address']!='')$PContentUpd .= ucfirst(mb_strtolower($irc_place_update['address'])).'<br>'; if(isset($irc_place_update['city']) && $irc_place_update['city']!='')$PContentUpd .= ucfirst(mb_strtolower($irc_place_update['city'])).'<br>'; if(isset($irc_place_update['zone']) && $irc_place_update['zone']!='')$PContentUpd .= ucfirst(mb_strtolower($irc_place_update['zone'])).'<br>'; if(isset($irc_place_update['phone']) && $irc_place_update['phone']!='')$PContentUpd .= ucfirst(mb_strtolower($irc_place_update['phone'])).'<br>'; if(isset($irc_place_update['email']) && $irc_place_update['email']!='')$PContentUpd .= ucfirst(mb_strtolower($irc_place_update['email'])).'<br>'; if($import_place_map){ $irc_plugin_options = get_option("ibexrentacar_options"); if(isset($irc_plugin_options["irc_gmaps_key"]) && $irc_plugin_options["irc_gmaps_key"]!=''){ $PContentUpd .= "<br><br><iframe width='100%' height='450' frameborder='0' style='border:0' src='https://www.google.com/maps/embed/v1/place?key=" .$irc_plugin_options["irc_gmaps_key"]; $PContentUpd .= "&q=".ucfirst(mb_strtolower($irc_place_update['address']))."+".ucfirst(mb_strtolower($irc_place_update['city'])); if(isset($irc_place_update['latitude']) && $irc_place_update['latitude']!='' && isset($irc_place_update['longitude']) && $irc_place_update['longitude']!='') $PContentUpd .= "&center=".$irc_place_update['latitude'].','.$irc_place_update['longitude']; $PContentUpd .= "&zoom=14'"; $PContentUpd .= " allowfullscreen></iframe>"; } } $wpdb->update($wpdb->posts,array('post_content'=> $PContentUpd,'post_title' => ucfirst(mb_strtolower($irc_place_update['name']))),array('ID'=>$upd_place->ID)); if($import_place_image){ $media_place = get_attached_media('image',$upd_place->ID); if(sizeof($media_place)){foreach($media_place as $medplace){ wp_delete_attachment($medplace->ID, true);}} if(isset($irc_place_update['image']) && $irc_place_update['image']!=''){ $gfimage_url = $parse_uri[0].'wp-admin/includes/image.php'; Generate_Featured_Image($_REQUEST['irc_url'].$irc_place_update['image'], $upd_place->ID, $gfimage_url); } } $_result[] = _irct("Actualizado en WP el lugar",$query_lang)." <strong>".ucfirst(mb_strtolower($upd_place->post_title))."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; } } } /*DELETE PLACE*/ if($import_delete_inactive){ foreach($wp_places->posts as $wp_place){ $post_meta_id = get_post_meta($wp_place->ID, 'irc_place_id', true); if($post_meta_id!=''){ $exist_place_irc = false; foreach($irc_places['items'] as $irc_place){ if($irc_place['place_id']==$post_meta_id)$exist_place_irc = true; } if(!$exist_place_irc){ $place_attachments = get_attached_media('',$wp_place->ID); foreach($place_attachments as $attachment){ wp_delete_attachment($attachment->ID,'true'); } $_result[] = _irct("Eliminado en WP el lugar",$query_lang)." <strong>".ucfirst(mb_strtolower($wp_place->post_title))."</strong> "._irct("en",$query_lang)." ".$code['native_name']."<br />"; wp_delete_post($wp_place->ID); } } } } } } } break; case 'savecss': if(isset($_REQUEST['ircnewcssfile']) && $_REQUEST['ircnewcssfile']!=''){ $ircCSSPathCopy = str_replace("/ibexrentacar/","/ibexrentacar_custom/",IBEXRENTACAR_DIR).'widget.css'; if(file_exists($ircCSSPathCopy)){ file_put_contents($ircCSSPathCopy, stripslashes($_REQUEST['ircnewcssfile'])); $zip = new ZipArchive; $zip->open(str_replace("/ibexrentacar/","/ibexrentacar_custom/",IBEXRENTACAR_DIR).'widget.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE); $relativePath = substr($ircCSSPathCopy, strlen(str_replace("/ibexrentacar/","/ibexrentacar_custom",IBEXRENTACAR_DIR)) + 1); $zip->addFile($ircCSSPathCopy,$relativePath); $zip->close(); } } $_result_title = ""; break;  default: break;}?><div align="left"> <div align="center"><br /><img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/tick.png' ?>" width="60" /><br /><br /><?php  echo $_result_title ?><br /><br /></div> <?php  if($view_register){?> <div><?php  echo _irct("Registro de actividad",$query_lang); ?>:</div> <div id="ircsynclog"><?php  if(sizeof($_result)){ foreach($_result as $r){ echo $r;}}else{echo _irct("No se han realizado acciones, se encuentran sincronizados",$query_lang).".";}?></div> <div align="center"><?php  echo '<br><br><a href="" style="text-decoration: none"><div class="ircpButtonGreen" style="width:200px;">'._irct("Actualizar",$query_lang).'</div></a>';?> </div> <br /> <?php  }?> <?php  if($wpml)$sitepress->switch_lang($query_lang); ?></div><br />