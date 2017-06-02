//新浪微博批量删除
javascript:var o=document.createElement('script');o.src= 'http:\\ajax.microsoft.com/ajax/jquery/jquery-1.4.min.js';document.body.appendChild(o);o.onload= function(){$("a[title='删除此条微博']").each(function(i){var that = this; setTimeout( function(){that.click();$("a[node-type='ok']").each(function(){this.click();})},i*400)})};

//智联批量申请
var o=document.createElement('script');o.src= 'http://ajax.microsoft.com/ajax/jquery/jquery-1.4.min.js';document.body.appendChild(o);o.onload= function(){var k = $("input[value*='立即申请']").length;$("input[value*='立即申请']").each(function(i){var that = this;setTimeout( function(){that.click();$("#closeLayerBtn").trigger("click");if(i >= (k-1)){ $("a.c-pagenext")[0].click()}},i*50)})}

<div style="text-align: center;">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" height="325" width="400">
    <param name="movie" value="http://v.ifeng.com/include/exterior.swf?guid=01265379-2972-4af7-972b-876929e4d16e&amp;pageurl=http://www.ifeng.com&amp;fromweb=other&amp;AutoPlay=false" />
    <param name="quality" value="high" />
    <param name="allowScriptAccess" value="always" />
    <embed allowscriptaccess="always" height="325" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="http://v.ifeng.com/include/exterior.swf?guid=01265379-2972-4af7-972b-876929e4d16e&amp;pageurl=http://www.ifeng.com&amp;fromweb=other&amp;AutoPlay=false" type="application/x-shockwave-flash" width="400">
    </embed>
  </object>
</div>

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" height="400" width="600"><param name="quality" value="high" />
  <param name="movie" value="http://v.ifeng.com/include/exterior.swf?guid=01265379-2972-4af7-972b-876929e4d16e&amp;amp;pageurl=http://www.ifeng.com&amp;amp;fromweb=other&amp;amp;AutoPlay=false" /><embed height="400" pluginspage="http://www.macromedia.com/go/getflashplayer" quality="high" src="http://v.ifeng.com/include/exterior.swf?guid=01265379-2972-4af7-972b-876929e4d16e&amp;amp;pageurl=http://www.ifeng.com&amp;amp;fromweb=other&amp;amp;AutoPlay=false" type="application/x-shockwave-flash" width="600"></embed>
</object>
