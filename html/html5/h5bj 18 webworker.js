//importScripts('./js/jquery-1.12.3.js'); //可引入其他JS文件

self.onmessage = function(e){ //监听 postMessage 事件
  var copyData = e.data.copyData,
      newData = e.data.newData,
      n = e.data.n;
  for(var i=0; i<copyData.height;i+=n){
    for(var j=0; j<copyData.width;j+=n){
      var color = getData(copyData,j+Math.floor(Math.random()*n),i+Math.floor(Math.random()*n));
      for(var k=0; k<n;k++){
        for(var l=0; l<n;l++){
          setData(newData,j+l,i+k,color);
        }
      }
    }
  };

  self.postMessage(newData);  //发送数据

  self.close();  //关闭worker
};

//像素获取, 4个值为一组, r g b a;
function getData(obj,x,y){//一行一列来获取具体某个坐标点的像素值
  var w = obj.width;
  var d = obj.data;
  var color = [];
  color[0] = d[4*(w*y+x)];
  color[1] = d[4*(w*y+x)+1];
  color[2] = d[4*(w*y+x)+2];
  color[3] = d[4*(w*y+x)+3];
  return color;
}

//像素处理, 4个值为一组
function setData(obj,x,y,color){
  var w = obj.width;
  var d = obj.data;
  d[4*(w*y+x)] = color[0];
  d[4*(w*y+x)+1] = color[1];
  d[4*(w*y+x)+2] = color[2];
  d[4*(w*y+x)+3] = color[3];
};


