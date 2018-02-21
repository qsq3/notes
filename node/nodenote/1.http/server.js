const http = require('http'); //http 模块
const url = require('url');   //url  模块
const querystring = require('querystring');   //querystring  模块

const hostname = '127.0.0.1';
const port = 3000;
const add = require('./modules/add.js') // 自定义模块


// http://127.0.0.1:3000/?a=1&b=3
const server = http.createServer((req, res) => {
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/plain; charset=utf-8');
  var arg = url.parse(req.url, true).query;  // arg => { a: '001', b: '002' }
  let str = '无参数'
  if(arg.a && arg.b){
    str = add(arg.a, arg.b)
  }
  res.write(`Hello World\n`)
  res.write(`${str} \n`)
  res.write(`${querystring.stringify(arg)} \n`)
  res.end(`END`);
});

server.listen(port, hostname, () => {
  console.log(`Server running at http://${hostname}:${port}/`);
});