<?php

//start session
session_start();

include_once('Models/Contact.php');

$contact = new Contact();



if (isset($_GET['getdata'])) {


    if (isset($_GET['filterbyPhone'])) {
        $data[] = $_GET['filterbyPhone'];
    }
    if (isset($_GET['search'])) {
        $data['search'] = $_GET['search'];
    }
    if (isset($_GET['page'])) {
        $data['page'] = $_GET['page'];
    }


    $result = $contact->ContactData($data);

    if (!$result) {
        echo  json_encode(

            [
                'success' => false,
                'data' => $result,
            ]
        );

        return;
    }
    echo json_encode(

        [
            'success' => true,
            'data' => $result,
            'page' => $data['page'],

        ]
    );
}


if (isset($_POST['addData'])) {

    $data = array();

    if (isset($_POST['contact_data'])) {
        $data['contact_data'] = $_POST['contact_data'];
    }
    $result =  $contact->Store($data);

    echo json_encode(

        [
            'success' => true,
            'data' => $result
        ]
    );
}

if (isset($_POST['deleteData'])) {


    if (isset($_POST['id'])) {

        $id = $_POST['id'];

        $deleteData = $contact->deleteData($id);

        if (!$deleteData) {
            echo json_encode(

                [
                    'success' => false,
                    'data' => null
                ]
            );

            return;
        }
        echo json_encode(

            [
                'success' => true,
                'data' => 'record deleted successfully'
            ]
        );
    }
}
