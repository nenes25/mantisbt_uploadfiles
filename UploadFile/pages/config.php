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

auth_reauthenticate();
access_ensure_global_level(config_get('manage_plugin_threshold'));

html_page_top(plugin_lang_get('title'));

print_manage_menu();
?>

<h2><?php echo plugin_lang_get('title');?></h2>

<form action="<?php echo plugin_page('config_edit') ?>" method="post">
    <table>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('max_files'); ?></td>
            <td><input type="text" name="max_files" size="2" value="<?php echo plugin_config_get('max_files'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('max_file_size'); ?></td>
            <td><input type="text" name="max_file_size" size="2" value="<?php echo plugin_config_get('max_file_size'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="category"><?php echo plugin_lang_get('allowed_extensions'); ?></td>
            <td><input type="text" name="allowed_extensions" size="150"value="<?php echo plugin_config_get('allowed_extensions'); ?>" /></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td colspan="2"><?php echo plugin_lang_get('allowed_extensions_description'); ?></td>
        </tr>
        <tr <?php echo helper_alternate_class() ?>>
            <td class="center" colspan="2"><input type="submit" value="<?php echo plugin_lang_get("config_action_update") ?>"/></td>
        </tr>
    </table>
</form>
