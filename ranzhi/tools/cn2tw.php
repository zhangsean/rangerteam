#!/usr/bin/env php
<?php
foreach(glob('../app/*') as $app)
{
    echo "converting app " . basename($app) . ":\n";
    convertTW($app);
}

function convertTW($app)
{
    foreach(glob("$app/*") as $moduleName)
    {
        $moduleLangPath  = realpath($moduleName) . '/lang/';
        $defaultLangFile = $moduleLangPath . 'zh-cn.php';
        $targetLangFile  = $moduleLangPath . 'zh-tw.php';
        if(!file_exists($defaultLangFile)) continue;

        echo "  converting module " . basename($moduleName) . ",";

        system("cconv -f utf-8 -t UTF8-TW $defaultLangFile > $targetLangFile");
        $defaultLang = file_get_contents($targetLangFile);
        $targetLang  = str_replace('zh-cn', 'zh-tw', $defaultLang);
        file_put_contents($targetLangFile, $targetLang);
        echo " ok.\n";
    }
}
