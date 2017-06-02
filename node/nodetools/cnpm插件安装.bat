CLS
@ECHO OFF
ECHO cnpm插件安装批处理程序,练习用,作者 空山 ssmat@qq.com

setlocal enabledelayedexpansion

::注意 使用set命令给变量赋值，如果变量名后或变量值前有空格，则会导致难以发现的错误

::这里用尾缀 _-g 表示全局
SET a=gulp_-g gulp gulp-less gulp-concat gulp-minify-css gulp-htmlmin gulp-uglify gulp-rename gulp-clean gulp-replace gulp-processhtml gulp-add-src
::SET a=karma karma-jasmine karma-chrome-launcher karma-cli_-g

::检查路径
::SET dir=d:/www/node_modules/gulp
SET dir=%cd%

::IF NOT EXIST %dir% (
::echo ------------------文件夹不存在,开始创建---------------------
::MD dir
::pause
::exit
::)
::echo --------------------------gulp目标路径正确,开始安装---------------------

::跳转目录
::SET dis=%dir:~0,1%
::%dis%:
::cd %dir%

::SET /P flag=当前安装目录是：%cd% ;请确认Y/N
::IF %flag%==n EXIT

CHOICE /C YN /N /M "当前安装目录是：%cd% ;请确认 Y/N"
if %errorlevel%==1 goto StartInstall
if %errorlevel%==2 goto EndInstall

::检查文件,开始遍历
:StartInstall
FOR %%i IN (%a%) DO (
SET name=%%i
echo !name!|findstr "_-g$" >nul
if !errorlevel! equ 0 (

	SET title=全局
	SET name=!name:~0,-4!
	SET g=-g --save-dev
	SET d=C:\Users\Administrator\AppData\Roaming\npm

) else (

	SET title=本地
	SET g=--save-dev
	SET d=%cd%

)
IF EXIST !d!\node_modules\!name! ( 
	SET tip=------------------!title! !name! 已存在,开始更新--------------------- 
	SET act=update

) else ( 
	SET tip=------------------!title! !name! 不存在,开始安装---------------------
	SET act=install
)
ECHO !tip!
start "cnpm !name! 安装窗口" /high /wait /b cnpm !act! !name! !g!
choice /t 30 /d y /n >nul
ECHO --------------!title! !name! 完成-----------------
)
echo -------------------------------------------------------------
echo ------------------------批处理安装结束-----------------------
echo -------------------------------------------------------------
pause>nul

:EndInstall
EXIT

::卸载命令 rimraf node_modules