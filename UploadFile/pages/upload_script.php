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
#  FileUploader Plugin :  - Allow you to send mutiple files in bug with drag & drop
#  This plugin use the folowing librairies :
#  - Jquery-FileDrop : https://github.com/weixiyen/jquery-filedrop
#  - Le tutoriel suivant : http://tutorialzine.com/2011/09/html5-file-upload-jquery-php/
#  - Le script d'upload https://github.com/mantisbt-plugins/PastePicture/blob/master/PastePicture/pages/bug_file_add.php
#
#  © Hennes Hervé <contact@h-hennes.fr>
#    2015-2016
#  http://www.h-hennes.fr/blog/

require_once( dirname(__FILE__) . '/../../../core.php' );
require_once( dirname(__FILE__) . '/../../../core/file_api.php' );

/**
 * Get upload status error
 * @param string $str
 */
function exit_status($str) {
    echo json_encode(array('status' => $str));
    exit;
}

/**
 * Get uploaded file data
 * @param string $p_var_name : file_name
 * @param boolean $p_default
 * @return array || null
 */
function gpc_get_fileCustom($p_var_name, $p_default = null) {
    if (isset($_FILES[$p_var_name])) {
    # FILES are not escaped even if magic_quotes is ON, this applies to Windows paths.
        $t_result = $_FILES[$p_var_name];
    } else if (isset($_POST[$p_var_name])) {
        $f = $_POST[$p_var_name][0];
        $h = "data:image/png;base64,";
        if (substr($f, 0, strlen($h)) == $h) {
            $data = base64_decode(substr($f, strlen($h)));
            $fn = tempnam("/tmp", "CLPBRD");
            file_put_contents($fn, $data);
            chmod($fn, 0777);
            $t_result = array();
            $pi = pathinfo($fn);
            $t_result[0]['name'] = $pi['filename'] . ".png";
            $t_result[0]['type'] = "image/png";
            $t_result[0]['size'] = strlen($data);
            $t_result[0]['tmp_name'] = $fn;
            $t_result[0]['error'] = 0;
        }
    } else if (func_num_args() > 1) {
        # check for a default passed in (allowing null)
        $t_result = $p_default;
    } else {
        error_parameters($p_var_name);
        trigger_error(ERROR_GPC_VAR_NOT_FOUND, ERROR);
    }
    return $t_result;
}

$f_bug_id = gpc_get_int('bug_id', -1);
$f_files = gpc_get_fileCustom('pic', -1);

if ($f_bug_id == -1 && $f_files == -1) {
# _POST/_FILES does not seem to get populated if you exceed size limit so check if bug_id is -1
    trigger_error(ERROR_FILE_TOO_BIG, ERROR);
}
$t_bug = bug_get($f_bug_id, true);
if (!file_allow_bug_upload($f_bug_id)) {
    access_denied();
}
access_ensure_bug_level(config_get('upload_bug_file_threshold'), $f_bug_id);
file_add($f_bug_id, $f_files, 'bug', '', '', 1);

#Success message
exit_status(plugin_lang_get('file_was_uploaded_successfuly'));
?>