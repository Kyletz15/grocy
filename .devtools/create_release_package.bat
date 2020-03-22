set projectPath=%~dp0
if %projectPath:~-1%==\ set projectPath=%projectPath:~0,-1%
set projectPath=%projectPath%\..

set releasePath=%projectPath%\.release
mkdir "%releasePath%"

del "%releasePath%\grocy.tar"
del "%releasePath%\grocy.tar.gz"
7za a -r "%releasePath%\grocy.tar" "%projectPath%\*" -xr!.* -xr!package.json -xr!publication_assets
7za a "%releasePath%\grocy.tar" "%projectPath%\public\.htaccess"
7za rn "%releasePath%\grocy.tar" .htaccess public\.htaccess
7za d "%releasePath%\grocy.tar" data\*.* data\storage data\viewcache\*
7za a "%releasePath%\grocy.tar.gz" "%releasePath%\grocy.tar"

del "%releasePath%\grocy.zip"
7za a -r "%releasePath%\grocy.zip" "%projectPath%\*" -xr!.* -xr!build.bat -xr!composer.json -xr!composer.lock -xr!package.json -xr!yarn.lock -xr!publication_assets
7za a "%releasePath%\grocy.zip" "%projectPath%\public\.htaccess"
7za rn "%releasePath%\grocy.zip" .htaccess public\.htaccess
7za d "%releasePath%\grocy.zip" data\*.* data\storage data\viewcache\*
