<?php
function clean_input($input)
{
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

function getFileExtension($fileName)
{
    return pathinfo($fileName)['extension'];
}


function uploadFile($file, $path, $allowType, $maxSize)
{
    $fileName = $file['name'];
    $ext = getFileExtension($fileName);
    $fileSize = $file['size'];
    $tmpFile = $file['tmp_name'];
    $result = [
        "error" => [],
        "path" => ""
    ];

    if ($fileSize > $maxSize) {
        $result ['error'][] = [
            "msg" => "Exceeded filesize limit (" . ($maxSize / 1000000) . "MB)"
        ];
    }
    if (count($result['error']) == 0) {
        $fileName = time() . "_" . $fileName;
        if (!is_dir(getcwd() . $path)) mkdir($path, 0777, true);
        $path = $path . "/" . $fileName;
        if (move_uploaded_file(stmpFile, getcwd() . $path)) {
            $result['path'] = $path;
        } else {
            $result['error'][] = [
                "msg" => " Error on upload file : Permission denied"
            ];
        }
    }
    return $result;
}