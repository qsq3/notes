<?php
header('Content-Type:text/html;charset=utf-8');
date_default_timezone_set('PRC');
// Session 自定义类
// php.ini中: session.save_handler = user
session_set_save_handler('open','close','read','write','destroy','gc');

