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
        $this->version = '0.3.0';
        $this->requires = array(
            'MantisCore' => '1.3.0',
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
        
        #Load css and Js
        echo '<link rel="stylesheet" type="text/css" href="'.plugin_file('css/upload.css').'" />
              <script type="text/javascript" src="'.plugin_file('js/jquery.filedrop.js').'"></script>
              <script type="text/javascript" src="'.plugin_file('js/jquery.fileUploader_init.js').'"></script>    
              ';
                
       #Translation vars
       echo '<input type="hidden" name="BrowserNotSupportedMsg" id="BrowserNotSupportedMsg" value="'.$this->cleanJsTranslation(plugin_lang_get('browser_not_supported_msg','uploadfile')).'" />';
       echo '<input type="hidden" id="TooManyFilesMsg" value="'.$this->cleanJsTranslation(plugin_lang_get('too_many_files_msg','uploadfile')).'" />';
       echo '<input type="hidden" id="FileTooLargeMsg" value="'.$this->cleanJsTranslation(plugin_lang_get('file_too_large_msg','uploadfile')).'" />';
       echo '<input type="hidden" id="FileExtensionNotAllowedMsg" value="'.$this->cleanJsTranslation(plugin_lang_get('file_extension_not_allowed_msg','uploadfile')).'" />';
       echo '<input type="hidden" id="FileUploadSuccessMsg" value="'.$this->cleanJsTranslation(plugin_lang_get('file_upload_success_msg','uploadfile')).'" />';
       echo '<input type="hidden" id="FilesMaxNumber" value="'.plugin_config_get('max_files').'" />';
       echo '<input type="hidden" id="MaxFileSize" value="'.plugin_config_get('max_file_size').'" />';
       echo '<input type="hidden" id="FileUploadSuccessMsg" value="'.json_encode(explode(',',plugin_config_get('allowed_extensions'))).'" />';
       
        #Upload Code
        echo '<div id="upload_form_multi">
                <div id="multiple_upload_area">
                <input type="hidden" name="bug_id" id="bug_value" value="'.gpc_get_int('id').'" />
                <div id="dropbox">
                    <span class="message">'.plugin_lang_get( 'drop_attachments_here' , 'uploadfile').'<br />
                        <i>('.sprintf( plugin_lang_get( 'max_files_number','uploadfile'), plugin_config_get('max_files') ).' , '.sprintf( plugin_lang_get( 'max_files_size','uploadfile') , plugin_config_get('max_file_size') ).')</i>
                    </span>
                </div>
                </div>
	      </div>';
    }
    
    #Clean js translations
    public function cleanJsTranslation($input) {
            $input = str_replace("'","\'",$input);
            return $input;
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