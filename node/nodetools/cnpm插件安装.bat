CLS
@ECHO OFF
ECHO cnpm�����װ���������,��ϰ��,���� ��ɽ ssmat@qq.com

setlocal enabledelayedexpansion

::ע�� ʹ��set�����������ֵ�����������������ֵǰ�пո���ᵼ�����Է��ֵĴ���

::������β׺ _-g ��ʾȫ��
SET a=gulp_-g gulp gulp-less gulp-concat gulp-minify-css gulp-htmlmin gulp-uglify gulp-rename gulp-clean gulp-replace gulp-processhtml gulp-add-src
::SET a=karma karma-jasmine karma-chrome-launcher karma-cli_-g

::���·��
::SET dir=d:/www/node_modules/gulp
SET dir=%cd%

::IF NOT EXIST %dir% (
::echo ------------------�ļ��в�����,��ʼ����---------------------
::MD dir
::pause
::exit
::)
::echo --------------------------gulpĿ��·����ȷ,��ʼ��װ---------------------

::��תĿ¼
::SET dis=%dir:~0,1%
::%dis%:
::cd %dir%

::SET /P flag=��ǰ��װĿ¼�ǣ�%cd% ;��ȷ��Y/N
::IF %flag%==n EXIT

CHOICE /C YN /N /M "��ǰ��װĿ¼�ǣ�%cd% ;��ȷ�� Y/N"
if %errorlevel%==1 goto StartInstall
if %errorlevel%==2 goto EndInstall

::����ļ�,��ʼ����
:StartInstall
FOR %%i IN (%a%) DO (
SET name=%%i
echo !name!|findstr "_-g$" >nul
if !errorlevel! equ 0 (

	SET title=ȫ��
	SET name=!name:~0,-4!
	SET g=-g --save-dev
	SET d=C:\Users\Administrator\AppData\Roaming\npm

) else (

	SET title=����
	SET g=--save-dev
	SET d=%cd%

)
IF EXIST !d!\node_modules\!name! ( 
	SET tip=------------------!title! !name! �Ѵ���,��ʼ����--------------------- 
	SET act=update

) else ( 
	SET tip=------------------!title! !name! ������,��ʼ��װ---------------------
	SET act=install
)
ECHO !tip!
start "cnpm !name! ��װ����" /high /wait /b cnpm !act! !name! !g!
choice /t 30 /d y /n >nul
ECHO --------------!title! !name! ���-----------------
)
echo -------------------------------------------------------------
echo ------------------------������װ����-----------------------
echo -------------------------------------------------------------
pause>nul

:EndInstall
EXIT

::ж������ rimraf node_modules