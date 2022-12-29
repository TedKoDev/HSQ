// 모듈 참조
const app = require('express')();
const http = require('http').createServer(app);
const io = require('socket.io')(http);


// 라우터 
app.get('/', (req, res) => {
    res.sendFile(__dirname + '/index.html');
});


app.get('/namespace1', (req, res) => {
    // console.log("namespace1에 입장 "+req.query.value);
    res.sendFile(__dirname + '/namespace1.html');
});


app.get('/namespace2', (req, res) => {
    // console.log("namespace2에 입장 "+req.query.value);
    res.sendFile(__dirname + '/namespace2.html');
});


// 네임스페이스 구분
const namespace1 = io.of('/webChatting');
const namespace2 = io.of('/namespace2');


namespace1.on('connection', (socket)=>{
    console.log("namespace1에 입장");

    let room;

    socket.on('enter', (val) => {
        room = val;
        socket.join(room);
        namespace1.to(room).emit("enter", "클라이언트가 입장하였습니다.");
    })

    socket.on('request_message', (msg) => {
        console.log("n1: "+msg);
        namespace1.to(room).emit('response_message', msg);
    });

    socket.on('disconnect', async () => {
        console.log('user disconnected');
    });
});



namespace2.on('connection', (socket)=>{
    console.log("namespace2에 입장");

    let room;

    socket.on('enter', (val) => {
        room = val;
        socket.join(room);
        namespace2.to(room).emit("enter", "클라이언트가 입장하였습니다.");
    })

    socket.on('request_message', (msg) => {
        console.log("n2: "+msg);
        namespace2.to(room).emit('response_message', msg);
    });

    socket.on('disconnect', async () => {
        console.log('user disconnected');
    });
});





// 포트 열고 대기
http.listen(3000, () => {
    console.log('Connected at 3000');
});