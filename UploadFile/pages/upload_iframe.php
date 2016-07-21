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

require_once( dirname(__FILE__) . '/../../../core.php' );
#Span to allow iframe display
header("X-Frame-Options: GOFORIT");

#Specific code to get plugin var due to iframe
$t_max_files = UploadFilePlugin::plugin_config_get_iframe('max_files');
$t_max_file_size = UploadFilePlugin::plugin_config_get_iframe('max_file_size');
$t_extensions_allowed = UploadFilePlugin::plugin_config_get_iframe('allowed_extensions');

#Clean js translations
function cleanJsTranslation($input) {
	$input = str_replace("'","\'",$input);
	return $input;
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> <?php echo plugin_lang_get( 'iframe_title' ,'uploadfile'); ?></title>

        <!-- Javascript Ressources -->
        <?php #@ToDO: use mantis jquery ?>
        <script src="../../jQuery/files/jquery-min.js"></script>
        <script src="js/jquery.filedrop.js"></script>

        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" type="text/css" href="css/upload.css"/>

        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Upload management -->
        <script type="text/javascript">
            //Upload messages translations
            var BrowserNotSupportedMsg = '<?php echo cleanJsTranslation(plugin_lang_get('browser_not_supported_msg' ,'uploadfile')); ?>';
            var TooManyFilesMsg = '<?php echo cleanJsTranslation(sprintf( plugin_lang_get('too_many_files_msg' ,'uploadfile') , $t_max_files )) ; ?>';
            var FileTooLargeMsg = '<?php echo cleanJsTranslation(sprintf( plugin_lang_get('file_too_large_msg' ,'uploadfile') , $t_max_file_size )); ?>';
            var FileExtensionNotAllowedMsg = '<?php echo cleanJsTranslation(plugin_lang_get('file_extension_not_allowed_msg' ,'uploadfile')); ?>';
            var FileUploadSuccessMsg = '<?php echo cleanJsTranslation(plugin_lang_get('file_upload_success_msg' ,'uploadfile')); ?>'; 
            
            //Upload configuration vars
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