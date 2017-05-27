<?php
 
require_once 'include/DbHandler.php';
require_once 'include/PassHash.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

/**
 * ----------- METHODS WITHOUT AUTHENTICATION ---------------------------------
 */

$app->get('/getallrequestlaundry', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetAllRequestLaundry();
    if ($result != null) {
        $response['error'] = false;
        $response['listAkun'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/acceptrequestlaundry', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id'));
    $id = $app->request->post('id');
    $response = array();
    $response['error'] = false;
    $result = $db->AcceptRequestLaundry($id);
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/createnewpesanan', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('alamat', 'id_pemesan', 'total_1', 'total_2', 'total_3', 'total_harga'));
    $response = array();
    $alamat = $app->request->post('alamat');
    $id_pemesan = $app->request->post('id_pemesan');
    $total_1 = $app->request->post('total_1');
    $total_2 = $app->request->post('total_2');
    $total_3 = $app->request->post('total_3');
    $total_harga = $app->request->post('total_harga');
    $response['error'] = false;
    $result = $db->CreateNewPesanan($alamat, $id_pemesan, $total_1, $total_2, $total_3, $total_harga);
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/login', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_facebook'));
    $response = array();
    $id_facebook = $app->request->post('id_facebook');
    $response['error'] = false;
    $result = $db->Login($id_facebook);
    if ($result != null) {
        $response['error'] = false;
        $response['akun'] = array();
        $response['akun'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/register', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('nama', 'alamat', 'no_telp', 'role', 'id_facebook'));
    $nama = $app->request->post('nama');
    $alamat = $app->request->post('alamat');
    $no_telp = $app->request->post('no_telp');
    $role = $app->request->post('role');
    $id_facebook = $app->request->post('id_facebook');
    $response = array();
    $response['error'] = false;
    $result = $db->Register($nama, $alamat, $no_telp, $role, $id_facebook);
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getalllaundry', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetAllLaundry();
    if ($result != null) {
        $response['error'] = false;
        $response['listAkun'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});




/*
    BUKALAPAK SECTION
    #
    #
    #
    #
    #
    #
    #
    #
    #

*/









$app->get('/getProduct', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['products'] = array();
    $result = $db->getProduct();
    if ($result != null) {
        $response['error'] = false;
        $response['products'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getProductById/:id', function ($id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['products'] = array();
    $result = $db->getProductById($id);
    if ($result != null) {
        $response['error'] = false;
        $response['products'] = $result[0];
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});



$app->get('/getProductReviewById/:product_id', function ($product_id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['reviews'] = array();
    $result = $db->getProductReviewById($product_id);
    if ($result != null) {
        $response['error'] = false;
        $response['reviews'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});









/*



END OF BUKALAPAK SECTION

*/






$app->get('/getlaundry/:laundry_id', function ($laundry_id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetLaundry($laundry_id);
    if ($result != null) {
        $response['error'] = false;
        $response['laundry'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getpesananbyaccount/:account_id', function ($id_pemesan) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetPesananbyAccount($id_pemesan);
    if ($result != null) {
        $response['error'] = false;
        $response['laundry'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getpesanandetailcustomer/:pesanan_id', function ($id_pesanan) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetPesananDetailCustomer($id_pesanan);
    if ($result != null) {
        $response['error'] = false;
        $response['laundry'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getpesanandetail/:pesanan_id', function ($id_pesanan) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetPesananDetail($id_pesanan);
    if ($result != null) {
        $response['error'] = false;
        $response['laundry'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getpesananbylaundry/:account_id', function ($id_laundry) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetPesananbyLaundry($id_laundry);
    if ($result != null) {
        $response['error'] = false;
        $response['laundry'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getunaccepted', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetUnaccepted();
    if ($result != null) {
        $response['error'] = false;
        $response['laundry'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getunacceptedlaundry', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->GetUnacceptedLaundry();
    if ($result != null) {
        $response['error'] = false;
        $response['account'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getunfinishedlaundry/:account_id', function ($account_id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['laundry'] = array();
    $result = $db->GetLaundrybyAccount($account_id);
    if ($result != null) {
        $response['error'] = false;
        $response['laundry'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getallaccount', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['listAkun'] = array();
    $result = $db->GetAllAccount();
    if ($result != null) {
        $response['error'] = "false";
        $response['listAkun'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/cancelpesanan', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_pesanan'));
    $id_pesanan = $app->request->post('id_pesanan');
    $response = array();
    $response['error'] = false;
    $result = $db->CancelPesanan($id_pesanan);
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/finishpesanan', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_pesanan'));
    $id_pesanan = $app->request->post('id_pesanan');
    $response = array();
    $response['error'] = false;
    $result = $db->FinishedPesanan($id_pesanan);
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/completepesanan', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_pesanan'));
    $id_pesanan = $app->request->post('id_pesanan');
    $response = array();
    $response['error'] = false;
    $result = $db->CompletePesanan($id_pesanan);
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/takenpesanan', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_pesanan'));
    $id_pesanan = $app->request->post('id_pesanan');
    $response = array();
    $response['error'] = false;
    $result = $db->TakenPesanan($id_pesanan);
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/acceptpesanan', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_pesanan', 'id_laundry'));
    $id_pesanan = $app->request->post('id_pesanan');
    $id_laundry = $app->request->post('id_laundry');
    $response = array();
    $response['error'] = false;
    $result = $db->AcceptedPesanan($id_pesanan, $id_laundry);
    if ($result != null) {
        if($result == "SUCCESS"){
            $response['error'] = false;
        } else {
            $response['error'] = true;
            $response['message'] = $result;
        }
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/placebid', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_pesanan', 'id_laundry', 'message', 'total_harga'));
    $id_pesanan = $app->request->post('id_pesanan');
    $id_laundry = $app->request->post('id_laundry');
    $message = $app->request->post('message');
    $total_harga = $app->request->post('total_harga');
    $response = array();
    $response['error'] = false;
    $result = $db->PlaceBid($id_pesanan, $id_laundry, $message, $total_harga);
    if ($result != null) {
        if($result == "SUCCESS"){
            $response['error'] = false;
        } else {
            $response['error'] = true;
            $response['message'] = $result;
        }
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getpesananbid/:id_pesanan', function ($id_pesanan) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->GetPesananBid($id_pesanan);
    if ($result != null) {
        $response['error'] = false;
        $response['bid'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->post('/acceptlaundry', function () use ($app) {
    $db = new DbHandler();
    verifyRequiredParams(array('id_account'));
    $id_account = $app->request->post('id_account');
    $response = array();
    $response['error'] = false;
    $result = $db->AcceptedLaundry($id_account);
    if ($result != null) {
        if($result == "SUCCESS"){
            $response['error'] = false;
        } else {
            $response['error'] = true;
            $response['message'] = $result;
        }
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getnotification/:account_id', function ($account_id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['notification'] = "";
    $result = $db->GetNotif($account_id);
    if ($result != null) {
        $response['error'] = false;
        $response['notification'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    echoRespnse(200, $response);
});

$app->get('/test', function () use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    echoRespnse(200, $response);
});




//WatchKids Start Here

$app->get('/getLogin/:username/:password', function ($username, $password) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->getLogin($username, $password);
    if ($result != null) {
        $response['error'] = false;
        $response['isExist'] = true;
        $response['profile'] = $result;
    } else {
        $response['error'] = true;
        $response['isExist'] = false;
    }
    echoRespnse(200, $response);
});


$app->get('/loginKids/:code', function ($code) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->loginKids($code);
    if ($result != null) {
        $response['error'] = false;
        //$response['isExist'] = true;
        $response['data_kids'] = $result;
    } else {
        $response['error'] = true;
        //$response['isExist'] = false;
    }
    echoRespnse(200, $response);
});

$app->get('/createKids/:parent_id/:first_name/:last_name/:address/:phone', function ($parent_id, $first_name, $last_name, $address, $phone) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->createKids($parent_id, $first_name, $last_name, $address, $phone);
    if ($result == true) {
        $response['error'] = false;
    } else {
        $response['error'] = true;
    }
    echoRespnse(200, $response);
});


// update location kids
$app->get('/updateLocationKids/:id/:latitude/:longitude/:updated', function ($id, $latitude, $longitude, $updated) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->updateLocationKids($id,$latitude, $longitude, $updated);
    if ($result == true) {
        $response['error'] = false;
        $response['status'] = $result;
    } else {
        $response['error'] = true;
       $response['status'] = $result;
    }
    echoRespnse(200, $response);
});

// update location orangtua
$app->get('/updateLocationParent/:id/:latitude/:longitude', function ($id, $latitude, $longitude) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->updateLocationParent($id,$latitude, $longitude);
    if ($result == true) {
        $response['error'] = false;
        $response['status'] = $result;
    } else {
        $response['error'] = true;
       $response['status'] = $result;
    }
    echoRespnse(200, $response);
});

$app->get('/createAturan/:parent_id/:kids_id/:start_time/:end_time/:latitude/:longitude', function ($parent_id, $kids_id, $start_time, $end_time, $latitude, $longitude) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->createAturan($parent_id, $kids_id, $start_time, $end_time, $latitude, $longitude);
    if ($result == true) {
        $response['error'] = false;
    } else {
        $response['error'] = true;
    }
    echoRespnse(200, $response);
});

//  create message
$app->get('/createMessage/:id_kids/:id_profile/:message/:time_created', function ($id_kids, $id_profile, $message, $time_created) use ($app) {
    $db = new DbHandler();
    $status = "Delivered";
    $response = array();
    $response['error'] = false;
    $result = $db->createMessage($id_kids,$id_profile, $message, $status, $time_created);
    //echo $result;
    if ($result != null) {
        $response['error'] = false;
    } else {
        $response['error'] = true;
      
    }
    echoRespnse(200, $response);
});


// obtain message by parent

$app->get('/getMessageByProfileId/:id_profile', function ($id_profile) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['data_message'] = array();
    $result = $db->getMessageByProfileId($id_profile);
    if ($result != null) {
        $response['error'] = false;
        $response['data_message'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getAturanByProfilId/:id_profile', function ($id_profile) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['data_limit'] = array();
    $result = $db->getAturanByProfilId($id_profile);
    if ($result != null) {
        $response['error'] = false;
        $response['data_limit'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getAturanByKidsId/:id_profile', function ($id_kids) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['data_limit'] = array();
    $result = $db->getAturanByKidsId($id_kids);
    if ($result != null) {
        $response['error'] = false;
        $response['data_limit'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getKidsLocationByProfileId/:id_profile', function ($id_profile) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['data_kids'] = array();
    $result = $db->getKidsLocationByProfileId($id_profile);
    if ($result != null) {
        $response['error'] = false;
        $response['data_kids'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/getAllKidsByProfileId/:id_profile', function ($id_profile) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['data_kids'] = array();
    $result = $db->getAllKidsByProfileId($id_profile);
    if ($result != null) {
        $response['error'] = false;
        $response['data_kids'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});

$app->get('/panic/:id', function ($id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->panic($id);
    if ($result == true) {
        $response['error'] = false;
        $response['status'] = $result;
    } else {
        $response['error'] = true;
       $response['status'] = $result;
    }
    echoRespnse(200, $response);
});

$app->get('/unpanic/:id', function ($id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $result = $db->unpanic($id);
    if ($result == true) {
        $response['error'] = false;
        $response['status'] = $result;
    } else {
        $response['error'] = true;
       $response['status'] = $result;
    }
    echoRespnse(200, $response);
});

$app->get('/getParentsLocationByKidsId/:id_profile', function ($id_kids) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['profile'] = array();
    $result = $db->getParentsLocationByKidsId($id_kids);
    if ($result != null) {
        $response['error'] = false;
        $response['profile'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});











$app->get('/getaccount/:account_id', function ($account_id) use ($app) {
    $db = new DbHandler();
    $response = array();
    $response['error'] = false;
    $response['account'] = array();
    $result = $db->TakenLaundry($account_id);
    if ($result != null) {
        $response['error'] = false;
        $response['account'] = $result;
    } else {
        $response['error'] = "true";
    }
    echoRespnse(200, $response);
});
/**
        * Verifying required params posted or not
        */
        function verifyRequiredParams($required_fields) {
            $error = false;
            $error_fields = "";
            $request_params = array();
            $request_params = $_REQUEST;
            // Handling PUT request params
            if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
                $app = \Slim\Slim::getInstance();
                parse_str($app->request()->getBody(), $request_params);
            }
            foreach ($required_fields as $field) {
                if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
                    $error = true;
                    $error_fields .= $field . ', ';
                }
            }
            if ($error) {
                // Required field(s) are missing or empty
                // echo error json and stop the app
                $response = array();
                $app = \Slim\Slim::getInstance();
                $response["error"] = true;
                $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
                echoRespnse(400, $response);
                $app->stop();
            }
        }


/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 * Daftar response
 * 200	OK
 * 201	Created
 * 304	Not Modified
 * 400	Bad Request
 * 401	Unauthorized
 * 403	Forbidden
 * 404	Not Found
 * 422	Unprocessable Entity
 * 500	Internal Server Error
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

	//print_r($response);
    echo json_encode($response);
}


$app->run();
?>