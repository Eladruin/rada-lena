
set baza=%~dp0
rem echo %baza%
xcopy \\kanskrdp\d$\logs\log\kanskrdp.log %baza%alllogs\ /Y
xcopy \\abakanrdp\e$\logs\log\abakanrdp.log %baza%alllogs\ /Y
xcopy \\achinskrdp\e$\logs\log\achinskrdp.log %baza%alllogs\ /Y
xcopy \\barnaulrdp\e$\logs\log\barnaulrdp.log %baza%alllogs\ /Y
xcopy \\irkutskrdp\e$\logs\log\irkutskrdp.log %baza%alllogs\ /Y
xcopy \\minusinskrdp\e$\logs\log\minusinskrdp.log %baza%alllogs\ /Y
xcopy \\nskrdp\d$\logs\log\nskrdp.log %baza%alllogs\ /Y
xcopy \\omskrdp\d$\logs\log\omskrdp.log %baza%alllogs\ /Y
xcopy \\ulanuderdp\d$\logs\log\ulanuderdp.log %baza%alllogs\ /Y
xcopy \\ts\d$\logs\log\ts.log %baza%alllogs\ /Y

cd %baza%alllogs\
chcp 65001
type %baza%alllogs\achinskrdp.log > %baza%alllogs\utf8\achinskrdp.log 
type %baza%alllogs\abakanrdp.log > %baza%alllogs\utf8\abakanrdp.log
type %baza%alllogs\barnaulrdp.log > %baza%alllogs\utf8\barnaulrdp.log
type %baza%alllogs\irkutskrdp.log > %baza%alllogs\utf8\irkutskrdp.log
type %baza%alllogs\kanskrdp.log > %baza%alllogs\utf8\kanskrdp.log
type %baza%alllogs\minusinskrdp.log > %baza%alllogs\utf8\minusinskrdp.log
type %baza%alllogs\nskrdp.log > %baza%alllogs\utf8\nskrdp.log
type %baza%alllogs\omskrdp.log > %baza%alllogs\utf8\omskrdp.log
type %baza%alllogs\ts.log > %baza%alllogs\utf8\ts.log
type %baza%alllogs\ulanuderdp.log > %baza%alllogs\utf8\ulanuderdp.log
