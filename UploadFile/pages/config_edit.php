<?php
/**
  Plugin FileUploader pour Mantis BugTracker :

  - Envoi de fichiers multiples dans les bugs

  - Pour ce projet j'ai utilisé les librairies suivantes :

  - Jquery-FileDrop : https://github.com/weixiyen/jquery-filedrop
  - Le tutoriel suivant : http://tutorialzine.com/2011/09/html5-file-upload-jquery-php/
  - Le script d'upload https://github.com/mantisbt-plugins/PastePicture/blob/master/PastePicture/pages/bug_file_add.php

  © Hennes Hervé - 2015
  http://www.h-hennes.fr
 */

#Page de mise à jour de la configuration du module

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_max_files = gpc_get_int('max_files');
$f_max_file_size = gpc_get_int('max_file_size');
$f_allowed_extensions = gpc_get_string('allowed_extensions');

if( plugin_config_get( 'max_files' ) != $f_max_files ) {
	plugin_config_set( 'max_files', $f_max_files );
}
if( plugin_config_get( 'max_file_size' ) != $f_max_file_size ) {
	plugin_config_set( 'max_file_size', $f_max_file_size );
}
if( plugin_config_get( 'allowed_extensions' ) != $f_allowed_extensions ) {
	plugin_config_set( 'allowed_extensions', $f_allowed_extensions );
}

print_successful_redirect( plugin_page( 'config', true ) );

?>
