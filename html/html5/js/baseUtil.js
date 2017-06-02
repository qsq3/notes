//一些公共函数
(function(window) {

  //动画帧兼容
  var lastTime = 0;
  var vendors = ['webkit', 'moz'];
  for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
    window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
    window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || // Webkit中此取消方法的名字变了
      window[vendors[x] + 'CancelRequestAnimationFrame'];
  }

  if (!window.requestAnimationFrame) {
    window.requestAnimationFrame = function(callback, element) {
      var currTime = new Date().getTime();
      var timeToCall = Math.max(0, 16.7 - (currTime - lastTime));
      var id = window.setTimeout(function() {
        callback(currTime + timeToCall);
      }, timeToCall);
      lastTime = currTime + timeToCall;
      return id;
    };
  }
  if (!window.cancelAnimationFrame) {
    window.cancelAnimationFrame = function(id) {
      clearTimeout(id);
    };
  };

  //动画帧兼容简单版
  // window.requestAnimationFrame = ( function() {
  //   return window.requestAnimationFrame ||
  //         window.webkitRequestAnimationFrame ||
  //         window.mozRequestAnimationFrame ||
  //         function( callback ) {
  //           window.setTimeout( callback, 1000 / 60 );
  //         };
  // })();

  //forEach兼容
  if (typeof Array.prototype.forEach != "function") {
    Array.prototype.forEach = function(fn, context) {
      for (var k = 0, length = this.length; k < length; k++) {
        if (typeof fn === "function" && Object.prototype.hasOwnProperty.call(this, k)) {
          fn.call(context, this[k], k, this);
        }
      }
    };
  }

  //some兼容
  if (typeof Array.prototype.some != "function") {
    Array.prototype.some = function(fun, thisArg) {
      'use strict';
      if (this === void 0 || this === null)
        throw new TypeError();

      var t = Object(this);
      var len = t.length >>> 0;
      if (typeof fun !== 'function')
        throw new TypeError();

      var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
      for (var i = 0; i < len; i++) {
        if (i in t && fun.call(thisArg, t[i], i, t))
          return true;
      }
      return false;
    };
  }

  //获取页面坐标
  window.getOffset = function(obj) {
    var offset = {
      left: 0,
      top: 0
    };
    while (obj != document.body && obj != document.documentElement) {
      offset.left += obj.offsetLeft;
      offset.top += obj.offsetTop;
      obj = obj.offsetParent;
    }
    return offset;
  };
  //随机颜色
  window.getRandomColor = function() {
    return "#" + (function(color) {
      return new Array(7 - color.length).join("0") + color
    })((~~(Math.random() * (1 << 24))).toString(16))
  };

  // 转换pre标签内部文本
  var o;
  function transPre() {
    $("pre").each(function(index, el) {
      $(this).text(this.innerHTML);
    });
  }
  if (typeof $ === "undefined") {
    o = document.createElement("script");
    o.src = 'js/jquery-1.12.3.js';
    document.head.appendChild(o);
    o.onload = transPre;
  } else {
    $(transPre);
  }

})(window);
