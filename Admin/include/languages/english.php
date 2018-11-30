
<?php

 function lang($phrase){

  static $lang= array(
                // admin navbar links
            'home_admin' => 'Home',
					  'categories' => 'Sections',
					  'item'       => 'item',
					  'members'    => 'members',
            'comments'   => 'comments',
					  'statistics' => 'statistics',
					  'logs'       => 'logs'
                      );
  return $lang[$phrase];
  }




?>
