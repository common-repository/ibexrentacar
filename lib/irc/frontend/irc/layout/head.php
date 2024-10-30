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
<div id="irctopNav"> <div class="ircpleft"><img class="irctopNavLogo" src="<?php  echo $this->plugin_url.'/img/irctoplogodeveloper.png' ?>" /></div> <div class="ircpright"> <div class="status"> <?php  if($this->is_ws_logged && isset($session_company['items'][0])){ ?><strong class="company"><?php  echo $session_company['items'][0]['company'] ?></strong> | <?php  }?> <?php  if(!isset($this->wplanguages[$this->wplang]) && $this->wplanguages[$this->wplang]['country_flag_url']!=''){ ?> <img src="<?php  echo $this->wplanguages[$this->wplang]['country_flag_url'] ?>" style="padding:0 !important" /> | <?php  }else{?><?php  echo $this->wplanguages[$this->wplang]['native_name'] ?> | <?php  }?> <?php  if($this->is_ws_logged && isset($session_user['items'][0])){ ?><?php  echo _irct("Usuario") ?>: <strong><?php  echo $session_user['items'][0]['name'] ?></strong> | <?php  }?> <?php  echo _irct("Estado") ?>: <?php  if($this->is_ws_logged){ ?><strong class="ircsuccestxt"><?php  echo _irct("Conectado") ?></strong><?php  }else{ ?> <strong class="ircerrortxt"><?php  echo _irct("Sin conexión") ?></strong> | <a href="?page=ibexrentacar&tab=settings"><?php  echo _irct("Configurar ahora") ?></a><?php  }?> </div> </div> <div class="ircpleft w100"> <div class="statusmobile w100"> <div class="ircpleft col1"> <?php  if($this->is_ws_logged && isset($session_company['items'][0])){ ?><strong class="company"><?php  echo $session_company['items'][0]['company'] ?></strong><br /><?php  }?> <?php  if($this->is_ws_logged && isset($session_user['items'][0])){ ?><strong><?php  echo ucfirst(mb_strtolower($session_user['items'][0]['name'])) ?></strong> <br /><?php  }?> <div style="margin-top:10px;"> <?php  if(isset($this->wplanguages[$this->wplang]) && $this->wplanguages[$this->wplang]['country_flag_url']!=''){ ?> <div class="ircpleft"><img src="<?php  echo $this->wplanguages[$this->wplang]['country_flag_url'] ?>" style="padding:0 5px 0 0 !important" width="20" /></div> <?php  }?> <div class="ircpleft"><?php  echo $this->wplanguages[$this->wplang]['native_name'] ?></div> <div class="ircpclear"></div> </div> </div> <div class="ircpright col2"> <?php  if($this->is_ws_logged){ ?><strong class="ircsuccestxt"><?php  echo _irct("Conectado") ?></strong><?php  }else{ ?> <strong class="company"><?php  echo _irct("Ibexrentacar") ?></strong><br /> <div style="margin:10px 0 5px 0"><strong class="ircerrortxt"><?php  echo _irct("Sin conexión") ?></strong></div> <a href="?page=ibexrentacar&tab=settings"><?php  echo _irct("Configurar ahora") ?></a> <?php  }?> <div class="ircpclear" style="height:10px;"></div> </div> <div class="ircpclear"></div> </div> </div> <div class="ircpclear"></div></div>