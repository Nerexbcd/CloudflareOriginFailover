<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Lib/Rules/validation.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/Config/files.php');

function convertAssetToDB($assetId) {
    $splited = explode('-',$assetId);
    return ['category' => intval($splited[0]), 'id' => intval($splited[1])];
}

function convertAssetToHuman($asset_category,$asset_id) {
    return str_pad($asset_category, 2, '0', STR_PAD_LEFT) . '-' . str_pad($asset_id, 4, '0', STR_PAD_LEFT);
}

function convertCategoryToDB($categoryId) {
    return intval($categoryId);
}


function convertCategoryToHuman($categoryId) {
    return str_pad($categoryId, 2, '0', STR_PAD_LEFT);
}

function checkAsset($assetId) {
    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':assetId' => $id, ':assetCategory' => $category ];
    $sql = 'SELECT * FROM Asset WHERE id = :assetId AND category = :assetCategory';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    return boolval($dbResult);
}

function checkCategory($categoryId) {
    $data = [':id' => $categoryId ];
    $sql = 'SELECT * FROM Category WHERE id = :id';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    return boolval($dbResult);
}

function getCategoryName($categoryId) {
    $data = [':id' => $categoryId ];
    $sql = 'SELECT name FROM Category WHERE id = :id';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    return $dbResult["name"];
}

function showAssetTags($assetId) {    
    if(getAssetCategory($assetId)["id"] == 1) {
        echo '<span class="badge text-bg-primary me-1 mb-1">' . "Avatar Base" . '</span>';
        echo '<span class="badge text-bg-primary me-1 mb-1">' . getAssetName($assetId) . '</span>';
    } else {
        echo '<span class="badge text-bg-primary me-1 mb-1">' . ucfirst(getAssetCategory($assetId)["name"]) . '</span>';
        echo '<span class="badge text-bg-primary me-1 mb-1">' . getAssetName(getAssetRelBaseId($assetId)) . '</span>';
    }
}

function getLastAssetId($category) {
    $data = [':category' => $category];
    $sql = "SELECT MAX(id) FROM Asset WHERE category = :category";
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);

    return $dbResult[0];
}

function getAssetImg($assetId) {
    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':assetId' => $id, ':assetCategory' => $category ];
    $sql = 'SELECT url_Img FROM AssetImg WHERE asset_id = :assetId AND asset_category = :assetCategory';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    
    
    if (!$dbResult) {
        $url = "/Data/public/default/file_asset.png";
    } else {
        $url = $dbResult['url_Img'];
    }
    return $url;
}

function getAssetsIds($query) {
    $sql = "SELECT id, category FROM Asset ";
    $data = [];
    if ($query) {
        $data = [':query' => '%' .$query . '%' ];
        $sql .= 'WHERE name LIKE :query';
    } 
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetchAll();
    unset($stmt);
    unset($link);

    $result = array();
    foreach ($dbResult as $asset) {
        array_push($result, convertAssetToHuman($asset["category"], $asset["id"]));
    }
    return $result;
}

function getAssetName($assetId) {
    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':assetId' => $id, ':assetCategory' => $category ];
    $sql = 'SELECT name FROM Asset WHERE id = :assetId AND category = :assetCategory';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    
    return $dbResult['name'];
}

function getAssetAuthorName($assetId) {
    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':assetId' => $id, ':assetCategory' => $category ];
    $sql = 'SELECT author FROM Asset WHERE id = :assetId AND category = :assetCategory';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    
    return $dbResult['author'];
}

function getAssetUrlRef($assetId){
    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':assetId' => $id, ':assetCategory' => $category ];
    $sql = 'SELECT urlRef FROM Asset WHERE id = :assetId AND category = :assetCategory';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    
    return $dbResult['urlRef'];
}

function getAssetFiles($assetId) {

    return ["somefile-substance_painter.spp","somefile-unity.unitypackage","somefile-blender.blend","somefile-other.txt","somepack-pack.rar"];
}

