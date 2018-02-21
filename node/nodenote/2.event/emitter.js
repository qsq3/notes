// 事件模块
const EventEmitter = require('events').EventEmitter

// 创建一个事件对象实例
let life = new EventEmitter();

// 自定义事件, 单个名称默认最多回调函数10个
// 自定义回调函数最多数目
life.setMaxListeners(11)

function callbackFunc1 (who){
  console.log( who + ' do something ...1')
}

function callbackFunc2 (who){
  console.log( who + ' do something ...2')
}

// 设置事件回调函数, 同 life.addEventListener
life.on('事件名称1', callbackFunc1)
life.on('事件名称1', callbackFunc2)
life.on('事件名称2', callbackFunc2)

// 触发事件
life.emit('事件名称1', '参数')

// 事件回调函数个数:
console.log('事件名称1 回调函数个数: ', life.listeners('事件名称1').length)
console.log('事件名称2 回调函数个数: ', EventEmitter.listenerCount(life, '事件名称2'))

// 移除单个事件回调
life.removeListener('事件名称1', callbackFunc1)

//检测事件是否定义
console.log('事件名称1 存在回调: ', life.emit('事件名称1', '参数1'))
console.log('事件名称2 存在回调: ', life.emit('事件名称2', '参数2'))
console.log('事件名称3 存在回调: ', life.emit('事件名称3', '参数3'))

//移除 事件名称1 下所有回调
life.removeAllListeners('事件名称1');
console.log('事件名称1 回调函数个数: ', life.listeners('事件名称1').length) //0

//移除 实例life 所有事件
life.removeAllListeners();
console.log('事件名称2 回调函数个数: ', EventEmitter.listenerCount(life, '事件名称2')) //0