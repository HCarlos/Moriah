/// image 1


function changeProfile2() {
    $('#image2').click();
}
$('#image2').change(function () {
    var imgPath = this.value;
    var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
        readURL(this);
    else
        alert("selecciona archivos (jpg, jpeg, png).")
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload = function (e) {
            $('#preview2').attr('src', e.target.result);
//              $("#remove").val(0);
        };
    }
}
function removeImage() {
    $('#preview').attr('src', '../public/assets/img/no-image.jpg');
//      $("#remove").val(1);
}



/// image 2

function changeProfile() {
    $('#image').click();
}
$('#image').change(function () {
    var imgPath = this.value;
    var ext = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    if (ext == "gif" || ext == "png" || ext == "jpg" || ext == "jpeg")
        readURL2(this);
    else
        alert("selecciona archivos (jpg, jpeg, png).")
});


function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.readAsDataURL(input.files[0]);
        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
//              $("#remove").val(0);
        };
    }
}