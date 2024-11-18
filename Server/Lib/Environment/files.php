<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Config/files.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/Lib/Base/files.php');

function convertFileToDB($assetId) {
    $splited = explode('-',$assetId);
    return ['asset_category' => intval($splited[0]), 'asset_id' => intval($splited[1]), 'file_type' => intval($splited[2]), 'file_id' => intval($splited[3])];
}

function convertFileToHuman($asset_category,$asset_id,$file_type,$file_id) {
    return str_pad($asset_category, 2, '0', STR_PAD_LEFT) . '-' . str_pad($asset_id, 4, '0', STR_PAD_LEFT) . '-' . str_pad($file_type, 3, '0', STR_PAD_LEFT) . '-' . str_pad($file_id, 6, '0', STR_PAD_LEFT);
}

function confirmCategoryFolder($categoryId) {
    if (checkCategory($categoryId)) {
        $folder_name = convertCategoryToHuman($categoryId);
        $path = STORAGE_PATH . DIRECTORY_SEPARATOR . $folder_name;

        if (!file_exists($path)) {
            good_mkdir($path,0777);
        }
    }
}

function confirmAssetFolder($assetId) {
    if (checkAsset($assetId)) {
        $dbAssetId = convertAssetToDB($assetId);
        $id = $dbAssetId['id'];
        $category = $dbAssetId['category'];

        confirmCategoryFolder($category);

        $folder_name = str_pad($id, 4, '0', STR_PAD_LEFT);
        $path = STORAGE_PATH . DIRECTORY_SEPARATOR . convertCategoryToHuman($category) . DIRECTORY_SEPARATOR . $folder_name;

        if (!file_exists($path)) {
            good_mkdir($path,0777);
        }
    }
}

function getAssetFileTypes() {
    $sql = 'SELECT id, name FROM FileType';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $dbResult = $stmt->fetchAll();
    unset($stmt);
    unset($link);

    $result = array();
    foreach ($dbResult as $category) {
        $result[$category["id"]] = $category["name"];
    }
    return $result;
}





?>