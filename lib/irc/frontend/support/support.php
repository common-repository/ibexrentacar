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
<div class="ircSupportBox"> <div class="ircpleft col20"><br><div align="center"><img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/247.png' ?>" style="width:80px;" /></div></div> <div class="ircpleft col50"> <h2><?php  echo _irct("Tickets de soporte") ?></h2><strong><?php  echo _irct("Si tiene una consulta envíenos un ticket 24/7") ?></strong><br /> <?php  echo _irct("Si no encuentra solución a su caso o tiene una duda técnica, por favor remita su questión a nuestro equipo de atención y soporte generando un ticket") ?>.<br /> </div> <div class="ircpright col30"><div align="center" style="margin-top: 35px;"> <?php  if(isset($this->ircuser['user_template']) && apirc_isadmin(mb_strtolower($this->ircuser['user_template'])) && $this->is_ws_logged){ if(isset($this->irccompany['zendesk_contact_id']) && $this->irccompany['zendesk_contact_id']!=''){?> <a href="https://support.ibexestudio.com/?zid=<?php  echo $this->irccompany['zendesk_contact_id'] ?>" target="_blank"> <input type="button" class="button button-primary ircpButtonGreen" value="<?php  echo _irct("Nuevo ticket") ?>" /> </a> <?php  }?> <?php  }else{?> <img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/locked.png' ?>" style="width:70px;" title="<?php  echo _irct("Debe iniciar sesión") ?>" /> <?php  }?> </div></div> <div class="ircpclear" style="height:10px"></div><hr class="irchrs2" /> <h2><?php  echo _irct("Preguntas frecuentes") ?></h2> <h3><?php  echo _irct("¿En cuántos sitios puedo instalar Ibexrentacar Plugin?") ?></h3> <?php  echo _irct("Puede registrar Ibexrentacar en todos sus sitios y en aquellos desarrollados para sus clientes") ?>.<br /> <?php  echo _irct("Accederá a su contenido asociado mediante su usuario y contraseña de conexión") ?>.<br /> <h3><?php  echo _irct("¿Puedo usar mi tema WordPress actual?") ?></h3> <?php  echo _irct("¡Sí! Ibexrentacar funciona nada más instalarse con cualquier tema WordPress") ?>.<br /> <h3><?php  echo _irct("¿Es compatible con instalaciones de WordPress multisitio?") ?></h3> <?php  echo _irct("Si, es completamente compatible") ?>.<br /> <h3><?php  echo _irct("¿Puedo usar más de un shorcode por página?") ?></h3> <?php  echo _irct("Si, puede insertar distintos shortcodes en una misma página") ?>.<br /> <h3><?php  echo _irct("¿Si hay cambios en mi flota, WP me pedirá realizar una nueva sincronización?") ?></h3> <?php  echo _irct("¡Si! El plugin Ibexrentacar le notificará si requiere de un sincronización de su flota y/o lugares") ?>.<br /> <br /><hr class="irchrs2" /> <?php  if($this->is_ws_logged){?> <h2><?php  echo _irct("Atención telefónica") ?></h2> <div style="width:95%; text-align: justify; margin-top:5px"><?php  echo _irct("No podremos atender peticiones telefónicas que pongan en riesgo la seguridad de sus servicios o la confidencialidad de sus datos, para ello utilice el sistema de tickets es seguro y rápido") ?>.</div> <div class="ircpclear"></div><br /> <div class="ircpleft col50"> <div class="ircpleft col50"><div class="ircpleft"><img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/phonemin.png' ?>" /></div> <div class="ircpleft"><?php  echo _irct("España") ?>:</div></div> <div class="ircpleft col50"><strong>+34.902.00.81.85</strong></div> <div class="ircpclear"></div><br /> <div class="ircpleft col50 "><div class="ircpleft"><img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/phonemin.png' ?>" /></div> <div class="ircpleft"><?php  echo _irct("Chile") ?>:</div></div> <div class="ircpleft col50"><strong>+56.2.2581.4440</strong></div> <div class="ircpclear"></div><br /> <div class="ircpleft col50"><div class="ircpleft"><img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/phonemin.png' ?>" /></div> <div class="ircpleft"><?php  echo _irct("United states") ?>:</div></div> <div class="ircpleft col50"><strong>+1.305.507.8433</strong></div> <div class="ircpclear"></div><br /> <div class="ircpleft col50"><div class="ircpleft"><img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/phonemin.png' ?>" /></div> <div class="ircpleft"><?php  echo _irct("United Kingdom") ?>:</div></div> <div class="ircpleft col50"><strong>+44.207.44.25858</strong></div> <div class="ircpclear"></div><br /> </div> <div class="ircpleft col50"> <img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/language/es.png' ?>" width="21" /> <strong style="padding-left:10px; font-size:14px;"><?php  echo _irct("En Español") ?></strong><br /><?php  echo _irct("9:00-14:00") ?> / <?php  echo _irct("16:00-19:00") ?><br /> CET - <?php  echo _irct("Central European Time") ?> <br /><br /> <img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/language/en.png' ?>" width="21" /> <strong style="padding-left:10px; font-size:14px;"><?php  echo _irct("In english") ?></strong><br /><?php  echo _irct("9:00-13:00") ?><br /> <?php  echo _irct("PDT - Pacific Daylight Time") ?> </div> <div class="ircpclear" style="height:10px"></div><hr class="irchrs2" /> <?php  }?> <img src="<?php  echo $GLOBALS['lsPluginPath'].'/img/help/ibexestudio.png' ?>" style="width:170px;" /> <h3 style="margin-top:0"><?php  echo _irct("¿Necesita una integración personalizada?") ?></h3> <div style="width:95%; text-align: justify"><?php  echo _irct("En Ibexestudio desarrollamos un conjunto de herramientas que nos permiten brindar nuestra asistencia en toda clase de requerimientos que involucran el desarrollo y/o mantenimiento, desde su diseño e implementación y puesta en marcha, hasta la migración y rediseño de aplicativos ya existentes") ?>.<br><br><?php  echo _irct("Le brindamos un servicio personalizado, interesándonos en las necesidades de cada cliente y desarrollando la solución que mejor las satisfaga") ?>.</div> <div class="ircpclear"></div><br></div>