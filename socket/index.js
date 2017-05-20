var app = require("express")();
var server = require("http").Server(app);
var io = require("socket.io")(server);
var bodyParser = require("body-parser");


var webPort = process.env.PORT || 8080;
var socketPort = 7008;

server.listen(socketPort);

var clients = {};

app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());


app.get("/",function(req,res){
	res.send("Siap tempur!");
	io.emit("notif",req.query);
	console.log(req.query);
});

app.post("/notif_surat_baru",function(req,res){
	var id_pengguna = req.body.id_pengguna;
	delete(req.body.id_pengguna);
	if(io.sockets.connected[clients["id_"+id_pengguna]])
		io.sockets.connected[clients["id_"+id_pengguna]].emit("surat_baru",req.body);
	res.send("OK");
});

io.on("connection",function(socket){
	var clientId = socket.id;

	socket.on("join",function(id_pengguna){
        clients["id_"+id_pengguna] = clientId;
        console.log("Client terhubung dengan ID : " + clientId);
        console.log("Jumlah client : " + Object.size(clients));
        console.log(clients);
	});

	socket.on("leave",function(id_pengguna){
		delete(clients["id_"+id_pengguna]);
		console.log("Client dengan ID : " + clientId + " terputus");
		console.log("Jumlah client : " + Object.size(clients));
		console.log(clients);
	});

});


app.listen(webPort);

console.log("e-Office socket server siap tempur di web port " + webPort + " dan socket port " + socketPort);

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
}