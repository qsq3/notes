//创建数据库			数据库	 版本	      提示信息					数据库大小
var db = openDatabase('noteapp','1.0','一个可以记录笔记的应用', 5 * 1024 * 1024);

//创建数据表 [[transaction]=交易的理解,executeSql执行sql]
db.transaction(function(tx){
	tx.executeSql("CREATE TABLE IF NOT EXISTS note (id INTEGER PRIMARY KEY ASC, note_content TEXT, note_date TEXT)");
});

//载入并显示笔记内容
loadNote();

//得到提交笔记的表单
var noteForm = document.getElementById('note-form');

//实时设置 Loacl Storage 存储用户输入的内容
var noteFormText = noteForm.elements['note-content'];
noteFormText.addEventListener('keyup',function(){
	localStorage.setItem('note',noteForm.elements['note-content'].value);
});
//将Local Storage 里的内容恢复到文本区域上
noteForm.elements['note-content'].value = localStorage.getItem('note');


//提交笔记
function submitNote(event){
	event.preventDefault(); //去除按钮的默认行为

	//得到提交表单的内容
	var noteContent = noteForm.elements['note-content'].value;
	//得到 提交按钮的值
	var status = noteForm.elements['submit-btn'].value;
	//得到隐藏文本框 note-id 里的值
	var noteID = noteForm.elements['note-id'].value;

	//进行if判断语句
	if (status === 'submit'){
		//执行的数据[插入]
		db.transaction(function(tx){
			tx.executeSql("INSERT INTO note (note_content,note_date) VALUES (?, DATETIME('now','localtime'))",[noteContent]);
		});
	}else{
		//执行的数据[更新]
		db.transaction(function(tx){
			tx.executeSql('UPDATE note SET note_content = ? WHERE id = ?',[noteContent,noteID],onSuccess,onError);
		});
	}

};

//获得 提交 按钮并监听它的点击事件
var submitBtn = document.getElementById('submit-btn');
	
	//为按钮添加点击事件   点击执行 -> 函数
submitBtn.addEventListener('click', submitNote, false);


//执行 SQL 成功之后 tx执行  rs结果
function onSuccess(tx,rs){
	console.log('成功')
	loadNote();
};

//执行 SQL 失败 tx执行 e失败的结果
function onError(tx,e){
	console.log('失败'+e.message);
};

//删除笔记按钮
function deleteNote(id){
	db.transaction(function(tx){
		tx.executeSql('DELETE FROM note WHERE ID = ?',[id],onSuccess,onError);
	});
};
//编辑笔记按钮
function editNote(id){
	db.transaction(function(tx){
		tx.executeSql('SELECT * FROM note WHERE id = ?',[id],function(tx,rs){
			//把笔记的内容更新到文本里面
			noteForm.elements['note-content'].value = rs.rows.item(0).note_content;
			//submit 提交笔记内容update 更新笔记的内容
			noteForm.elements['submit-btn'].value = 'update';
			noteForm.elements['submit-btn'].innerHTML='更新';
			noteForm.elements['note-id'].value = id;
		});
	});
};
//显示数据表里面的内容
function displayNote(tx,rs){
	//console.log('找到的结果数量是：'+rs.rows.length);
	//获取到显示笔记列表窗口并清空原有内容
	var noteListContainer = document.getElementById('note-list');
	noteListContainer.innerHTML = '';

	//循环输出笔记
	for (var i = 0; i< rs.rows.length; i++){
		var noteEntry = rs.rows.item(i);

		noteListContainer.innerHTML += 
			'<li class="list-group-item">' + 
			noteEntry.note_content +
			'<div class="btn-group btn-grouf-xs pull-right btn-group-seat">' +
				'<button class="btn btn-default" onclick="deleteNote('+noteEntry.id+')">删除</button>'+
				'<button class="btn btn-default" onclick="editNote('+noteEntry.id+')">编辑</button>'+
			'</div>' +
			'<small class="pull-right note-date">'+ 
			noteEntry.note_date +
			'</small>'+
			'</li>';
	}
};

//查询数据表里面的内容
function loadNote(){
	db.transaction(function(tx){
		tx.executeSql("SELECT * FROM note ORDER BY id  ",[],displayNote,onError)
	});
};

