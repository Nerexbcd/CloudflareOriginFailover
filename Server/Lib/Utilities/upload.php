<?php
    function checkFiles() {
        return !(empty($_FILES) || $_FILES['file']['error']);
    }







    // upload destination
    $filePath = __DIR__ . DIRECTORY_SEPARATOR . "uploads";
    if (!file_exists($filePath)) {
        if (!mkdir($filePath, 0777, true)) {
            verbose(0, "Failed to create $filePath");
        }
    }
    $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
    $filePath = $filePath . DIRECTORY_SEPARATOR . $fileName;


    // dealing with the chunks
    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
    $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
    if ($out) {
        $in = @fopen($_FILES['file']['tmp_name'], "rb");
        if ($in) {
            while ($buff = fread($in, 4096)) { fwrite($out, $buff); }
        } else {
            verbose(0, "Failed to open input stream");
        }
        @fclose($in);
        @fclose($out);
        @unlink($_FILES['file']['tmp_name']);
    } else {
        verbose(0, "Failed to open output stream");
    }
    // check if file was uploaded
    if (!$chunks || $chunk == $chunks - 1) {
        rename("{$filePath}.part", $filePath);
    }
    verbose(1, "Upload OK");
?>