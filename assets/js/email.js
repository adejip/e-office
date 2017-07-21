var $eContainer = $("#compose_email_container"),
    $eHeader = $("#compose_header"),
    $eForm = $("#email_form"),
    $ePengirim = $("#pengirim_email"),
    $ePenerima = $("#penerima_email"),
    $eSubjek = $("#subjek_email")
    $eIsi = $("#isi_email"),
    $eSend = $("#send_email"),
    $eChange = $("#change_email"),
    $pampele = $("#pampele"),
    $errorsContainer = $("#errors"),
    $errorsMsg = $("#errors_msg");

$(document).ready(function () {

    $eIsi.froalaEditor({
        height: 300,
        toolbarSticky: false
    });

    $ePenerima.on("beforeItemAdd", function (ev) {
        if (!valid_email(ev.item)) {
            ev.cancel = true;
        }
    });
    $eHeader.on("click", function () {
        $pampele.show();
        $.getJSON(BASE_URL + "/email/gmail_cek_user/", function (res) {
            if (!res.status) {
                konfig_email();
            } else {
                prepare_form(res.data.email);
            }
            $pampele.hide();
        });
    });
    $eSend.on("click", function () {
        var data = $eForm.serialize();
        console.log(data);
        if (cek_isi(data)) {
            $errorsContainer.hide();
            kirim_email(data);
        } else {
            $errorsMsg.text("Isi semua field");
            $errorsContainer.show();
        }
    });
    $eChange.on("click", function (ev) {
        konfig_email();
        ev.preventDefault();
    });

    var emailLoggedIn = getUrlParameter("emailLoggedIn");

    if(emailLoggedIn){
        swal({
            type: "success",
            title: "Login Berhasil",
            text: "Berhasil login dengan akun gmail : " + emailLoggedIn
        },function(){
            prepare_form(emailLoggedIn);
        });
    }

});

function kirim_email(data) {
    $errorsContainer.hide();
    $pampele.show();
    $.post(BASE_URL + "/email/gmail_send/", data, function (res) {
        if(res.status != true){
            $errorsMsg.text(res.errors[0]);
            $errorsContainer.show();
        } else {
            swal("Sukses","Email terkirim","success");
            clear_form();
        }
        $pampele.hide();
    });
}

function prepare_form(email) {
    $eContainer.toggleClass("tutup");
    $ePengirim.val(email);
}

function konfig_email() {
    swal({
        title: "Masuk dengan akun",
        text: "<a href='" + BASE_URL + "/email/gmail_sign_in?return=" + window.location.href + "' class='google-btn'><img src='" + BASE_URL + "/assets/images/google_logo.svg'/>Google Mail</a>",
        showCancelButton: true,
        showConfirmButton: false,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        html: true
    });
}
function valid_email(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function cek_isi(serial) {
    var pieces = serial.split("&");
    if (pieces.length == 3) {
        for (var i = 0; i < pieces.length; i++) {
            var item = pieces[i].split("=");
            if (item[1] == "")
                return false;
        }
        return true;
    } else {
        return false;
    }
}

function clear_form() {
    $ePenerima.tagsinput("removeAll");
    $eIsi.froalaEditor("html.set","");
    $eSubjek.val("");
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};