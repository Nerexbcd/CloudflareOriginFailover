const server         = require("http").createServer();
const { Server }     = require("socket.io");
const { instrument } = require("@socket.io/admin-ui");

// Service Start Message
console.log('\nCloudflare Origin Failover Communication Server');
console.log('github.com/Nerexbcd/CloudflareOriginFailover');
console.log('Project by Nerexbcd\n');



// ------------ Prepare Configs ------------ //
const config = require('./config')();

// ------------ Prepare Socket.IO Server with CORS ------------ //
const io = new Server(server, {
  cors: {
    origin: config.cors,
    credentials: true
  }
});

// ------------ Prepare and Start Metrics Server ------------ //
const MetricServer = require('./src/MetricsServer');
const metric = new MetricServer();
metric.start();

// ------------ Prepare and Connect to Database ------------ //
const DataBase = require('./src/Database');
const { exit } = require("process");
const db = new DataBase();
// db.connect();

// Reset currently running nodes
// db.resetNodes();

// ------------ Define NameSpaces ------------ //
// require('./src/Namespaces/remoteTester')(io,metric.namespaceEvents,db.namespaces.nodes);
//require('./src/Namespaces/web')(io,metric.namespaceEvents,db);

// Refuse Main NameSpace Connections
io.use((socket, next) => {
  return next(new Error("Not Authorized"));
});

// ------------ Config for Admin UI ------------ //
 instrument(io, {
  auth: {
    type: "basic",
    username: config.webUi_username,
    password: config.webUi_password // "changeit" encrypted with bcrypt
  },
  readonly: config.webUi_readonly,
  mode: config.webUi_mode,
}); 

// ------------ Start the Server ------------ //
server.listen(3000, () => {
  console.log('socket.io Server listening on *:3000\n');
});





// Proxy Server Tests

// var http = require('http'),
// httpProxy = require('http-proxy')

// http.createServer(function(req, res) {
//   console.log(req.url)
// }).listen(80);

// // Set up proxy rules instance
// var proxyRules = new HttpProxyRules({
// rules: {
// '.*/test': 'http://localhost:8080/cool', // Rule (1)
// '.*/test2/': 'http://localhost:8080/cool2/', // Rule (2)
// '/posts/([0-9]+)/comments/([0-9]+)': 'http://localhost:8080/p/$1/c/$2', // Rule (3)
// '/author/([0-9]+)/posts/([0-9]+)/': 'http://localhost:8080/a/$1/p/$2/' // Rule (4)
// },
// default: 'http://localhost:8080' // default target
// });

// // Create reverse proxy instance
// var proxy = httpProxy.createProxy();

// // Create http server that leverages reverse proxy instance
// // and proxy rules to proxy requests to different targets
// http.createServer(function(req, res) {

// // a match method is exposed on the proxy rules instance
// // to test a request to see if it matches against one of the specified rules
// var target = proxyRules.match(req);
// if (target) {
// return proxy.web(req, res, {
//   target: target
// });
// }

// res.writeHead(500, { 'Content-Type': 'text/plain' });
// res.end('The request url and path did not match any of the listed rules!');
// }).listen(6010);