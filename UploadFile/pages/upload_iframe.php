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

require_once( dirname(__FILE__) . '/../../../core.php' );
#Balise pour autoriser l'affichage de l'iframe
header("X-Frame-Options: GOFORIT");

#Récupération spécifique des variables de configuration en raison de l'utilisation de l'iframe
$t_max_files = UploadFilePlugin::plugin_config_get_iframe('max_files');
$t_max_file_size = UploadFilePlugin::plugin_config_get_iframe('max_file_size');
$t_extensions_allowed = UploadFilePlugin::plugin_config_get_iframe('allowed_extensions');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> <?php echo plugin_lang_get( 'iframe_title' ,'uploadfile'); ?></title>

        <!-- Javascript Ressources -->
        <?php #@ToDO: Voir si on peut récupérer l'url de jquery par une fonction mantis ?>
        <script src="../../jQuery/files/jquery-min.js"></script>
        <script src="js/jquery.filedrop.js"></script>

        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" type="text/css" href="css/upload.css"/>

        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Javascript de gestion d'upload -->
        <script type="text/javascript">
            //Traductions des messages d'upload
            var BrowserNotSupportedMsg = '<?php echo plugin_lang_get('browser_not_supported_msg' ,'uploadfile'); ?>';
            var TooManyFilesMsg = '<?php echo sprintf( plugin_lang_get('too_many_files_msg' ,'uploadfile') , $t_max_files ) ; ?>';
            var FileTooLargeMsg = '<?php echo sprintf( plugin_lang_get('file_too_large_msg' ,'uploadfile') , $t_max_file_size ); ?>';
            var FileExtensionNotAllowedMsg = '<?php echo plugin_lang_get('file_extension_not_allowed_msg' ,'uploadfile'); ?>';
            var FileUploadSuccessMsg = '<?php echo plugin_lang_get('file_upload_success_msg' ,'uploadfile'); ?>'; 
            
            //Variables de configuration des upload
            var FilesMaxNumber = <?php echo $t_max_files ?>;
            var MaxFileSize = <?php echo $t_max_file_size; ?>;
            var FilesAllowedExtensions = <?php echo json_encode(explode(',',$t_extensions_allowed));?>;
        </script>
        <script src="js/jquery.fileUploader_init.js"></script>
    </head>
 
    <body>
        <input type="hidden" name="bug_id" id="bug_value" value="<?php echo gpc_get_int('bug_id'); ?>" />
        <div id="dropbox">
            <span class="message"><?php echo plugin_lang_get( 'drop_attachments_here' , 'uploadfile'); ?><br />
                <i>(<?php echo sprintf( plugin_lang_get( 'max_files_number','uploadfile'), $t_max_files ); ?> , <?php echo sprintf( plugin_lang_get( 'max_files_size','uploadfile') , $t_max_file_size ); ?>)</i>
            </span>
        </div>
    </body>
</html>