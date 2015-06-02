<?php
/*
  Plugin FileUploader pour Mantis BugTracker :

  - Envoi de fichiers multiples dans les bugs en drag & drop

  Pour ce projet j'ai utilisé les librairies suivantes :

  - Jquery-FileDrop : https://github.com/weixiyen/jquery-filedrop
  - Le tutoriel suivant : http://tutorialzine.com/2011/09/html5-file-upload-jquery-php/
  - Le script d'upload https://github.com/mantisbt-plugins/PastePicture/blob/master/PastePicture/pages/bug_file_add.php

  © Hennes Hervé - 2015
  http://www.h-hennes.fr
 */
require_once( config_get('class_path') . 'MantisPlugin.class.php' );

class UploadFilePlugin extends MantisPlugin {

    /**
     * Enregistrement du module
     */
    function register() {
        $this->name = lang_get( 'plugin_uploadfile_title' );
        $this->description = lang_get( 'plugin_uploadfile_description' );
        $this->version = '0.1.1';
        $this->requires = array('MantisCore' => '1.2.0',);
        $this->author = 'Hennes Hervé';
        $this->url = 'http://www.h-hennes.fr';
    
    }

    /**
     * Initialisation du module
     */
    function init() {
        plugin_event_hook('EVENT_VIEW_BUG_DETAILS', 'uploadFileBugDetails');
    }

    /**
     * Affichage du code dans la page de visualisation d'un bug
     * Placement dans le DOM via jquery
     */
    function uploadFileBugDetails() {

        #Insertion librairie jquery
        echo '<script type="text/javascript" src="plugins/UploadFile/pages/js/jquery-1.9.1.min.js"></script>';

        #Déplacement du code d'upload dans le DOM
        echo '<script type="text/javascript">
			$(function(){
                            $("#upload_form_open").after($("#upload_form_multi").html());
			});
			</script>';

        #Code qui va servir à l'upload ( Iframe avec une page html5 )
        echo '<div id="upload_form_multi" style="display:none">
                <div id="multiple_upload_area" style="margin-top:20px;">
                  <iframe src="plugins/UploadFile/pages/upload_iframe.php?bug_id=' . gpc_get_int('id', -1) . '" id="uploadPage" width="100%" scrolling="no" height="200px;" frameborder="0"></iframe>
                </div>
	      </div>';
    }

}

?>