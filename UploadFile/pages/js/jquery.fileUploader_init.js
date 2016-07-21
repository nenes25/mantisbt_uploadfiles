/*
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
 */
$(function () {

    var dropbox = $('#dropbox'),
            message = $('.message', dropbox);

    //Get bug identifier
    var bug_id = $('#bug_value').val();

    dropbox.filedrop({
        paramname: 'pic',
        maxfiles: FilesMaxNumber,
        maxfilesize: MaxFileSize, // in mb
        url: 'upload_script.php?bug_id=' + bug_id,
        //End of upload
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
        
        //thumb creation
        uploadStarted: function (i, file, len) {
            createImage(file);
        },
        //Progress Bar update
        progressUpdated: function (i, file, progress) {
            $.data(file).find('.progress').width(progress);
        },
        //Après l'upload de toutes les images on raffraichis la page pour que les pièces jointes soient bien affichées
        afterAll: function () {
            alert(FileUploadSuccessMsg);
            parent.location.href = parent.location.href;
        }

    });

    //Image display model
    var template = '<div class="preview">' +
            '<span class="imageHolder">' +
            '<img />' +
            '<span class="uploaded"></span>' +
            '</span>' +
            '<div class="progressHolder">' +
            '<div class="progress"></div>' +
            '</div>' +
            '</div>';


	/**
	 * Create Image thumb
	 * @var string file : uploaded file
	 */
    function createImage(file) {
        var preview = $(template),
                image = $('img', preview);

        var reader = new FileReader();

        image.width = 100;
        image.height = 100;

        reader.onload = function (e) {

            //If the file is not an image, display standard icon
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