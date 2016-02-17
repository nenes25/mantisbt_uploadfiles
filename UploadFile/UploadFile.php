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
        $this->page = 'config.php';
        $this->version = '0.2.2';
        $this->requires = array(
            'MantisCore' => '1.2.0',
            'jQuery' => '1.11'
        );
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
     * Configuration par défaut du module
     * @return array
     */
    function config() {
        
        return array(
            'max_files' => 5,
            'max_file_size' => 5,
            'allowed_extensions' => ".jpg,.jpeg,.png,.gif,.csv,.doc,.docx,.xls,.xlsx,.txt,.zip,.ppt,.pptx,.pdf,.psd,.html",
            );
    }

    /**
     * Affichage du code dans la page de visualisation d'un bug
     * Placement dans le DOM via jquery
     */
    function uploadFileBugDetails() {
                
        #Déplacement du code d'upload dans le DOM
        echo '<script type="text/javascript">
                jQuery(document).ready(function($){
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
    
    /**
     * Dans la page iframe la fonction plugin_config_get ne fonctionne pas
     * Retour statique de cette variable pour l'iframe
     * @param string Configuration option name
     */
    public static function plugin_config_get_iframe($p_option){
        return config_get( 'plugin_UploadFile_'.$p_option, null, null, null );
    }
}

?>