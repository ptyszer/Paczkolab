<?php
Size::setDb($db);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $tmpSizes = [];
    if(!empty($pathId)){
        $size = Size::load($pathId);
        $tmpSizes[0]['id'] = $size->getId();
        $tmpSizes[0]['size'] = $size->getSize();
        $tmpSizes[0]['price'] = $size->getPrice();
    } else {
        $sizes = Size::loadAll();
        foreach ($sizes as $k => $size) {
            $tmpSizes[$k]['id'] = $size['id'];
            $tmpSizes[$k]['size'] = $size['size'];
            $tmpSizes[$k]['price'] = $size['price'];
        }
    }
    $response = $tmpSizes;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $size = new Size(null, $_POST['size'], $_POST['price']);
    $size->save();
    $response = ['success' => [json_decode(json_encode($size), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $size = Size::load($patchVars['id']);
    $size->setSize($patchVars['size']);
    $size->setPrice($patchVars['price']);
    $size->update();
    $response = ['success' => [json_decode(json_encode($size), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $size = Size::load($deleteVars['id']);
    $size->delete();
    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}