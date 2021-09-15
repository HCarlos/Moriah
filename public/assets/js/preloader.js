$(document).ready(function() {
    document.getElementById("cargando").style = "display:none";
    // $('#cargando').prop('display',none);
    $('.subirimagen').on('click',function() {
        document.getElementById("cargando").style = "display:block";
        document.getElementById("subirimagen").style = "display:none";
    });
});
