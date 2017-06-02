//去掉字符串的右空格
String.prototype.rtrim = function() {
		return this.replace(/\s+$/ig, "");
	}
//去掉字符串的左空格
String.prototype.ltrim = function() {
	return this.replace(/^\s+/ig, "");
}