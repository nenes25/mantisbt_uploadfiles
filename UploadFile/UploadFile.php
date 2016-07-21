<?php
# MantisBT - A PHP based bugtracking system
# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

#
#  FileUploader Plugin :  - Allow you to send mutiple file in bug with drag & drop
#  This plugin use the folowing librairies :
#  - Jquery-FileDrop : https://github.com/weixiyen/jquery-filedrop
#  - Le tutoriel suivant : http://tutorialzine.com/2011/09/html5-file-upload-jquery-php/
#  - Le script d'upload https://github.com/mantisbt-plugins/PastePicture/blob/master/PastePicture/pages/bug_file_add.php
#
#  © Hennes Hervé <contact@h-hennes.fr>
#    2015-2016
#  http://www.h-hennes.fr/blog/

require_once( config_get('class_path') . 'MantisPlugin.class.php' );

class UploadFilePlugin extends MantisPlugin {

    /**
     * Module register
     */
    function register() {
        $this->name = lang_get( 'plugin_uploadfile_title' );
        $this->description = lang_get( 'plugin_uploadfile_description' );
        $this->page = 'config.php';
        $this->version = '0.2.3';
        $this->requires = array(
            'MantisCore' => '1.2.0',
            'jQuery' => '1.11'
        );
        $this->author = 'Hennes Hervé';
        $this->url = 'http://www.h-hennes.fr/blog/';
    
    }

    /**
     * Module init on hooks
     */
    function init() {
        plugin_event_hook('EVENT_VIEW_BUG_DETAILS', 'uploadFileBugDetails');
    }
    
    /**
     * Default module configuration
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
	 * Code display in bug page
     * Done in the DOM with Jquery
     */
    function uploadFileBugDetails() {
                
        #Move upload code in DOM
        echo '<script type="text/javascript">
                jQuery(document).ready(function($){
                    $("#upload_form_open").after($("#upload_form_multi").html());
                });
              </script>';

        #Upload Code ( Iframe with html5 page )
        echo '<div id="upload_form_multi" style="display:none">
                <div id="multiple_upload_area" style="margin-top:20px;">
                  <iframe src="plugins/UploadFile/pages/upload_iframe.php?bug_id=' . gpc_get_int('id', -1) . '" id="uploadPage" width="100%" scrolling="no" height="200px;" frameborder="0"></iframe>
                </div>
	      </div>';
    }
    
    /**
     * Specific function to get module configuration in iframe
     * @param string Configuration option name
     */
    public static function plugin_config_get_iframe($p_option){
        return config_get( 'plugin_UploadFile_'.$p_option, null, null, null );
    }
}

?>