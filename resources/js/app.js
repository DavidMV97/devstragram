import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
    dictDefaultMessage: "Sube aquí tu imagen",
    acceptedFiles: ".jpg,.jpeg,.png,.gif",
    maxFiles: 1,
    dictRemoveFile: "Eliminar imagen",
    addRemoveLinks: true,
    uploadMultiple: false,
});

dropzone.on("sending", function (file, xhr, formData) {
    console.log("Enviando archivo:", file); 
});
