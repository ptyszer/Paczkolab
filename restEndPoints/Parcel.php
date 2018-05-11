<?php
Parcel::setDb($db);
User::setDb($db);
Size::setDb($db);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $parcels = Parcel::loadAll();
    $tmpParcels = [];
    foreach ($parcels as $k => $parcel) {
        $tmpParcels[$k]['id'] = $parcel['id'];
        $tmpParcels[$k]['user_id'] = $parcel['user_id'];
        $tmpParcels[$k]['size_id'] = $parcel['size_id'];
        $tmpParcels[$k]['address_id'] = $parcel['address_id'];
    }
    $response = $tmpParcels;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $sizeId = $_POST['size_id'];
    $addressId = $_POST['address_id'];
    $user = User::load($userId);
    $size = Size::load($sizeId);

    if($user->getCredits() >= $size->getPrice()){
        $credits = $user->getCredits() - $size->getPrice();
        $user->setCredits($credits);
        $parcel = new Parcel(null, $userId, $sizeId, $addressId);
        $parcel->save();
        $user->update();
        $response = ['success' => [json_decode(json_encode($parcel), true)]];
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $parcel = Parcel::load($patchVars['id']);
    $parcel->setSender($patchVars['user_id']);
    $parcel->setSize($patchVars['size_id']);
    $parcel->setAddress($patchVars['address_id']);
    $parcel->update();
    $response = ['success' => [json_decode(json_encode($parcel), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $parcel = Parcel::load($deleteVars['id']);
    $parcel->delete();
    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}