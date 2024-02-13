const express = require("express");
const http = require("http");
const { Server } = require("socket.io");

const app = express();
const server = http.createServer(app);
// Store connected users
var users = {};

const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
    },
});

io.on("connection", (socket) => {
    console.log("A user connected", socket.id);

    socket.on("user_conected", (data) => {
        users[data] = data;
        console.log(users);
        socket.emit("the_user", data);
    });


    socket.on("disconnect", () => {
        console.log("A user disconnected", socket.id);
    });

   socket.emit('message', 'Hello from server', socket.id);

    // Handle socket events here
});

server.listen(3000, () => {
    console.log("Socket server is running on port 3000");
});
