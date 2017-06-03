$(document).ready(function(){

    var notifCount = 0;

    var socket = io.connect(window.location.origin + ":7008");
    var alertSound = new Audio(BASE_URL + "assets/audio/incoming.mp3");

    socket.on("notifBaru",function(data){
        var itemBaru = builder(data);
        notifCount++;
        $("#notifCount").text(notifCount);

        $("title").text("(" + notifCount + ") " + data.judul);

        iziToast.show({
            title: data.judul,
            message: data.pesan,
            color: "rgba(189, 195, 199,1.0)",
            icon: "fa fa-envelope-o fa-lg",
            position: "bottomLeft",
            resetOnHover: true,
            timeout: 10000,
            buttons: [
                ['<button class="btnToast">Baca</a>',function(instance,toast){
                    window.location.href = BASE_URL + 'panel/' + data.link;
                }],
                ['<button class="btnToast">Tutup</button>',function(instance,toast){
                    instance.hide({
                        transitionOut: 'fadeOutUp',
                        onClose: function(instance, toast, closedBy){

                        }
                    }, toast, 'close', 'btn2');
                }]
            ]
        });

        $("#notifList").prepend(itemBaru);
        
        alertSound.play();

    });

    $.getJSON(BASE_URL + "ajax/ambil_data_pengguna/",function(respon){

        pengguna = respon;

        socket.emit("join",respon.data.id_pengguna);

        $(window).on("beforeunload",function(){
            socket.emit("leave");
        });

    });


    $.getJSON(BASE_URL + "ajax/ambil_pemberitahuan/",function(respon){

        var badan = "";

        respon.data.forEach(function(item,key){
            badan += builder(item,key);
        });

        notifCount = respon.belum_dibaca;

        $("#notifList").prepend(badan);

        if(notifCount > 0)
            $("#notifCount").text(notifCount);

    });



    var builder = function(item) {
        var cls = (item.dibaca == 0) ? "active" : "";
        return '<a class="'+cls+'" href="' + BASE_URL + 'panel/baca_notif/?id=' + item.id_pemberitahuan + "&rel_link=" + item.link + '" style="color: inherit;display: block"><li class="left clearfix">' +
            '		    <span class="chat-img pull-left">' +
            '			    <img src="http://placehold.it/90/30a5ff/fff/?text=' + item.judul + '" alt="" class="img-circle">' +
            '			</span>' +
            '           <div class="chat-body clearfix">' +
            '               <div class="header">' +
            '                   <strong class="primary-font">'+ item.nama_lengkap +'</strong> <small class="text-muted">'+ item.waktu +'</small>' +
            '               </div>' +
            '               <p>' + item.pesan + '</p>' +
            '           </div>' +
            '        </li></a><hr />';
    };

    $("#btnLogout").on("click",function(ev){

        ev.preventDefault();


        swal({
            title: "Anda yakin?",
            text: "Anda akan keluar dari e-Office?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, keluar!",
            cancelButtonText: "Lanjut bekerja",
            closeOnConfirm: false
        },function(ya){
            if(ya) {
                window.location.href = $("#btnLogout").prop("href");
                socket.emit("leave");
            }
        });

    });

});
