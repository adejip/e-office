var app = require("express")();
var server = require("http").Server(app);
var io = require("socket.io")(server);
var bodyParser = require("body-parser");


var webPort = process.env.PORT || 8080;
var socketPort = 7008;

server.listen(socketPort);

var clients = [];

app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());


app.get("/",function(req,res){
	res.send("Siap tempur!");
	io.emit("notif",req.query);
	console.log(req.query);
});

app.post("/kirimNotif",function(req,res){
	console.log(req.body);
	var id_pengguna = req.body.id_pengguna;
	delete(req.body.id_pengguna);

	clients.forEach(function(item,index){
		if(item.id_pengguna == id_pengguna)
			if(io.sockets.connected[item.clientId])
				io.sockets.connected[item.clientId].emit("notifBaru",req.body);
	});

	res.send("OK");
});

io.on("connection",function(socket){
	var clientId = socket.id;


	socket.on("join",function(id_pengguna){
        clients.push({
			id_pengguna: id_pengguna,
			clientId: clientId
		});
        console.log("Client terhubung dengan ID : " + clientId);
        console.log("Jumlah client : " + clients.length);
	});

	socket.on("leave",function(){
		clients.forEach(function(item,index){
			if(item.clientId == clientId)
				clients.splice(index,1);
		});
		console.log("Client dengan ID : " + clientId + " terputus");
		console.log("Jumlah client : " + clients.length);
	});

});



app.listen(webPort);

console.log("e-Office ready..");
