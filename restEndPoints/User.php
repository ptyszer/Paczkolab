<?php
User::setDb($db);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $tmpUsers = [];
    if(!empty($pathId)){
        $user = User::load($pathId);
        $tmpUsers[0]['id'] = $user->getId();
        $tmpUsers[0]['name'] = $user->getName();
        $tmpUsers[0]['surname'] = $user->getSurname();
        $tmpUsers[0]['credits'] = $user->getCredits();
        $tmpUsers[0]['address_id'] = $user->getAddressId();
    } else {
        $users = User::loadAll();
        foreach ($users as $k => $user) {
            $tmpUsers[$k]['id'] = $user['id'];
            $tmpUsers[$k]['name'] = $user['name'];
            $tmpUsers[$k]['surname'] = $user['surname'];
            $tmpUsers[$k]['credits'] = $user['credits'];
            $tmpUsers[$k]['address_id'] = $user['address_id'];
        }
    }
    $response = $tmpUsers;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User(null, $_POST['name'], $_POST['surname'], $_POST['credits'], $_POST['address_id']);
    $user->save();
    $response = ['success' => [json_decode(json_encode($user), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $user = User::load($patchVars['id']);
    $user->setName($patchVars['name']);
    $user->setSurname($patchVars['surname']);
    $user->setCredits($patchVars['credits']);
    $user->update();
    $response = ['success' => [json_decode(json_encode($user), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $user = User::load($deleteVars['id']);
    $user->delete();
    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}