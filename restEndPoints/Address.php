<?php
Address::setDb($db);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $tmpAddresses = [];
    if(!empty($pathId)){
        $address = Address::load($pathId);
        $tmpAddresses[0]['id'] = $address->getId();
        $tmpAddresses[0]['city'] = $address->getCity();
        $tmpAddresses[0]['code'] = $address->getCode();
        $tmpAddresses[0]['street'] = $address->getStreet();
        $tmpAddresses[0]['flat'] = $address->getFlat();
    } else {
        $addresses = Address::loadAll();
        foreach ($addresses as $k => $address) {
            $tmpAddresses[$k]['id'] = $address['id'];
            $tmpAddresses[$k]['city'] = $address['city'];
            $tmpAddresses[$k]['code'] = $address['code'];
            $tmpAddresses[$k]['street'] = $address['street'];
            $tmpAddresses[$k]['flat'] = $address['flat'];
        }
    }
    $response = $tmpAddresses;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = new Address(null, $_POST['city'], $_POST['code'], $_POST['street'], $_POST['flat']);
    $address->save();
    $response = ['success' => [json_decode(json_encode($address), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $address = Address::load($patchVars['id']);
    $address->setCity($patchVars['city']);
    $address->setCode($patchVars['code']);
    $address->setStreet($patchVars['street']);
    $address->setFlat($patchVars['flat']);
    $address->update();
    $response = ['success' => [json_decode(json_encode($address), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $address = Address::load($deleteVars['id']);
    $address->delete();
    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}