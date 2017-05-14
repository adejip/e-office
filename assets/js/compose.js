$(document).ready(function(){


    $("#external_wrap").hide();
    $("#msg").froalaEditor({
        height: 300
    });
    $(".penerima").select2();
    $("#attach").fileinput({'showUpload':false, 'previewFileType':'any'});

    $("#external").on("change",function(){
        if(this.checked){
            $("#external_wrap").slideDown();
            $("#external_wrap input").val("").prop("disabled",false);
        } else {
            $("#external_wrap").slideUp();
            $("#external_wrap input").val("").prop("disabled",true);
        }
    });

    $(".tanggal").datepicker({
        format: "yyyy-mm-dd"
    });



});