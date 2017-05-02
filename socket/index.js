var app = require("express")();
var server = require("http").Server(app);
var io = require("socket.io")(server);
var bodyParser = require("body-parser");

server.listen(7008);

var clients = [];

app.use(bodyParser.urlencoded({extended: true}));
app.use(bodyParser.json());

var port = process.env.PORT || 8080;

app.get("/",function(req,res){
	res.send("Siap tempur!");
	io.emit("notif",req.query);
	console.log(req.query);
});

io.on("connection",function(socket){
	console.log("Client terhubung dengan ID : " + socket.id);
	clients.push(socket.id);
	console.log("Jumlah client : " + clients.length);
});

io.on("disconnect",function(socket){
	console.log("Client dengan ID : " + socket.id + "terputus");
});

app.listen(port);

console.log("e-Office socket server siap tempur di port " + port);
