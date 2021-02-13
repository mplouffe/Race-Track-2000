const path = require('path');
const http = require('http');
const express = require('express');
const bodyParser = require('body-parser');

const users = [];

const publicPath = path.join(__dirname, '../../racetrack-2000/dist');
const port = process.env.PORT || 3000;

const app = express();

app.use(express.static(publicPath));
app.use(bodyParser.json());

app.get('/api/users', (req, res) => {
    console.log('api/users called!');
    res.json(users);
});

app.post('/api/user', (req, res) => {
    const user = req.body.user;
    console.log('Adding user:::', user);
    users.push(user);
    res.json("user added");
});

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, '../../racetrack-2000/dist/index.html'));
});

const server = http.createServer(app);
server.listen(port, (err) => {
    console.log(`RaceTrack 2000 is up on localhost:${port}`);
});