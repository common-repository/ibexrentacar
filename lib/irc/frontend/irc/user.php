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
<?php  if(sizeof($this->ircuser)){?><?php  if(isset($_user['logouser']) && $_user['logouser']!=''){?><br /><div align="center"><div class="logocompany"><img src="<?php  echo $this->ircurl.$this->ircuser['logouser'] ?>" height="80" /></div></div><br /><?php  }?><div class="ircpsidebarContent"><div class="ircpleft colp"><?php  echo _irct("Nombre") ?>:</div><div class="ircpright colv"><strong><?php  echo ucfirst(mb_strtolower($this->ircuser['name'])) ?></strong></div><div class="ircpclear"></div><div class="ircpleft colp"><?php  echo _irct("Perfil") ?>:</div><div class="ircpright colv"><strong><?php  echo ucfirst(mb_strtolower($this->ircuser['user_template'])) ?></strong></div><div class="ircpclear"></div><?php  if(isset($this->ircuser['comission']) && $this->ircuser['comission'] && $this->ircuser['comission']!="0.00"){?> <div class="ircpleft colp"><?php  echo _irct("Comisión") ?>:</div><div class="ircpright colv"><strong><?php  echo $this->ircuser['comission'].'	%' ?></strong></div><div class="ircpclear"></div><?php  }?><?php  if(isset($this->ircuser['landing_user_active']) && $this->ircuser['landing_user_active']){?> <div class="ircpleft colp"><?php  echo _irct("Web afiliado") ?>:</div> <div class="ircpright colv"><a href="<?php  echo $this->ircurl ?>/affiliate/<?php  echo mb_strtolower($this->ircuser['username'])?>" target="_blank"><strong><?php  echo _irct("Activa") ?></strong></a></div> <div class="ircpclear"></div><?php  }?></div><?php  }?>