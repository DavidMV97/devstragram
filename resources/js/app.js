import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
    dictDefaultMessage: "Sube aquí tu imagen",
    acceptedFiles: ".jpg,.jpeg,.png,.gif",
    maxFiles: 1,
    dictRemoveFile: "Eliminar imagen",
    addRemoveLinks: true,
    uploadMultiple: false,

    init: function () {
        if (document.querySelector('[name="imagen"]').value.trim() ) {
            const imagenPublicada = {};
            imagenPublicada.imagen = 1234; 
            imagenPublicada.name = document.querySelector('[name="imagen"]').value; 

            this.options.addedfile.call(this, imagenPublicada); 
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`); 

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete')
        }
    }

});

dropzone.on("success", function (file, response) {
    console.log('response => ', response); 
    document.querySelector('[name="imagen"]').value = response.imagen; 
});

dropzone.on("removedfile", function() {
    document.querySelector('[name="imagen"]').value = '' ; 
})


