const http = require('http');

const server = http.createServer((req, res) => {
    res.setHeader('Content-Type', 'text/html')
    res.writeHead(200)
    res.end('<i>Hello, world!</i>')
})

server.listen(8082, '0.0.0.0', () => {
    console.log('Server is running')
})