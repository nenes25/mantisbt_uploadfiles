<?php
/*
  Plugin EmailFile pour Mantis BugTracker :

  - Rajouts de pièces jointes à un bug via email

  Version 0.1.0
  © Hennes Hervé - 2014
  http://www.h-hennes.fr
 */

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