function getAssetsAvatarBases() {
    $sql = "SELECT id, name FROM Asset WHERE category = 1";
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $dbResult = $stmt->fetchAll();
    unset($stmt);
    unset($link);

    $result = array();
    foreach ($dbResult as $asset) {
        $result[convertAssetToHuman(1, $asset["id"])] = $asset["name"];
    }
    return $result;
}

function getAssets() {
    $sql = "SELECT id, category, name FROM Asset";
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $dbResult = $stmt->fetchAll();
    unset($stmt);
    unset($link);

    $assetsSimple = [];
    foreach ($dbResult as $asset) {
        $assetsSimple[convertAssetToHuman($asset["category"], $asset["id"])] = $asset["name"];
    }
    return $assetsSimple;
}

function getAssetRelBaseId($assetId) {
    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':id' => $id, ':category' => $category];
    $sql = 'SELECT related_id,related_category FROM AssetRelation WHERE relative_id = :id AND relative_category = :category';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);


    return $dbResult ? convertAssetToHuman($dbResult["related_category"], $dbResult["related_id"]) : "createNew";
}

function getAssetCategory($assetId) {
    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':id' => $category];
    $sql = 'SELECT name FROM Category WHERE id = :id';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute($data);
    $dbResult = $stmt->fetch();
    unset($stmt);
    unset($link);
    
    $result = ["id"=> $category,"name"=>$dbResult['name']];

    return $result;
}

function createNewAsset($name,$author,$category,$relBase,$urlRef,$urlImg,$fileImg) {
    
    Permissions::admin();

    $result = ['ok' => false];

    if (empty($name) || empty($author)) {
        $result['message'] = "The Fields Cannot be Empty!!";
        return $result;
    }

    if (empty($relBase) && !$category === 1) {
        $result['message'] = "You must set a related Asset Base!!";
        return $result;
    }

    if (!ValidateUrl($urlRef) && !empty($urlRef)) {
        $result['message'] = "The Asset Reference URL is Invalid!!";
        return $result;
    }

    if (!ValidateUrl($urlImg) && !empty($urlImg)) { 
        $result['message'] = "The Asset Image URL is Invalid!!";
        return $result;
    }

    if (!empty($fileImg)) {
        $file_name = basename($fileImg["name"]);
        $target_file = IMG_PATH . DIRECTORY_SEPARATOR . $file_name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        while (file_exists($target_file)) {
            $file_name = RandomString(15) . '.' . $imageFileType;
            $target_file = IMG_PATH . DIRECTORY_SEPARATOR . $file_name;
        }

        move_uploaded_file($fileImg["tmp_name"], $target_file);

        $urlImg = IMG_URL . DIRECTORY_SEPARATOR . $file_name;
    }

    $link = connectBD();

    $data = [':category' => $category, ':name' => $name,':author' => $author, ':urlRef' => $urlRef];
    $sql = 'INSERT INTO Asset (category, name, author, urlRef) VALUES(:category, :name, :author, :urlRef)';
    $link->prepare($sql)->execute($data);

    if(!empty($urlImg)) {
        $data = [':id' => getLastAssetId($category), ':category' => $category, ':urlImg' => $urlImg];
        $sql = 'INSERT INTO AssetImg (asset_id,asset_category,url_Img) VALUES(:id, :category, :urlImg)';
        $link->prepare($sql)->execute($data);
    }

    if ($category != 1) {
        $relBase = convertAssetToDB($relBase);
        $relId = $relBase['id'];
        $relCategory = $relBase['category'];

        $data = [':relative_id' => getLastAssetId($category), ':relative_category' => $category, ':related_id' => $relId, ':related_category' => $relCategory];
        $sql = 'INSERT INTO AssetRelation(relative_id,relative_category,related_id,related_category) VALUES(:relative_id, :relative_category, :related_id, :related_category)';
        $link->prepare($sql)->execute($data);
        
    }

    unset($link);

    $result['ok'] = true;
    $result['message'] = "Asset Created with Success!!";

    return $result;
    
}

