var server = require('http').Server();

var io = require('socket.io')(server);
var Redis = require('ioredis');

var redis = new Redis();

redis.subscribe('post-channel');


redis.on('message', function(channel, message){
    message = JSON.parse(message);
    io.emit(channel+":"+message.event,message.data.data);
    console.log(channel);
    console.log(message);
    //message =
});

server.listen(3000);