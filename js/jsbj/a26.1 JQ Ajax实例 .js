//把host写成自己的域名,然后headers里面写上需要的的session就行了,没有的话就不用写   
 
  var host = "http://";

  function getHost() {

      return host;
  }
  function amberNoheaderGet(path, succesFunc, errorFunc) {
      $.ajax({
          url: host + path,
          type: "get",
          dataType: "json",
          //添加额外的请求头
          headers: {
             
          },
          success: succesFunc,
          error: errorFunc
      });
  }

  function amberNoheaderPost(path, mdata, succesFunc, errorFunc) {
      $.ajax({
          url: host + path,
          type: "post",
          dataType: "json",
          data: mdata,
          //添加额外的请求头
          // headers: getHeader(),
          headers: {
             
          },
          success: succesFunc,
          error: errorFunc
      });
  }

  function amberNoheaderPut(path, mdata, succesFunc, errorFunc) {
      $.ajax({
          url: host + path,
          type: "put",
          dataType: "json",
          data: mdata,
            headers: {
             
          },
          success: succesFunc,
          error: errorFunc
      });
  }

  function getHeader() {
      var myuser = store.get('user');
      var obj = $.parseJSON(myuser);
      if (obj != null) {
          var openId = obj.openId;
          if (openId.length > 0) {
              return {
                  "sessionId": "uid:" + obj.openId
              }
          }
      }
  }
  

  function amberGet(path, succesFunc, errorFunc) {
      $.ajax({
          url: host + path,
          type: "get",
          dataType: "json",

          //添加额外的请求头
          headers: getHeader(),
          success: succesFunc,
          error: errorFunc

      });
     

  }


  function amberPost(path, mdata, succesFunc, errorFunc) {
      $.ajax({
          url: host + path,
          type: "post",
          dataType: "json",
          data: mdata,
          //添加额外的请求头
          headers: getHeader(),
          success: succesFunc,
          error: errorFunc
      });

  }

  function errorHandling(result) {
      var code = jQuery.parseJSON(result.responseText).code;
      switch (code) {
          case 4004:
              window.location.href = "/404";
              break;
          case 4000:
              window.location.href = "/400";
              break;
          case 4003:
              window.location.href = "/403";
              break;
          case 4001:
              window.location.href = "/401";
              break;
          case 4005:
              window.location.href = "/405";
              break;
          case 5000:
              window.location.href = "/500";
              break;
          case 5002:
              window.location.href = "/502";
              break;

      }
  }


  function amberPut(path, succesFunc, errorFunc) {
      $.ajax({
          url: host + path,
          type: "put",
          dataType: "json",
          headers: getHeader(),
          success: succesFunc,
          error: errorFunc
      });
  }

 function amberPutData(path, data,succesFunc, errorFunc) {
      $.ajax({
          url: host + path,
          type: "put",
          dataType: "json",
          data: data,
          headers: getHeader(),
          success: succesFunc,
          error: errorFunc
      });
  }
 
  //微信分享
  //发送给qq好友
  function qq(title, desc, link, imgUrl, succesFunc, errorFunc) {
      wx.onMenuShareQQ({
          title: title, // 分享标题
          desc: desc, // 分享描述
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          success: succesFunc,
          cancel: errorFunc
      });
  }

  //发送给好友
  function weixinFriend(title, desc, link, imgUrl, succesFunc, errorFunc) {
      wx.onMenuShareAppMessage({
          title: title, // 分享标题
          desc: desc, // 分享描述
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          type: '', // 分享类型,music、video或link，不填默认为link
          dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
          success: succesFunc,
          cancel: errorFunc
      });
  }

  //  //朋友圈
  function weixinQuan(title, desc, link, imgUrl, succesFunc, errorFunc) {
      // wx.hideOptionMenu();

      wx.onMenuShareTimeline({
          title: title, // 分享标题
          desc: desc, // 分享描述
          link: link, // 分享链接
          imgUrl: imgUrl, // 分享图标
          trigger: function(res) {
              //alert('触发成功');
          },
          success: succesFunc,
          cancel: errorFunc
      });
  }


  function orderStates(num) {
      var a = parseInt(num);
      switch (a) {
          case 1:
              return "待上架";
              break;
          case 2:
              return "已上架";
              break;
          case 3:
              return "待付款";
              break;
          case 4:
              return "待取货";
              break;
          case 5:
              return "已取货";
              break;
          case 6:
              return "已卖出";
              break;
          case 7:
              return "待结算";
              break;
          case 8:
              return "待验证";
              break;
          case 9:
              return "交易成功";
              break;

      }
  }
