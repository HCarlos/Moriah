
$(document).ready(function() {
    //Datemask dd/mm/yyyy
    $('#fecha_nacimiento').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //initialize
    $('[data-mask]').inputmask()

});
