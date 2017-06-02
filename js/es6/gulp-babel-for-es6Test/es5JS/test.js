'use strict';

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

var _marked = [objectEntries, genFuncWithReturn, logReturned].map(regeneratorRuntime.mark);

//字符串编码
var encodeUnicode = function encodeUnicode() {
  var strings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  return '\\u' + Array.from(strings).map(function (s) {
    s = s.codePointAt(0).toString(16);
    return new Array(5 - s.length).join("0") + s;
  }).join('\\u');
};

var decodeUnicode = function decodeUnicode() {
  var strings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  return strings.split(/\\u/).map(function (s) {
    return s === '' ? '' : String.fromCodePoint(parseInt(s, 16));
  }).join('');
};
var a = "𠮷a123𠮷bbb";
show.innerHTML = a + "<br>" + encodeUnicode(a) + "<br>" + decodeUnicode(encodeUnicode(a));

//递归数组扁平化
var arr = [1, [2, [4, [5, 6], 7], 3]];
arr[1][2] = arr;
arr[2] = arr;
var flat = function flat(arr) {
  var b = [];
  if (!arr.length) return arr;
  function c(item) {
    if ((typeof item === 'undefined' ? 'undefined' : _typeof(item)) !== "object" || item === null || !item.length || item === arr && b.length) {
      b.push(item);
    } else {
      [].forEach.call(item, function (value) {
        c(value);
      });
    }
  };
  c(arr);
  return b;
};
console.log(arr);
console.log(flat(arr));

//object的遍历器接口
function objectEntries() {
  var propKeys, _iteratorNormalCompletion, _didIteratorError, _iteratorError, _iterator, _step, propKey;

  return regeneratorRuntime.wrap(function objectEntries$(_context) {
    while (1) {
      switch (_context.prev = _context.next) {
        case 0:
          propKeys = Object.keys(this);
          _iteratorNormalCompletion = true;
          _didIteratorError = false;
          _iteratorError = undefined;
          _context.prev = 4;
          _iterator = propKeys[Symbol.iterator]();

        case 6:
          if (_iteratorNormalCompletion = (_step = _iterator.next()).done) {
            _context.next = 13;
            break;
          }

          propKey = _step.value;
          _context.next = 10;
          return [propKey, this[propKey]];

        case 10:
          _iteratorNormalCompletion = true;
          _context.next = 6;
          break;

        case 13:
          _context.next = 19;
          break;

        case 15:
          _context.prev = 15;
          _context.t0 = _context['catch'](4);
          _didIteratorError = true;
          _iteratorError = _context.t0;

        case 19:
          _context.prev = 19;
          _context.prev = 20;

          if (!_iteratorNormalCompletion && _iterator.return) {
            _iterator.return();
          }

        case 22:
          _context.prev = 22;

          if (!_didIteratorError) {
            _context.next = 25;
            break;
          }

          throw _iteratorError;

        case 25:
          return _context.finish(22);

        case 26:
          return _context.finish(19);

        case 27:
        case 'end':
          return _context.stop();
      }
    }
  }, _marked[0], this, [[4, 15, 19, 27], [20,, 22, 26]]);
}
var jane = { first: 'Jane', last: 'Doe' };
Object.prototype[Symbol.iterator] = objectEntries;
// for (let [key, value] of jane) {
//   console.log(`${key}: ${value}`);
// }


function genFuncWithReturn() {
  return regeneratorRuntime.wrap(function genFuncWithReturn$(_context2) {
    while (1) {
      switch (_context2.prev = _context2.next) {
        case 0:
          _context2.next = 2;
          return 'a';

        case 2:
          _context2.next = 4;
          return 'b';

        case 4:
          return _context2.abrupt('return', 'The result');

        case 5:
        case 'end':
          return _context2.stop();
      }
    }
  }, _marked[1], this);
}
function logReturned(genObj) {
  var result;
  return regeneratorRuntime.wrap(function logReturned$(_context3) {
    while (1) {
      switch (_context3.prev = _context3.next) {
        case 0:
          return _context3.delegateYield(genObj, 't0', 1);

        case 1:
          result = _context3.t0;

          console.log(result);

        case 3:
        case 'end':
          return _context3.stop();
      }
    }
  }, _marked[2], this);
}

console.log([].concat(_toConsumableArray(logReturned(genFuncWithReturn()))));
// The result
// 值为 [ 'a', 'b' ]