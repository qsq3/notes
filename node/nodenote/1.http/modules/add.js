function add(a, b){
  return a+b
}

// 注意两者引用关系的区别
module.exports = exports = add;

exports.add = '234';