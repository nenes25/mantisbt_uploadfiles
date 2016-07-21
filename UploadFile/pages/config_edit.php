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
