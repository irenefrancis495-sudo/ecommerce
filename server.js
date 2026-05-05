const http = require('http');
const fs = require('fs');
const path = require('path');

http.createServer((req, res) => {
  let filePath = path.join(__dirname, req.url);
  if (req.url === '/') {
    filePath = path.join(__dirname, 'index.html');
  }
  fs.readFile(filePath, (err, data) => {
    if (err) {
      res.writeHead(404);
      res.end('Not found');
    } else {
      res.writeHead(200, {'Content-Type': 'text/html'});
      res.end(data);
    }
  });
}).listen(8080, '127.0.0.1');

console.log('Server running at http://127.0.0.1:8080/');