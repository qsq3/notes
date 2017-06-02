@echo off
setlocal enabledelayedexpansion
for /F "tokens=1-3" %%i in ('reg query "HKLM\Software\Microsoft\MediaPlayer" /v "IEInstall"') do (
if "%%i"=="IEInstall" (
echo "%%i %%j %%k"
set m=%%i
echo "!m!"
echo "!m:~0,1!"
set v=!m:~0,1!
echo "!v!"
)
)
pause