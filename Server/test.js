var http = require('http')
// httpProxy = require('http-proxy')

http.createServer(function(req, res) {
  console.log(req.headers.host)
  res.writeHead(200, {'Content-Type': 'text/plain'});
  res.end('Hello World\n');
}).listen(9870);