function listAssets() {
    $sql = 'SELECT id, category, name, author, createdAt FROM Asset ORDER BY createdAt DESC';
    $link = connectBD();
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $dbResult = $stmt->fetchAll();
    unset($stmt);
    unset($link);

    return $dbResult;
}

function getAssetCategories() {
    $sql = 'SELECT id, name FROM Category';
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

function deleteAsset($assetId) {
    Permissions::admin();

    $assetId = convertAssetToDB($assetId);
    $id = $assetId['id'];
    $category = $assetId['category'];

    $data = [':id' => $id, ':category' => $category];
    $sql = 'DELETE FROM AssetImg WHERE asset_id = :id AND asset_category = :category';
    $sql2 = 'DELETE FROM AssetFile WHERE asset_id = :id AND asset_category = :category';
    $sql3 = 'DELETE FROM AssetRelation WHERE relative_id = :id AND relative_category = :category';
    $sql4 = 'DELETE FROM Asset WHERE id = :id AND category = :category';

    $link = connectBD();
    $link->prepare($sql)->execute($data);
    $link->prepare($sql2)->execute($data);
    $link->prepare($sql3)->execute($data);
    $link->prepare($sql4)->execute($data);
    unset($link);
}

function updateAsset($assetId,$name,$author,$relBase,$urlRef,$urlImg,$fileImg) {

    $assetId_div = convertAssetToDB($assetId);
    $id = $assetId_div['id'];
    $category = $assetId_div['category'];
    
    Permissions::admin();

    $result = ['ok' => false];

    if (empty($name) || empty($author)) {
        $result['message'] = "The Fields Cannot be Empty!!";
        return $result;
    }

    if (empty($relBase) && !$category === 1) {
        $result['message'] = "You must set a related Asset Base!!";
        return $result;
    }

    if (!ValidateUrl($urlRef) && !empty($urlRef)) {
        $result['message'] = "The Asset Reference URL is Invalid!!";
        return $result;
    }

    if (!ValidateUrl($urlImg) && !empty($urlImg)) { 
        $result['message'] = "The Asset Image URL is Invalid!!";
        return $result;
    }

    if (!empty($fileImg)) {
        $file_name = basename($fileImg["name"]);
        $target_file = IMG_PATH . DIRECTORY_SEPARATOR . $file_name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        while (file_exists($target_file)) {
            $file_name = RandomString(15) . '.' . $imageFileType;
            $target_file = IMG_PATH . DIRECTORY_SEPARATOR . $file_name;
        }

        move_uploaded_file($fileImg["tmp_name"], $target_file);

        $urlImg = IMG_URL . DIRECTORY_SEPARATOR . $file_name;
    }

    $link = connectBD();

    $data = [':id' => $id,':category' => $category, ':name' => $name,':author' => $author, ':urlRef' => $urlRef];
    $sql = 'UPDATE Asset SET name = :name, author = :author, urlRef = :urlRef WHERE id = :id AND category = :category';
    $link->prepare($sql)->execute($data);

    if(!empty($urlImg)) {
        $data = [':id' => $id, ':category' => $category, ':urlImg' => $urlImg];
        if(getAssetImg($assetId) == '/Data/public/default/file_asset.png') {
            $sql = 'INSERT INTO AssetImg(asset_id,asset_category,url_Img) VALUES(:id, :category, :urlImg)';
        } else {
            $sql = 'UPDATE AssetImg SET url_Img = :urlImg WHERE asset_id = :id AND asset_category = :category';
        }
        $link->prepare($sql)->execute($data);

    }

    if ($category != 1) {
        $relBase = convertAssetToDB($relBase);
        $relId = $relBase['id'];
        $relCategory = $relBase['category'];

        $data = [':relative_id' => $id, ':relative_category' => $category, ':related_id' => $relId, ':related_category' => $relCategory];
        $sql = 'UPDATE AssetRelation SET related_id = :related_id, related_category = :related_category WHERE relative_id = :relative_id AND relative_category = :relative_category';
        $link->prepare($sql)->execute($data);
        
    }

    unset($link);

    $result['ok'] = true;
    $result['message'] = "Asset Updated with Success!!";

    return $result;
    
}



?>