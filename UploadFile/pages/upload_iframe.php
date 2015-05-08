<?php
/**
  Plugin FileUploader pour Mantis BugTracker :

  - Envoi de fichiers multiples dans les bugs

  - Pour ce projet j'ai utilisé les librairies suivantes :

  - Jquery-FileDrop : https://github.com/weixiyen/jquery-filedrop
  - Le tutoriel suivant : http://tutorialzine.com/2011/09/html5-file-upload-jquery-php/
  - Le script d'upload https://github.com/mantisbt-plugins/PastePicture/blob/master/PastePicture/pages/bug_file_add.php

  Version 0.1.0
  © Hennes Hervé - 2014
  http://www.h-hennes.fr
 */
# Comme ce fichier est en iframe nous ne pouvons pas utiliser les fonctions mantis ( cause une erreur  Load denied by X-Frame-Options dans Firefox )
#@ToDO : Gérer des traductions
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Multi-upload mantisbt</title>

        <!-- Javascript Ressources-->
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/jquery.filedrop.js"></script>

        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" type="text/css" href="css/upload.css"/>

        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Javascript de gestion d'upload -->
        <script src="js/jquery.fileUploader_init.js"></script>
    </head>

    <body>
        <input type="hidden" name="bug_id" id="bug_value" value="<?php echo intval($_GET['bug_id']); ?>" />
        <div id="dropbox">
            <span class="message">Déposer vos pièces jointes ici <br /><i>(Maximum 5 pièces jointes , 5 mo par fichier maximum)</i></span>
        </div>
    </body>
</html>