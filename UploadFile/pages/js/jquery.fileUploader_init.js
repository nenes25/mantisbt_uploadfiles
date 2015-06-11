/*
 Plugin FileUploader pour Mantis BugTracker :
 
 - Envoi de fichiers multiples dans les bugs en drag & drop
 
 Pour ce projet j'ai utilisé les librairies suivantes :
 - Jquery-FileDrop : https://github.com/weixiyen/jquery-filedrop
 
 - Le tutoriel suivant : http://tutorialzine.com/2011/09/html5-file-upload-jquery-php/
 - Le script d'upload https://github.com/mantisbt-plugins/PastePicture/blob/master/PastePicture/pages/bug_file_add.php
 
 Version 0.1.0
 © Hennes Hervé - 2014
 http://www.h-hennes.fr
 */
$(function () {

    var dropbox = $('#dropbox'),
            message = $('.message', dropbox);

    //Récupération de l'identifiant du bug
    var bug_id = $('#bug_value').val();

    //@ToDO : Permettre de configurer ces variables en BO
    dropbox.filedrop({
        // The name of the $_FILES entry:
        paramname: 'pic',
        maxfiles: FilesMaxNumber,
        maxfilesize: MaxFileSize, // in mb
        url: 'upload_script.php?bug_id=' + bug_id,
        //Fin de l'upload
        uploadFinished: function (i, file, response) {
            $.data(file).addClass('done');
        },
        error: function (err, file) {

            switch (err) {
                case 'BrowserNotSupported':
                    showMessage(BrowserNotSupportedMsg);
                    break;
                case 'TooManyFiles':
                    alert(TooManyFilesMsg);
                    break;
                case 'FileTooLarge':
                    alert(file.name + FileTooLargeMsg);
                    break;
                case 'FileExtensionNotAllowed':
                    alert(file.name + FileExtensionNotAllowedMsg)
                default:
                    break;
            }
        },
        allowedfileextensions: FilesAllowedExtensions,
        
        //Au début de l'upload création de la miniature
        uploadStarted: function (i, file, len) {
            createImage(file);
        },
        //Mise à jour de la barre de progression
        progressUpdated: function (i, file, progress) {
            $.data(file).find('.progress').width(progress);
        },
        //Après l'upload de toutes les images on raffraichis la page pour que les pièces jointes soient bien affichées
        afterAll: function () {
            alert(FileUploadSuccessMsg);
            parent.location.href = parent.location.href;
        }

    });

    //Modèle d'affichage des images
    var template = '<div class="preview">' +
            '<span class="imageHolder">' +
            '<img />' +
            '<span class="uploaded"></span>' +
            '</span>' +
            '<div class="progressHolder">' +
            '<div class="progress"></div>' +
            '</div>' +
            '</div>';


    //
    function createImage(file) {
        var preview = $(template),
                image = $('img', preview);

        var reader = new FileReader();

        image.width = 100;
        image.height = 100;

        reader.onload = function (e) {

            //Si ce n'est pas une image on affiche une icone standard
            if (!file.type.match(/^image\//)) {
                image.attr('src', 'default-file.jpg');
            }
            else {
                // e.target.result holds the DataURL which
                // can be used as a source of the image:
                image.attr('src', e.target.result);
            }
        };

        // Reading the file as a DataURL. When finished,
        // this will trigger the onload function above:
        reader.readAsDataURL(file);

        message.hide();
        preview.appendTo(dropbox);

        // Associating a preview container
        // with the file, using jQuery's $.data():

        $.data(file, preview);
    }

});