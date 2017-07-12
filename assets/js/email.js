var $eContainer = $("#compose_email_container"),
    $eHeader = $("#compose_header"),
    $eBody = $("#compose_body"),
    $eForm = $("#email_form"),
    $ePengirim = $("#pengirim_email"),
    $ePenerima = $("#penerima_email"),
    $eSend = $("#send_email"),
    $pampele = $("#pampele"),
    $errors = $("#errors");

$(document).ready(function(){
    $ePenerima.on("beforeItemAdd",function(ev){
        if(!valid_email(ev.item)){
            ev.cancel = true;
        }
    });
    $eHeader.on("click",function(){
        $.getJSON(BASE_URL + "/ajax/cek_konfig_email/",function(res){
            if(!res.status) {
                konfig_email();
            } else {
                prepare_form(res.data);
            }
        });
    });
    $eSend.on("click",function(){
        var data = $eForm.serialize();
        if(cek_isi(data)) {
            $errors.hide();
            kirim_email();
        } else {
            $errors.show();
        }
    });
});

function kirim_email() {
    $pampele.show();
    var data = $eForm.serialize();
    $.post(BASE_URL + "/ajax/kirim_email/",data,function(res){
        console.log(res);
        $pampele.hide();
    });
}

function prepare_form(session) {
    console.log(session);
    $eContainer.toggleClass("tutup");
    $ePengirim.val(session.email + ((session.tipe == "gmail") ? " (Google Mail)" : " (Yahoo Mail)"));
}

function konfig_email() {
    swal({
        title: "Konfig Email",
        text: "Konfigurasi email anda untuk sesi login ini" +
        "<form action='' method='POST' id='form_email_popup'>" +
        "   <b>&raquo; Email</b>" +
        "   <input type='text' name='email' value='' id='email_input'>" +
        "   <b>&raquo; Tipe Email</b>" +
        "   <select name='tipe' id='email_opt' disabled>" +
        "       <option value=''></option>" +
        "       <option value='gmail'>Google Mail</option>" +
        "       <option value='yahoomail'>Yahoo Mail</option>" +
        "   </select>" +
        "   <b>&raquo; Password</b>" +
        "   <input type='password' name='password'>" +
        "   <input type='hidden' name='tipe' id='email_value'>" +
        "</form>",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        html: true
    },function(confirm){
        if(confirm) {
            var data = $("#form_email_popup").serialize();
            if(!cek_isi(data)) {
                swal.showInputError("Isi semua field");
                return false;
            }
            $.post(BASE_URL + "/ajax/config_email",data,function(res){
                if(res.status == true) {
                    swal({
                        title: "Sukses",
                        text: "Email terkonfigurasi",
                        type: "success"
                    },function(){
                        prepare_form(res.data);
                    });
                } else {
                    swal("Error","Server error","error");
                }
            });
            swal("Sukses!","Email terkonfigurasi!","success");
        }
    });
    $("#email_input").on("keyup change blur",function(){
        var val = $(this).val(),
            $eOpt = $("#email_opt"),
            $eVal = $("#email_value");

        if(valid_email(val)) {
            var end = val.split("@")[val.split("@").length - 1];
            if(end.endsWith("gmail.com") || end.endsWith("gmail.co.id")) {
                console.log("gmail");
                $eOpt.val("gmail");
                $eVal.val("gmail");
            } else if(
                end.endsWith("yahoo.com") || end.endsWith("yahoo.co.id") ||
                end.endsWith("ymail.com") || end.endsWith("ymail.co.id") ||
                end.endsWith("rocketmail.com") || end.endsWith("rocketmail.co.id")
            ) {
                console.log("yahoomail");
                $eOpt.val("yahoomail");
                $eVal.val("yahoomail");
            } else {
                console.log("undefined");
                $eOpt.val("");
                $eVal.val("");
            }
        } else {
            $eOpt.val("");
            $eVal.val("");
        }

    });
}

function valid_email(emailAddress) {
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(emailAddress);
}

function cek_isi(qs) {
    var items = qs.split("&");
    var ret = true;
    console.log(qs);
    for(var i =0; i < items.length; i++) {
        var item = items[i];
        if(item.split("=")[item.split("=").length - 1] == "") {
            ret = false;
            break;
        }
    }
    return ret;
}