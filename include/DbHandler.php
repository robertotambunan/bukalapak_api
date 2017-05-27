<?php

class DbHandler {
 
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }



    //WatchKids



    public function getLogin($username, $password){
        $ret = array();
        $query = "SELECT * FROM account WHERE username= '$username' and password = '$password'";
        $result = $this->conn->query($query);

        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $ids = $tmp["id"];
            if($ids!=null){
                $query1 = "SELECT * FROM profile WHERE id_account= '$ids'";
                $result1 = $this->conn->query($query1);
                while ($task1 = $result1->fetch_assoc()) {
                    $tmp1 = array();
                    $tmp1["id_profile"] = $task1["id"];
                    $tmp1["first_name"] = $task1["first_name"];
                    $tmp1["last_name"] = $task1["last_name"];
                    $tmp1["address"] = $task1["address"];
                    $tmp1["phone"] = $task1["phone"];
                    $tmp1["email"] = $task1["email"];
                    $tmp1["latitude"] = $task1["latitude"];
                    $tmp1["longitude"] = $task1["longitude"];
                    array_push($ret, $tmp1);
                }
         }
           // array_push($ret, $tmp);
        }
        

        return $ret;

    }

    public function createKids($parent_id, $first_name, $last_name, $address, $phone){
        $random = rand(0, 9999999);
        $code = "".$random;
        $query = "INSERT INTO kids (parent_id, first_name, last_name, address, phone, latitude, longitude, code, active, panic) VALUES ('$parent_id', '$first_name', '$last_name', '$address', '$phone', 0, 0, $code, 0,0 )";
        if ($this->conn->query($query) === true) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

  
     public function updateLocationKids($id,$latitude,$longitude, $updated){
        
        $query = "UPDATE kids SET kids.longitude= '$longitude', kids.latitude='$latitude', updated='$updated' WHERE kids.id = '$id'";
        if($this->conn->query($query) === TRUE){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    
    public function updateLocationParent($id,$latitude,$longitude){
        
        $query = "UPDATE profile SET profile.longitude= '$longitude', profile.latitude='$latitude' WHERE profile.id = '$id'";

        if($this->conn->query($query) === TRUE){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function createAturan($parent_id, $kids_id, $start_time, $end_time,  $latitude, $longitude){
        $radius = 1;
        $status = 1;
        //echo $parent_id." ". $kids_id." ".$start_time." ".$end_time." ".$latitude." ".$longitude." ". $radius;
     
        $query = "INSERT INTO bukuresep.limit (parent_id, kids_id, start_time, end_time, longitude, latitude, radius, status) VALUES ('$parent_id', '$kids_id', '$start_time', '$end_time', '$longitude',$latitude, $radius, $status)";
        if ($this->conn->query($query) === true) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function getAturanByProfilId($id_profile){
        $ret = array();
        $query = "SELECT * FROM bukuresep.limit WHERE parent_id = '$id_profile' and status = 1 ORDER BY id_limit DESC";
        $result = $this->conn->query($query);

        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id_limit"] = $task["id_limit"];
            $tmp["kids_id"] = $task["kids_id"];
            $id_kids = $tmp["kids_id"];

            $query = "SELECT kids.first_name FROM kids WHERE kids.id= '$id_kids'";
            $result2 = $this->conn->query($query);
            $task2 = $result2->fetch_assoc();
            $tmp["kids_firstname"] = $task2["first_name"];

            $tmp["parent_id"] = $task["parent_id"];
            $id_profile = $tmp["parent_id"];

            $query = "SELECT profile.first_name FROM profile WHERE profile.id= '$id_profile'";
            $result2 = $this->conn->query($query);
            $task2 = $result2->fetch_assoc();
            $tmp["profile_firstname"] = $task2["first_name"];
            
            $tmp["start_time"] = $task["start_time"];
            $tmp["end_time"] = $task["end_time"];
            $tmp["longitude"] = $task["longitude"];
            $tmp["latitude"] = $task["latitude"];
            $tmp["radius"] = $task["radius"];
            $tmp["status"] = $task["status"];
            array_push($ret, $tmp);
     
        }
   

        return $ret;

    }

    public function getAturanByKidsId($id_kids){
        $ret = array();
        $query = "SELECT * FROM bukuresep.limit WHERE kids_id = '$id_kids' and status = 1 ORDER BY id_limit DESC";
        $result = $this->conn->query($query);

        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id_limit"] = $task["id_limit"];
            $tmp["kids_id"] = $task["kids_id"];
            $id_kids = $tmp["kids_id"];

            $query = "SELECT kids.first_name FROM kids WHERE kids.id= '$id_kids'";
            $result2 = $this->conn->query($query);
            $task2 = $result2->fetch_assoc();
            $tmp["kids_firstname"] = $task2["first_name"];

            $tmp["parent_id"] = $task["parent_id"];
            $id_profile = $tmp["parent_id"];

            $query = "SELECT profile.first_name FROM profile WHERE profile.id= '$id_profile'";
            $result2 = $this->conn->query($query);
            $task2 = $result2->fetch_assoc();
            $tmp["profile_firstname"] = $task2["first_name"];
            
            $tmp["start_time"] = $task["start_time"];
            $tmp["end_time"] = $task["end_time"];
            $tmp["longitude"] = $task["longitude"];
            $tmp["latitude"] = $task["latitude"];
            $tmp["radius"] = $task["radius"];
             $tmp["status"] = $task["status"];
            array_push($ret, $tmp);
     
        }
   

        return $ret;

    }

    public function loginKids($code){
        $ret = array();
        $query = "SELECT * FROM kids WHERE code = '$code'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["parent_id"] = $task["parent_id"];
            $tmp["first_name"] = $task["first_name"];
            $tmp["last_name"] = $task["last_name"];
            $tmp["address"] = $task["address"];
            $tmp["phone"] = $task["phone"];
            $tmp["code"] = $task["code"];
            $tmp["latitude"] = $task["latitude"];
            $tmp["longitude"] = $task["longitude"];
            $tmp["active"] = $task["active"];
            $tmp["panic"] = $task["panic"];
            $tmp["updated"] = $task["updated"];
            $ids = $tmp["id"] ;
            
            array_push($ret, $tmp);

            $querys = "UPDATE kids SET active= 1 WHERE id = '$ids'";
            if($this->conn->query($querys) === TRUE){
                $results = true;
            } else {
                $results = false;
                $ret = array();
            }
            
            
         }
           // array_push($ret, $tmp);
        return $ret;
    }

    public function createMessage($id_kids,$id_profile,$message,$status,$time_created){

        $query = "INSERT INTO message (id_kids,id_profile,message,status,time_created) VALUES ('$id_kids', '$id_profile', '$message', '$status', '$time_created')";

        if ($this->conn->query($query) === TRUE) {
            //$result = "SUCCESS";
        } else {
            //$result = "";
        }
        return $result;

    }

    public function getMessageByProfileId($id_profile) {
        $ret = array();
        $query = "SELECT * FROM message WHERE message.id_profile = '$id_profile' ORDER BY id DESC";
        $result = $this->conn->query($query);
        //var_dump($result);
        $t=0;

        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["id_kids"] = $task["id_kids"];
            $id_kids = $tmp["id_kids"];

            $query = "SELECT kids.first_name FROM kids WHERE kids.id= '$id_kids'";
            $result2 = $this->conn->query($query);
            $task2 = $result2->fetch_assoc();
            $tmp["kids_firstname"] = $task2["first_name"];

            $tmp["id_profile"] = $task["id_profile"];
            $id_profile = $tmp["id_profile"];

            $query = "SELECT profile.first_name FROM profile WHERE profile.id= '$id_profile'";
            $result2 = $this->conn->query($query);
            $task2 = $result2->fetch_assoc();
            $tmp["profile_firstname"] = $task2["first_name"];
            
            $tmp["message"] = $task["message"];
            $tmp["status"] = $task["status"];
            $tmp["time_created"] = $task["time_created"];
            array_push($ret, $tmp);
            $t=1;
        }
        if($t==1){
             $querys = "UPDATE message SET status= 'Read' WHERE id_profile = '$id_profile'";
                if($this->conn->query($querys) === TRUE){
                    $results = true;
                } else {
                    $results = false;
                    $ret = array();
                }
        }

        return $ret;
    }

    public function getKidsLocationByProfileId($id_profile) {
        $ret = array();
        $query = "SELECT * FROM kids WHERE parent_id = '$id_profile' ORDER BY id DESC";
        $result = $this->conn->query($query);
        //var_dump($result);

        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["latitude"] = $task["latitude"];
            $tmp["longitude"] = $task["longitude"];
            $tmp["updated"] = $task["updated"];
            array_push($ret, $tmp);
           
        }
        return $ret;
    }

    public function getAllKidsByProfileId($id_profile) {
        $ret = array();
        $query = "SELECT * FROM kids WHERE parent_id = '$id_profile' ORDER BY id DESC";
        $result = $this->conn->query($query);
        //var_dump($result);

        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["parent_id"] = $task["parent_id"];
            $tmp["first_name"] = $task["first_name"];
            $tmp["last_name"] = $task["last_name"];
            $tmp["address"] = $task["address"];
            $tmp["phone"] = $task["phone"];
            $tmp["code"] = $task["code"];
            $tmp["latitude"] = $task["latitude"];
            $tmp["longitude"] = $task["longitude"];
            $tmp["active"] = $task["active"];
            $tmp["panic"] = $task["panic"];
            $tmp["updated"] = $task["updated"];
            array_push($ret, $tmp);
           
        }
        return $ret;
    }

    public function panic($id_kids){
        $query = "UPDATE kids SET panic = 1 WHERE id = '$id_kids'";
        if($this->conn->query($query) === TRUE){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function unpanic($id_kids){
        $query = "UPDATE kids SET panic = 0 WHERE id = '$id_kids'";
        if($this->conn->query($query) === TRUE){
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function getParentsLocationByKidsId($id_kids) {
        $ret = array();

        $querys = "SELECT * FROM kids WHERE id = '$id_kids' ORDER BY id DESC";
        $results = $this->conn->query($querys);
        //var_dump($result);

        while ($tasks = $results->fetch_assoc()) {
            $tmps = array();
            $id_profile = $tasks["parent_id"];
            //$tmp["updated"] = $task["updated"];
          
            $query = "SELECT * FROM profile WHERE id = '$id_profile' ORDER BY id DESC";
            $result = $this->conn->query($query);
            //var_dump($result);

            while ($task = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $task["id"];
                $tmp["latitude"] = $task["latitude"];
                $tmp["longitude"] = $task["longitude"];
                //$tmp["updated"] = $task["updated"];
                array_push($ret, $tmp);
               
            }   
        
        }

        
        return $ret;
    }







    public function GetAllRequestLaundry() {
        $ret = array();
        $query = "SELECT * FROM account where role = '1' and pending = '1'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["nama"] = $task["nama"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["no_telp"] = $task["no_telp"];
            if($task["pending"] == '0'){
                $tmp["pending"] = 'sukses';
            } else {
                $tmp["pending"] = 'pending';
            }
            array_push($ret, $tmp);
        }
        return $ret;
    }

    public function AcceptRequestLaundry($id) {
        $query = "UPDATE account set account.pending = '0' WHERE id = '$id'";
        if($this->conn->query($query) === TRUE){
            $result = "SUCCESS";
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function CreateNewPesanan($alamat, $id_pemesan, $total_1, $total_2, $total_3, $total_harga) {
        $date_time = date("Y-m-d H:i:s");
        $query = "INSERT INTO pesanan (alamat, tanggal_pesan, id_pemesan, total_harga) VALUES ('$alamat', '$date_time', '$id_pemesan', $total_harga)";
        if ($this->conn->query($query) === TRUE) {
            $id_pesanan = $this->GetPesananId($id_pemesan, $date_time);
            $this->CreateDetailPesanan($id_pesanan, $id_pemesan, 1, $total_1);
            $this->CreateDetailPesanan($id_pesanan, $id_pemesan, 2, $total_2);
            $this->CreateDetailPesanan($id_pesanan, $id_pemesan, 3, $total_3);
            $result = "SUCCESS";
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function GetPesananId($id_pemesan, $date_time) {
        $query = "SELECT id FROM pesanan WHERE pesanan.id_pemesan = '$id_pemesan' AND pesanan.tanggal_pesan = '$date_time'";
        $result = $this->conn->query($query);
        $task = $result->fetch_assoc();
        return $task["id"];
    }
    
    public function CreateDetailPesanan($id_pesanan, $id_pemesan, $id, $total) {
        $harga = $this->GetUnitPrice($id);
        $total_harga = $harga * $total;
        $query = "INSERT INTO pesanan_laundry (id_pesanan, id_pemesan, jenis, jumlah, harga) VALUES ('$id_pesanan', '$id_pemesan', '$id', $total, $total_harga)";
        if ($this->conn->query($query) === TRUE) {
            $result = "SUCCESS";
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function GetUnitPrice($id) {
        $query = "SELECT harga FROM jenis_laundry WHERE id = '$id'";
        $result = $this->conn->query($query);
        $task = $result->fetch_assoc();
        return $task["harga"];
    }
    
    public function GetPriceandType($jenis_id, $amount){
        $ret = array();
        $query = "SELECT * FROM jenis_laundry where id = '$jenis_id'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $ret["type"] = $task["satuan"];
            $ret["price"] = $amount * $task["harga"];
        }
        return $ret;
    }
    
    public function Login($id_facebook) {
        $query = "SELECT * FROM account WHERE account.id_facebook = '$id_facebook'";
        $result = $this->conn->query($query);
        $tmp = array();
        while ($task = $result->fetch_assoc()) {
            $tmp["id"] = $task["id"];
            $tmp["nama"] = $task["nama"];
            $tmp["alamat"] = $task["alamat"];
            if($task["role"] == '0'){
                $tmp["role"] = 'customer';
            }
            else if($task["role"] == '2'){
                $tmp["role"] = 'admin';
            }
            else {
                $tmp["role"] = 'laundry';
            }
            $tmp["no_telp"] = $task["no_telp"];
            $tmp["id_facebook"] = $task["id_facebook"];
            if($task["pending"] == '0'){
                $tmp["pending"] = 'sukses';
            } else {
                $tmp["pending"] = 'pending';
            }
        }
        return $tmp;
    }
    
    public function Register($nama, $alamat, $no_telp, $role, $id_facebook) {
        $index = 0;
        if($role == 'Customer'){
            $role = 0;
            $pending = 0;
        } else {
            $role = 1;
            $pending = 1;
        }
        $query = "INSERT INTO account (nama, alamat, no_telp, role, id_facebook, pending) VALUES ('$nama', '$alamat', '$no_telp', '$role', '$id_facebook', '$pending')";
        if ($this->conn->query($query) === TRUE) {
            $akun = $this->Login($id_facebook);
            $id = $akun['id'];
            $query1 = "INSERT INTO notification (account_id) VALUES ('$id')";
            if($this->conn->query($query1) === TRUE){
                $result = "SUCCESS"; 
            }
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function GetAllLaundry() {
        $ret = array();
        $query = "SELECT * FROM account where role = '1' and pending = '0'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["nama"] = $task["nama"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["no_telp"] = $task["no_telp"];
            if($task["pending"] == '0'){
                $tmp["pending"] = 'sukses';
            } else {
                $tmp["pending"] = 'pending';
            }
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetAllAccount() {
        $ret = array();
        $index = 0;
        $query = "SELECT * FROM account";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["nama"] = $task["nama"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["no_telp"] = $task["no_telp"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetLaundry($laundry_id) {
        $ret = array();
        $index = 0;
        $query = "SELECT * FROM laundry WHERE laundry.id = '$laundry_id'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["tanggal_masuk"] = $task["tanggal_masuk"];
            $tmp["tanggal_keluar"] = $task["tanggal_keluar"];
            $tmp["jenis"] = $task["jenis"];
            $tmp["kiloan"] = $task["kiloan"];
            $tmp["pcs"] = $task["pcs"];
            $tmp["prices"] = $task["prices"];
            $tmp["account_id"] = $task["account_id"];
            $tmp["finished"] = $task["finished"];
            $tmp["taken"] = $task["taken"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetPesananbyAccount($id_pemesan) {
        $ret = array();
        $query = "SELECT * FROM pesanan WHERE pesanan.id_pemesan = '$id_pemesan' ORDER BY pesanan.tanggal_pesan DESC";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["tanggal_pesan"] = $task["tanggal_pesan"];
            $tmp["tanggal_diterima"] = $task["tanggal_diterima"];
            $tmp["tanggal_diambil"] = $task["tanggal_diambil"];
            $tmp["tanggal_selesai"] = $task["tanggal_selesai"];
            if($task["id_laundry"] != ''){
                $tmp["laundry"] = $this->GetAccountNamebyId($task["id_laundry"]);
            } else {
                $tmp["laundry"] = $task["id_laundry"];
            }
            $tmp["total_harga"] = $task["total_harga"];
            $tmp["accepted"] = $task["accepted"];
            $tmp["taken"] = $task["taken"];
            $tmp["finished"] = $task["finished"];
            $tmp["complete"] = $task["complete"];
            $tmp["cancel"] = $task["cancel"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetPesananDetailCustomer($id_pesanan) {
        $ret = array();
        $query = "SELECT * FROM pesanan WHERE pesanan.id = '$id_pesanan'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["tanggal_pesan"] = $task["tanggal_pesan"];
            $tmp["tanggal_diterima"] = $task["tanggal_diterima"];
            $tmp["tanggal_diambil"] = $task["tanggal_diambil"];
            $tmp["tanggal_selesai"] = $task["tanggal_selesai"];
            if($task["id_laundry"] != ''){
                $tmp["laundry"] = $this->GetAccountNamebyId($task["id_laundry"]);
            } else {
                $tmp["laundry"] = $task["id_laundry"];
            }
            $tmp["total_harga"] = $task["total_harga"];
            $tmp["accepted"] = $task["accepted"];
            $tmp["taken"] = $task["taken"];
            $tmp["finished"] = $task["finished"];
            $tmp["complete"] = $task["complete"];
            $tmp["cancel"] = $task["cancel"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetPesananDetail($id_pesanan) {
        $ret = array();
        $query = "SELECT * FROM pesanan WHERE pesanan.id = '$id_pesanan'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["tanggal_pesan"] = $task["tanggal_pesan"];
            $tmp["tanggal_diterima"] = $task["tanggal_diterima"];
            $tmp["tanggal_diambil"] = $task["tanggal_diambil"];
            $tmp["tanggal_selesai"] = $task["tanggal_selesai"];
            $tmp["pemesan"] = $this->GetAccountNamebyId($task["id_pemesan"]);
            $tmp["total_harga"] = $task["total_harga"];
            $tmp["accepted"] = $task["accepted"];
            $tmp["taken"] = $task["taken"];
            $tmp["finished"] = $task["finished"];
            $tmp["complete"] = $task["complete"];
            $tmp["cancel"] = $task["cancel"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetPesananbyLaundry($id_laundry) {
        $ret = array();
        $query = "SELECT * FROM pesanan WHERE pesanan.id_laundry = '$id_laundry' ORDER BY pesanan.tanggal_pesan DESC";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["tanggal_pesan"] = $task["tanggal_pesan"];
            $tmp["tanggal_diterima"] = $task["tanggal_diterima"];
            $tmp["tanggal_diambil"] = $task["tanggal_diambil"];
            $tmp["tanggal_selesai"] = $task["tanggal_selesai"];
            $tmp["pemesan"] = $this->GetAccountNamebyId($task["id_pemesan"]);
            $tmp["accepted"] = $task["accepted"];
            $tmp["taken"] = $task["taken"];
            $tmp["finished"] = $task["finished"];
            $tmp["complete"] = $task["complete"];
            $tmp["cancel"] = $task["cancel"];
            array_push($ret, $tmp);
        }
        $query = "SELECT * FROM sub_pesanan WHERE sub_pesanan.id_laundry = '$id_laundry' AND sub_pesanan.status = 1";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $query      = "SELECT * FROM pesanan WHERE pesanan.id LIKE '$task[id_pesanan]' ";
            $resultsec  = $this->conn->query($query);
            while ($task = $resultsec->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $task["id"];
                $tmp["alamat"] = $task["alamat"];
                $tmp["tanggal_pesan"] = $task["tanggal_pesan"];
                $tmp["tanggal_diterima"] = $task["tanggal_diterima"];
                $tmp["tanggal_diambil"] = $task["tanggal_diambil"];
                $tmp["tanggal_selesai"] = $task["tanggal_selesai"];
                $tmp["pemesan"] = $this->GetAccountNamebyId($task["id_pemesan"]);
                $tmp["accepted"] = $task["accepted"];
                $tmp["taken"] = $task["taken"];
                $tmp["finished"] = $task["finished"];
                $tmp["complete"] = $task["complete"];
                $tmp["cancel"] = $task["cancel"];
                array_push($ret, $tmp);
            }
        }
        return $ret;
    }
    
    public function GetUnaccepted() {
        $ret = array();
        $query = "SELECT * FROM pesanan WHERE pesanan.accepted = '0' AND pesanan.cancel <> '1' ORDER BY pesanan.tanggal_pesan DESC";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["tanggal_pesan"] = $task["tanggal_pesan"];
            $tmp["tanggal_diterima"] = $task["tanggal_diterima"];
            $tmp["tanggal_diambil"] = $task["tanggal_diambil"];
            $tmp["tanggal_selesai"] = $task["tanggal_selesai"];
            $tmp["pemesan"] = $this->GetAccountNamebyId($task["id_pemesan"]);
            $tmp["total_harga"] = $task["total_harga"];
            $tmp["accepted"] = $task["accepted"];
            $tmp["taken"] = $task["taken"];
            $tmp["finished"] = $task["finished"];
            $tmp["complete"] = $task["complete"];
            $tmp["cancel"] = $task["cancel"];
            $detail = $this->GetDetailPesanan($tmp["id"]);
            $tmp["total_1"] = $detail["total_1"];
            $tmp["total_2"] = $detail["total_2"];
            $tmp["total_3"] = $detail["total_3"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetDetailPesanan($id_pesanan){
        $query = "SELECT * FROM pesanan_laundry WHERE pesanan_laundry.id_pesanan = '$id_pesanan'";
        $result = $this->conn->query($query);
        $tmp = array();
        $tmp["total_1"] = $result->fetch_assoc()["jumlah"];
        $tmp["total_2"] = $result->fetch_assoc()["jumlah"];
        $tmp["total_3"] = $result->fetch_assoc()["jumlah"];
        return $tmp;
    }
    
     public function GetUnacceptedLaundry() {
        $ret = array();
        $query = "SELECT * FROM account WHERE account.role = '1' AND account.pending = '1'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["nama"] = $task["nama"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["no_telp"] = $task["no_telp"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetAccountNamebyId($account_id){
        $query = "SELECT nama FROM account WHERE account.id = '$account_id'";
        $result = $this->conn->query($query);
        $task = $result->fetch_assoc();
        return $task["nama"];
    }
    
    public function GetUnfinishedLaundry($account_id) {
        $ret = array();
        $index = 0;
        $query = "SELECT * FROM laundry WHERE laundry.account_id = '$account_id' AND laundry.finished = '0'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["tanggal_masuk"] = $task["tanggal_masuk"];
            $tmp["tanggal_keluar"] = $task["tanggal_keluar"];
            $tmp["jenis"] = $task["jenis"];
            $tmp["kiloan"] = $task["kiloan"];
            $tmp["pcs"] = $task["pcs"];
            $tmp["prices"] = $task["prices"];
            $tmp["account_id"] = $task["account_id"];
            $tmp["finished"] = $task["finished"];
            $tmp["taken"] = $task["taken"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetAccount($account_id) {
        $ret = array();
        $index = 0;
        $query = "SELECT * FROM account WHERE account.id = '$account_id'";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["nama"] = $task["nama"];
            $tmp["alamat"] = $task["alamat"];
            $tmp["no_telp"] = $task["no_telp"];
            $tmp["role"] = $task["role"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function GetPemesanIdbyPesanan($id_pesanan){
        $query = "SELECT id_pemesan FROM pesanan WHERE pesanan.id = '$id_pesanan'";
        $result = $this->conn->query($query);
        $ret = "";
        while ($task = $result->fetch_assoc()) {
            $ret = $task['id_pemesan'];
        }
        return $ret;
    }
    
    public function GetNotif($account_id){
        $query = "SELECT notif, message FROM notification WHERE account_id = '$account_id'";
        $result = $this->conn->query($query);
        $ret = array();
        while ($task = $result->fetch_assoc()) {
            $query1 = "UPDATE notification SET notif = '0', message = '' WHERE account_id = '$account_id'";
            if($this->conn->query($query1) === true){
                $ret['notif'] = $task['notif'];
                $ret['message'] = $task['message'];
            }
        }
        return $ret;
    }
    
    public function SetNotif($id_pesanan, $message){
        $id = $this->GetPemesanIdbyPesanan($id_pesanan);
        $query = "UPDATE notification SET notif = '1', message = '$message' WHERE account_id = '$id'";
        $result = "";
        if ($this->conn->query($query) === TRUE) {
            $result = "SUCCESS";
        }
        return $result;
    }
    
    public function SetNotifLaundry($id_pesanan, $message){
        $id = $this->GetLaundryIdbyPesanan($id_pesanan);
        $query = "UPDATE notification SET notif = '1', message = '$message' WHERE account_id = '$id'";
        $result = "";
        if ($this->conn->query($query) === TRUE) {
            $result = "SUCCESS";
        }
        return $result;
    }
    
    public function SetNotifByLaundryId($id_laundry, $message){
        $query = "UPDATE notification SET notif = '1', message = '$message' WHERE account_id = '$id_laundry'";
        $result = "";
        if ($this->conn->query($query) === TRUE) {
            $result = "SUCCESS";
        }
        return $result;
    }
    
    public function FinishedPesanan($id_pesanan) {
        $date_time = date("Y-m-d H:i:s");
        $query = "UPDATE pesanan set pesanan.finished = '1', pesanan.tanggal_selesai = '$date_time' WHERE pesanan.id = '$id_pesanan'";
        if($this->conn->query($query) === TRUE){
            $nama_laundry = $this->GetAccountNamebyId($this->GetLaundryIdbyPesanan($id_pesanan));
            $hasil = $this->SetNotif($id_pesanan, "Laundry anda telah diantar oleh " . $nama_laundry);
            if($hasil != NULL){
                $result = "SUCCESS";
            } else {
                $result = "";
            }
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function TakenPesanan($id_pesanan) {
        $date_time = date("Y-m-d H:i:s");
        $query = "UPDATE pesanan set pesanan.taken = '1', pesanan.tanggal_diambil = '$date_time' WHERE pesanan.id = '$id_pesanan'";
        if($this->conn->query($query) === TRUE){
            $nama_laundry = $this->GetAccountNamebyId($this->GetLaundryIdbyPesanan($id_pesanan));
            $hasil = $this->SetNotif($id_pesanan, "Laundry anda telah dijemput oleh " . $nama_laundry);
            if($hasil != NULL){
                $result = "SUCCESS";
            } else {
                $result = "";
            }
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function CompletePesanan($id_pesanan) {
        $date_time = date("Y-m-d H:i:s");
        $query = "UPDATE pesanan set pesanan.complete = '1' WHERE pesanan.id = '$id_pesanan'";
        if($this->conn->query($query) === TRUE){
            $result = "SUCCESS";
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function GetLaundryIdbyPesanan($id_pesanan){
        $query = "SELECT id_laundry FROM pesanan WHERE pesanan.id = '$id_pesanan'";
        $result = $this->conn->query($query);
        $ret = "";
        while ($task = $result->fetch_assoc()) {
            $ret = $task['id_laundry'];
        }
        return $ret;
    }
    
    public function AcceptedPesanan($id_pesanan, $id_laundry) {
        $date_time = date("Y-m-d H:i:s");
        if($this->CheckPesanan($id_pesanan) == 0){
            $query = "UPDATE pesanan set pesanan.accepted = '1', pesanan.tanggal_diterima = '$date_time', pesanan.id_laundry = '$id_laundry' WHERE pesanan.id = '$id_pesanan'";
            if($this->conn->query($query) === TRUE){
                if($this->CleanBid($id_pesanan, $id_laundry) == 1){
                    $result = 'SUCCESS';
                } else {
                    $result = '';
                }
            } else {
                $result = "";
            }
        } else {
            $result = "Pesanan sudah diterima laundry lain";
        }
        return $result;
    }
    
    public function CleanBid($id_pesanan, $id_laundry) {
        $query = "SELECT sub_pesanan.id, sub_pesanan.id_laundry FROM sub_pesanan WHERE sub_pesanan.id_pesanan = '$id_pesanan'";
        $result = $this->conn->query($query);
        $nama_pemesan = $this->GetAccountNamebyId($this->GetPemesanIdbyPesanan($id_pesanan));
        while ($task = $result->fetch_assoc()) {
            $id = $task['id'];
            if($task["id_laundry"] == $id_laundry){
                $this->SetNotifByLaundryId($task["id_laundry"], "Tawaran anda diterima oleh " . $nama_pemesan);
                $query2 = "UPDATE sub_pesanan SET status = '2' WHERE sub_pesanan.id = '$id'";
            } else {
                $this->SetNotifByLaundryId($task["id_laundry"], "Tawaran anda ditolak oleh " . $nama_pemesan);
                $query2 = "UPDATE sub_pesanan SET status = '0' WHERE sub_pesanan.id = '$id'";
            }
            if($this->conn->query($query2) === TRUE){
                $ret = 1;
            } else {
                $ret = '';
            }
        }
        return $ret;
    }
    
    public function PlaceBid($id_pesanan, $id_laundry, $message, $total_harga) {
        $query = "INSERT INTO sub_pesanan (id_pesanan, id_laundry, message, total_harga) VALUES ('$id_pesanan', '$id_laundry', '$message', '$total_harga')";
        if($this->conn->query($query) === TRUE){
            $result = "SUCCESS";
            $nama_laundry = $this->GetAccountNamebyId($id_laundry);
            $this->SetNotif($id_pesanan, "Pesanan laundry anda ditawar oleh " . $nama_laundry);
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function GetPesananBid($id_pesanan) {
        $query = "SELECT * FROM sub_pesanan WHERE sub_pesanan.id_pesanan = '$id_pesanan'";
        $result = $this->conn->query($query);
        $ret = array();
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["laundry"] = $this->GetAccountNamebyId($task["id_laundry"]);
            $tmp["id_laundry"] = $task["id_laundry"];
            $tmp["id_pesanan"] = $task["id_pesanan"];
            $tmp["message"] = $task["message"];
            $tmp["total_harga"] = $task["total_harga"];
            $tmp["status"] = $task["status"];
            array_push($ret, $tmp);
        }
        return $ret;
    }
    
    public function AcceptedLaundry($id_account) {
        $query = "UPDATE account set account.pending = '0' WHERE account.id = '$id_account'";
        if($this->conn->query($query) === TRUE){
            $query = "UPDATE notification SET notif = '1', message = 'Akun anda telah diterima' WHERE account_id = '$id_account'";
            $result = "";
            if ($this->conn->query($query) === TRUE) {
                $result = "SUCCESS";
            } else {
                $result = "";
            }
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function CancelPesanan($id_pesanan) {
        $query = "UPDATE pesanan set pesanan.cancel = '1' WHERE pesanan.id = '$id_pesanan'";
        if($this->conn->query($query) === TRUE){
            if($this->CheckPesanan($id_pesanan) == 0){
                $nama_pemesan = $this->GetAccountNamebyId($this->GetPemesanIdbyPesanan($id_pesanan));
                $this->SetNotifLaundry($id_pesanan, "Laundry dibatalkan oleh " . $nama_pemesan);
            }
            $result = "SUCCESS";
        } else {
            $result = "";
        }
        return $result;
    }
    
    public function CheckPesanan($id_pesanan){
        $query = "SELECT id_laundry FROM pesanan WHERE pesanan.id = '$id_pesanan'";
        $result = $this->conn->query($query);
        $task = $result->fetch_assoc();
        if($task != null) {
            $result = 0;
        } else {
            $result = 1;
        }
        return $result;
    }



    /*

    THIS IS FOR BUKALAPAK














    

    */

    public function getProduct() {
        $ret = array();
        $query = "SELECT * FROM products";
        $result = $this->conn->query($query);
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["name"] = $task["name"];
            $tmp["city"] = $task["city"];
            $tmp["province"] = $task["province"];
            $tmp["weight"] = $task["weight"];
            $tmp["images"] = $task["images"];
            $tmp["small_images"] = $task["small_images"];
            $tmp["description"] = $task["description"];
            $tmp["condition"] = $task["condition"];
            $tmp["stock"] = $task["stock"];
            $tmp["favorited"] = $task["favorited"];
            $tmp["created_at"] = $task["created_at"];
            $tmp["updated_at"] = $task["updated_at"];
            $tmp["seller_username"] = $task["seller_username"];
            $tmp["seller_name"] = $task["seller_name"];
            $tmp["seller_id"] = $task["seller_id"];
            $tmp["seller_avatar"] = $task["seller_avatar"];
            $tmp["seller_level"] = $task["seller_level"];
            $tmp["seller_level_badge_url"] = $task["seller_level_badge_url"];
            $tmp["seller_delivery_time"] = $task["seller_delivery_time"];
            $tmp["seller_positive_feedback"] = $task["seller_positive_feedback"];
            $tmp["seller_negative_feedback"] = $task["seller_negative_feedback"];
            $tmp["seller_term_condition"] = $task["seller_term_condition"];
            $tmp["top_merchant"] = $task["top_merchant"];
            $tmp["average_rate"] = $task["average_rate"];
            $tmp["features"] = array();
            $temps = array();
            $temps["category"]= "Baterai";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_batery.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);
            $temps["category"]= "Lensa";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_lensa.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);
            $temps["category"]= "Package";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_package.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);
            $temps["category"]= "Go Pro";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_gopro.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);
            
            array_push($ret, $tmp);
        }
        return $ret;
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = '$id'";
        $result = $this->conn->query($query);
        $ret = array();
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["name"] = $task["name"];
            $tmp["city"] = $task["city"];
            $tmp["province"] = $task["province"];
            $tmp["weight"] = $task["weight"];
            $tmp["images"] = $task["images"];
            $tmp["small_images"] = $task["small_images"];
            $tmp["description"] = $task["description"];
            $tmp["condition"] = $task["condition"];
            $tmp["stock"] = $task["stock"];
            $tmp["favorited"] = $task["favorited"];
            $tmp["created_at"] = $task["created_at"];
            $tmp["updated_at"] = $task["updated_at"];
            $tmp["seller_username"] = $task["seller_username"];
            $tmp["seller_name"] = $task["seller_name"];
            $tmp["seller_id"] = $task["seller_id"];
            $tmp["seller_avatar"] = $task["seller_avatar"];
            $tmp["seller_level"] = $task["seller_level"];
            $tmp["seller_level_badge_url"] = $task["seller_level_badge_url"];
            $tmp["seller_delivery_time"] = $task["seller_delivery_time"];
            $tmp["seller_positive_feedback"] = $task["seller_positive_feedback"];
            $tmp["seller_negative_feedback"] = $task["seller_negative_feedback"];
            $tmp["seller_term_condition"] = $task["seller_term_condition"];
            $tmp["top_merchant"] = $task["top_merchant"];
            $tmp["average_rate"] = $task["average_rate"];
            $tmp["features"] = array();
            $temps = array();
            $temps["category"]= "Baterai";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_batery.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);
            $temps["category"]= "Lensa";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_lensa.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);
            $temps["category"]= "Package";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_package.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);
            $temps["category"]= "Go Pro";
            $temps["image_url"] = "http://apibukalapak.azurewebsites.net/image/ic_gopro.png";
            $temps["positive"] = rand(1,24)."";
            $temps["negative"] = rand(1,6)."";
            $temps["netral"] = rand(3,17)."";
            array_push($tmp["features"], $temps);

            array_push($ret, $tmp);
        }
        return $ret;
    }

    public function getProductReviewById($product_id) {
        $query = "SELECT * FROM reviews WHERE product_id = '$product_id'";
        $result = $this->conn->query($query);
        $ret = array();
        while ($task = $result->fetch_assoc()) {
            $tmp = array();
            $tmp["id"] = $task["id"];
            $tmp["sender_id"] = $task["sender_id"];
            $tmp["sender_name"] = $task["sender_name"];
            $tmp["sender_type"] = $task["sender_type"];
            $tmp["rate"] = $task["rate"];
            $tmp["body"] = $task["body"];
            $tmp["updated_at"] = $task["updated_at"];
            $tmp["product"] = $task["product"];
            $tmp["user_vote"] = $task["user_vote"];
            $tmp["product_id"] = $task["product_id"];
            $tmp["positive_votes"] = $task["positive_votes"];
            $tmp["negative_votes"] = $task["negative_votes"];
            $tmp["sentimen"] = $task["sentimen"];
            $tmp["features"] = array();
            $temps = array();
            $fitur = array("Lensa", "Baterai", "Package", "Go Pro");
            $url = array("http://apibukalapak.azurewebsites.net/image/ic_lensa.png","http://apibukalapak.azurewebsites.net/image/ic_batery.png","http://apibukalapak.azurewebsites.net/image/ic_package.png","http://apibukalapak.azurewebsites.net/image/ic_gopro.png");
            $n = rand(0,1);
            $rand1 = 100;
            for($i=0;$i<=$n;$i++){
                $r1 = rand(0,3);
                while($r1!=$rand1){
                    $temps["category"] = $fitur[$r1];
                    $temps["image_url"] = $url[$r1];
                    $rand1 = $r1;
                    array_push($tmp["features"], $temps);
                }
            }
            array_push($ret, $tmp);
        }
        return $ret;
    }


}
 
?>