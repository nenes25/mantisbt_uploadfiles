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

require_once( dirname(__FILE__) . '/../../../core.php' );
require_once( dirname(__FILE__) . '/../../../core/file_api.php' );

/**
 * Renvoi du statut de l'erreur d'upload
 * @param type $str
 */
function exit_status($str) {
    echo json_encode(array('status' => $str));
    exit;
}

/**
 * Récupération des données du fichier envoyé
 * c
 * @param type $p_var_name
 * @param type $p_default
 * @return type
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

#Message de succès d'envoi
exit_status(plugin_lang_get('file_was_uploaded_successfuly'));
?>