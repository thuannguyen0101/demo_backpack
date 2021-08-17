<?php

// --------------------------------------------------------
// This is only a pointer file, not an actual language file
// --------------------------------------------------------
//
// If you've copied this file to your /resources/lang/vendor/backpack/
// folder, please delete it, it's no use there. You need to copy/publish the
// actual language file, from the package.

// If a langfile with the same name exists in the package, load that one
if (file_exists(__DIR__.'/../../../../../logmanager/src/resources/lang/'.basename(__DIR__).'/'.basename(__FILE__))) {
    return include __DIR__.'/../../../../../logmanager/src/resources/lang/'.basename(__DIR__).'/'.basename(__FILE__);
}

return [
    "log_manager"=>"アプリログ",
    "log_manager_description"=>"アプリログ",
    "file_name"=>"ファイルの名前",
    "date"=>"日",
    "file_size"=>"サイズ",
    "actions"=>"操作",
    "preview"=>"表示",
    "download"=>"ダウンロード",
    "delete"=>" 削除",
];
