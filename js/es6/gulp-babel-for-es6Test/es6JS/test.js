
//字符串编码
let encodeUnicode=(strings='')=>'\\u' + (Array.from(strings).map((s) => {
    s =s.codePointAt(0).toString(16);
    return new Array(5-s.length).join("0")+s}
  )).join('\\u');

let decodeUnicode=(strings='')=>strings.split(/\\u/).map(
  s=> s === ''? '':String.fromCodePoint(parseInt(s,16))
).join('');
let a ="𠮷a123𠮷bbb";
show.innerHTML = a + "<br>" + encodeUnicode(a) + "<br>" + decodeUnicode(encodeUnicode(a));

//递归数组扁平化
var arr = [1, [2,[4,[5,6],7],3]]
arr[1][2] = arr;
arr[2] = arr;
var flat = function (arr){
  var b = [];
  if(!arr.length) return arr;
  function c (item){
    if(typeof item !== "object" || item === null || !item.length || (item === arr && b.length)){
      b.push(item);
    }else{
      [].forEach.call(item,function(value){
        c(value);
      })
    }
  };
  c(arr);
  return b;
}
console.log(arr);
console.log(flat(arr));

//object的遍历器接口
function* objectEntries() {
  let propKeys = Object.keys(this);

  for (let propKey of propKeys) {
    yield [propKey, this[propKey]];
  }
}
let jane = { first: 'Jane', last: 'Doe' };
Object.prototype[Symbol.iterator] = objectEntries;
// for (let [key, value] of jane) {
//   console.log(`${key}: ${value}`);
// }


function* genFuncWithReturn() {
  yield 'a';
  yield 'b';
  return 'The result';
}
function* logReturned(genObj) {
  let result = yield* genObj;
  console.log(result);
}

console.log([...logReturned(genFuncWithReturn())])
// The result
// 值为 [ 'a', 'b' ]
