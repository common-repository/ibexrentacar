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
<br /><div align="center"><div class="logocompany"><img src="<?php  echo $this->ircurl.$this->irccompany['logotools'] ?>" style="max-width:80%" /></div></div><br /><div class="ircpsidebarContent"><div class="ircpleft colp"><?php  echo _irct("Empresa") ?>:</div><div class="ircpright colv"><strong><?php  echo ucfirst(mb_strtolower($this->irccompany['company'])) ?></strong></div><div class="ircpclear"></div><div class="ircpleft colp"><?php  echo _irct("NIF/CIF") ?>:</div><div class="ircpright colv"><strong><?php  echo ucfirst(mb_strtolower($this->irccompany['cif'])) ?></strong></div><div class="ircpclear"></div><hr /><div class="ircpright"><a href="mailto:<?php  echo $this->irccompany['mail'] ?>" title="<?php  echo _irct("Contactar") ?>"><div class="ircpButtonIcon"/><img src="<?php  echo $this->plugin_url.'/img/talk.png' ?>" /></div></a></div><div class="ircpright"> <a href="//<?php  echo $this->irccompany['web'] ?>" target="_blank" title="<?php  echo _irct("Página web") ?>"><div class="ircpButtonIcon"/><img src="<?php  echo $this->plugin_url.'/img/website.png' ?>" /></div></a></div><div class="ircpright"><a href="<?php  echo $this->ircurl ?>" target="_blank" title="<?php  echo _irct("Mi panel") ?>"><div class="ircpButtonIcon"/><img src="<?php  echo $this->plugin_url.'/img/laptop.png' ?>" /></div></a></div><div class="ircpclear"></div></div>