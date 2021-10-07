<?php
//include the php file connecting the database
include "dbconnect.php";
$uploadDir = '../uploads/';
//*************************LOGIN**********************/
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['level']))
{
    $username = $_POST['username'];
    $password =$_POST['password'];
    $level =$_POST['level'];

    

    $sql = "SELECT * FROM users WHERE user_password ='$password' AND user_group='$level' AND username='$username' OR user_email = '$username'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) != 0){
        echo 'match';
        
            while($row = mysqli_fetch_array($result)){
                //set sessions
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_email'] = $row['user_email'];
                $_SESSION['user_group'] = $row['user_group'];
                
                
            }
    }else{
        echo "no match";
    }
}


// All our actions will be managed here. The ajax response is sent here first
if(isset($_POST['readCat'])){
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file
    $data = '<table class="table table-bordered">
                <thead>
                    <th>No</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>';
                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data .= '<tr>
                                        <td>'.$number.'</td>
                                        <td>'.$row['cat_name'].'</td>
                                        <td>'.$row['cat_desc'].'</td>
                                        <td><button class="btn btn-primary" onclick="getCatDetails('.$row['cat_id'].');">Edit</button></td>
                                        <td><button class="btn btn-danger" onclick="deleteCat('.$row['cat_id'].');">Delete</button></td>
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="4"> No Categories Added</td>
                                    </tr>
                </tbody>
            </table>';
                    }
                    echo $data;
}
if(isset($_POST['catName']) && isset($_POST['catDesc']) )
{
    $catName = $_POST['catName'];
    $catDesc = $_POST['catDesc'];

    $sql = "INSERT INTO `categories`(`cat_id`, `cat_name`, `cat_desc`, `date_added`) 
    VALUES (NULL,'$catName','$catDesc',NOW())";
    $result = mysqli_query($con, $sql);
    if($result)
    {
        echo '1';
        
    }else{
        echo '0';
    }
}
if(isset($_POST['deleteCatId']))
{
    
  $cat_id = $_POST['deleteCatId'];
  $sql = "DELETE FROM categories WHERE cat_id='$cat_id'";
  $result = mysqli_query($con, $sql);

}
if(isset($_POST['cat_id']))
{
  $cat_id = $_POST['cat_id'];
  $query = "SELECT * FROM categories WHERE cat_id = '$cat_id'";
	if(!$result = mysqli_query($con, $query))
	{
		exit.mysqli_error($con);


	}
  	$response = array();
    if(mysqli_num_rows($result) >0){
      while($row = mysqli_fetch_assoc($result))
      {
        $response = $row;
      }
    }
  else
  {
      $response['status'] = 200;
      $response['message'] = "Data not found!";
  }
// php has some inbuilt functions to handle json
echo json_encode($response);

}
else{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}

if(isset($_POST['updateCatName']) && isset($_POST['updateCatDesc']) && isset($_POST['updateId']))
{
    $updateId =$_POST['updateId'];
    $updateCatName = $_POST['updateCatName'];
    $updateCatDesc = $_POST['updateCatDesc'];

    $sql = "UPDATE `categories` SET `cat_name`='$updateCatName',`cat_desc`='$updateCatDesc' WHERE cat_id='$updateId'";
    $result = mysqli_query($con, $sql);
    if($result)
    {
        echo $sql;
        
    }else{
        echo '0';
    }
}


// ************************************PATIENTS DETAILS***********************************
if(isset($_POST['readPatient'])){
    $sql = "SELECT * FROM patients";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file
    $data = '<table id="example" class="table table-striped table-bordered" style="border-radius: 20px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Age</th>
                        <th>Comments</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>';
                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data .= '<tr>
                                        <td>'.$number.'</td>
                                        <td>'.$row['patient_name'].'</td>
                                        <td>'.$row['patient_mobile'].'</td>
                                        <td>'.$row['patient_age'].'</td>
                                        <td>'.$row['patient_comments'].'</td>
                                        <td><button class="btn btn-primary" onclick="getPatientDetails('.$row['patient_id'].');">Edit</button></td>
                                        <td><button class="btn btn-danger" onclick="deletePatient('.$row['patient_id'].');">Delete</button></td>
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="6"> No Patients Added</td>
                                    </tr>
                </tbody>
            </table>';
                    }
                    echo $data;
}
if(isset($_POST['patientName']) && isset($_POST['patientMobile']) )
{
    $patientName = $_POST['patientName'];
    $patientMobile = $_POST['patientMobile'];
    $patientAge = $_POST['patientAge'];
    $patientComments = $_POST['patientComments'];

    $sql = "INSERT INTO `patients`(`patient_id`, `patient_name`, `patient_mobile`, `patient_age`, `patient_comments`, `patient_date`)
     VALUES (NULL,'$patientName','$patientMobile','$patientAge','$patientComments',NOW())";
    $result = mysqli_query($con, $sql);
    if($result)
    {
        echo '1';
        
    }else{
        echo '0';
    }
}
if(isset($_POST['deletePatientId']))
{
    
  $patient_id = $_POST['deletePatientId'];
  $sql = "DELETE FROM patients WHERE cat_id='$patient_id'";
  $result = mysqli_query($con, $sql);

}
if(isset($_POST['patient_id']))
{
  $patient_id = $_POST['patient_id'];
  $query = "SELECT * FROM patients WHERE patient_id = '$patient_id'";
	if(!$result = mysqli_query($con, $query))
	{
		exit.mysqli_error($con);


	}
  	$response = array();
    if(mysqli_num_rows($result) >0){
      while($row = mysqli_fetch_assoc($result))
      {
        $response = $row;
      }
    }
  else
  {
      $response['status'] = 200;
      $response['message'] = "Data not found!";
  }
// php has some inbuilt functions to handle json
echo json_encode($response);

}
else{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}

if(isset($_POST['updatePatientName']) && isset($_POST['updatePatientMobile']) && 
isset($_POST['updateId']) && isset($_POST['updatePatientAge']) && isset($_POST['updatePatientComments']))
{
    $updateId =$_POST['updateId'];
    $updatePatientName = $_POST['updatePatientName'];
    $updatePatientMobile = $_POST['updatePatientMobile'];
    $updatePatientAge = $_POST['updatePatientAge'];
    $updatePatientComments = $_POST['updatePatientComments'];

    $sql = "UPDATE `patients` SET `patient_name`='$updatePatientName',`patient_mobile`='$updatePatientMobile'
    ,`patient_age`='$updatePatientAge',`patient_comments`='$updatePatientComments' WHERE patient_id='$updateId'";
    $result = mysqli_query($con, $sql);
    if($result)
    {
        echo $sql;
        
    }else{
        echo '0';
    }
}

// *************************************Cashier******************************************

if(isset($_POST['readCashier'])){
    $sql = "SELECT * FROM users WHERE user_group='3'";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file
    $data = '<div class="row">';
                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data .= '<div class="col-md-4">
                                        <div class="card p-5">
                                            <img src="../uploads/'.$row['profile_pic'].'" class="rounded-circle" alt="profile pic" />
                                            <p>'.$row['username'].'</p>
                                            <p>'.$row['user_email'].'</p>
                                            <button style="margin-bottom: 10px;" class="btn btn-primary" onclick="getUserDetails('.$row['user_id'].');">Edit</button><br>
                                            <button class="btn btn-danger" onclick="deleteUser('.$row['user_id'].');">Delete</button>
                                        </div>
                                    </div>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<div class="col-md-12"
                                        <p style="text-align: center;"> No Users Added</p>
                                    </div>
                
            </div>';
                    }
                    echo $data;
}
if(isset($_POST['cashierName']) && isset($_POST['cashierEmail'] ) && isset($_POST['cashierPassword'] ) )
{
    $username = $_POST['cashierName'];
    $useremail = $_POST['cashierEmail'];
    $userpassword = $_POST['cashierPassword'];

       // Check whether submitted data is not empty
       if(!empty($username) && !empty($useremail) && !empty($userpassword)){

        $uploadStatus = 1;

        // Upload file
        $uploadedFile = '';
        if(!empty($_FILES["profilePic"]["name"])){

            // File path config
            $fileName = basename($_FILES["profilePic"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes)){
                // Upload file to the server
                if(move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)){
                    $uploadedFile = $fileName;
                }else{
                    $uploadStatus = 0;
                    echo 'Sorry, there was an error uploading your file.';
                }
            }else{
                $uploadStatus = 0;
                echo 'Sorry, only  JPG, JPEG, & PNG files are allowed to upload.';
            }
        }

        if($uploadStatus == 1){


            // Insert form data in the database
            $sql = "INSERT INTO `users`(`user_id`, `username`, `user_email`, `profile_pic`, `user_password`, `user_group`, `date_added`)
             VALUES (NULL,'$username','$useremail','$uploadedFile','$userpassword','3',NOW())";
            $result = mysqli_query($con, $sql);

            if($result){
                echo 'Form data submitted successfully!';
            }else{
                echo $sql;
            }
        }
    }
}
    

  
if(isset($_POST['deleteUserId']))
{
    
  $user_id = $_POST['deleteUserId'];
  $sql = "DELETE FROM users WHERE user_id='$user_id'";
  $result = mysqli_query($con, $sql);

}
if(isset($_POST['user_id']))
{
  $user_id = $_POST['user_id'];
  $query = "SELECT * FROM users WHERE user_id = '$user_id'";
	if(!$result = mysqli_query($con, $query))
	{
		exit.mysqli_error($con);


	}
  	$response = array();
    if(mysqli_num_rows($result) >0){
      while($row = mysqli_fetch_assoc($result))
      {
        $response = $row;
      }
    }
  else
  {
      $response['status'] = 200;
      $response['message'] = "Data not found!";
  }
// php has some inbuilt functions to handle json
echo json_encode($response);

}
else{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}

if(isset($_POST['updateCashierName']) && isset($_POST['updateCashierEmail']) && 
isset($_POST['updateId']) && isset($_POST['updateCashierPassword']) )
{
    $updateId =$_POST['updateId'];
    $username = $_POST['updateCashierName'];
    $useremail = $_POST['updateCashierEmail'];
    $userpassword = $_POST['updateCashierPassword'];

       // Check whether submitted data is not empty
       if(!empty($username) && !empty($useremail) && !empty($userpassword)){

        $uploadStatus = 1;

        // Upload file
        $uploadedFile = '';
        if(!empty($_FILES["profilePicUpdate"]["name"])){

            // File path config
            $fileName = basename($_FILES["profilePicUpdate"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes)){
                // Upload file to the server
                if(move_uploaded_file($_FILES["profilePicUpdate"]["tmp_name"], $targetFilePath)){
                    $uploadedFile = $fileName;
                }else{
                    $uploadStatus = 0;
                    echo 'Sorry, there was an error uploading your file.';
                }
            }else{
                $uploadStatus = 0;
                echo 'Sorry, only  JPG, JPEG, & PNG files are allowed to upload.';
            }
        }

        if($uploadStatus == 1){


            // Insert form data in the database
            $sql = "UPDATE `users` SET `username`='$username',`user_email`='$useremail'
            ,`profile_pic`='$uploadedFile',`user_password`='$userpassword' WHERE user_id= '$updateId'";
            $result = mysqli_query($con, $sql);

            if($result){
                echo 'Form data submitted successfully!';
            }else{
                echo $sql;
            }
        }
    }
}



// *************************************Pharmacist******************************************

if(isset($_POST['readPharmacist'])){
    $sql = "SELECT * FROM users WHERE user_group='2'";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file
    $data = '<div class="row">';
                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data .= '<div class="col-md-4">
                                        <div class="card p-5">
                                            <img src="../uploads/'.$row['profile_pic'].'" class="rounded-circle" alt="profile pic" />
                                            <p>'.$row['username'].'</p>
                                            <p>'.$row['user_email'].'</p>
                                            <button style="margin-bottom: 10px;" class="btn btn-primary" onclick="getUserDetails('.$row['user_id'].');">Edit</button><br>
                                            <button class="btn btn-danger" onclick="deleteUser('.$row['user_id'].');">Delete</button>
                                        </div>
                                    </div>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<div class="col-md-12"
                                        <p style="text-align: center;"> No Users Added</p>
                                    </div>
                
            </div>';
                    }
                    echo $data;
}
if(isset($_POST['pharmacistName']) && isset($_POST['pharmacistEmail'] ) && isset($_POST['pharmacistPassword'] ) )
{
    $username = $_POST['pharmacistName'];
    $useremail = $_POST['pharmacistEmail'];
    $userpassword = $_POST['pharmacistPassword'];

       // Check whether submitted data is not empty
       if(!empty($username) && !empty($useremail) && !empty($userpassword)){

        $uploadStatus = 1;

        // Upload file
        $uploadedFile = '';
        if(!empty($_FILES["profilePic"]["name"])){

            // File path config
            $fileName = basename($_FILES["profilePic"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes)){
                // Upload file to the server
                if(move_uploaded_file($_FILES["profilePic"]["tmp_name"], $targetFilePath)){
                    $uploadedFile = $fileName;
                }else{
                    $uploadStatus = 0;
                    echo 'Sorry, there was an error uploading your file.';
                }
            }else{
                $uploadStatus = 0;
                echo 'Sorry, only  JPG, JPEG, & PNG files are allowed to upload.';
            }
        }

        if($uploadStatus == 1){


            // Insert form data in the database
            $sql = "INSERT INTO `users`(`user_id`, `username`, `user_email`, `profile_pic`, `user_password`, `user_group`, `date_added`)
             VALUES (NULL,'$username','$useremail','$uploadedFile','$userpassword','2',NOW())";
            $result = mysqli_query($con, $sql);

            if($result){
                echo 'Form data submitted successfully!';
            }else{
                echo $sql;
            }
        }
    }
}
    


if(isset($_POST['updatePharmacistName']) && isset($_POST['updatePharmacistEmail']) && 
isset($_POST['updateId']) && isset($_POST['updatePharmacistPassword']) )
{
    $updateId =$_POST['updateId'];
    $username = $_POST['updatePharmacistName'];
    $useremail = $_POST['updatePharmacistEmail'];
    $userpassword = $_POST['updatePharmacistPassword'];

       // Check whether submitted data is not empty
       if(!empty($username) && !empty($useremail) && !empty($userpassword)){

        $uploadStatus = 1;

        // Upload file
        $uploadedFile = '';
        if(!empty($_FILES["profilePicUpdate"]["name"])){

            // File path config
            $fileName = basename($_FILES["profilePicUpdate"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes)){
                // Upload file to the server
                if(move_uploaded_file($_FILES["profilePicUpdate"]["tmp_name"], $targetFilePath)){
                    $uploadedFile = $fileName;
                }else{
                    $uploadStatus = 0;
                    echo 'Sorry, there was an error uploading your file.';
                }
            }else{
                $uploadStatus = 0;
                echo 'Sorry, only  JPG, JPEG, & PNG files are allowed to upload.';
            }
        }

        if($uploadStatus == 1){


            // Insert form data in the database
            $sql = "UPDATE `users` SET `username`='$username',`user_email`='$useremail'
            ,`profile_pic`='$uploadedFile',`user_password`='$userpassword' WHERE user_id= '$updateId'";
            $result = mysqli_query($con, $sql);

            if($result){
                echo 'Form data submitted successfully!';
            }else{
                echo $sql;
            }
        }
    }
}


//*************************************STOCK*****************************************8 */
if(isset($_POST['readStock'])){
    $sql = "SELECT stock.medicine_name, stock.pic, categories.cat_name, stock.quantity, stock.used_quantity, stock.remain_quantity, stock.register_date, stock.expire_date, stock.company, stock.actual_price, stock.selling_price, stock.profit_price, stock.status FROM stock, categories WHERE stock.cat_id = categories.cat_id";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file
    $data = '<div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="border-radius: 20px; width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>used Quantity</th>
                        <th>Remaining Quantity</th>
                        <th>Expiry Date</th>
                        <th>Company</th>
                        <th>Actual Price</th>
                        <th>Selling Price</th>
                        <th>Profit</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>';
                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data .= '<tr>
                                        <td>'.$number.'</td>
                                        <td>'.$row['medicine_name'].'</td>
                                        <td>'.$row['cat_name'].'</td>
                                        <td>'.$row['quantity'].'</td>
                                        <td>'.$row['used_quantity'].'</td>
                                        <td>'.$row['remain_quantity'].'</td>
                                        <td>'.$row['expire_date'].'</td>
                                        <td>'.$row['company'].'</td>
                                        <td>'.$row['actual_price'].'</td>
                                        <td>'.$row['selling_price'].'</td>
                                        <td>'.$row['profit_price'].'</td>
                                        <td>'.$row['status'].'</td>
                                        <td><button class="btn btn-primary" onclick="getStockDetails('.$row['id'].');">Edit</button></td>
                                        <td><button class="btn btn-danger" onclick="deleteMedicine('.$row['id'].');">Delete</button></td>
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="6"> No Stock Added</td>
                                    </tr>
                </tbody>
            </table>
            </div>';
                    }
                    echo $data;
}
if(isset($_POST['medicineName']) && isset($_POST['barCode'] ) && isset($_POST['medicineCategory'] ) )
{
    $barCode = $_POST['barCode'];
    $name = $_POST['medicineName'];
    $category = $_POST['medicineCategory'];
    $quantity = $_POST['medicineQuantity'];
    $expiry = $_POST['medicineExpiry'];
    $company = $_POST['companyName'];
    $actualPrice = $_POST['actualPrice'];
    $sellingPrice = $_POST['sellingPrice'];
    $profit = $sellingPrice -$actualPrice;
    $name = $_POST['medicineName'];

       // Check whether submitted data is not empty
       if(!empty($barCode) && !empty($quantity) && !empty($sellingPrice)){

        $uploadStatus = 1;

        // Upload file
        $uploadedFile = '';
        if(!empty($_FILES["medicinePic"]["name"])){

            // File path config
            $fileName = basename($_FILES["medicinePic"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array( 'jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes)){
                // Upload file to the server
                if(move_uploaded_file($_FILES["medicinePic"]["tmp_name"], $targetFilePath)){
                    $uploadedFile = $fileName;
                }else{
                    $uploadStatus = 0;
                    echo 'Sorry, there was an error uploading your file.';
                }
            }else{
                $uploadStatus = 0;
                echo 'Sorry, only  JPG, JPEG, & PNG files are allowed to upload.';
            }
        }

        if($uploadStatus == 1){


            // Insert form data in the database
            $sql = "INSERT INTO `stock`(`id`, `bar_code`, `medicine_name`, `pic`, `cat_id`, `quantity`, 
            `used_quantity`, `remain_quantity`, `register_date`, `expire_date`, `company`, `actual_price`, 
            `selling_price`, `profit_price`, `status`) VALUES (NULL,'$barCode','$name','$uploadedFile','$category','$quantity'
            ,'0','$quantity',NOW(),'$expiry','$company','$actualPrice','$sellingPrice','$profit','Available')";
            $result = mysqli_query($con, $sql);

            if($result){
                echo 'Form data submitted successfully!';
            }else{
                echo $sql;
            }
        }
    }
}
    

  
if(isset($_POST['deleteMedicineId']))
{
    
  $id = $_POST['deleteMedicineId'];
  $sql = "DELETE FROM stock WHERE id='$id'";
  $result = mysqli_query($con, $sql);

}
if(isset($_POST['medicine_id']))
{
  $medicine_id = $_POST['medicine_id'];
  $query = "SELECT * FROM stock WHERE id = '$medicine_id'";
	if(!$result = mysqli_query($con, $query))
	{
		exit.mysqli_error($con);


	}
  	$response = array();
    if(mysqli_num_rows($result) >0){
      while($row = mysqli_fetch_assoc($result))
      {
        $response = $row;
      }
    }
  else
  {
      $response['status'] = 200;
      $response['message'] = "Data not found!";
  }
// php has some inbuilt functions to handle json
echo json_encode($response);

}
else{
    $response['status'] = 200;
    $response['message'] = "Invalid Request!";
}
if(isset($_POST['updateMedicineName']) && isset($_POST['updateBarCode'] ) && isset($_POST['updateMedicineCategory'] )&& isset($_POST['updateId'] ) )
{
    $id=$_POST['updateId'];
    $barCode = $_POST['updateBarCode'];
    $name = $_POST['updateMedicineName'];
    $category = $_POST['updateMedicineCategory'];
    $quantity = $_POST['updateMedicineQuantity'];
    $expiry = $_POST['updateMedicineExpiry'];
    $company = $_POST['updateCompanyName'];
    $actualPrice = $_POST['updateActualPrice'];
    $sellingPrice = $_POST['updateSellingPrice'];
    

       // Check whether submitted data is not empty
       if(!empty($barCode) && !empty($quantity) && !empty($sellingPrice)){

        $uploadStatus = 1;

        // Upload file
        $uploadedFile = '';
        if(!empty($_FILES["medicinePicUpdate"]["name"])){

            // File path config
            $fileName = basename($_FILES["medicinePicUpdate"]["name"]);
            $targetFilePath = $uploadDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow certain file formats
            $allowTypes = array( 'jpg', 'png', 'jpeg');
            if(in_array($fileType, $allowTypes)){
                // Upload file to the server
                if(move_uploaded_file($_FILES["medicinePicUpdate"]["tmp_name"], $targetFilePath)){
                    $uploadedFile = $fileName;
                }else{
                    $uploadStatus = 0;
                    echo 'Sorry, there was an error uploading your file.';
                }
            }else{
                $uploadStatus = 0;
                echo 'Sorry, only  JPG, JPEG, & PNG files are allowed to upload.';
            }
        }

        if($uploadStatus == 1){


            // Insert form data in the database
            $sql = "UPDATE `stock` SET `bar_code`='$barCode',`medicine_name`='$name',`pic` ='$uploadedFile', `cat_id`='$category',
            `quantity`='$quantity',`expire_date`='$expiry',`company`='$company',`actual_price`='$actualPrice',`selling_price`='$sellingPrice' WHERE id= '$id'";
            $result = mysqli_query($con, $sql);

            if($result){
                echo 'Form data submitted successfully!';
            }else{
                echo $sql;
            }
        }
    }
}


//************READ PATIENTS FORTHE PHARMACIST************************/
if(isset($_POST['readPatientP'])){
    $sql = "SELECT * FROM patients";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file
  
                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data = '<tr>
                                        <td>'.$number.'</td>
                                        <td>'.$row['patient_name'].'</td>
                                        <td>'.$row['patient_mobile'].'</td>
                                        <td>'.$row['patient_age'].'</td>
                                        <td>'.$row['patient_comments'].'</td>
                                        <td><button class="btn btn-primary btn-sm" onclick="addPrescription('.$row['patient_id'].');">Create</button></td>
                                        <td><button class="btn btn-success btn-sm" onclick="showPrescription('.$row['patient_id'].');">Prescriptions</button></td>
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="6"> No Patients Added</td>
                                    </tr>';
                                    
                    }
       
                    
                    echo $data;
}
if(isset($_POST['name']) && isset($_POST['total']) &&  isset($_POST['times']) && isset($_POST['pills']) && isset($_POST['days'])){
    $name =$_POST['name'];
    $times =$_POST['times'];
    $days =$_POST['days'];
    $pills =$_POST['pills'];
    $total =$_POST['total'];
    $id = $_POST['id'];
    $price = $_POST['price'];
    echo "iui";
    $sql = "INSERT INTO `prescription`(`p_id`, `patient_id`, `medicine_id`, `daily_times`
    , `pills_daily`, `total_days`, `total_pills`, `total_price`,`served_by`, `date`, `date_paid`) 
    VALUES (NULL,'$id','$name','$times','$pills','$days','$total',
    '$price','James',NOW(), NOW())";
    $result = mysqli_query($con, $sql);
    if(!$result)
    {
        echo $sql;
    }else{
        echo "Success";
    }

    
}
if(isset($_POST['prescription_id']))
{
    $id = $_POST['prescription_id'];
    $sql = "SELECT prescription.p_id, prescription.patient_id, stock.medicine_name, prescription.daily_times, prescription.pills_daily, prescription.total_days, prescription.total_pills, prescription.total_price, prescription.served_by, prescription.status, prescription.date, prescription.date_paid FROM prescription, stock WHERE patient_id ='$id' AND prescription.medicine_id= stock.id";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file
  
                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data = '<tr>
                                       
                                        <td>'.$row['medicine_name'].'</td>
                                        <td>'.$row['daily_times'].'</td>
                                        <td>'.$row['pills_daily'].'</td>
                                        <td>'.$row['total_days'].'</td>
                                        <td>'.$row['total_pills'].'</td>
                                        <td>'.$row['total_price'].'</td>
                                        <td><button class="btn btn-success btn-sm" id="btnPrint"
                                        onclick="viewReceipt('.$row['patient_id'].');">View Receipt</button></td>
                                        
                                       
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data ="";
                        $data .= '<tr>
                                        <td rowspan="6"> No Prescriptions made</td>
                                    </tr>';
                                    
                    }
       
                    
                    echo $data;
}
if(isset($_POST['readStockP'])){
    $sql = "SELECT stock.id, stock.bar_code, stock.medicine_name, stock.pic, categories.cat_name, stock.quantity, stock.used_quantity, stock.remain_quantity, stock.register_date, stock.expire_date, stock.company, stock.actual_price, stock.selling_price, stock.profit_price, stock.status FROM stock, categories WHERE stock.cat_id = categories.cat_id";
    $result = mysqli_query($con, $sql);

    //this is the response to the html file

                if(mysqli_num_rows($result)>0)
                    {
                        $number = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                            $data = '<tr>
                                        
                                        <td>'.$row['medicine_name'].'</td>
                                        <td>'.$row['category'].'</td>
                                        <td>'.$row['quantity'].'</td>
                                        <td>'.$row['used_quantity'].'</td>
                                        <td>'.$row['remain_quantity'].'</td>
                                        <td>'.$row['expire_date'].'</td>
                                        <td>'.$row['company'].'</td>
                                        <td>'.$row['actual_price'].'</td>
                                        <td>'.$row['selling_price'].'</td>
                                        <td>'.$row['profit_price'].'</td>
                                        <td>'.$row['status'].'</td>
                                        
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="6"> No Stock Added</td>
                                    </tr>';
                                   
                    }
              
                    
                    echo $data;
                    echo "iut";
}   
if(isset($_POST['p_id']))
{
    $id = $_POST['p_id'];
    $data = '<h1 style="text-align: center;">MAYIAN</h1>
                <h3 style="text-align: center;">Prescription Receipt</h3>';
    //so first we display the patients details
    $sql = "SELECT * FROM patients WHERE patient_id= '$id'";
    $result = mysqli_query($con, $sql);
    //now get it and fix it to the h3 tags
    //it return one row
    while($row = mysqli_fetch_array($result))
    {
        $data .= '<h3>Name: '.$row['patient_name'].'<h3>
                <h3>Name: '.$row['patient_mobile'].'<h3>
                <h3>Age: '.$row['patient_age'].'<h3> ';
    }
    //Then the table now
    $data .= '<table class="table">
            <tr>
                <th>Medicine Name</th>
                <th>Prescription</th>
                <th>Price</th>
                <th>Date</th>
            </tr>';

    $sql = "SELECT prescription.p_id, prescription.patient_id, stock.medicine_name, prescription.daily_times, prescription.pills_daily, prescription.total_days, prescription.total_pills, prescription.total_price, prescription.served_by, prescription.status, prescription.date, prescription.date_paid FROM prescription, stock WHERE patient_id ='$id' AND prescription.medicine_id= stock.id AND prescription.status = 'unpaid'";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result))
    {
        $data .= '<tr>
                    <td>'.$row['medicine_name'].'</td>
                    <td>'.$row['pills_daily'].'X'.$row['daily_times'].' for '.$row['total_days'].' days</td>
                    <td>'.$row['total_price'].'</td>
                    <td>'.$row['date'].'</td>
                </tr>';
    }
    $data .= '</table>';
    //we make another same query and limit one
    $sql = "SELECT * FROM prescription WHERE patient_id='$id' LIMIT 1";
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result))
    {
        $data .= '<p>Served by: '.$row['served_by'].'</p>
        <p>Status: Unpaid</p>
    <br><p></p><br>';
    }
    //then make another query to calculate the sum of the price column
    $sql = "SELECT SUM(total_price)  as total FROM prescription WHERE patient_id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result); 
    $amount = $row['total'];
       $data .='<h2>Total Amount............Ksh. '.$amount.'</h2>';
       echo $data;
}
if(isset($_POST['readStatus']))
{
    $sql = "SELECT prescription.p_id, patients.patient_mobile, patients.patient_id, prescription.total_price, prescription.date, patients.patient_name FROM patients, prescription WHERE patients.patient_id = prescription.patient_id and prescription.status= 'unpaid'";
    $result = mysqli_query($con, $sql);
    $data ='';

    //this is the response to the html file
  
                if(mysqli_num_rows($result)>0)
                    {
                        echo mysqli_num_rows($result);
                        $number = 1;
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $data .= '<tr>
                                        <td>'.$number.'</td>';
                                      
                                       $data .=' <td>'.$row['patient_name'].'</td>
                                       <td>Ksh.'.$row['total_price'].'</td>
                                       <td>'.$row['date'].'</td>
                                       <td><button class="btn btn-success btn-sm" onclick="promptPay('.$row['patient_mobile'].','.$row['patient_id'].');">Prompt to pay</button></td>';
                                       
                                      
                                        
                                       
                                    $data .= '<td><button class="btn btn-primary btn-sm" onclick="viewReceipt('.$row['patient_id'].');">View Receipt</button></td>
                                    
                                     <td><button class="btn btn-warning btn-sm" onclick="markPaid('.$row['p_id'].');">Verify payment</button></td>
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="6"> No Patients Added</td>
                                    </tr>';
                                    
                    }
       
                    
                    echo $data;
                
            }
if(isset($_POST['readStatusAdmin']))
{
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
    $sql = "SELECT prescription.p_id, patients.patient_mobile, patients.patient_id, prescription.status,  prescription.total_price, prescription.date, patients.patient_name FROM patients, prescription WHERE patients.patient_id = prescription.patient_id ";
    $result = mysqli_query($con, $sql);
    $data ='';

    //this is the response to the html file
  
                if(mysqli_num_rows($result)>0)
                    {
                        echo mysqli_num_rows($result);
                        $number = 1;
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $data .= '<tr>
                                        <td>'.$number.'</td>';
                                      
                                       $data .=' <td>'.$row['patient_name'].'</td>
                                       <td>Ksh.'.$row['total_price'].'</td>
                                       <td>'.$row['date'].'</td>
                                       <td>'.$row['status'].'</td>
                                       
                                      
                                        
                                       
                                    <td>Processed</td>
                                    
                                     
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="4"> No Prescriptions</td>
                                    </tr>';
                                    
                    }
       
                    
                    echo $data;
                
            }
if(isset($_POST['readStatusPaid']))
{
    
    $sql = "SELECT prescription.p_id, patients.patient_mobile, patients.patient_id, prescription.date_paid, prescription.total_price, prescription.date, patients.patient_name FROM patients, prescription WHERE patients.patient_id = prescription.patient_id and prescription.status= '0'";
    $result = mysqli_query($con, $sql);
    $data ='';

    //this is the response to the html file
  
                if(mysqli_num_rows($result)>0)
                    {
                        echo mysqli_num_rows($result);
                        $number = 1;
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $data .= '<tr>
                                        <td>'.$number.'</td>';
                                      
                                       $data .=' <td>'.$row['patient_name'].'</td>
                                       <td>Ksh.'.$row['total_price'].'</td>
                                       <td>'.$row['date'].'</td>
                                       <td>'.$row['date_paid'].'</td>';
                                       
                                       
                                      
                                        
                                       
                                    $data .= '<td><button class="btn btn-primary btn-sm" onclick="viewReceipt('.$row['patient_id'].');">View Receipt</button></td>
                                    
                                    
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="4"> No Payments made</td>
                                    </tr>';
                                    
                    }
       
                    
                    echo $data;
                
            }

if(isset($_POST['readPaymentReport']))
{
    
    $sql = "SELECT prescription.p_id, patients.patient_mobile, prescription.total_pills, patients.patient_id, prescription.date_paid, prescription.total_price, prescription.daily_times, prescription.pills_daily, prescription.total_days, prescription.served_by, prescription.status, prescription.date, patients.patient_name FROM patients, prescription WHERE patients.patient_id = prescription.patient_id";
    $result = mysqli_query($con, $sql);
    $data ='';

    //this is the response to the html file
  
                if(mysqli_num_rows($result)>0)
                    {
                        echo mysqli_num_rows($result);
                        $number = 1;
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $data .= '<tr>
                                        <td>'.$number.'</td>';
                                      
                                       $data .=' <td>'.$row['patient_name'].'</td>
                                       <td>'.$row['daily_times'].' x '.$row['pills_daily'].' for '.$row['total_days'].' days</td>
                                       <td>'.$row['total_pills'].'</td>
                                       <td>Ksh.'.$row['total_price'].'</td>
                                       <td>'.$row['served_by'].'</td>
                                       <td>'.$row['status'].'</td>
                                       <td>'.$row['date'].'</td>
                                       
                                       
                                       
                                      
                                        
                                       
                                    
                                    
                                    
                                    </tr>';
                            $number = $number+1;
                        }
                    }else{
                        $data .= '<tr>
                                        <td rowspan="4"> No Payments made</td>
                                    </tr>';
                                    
                    }
       
                    
                    echo $data;
                
            }
if(isset($_POST['p_id_mark'])){
    $id = $_POST['p_id_mark'];

    $sql = " ";
    $result = mysqli_query($con, $sql);
    if(!$result)
    {
        echo $sql;
    }
    
}
if(isset($_POST['p_mobile']) && isset($_POST['p_id_pay']))
{
    $mobile = $_POST['p_mobile'];
    $id = $_POST['p_id_pay'];
    $sql = "SELECT SUM(total_price)  as total FROM prescription WHERE patient_id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result); 
    $amount = $row['total'];

    $consumerKey = "Y7WME0UggXp757CZASuQnm0gQh1vMdW7";
  $consumerSecret = "jAdLywHFKc5umzuQ";
    $headers = ['Content-Type:application/json; charset=utf8'];

    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HEADER, FALSE);
    curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $result = json_decode($result);
    
    
    $access_token = $result->access_token;

  $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  $BusinessShortCode = '174379';
  $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  
  
  /*
    This are your info, for
    $PartyA should be the ACTUAL clients phone number or your phone number, format 2547********
    $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
    TransactionDesc can be anything, probably a better description of or the transaction
    $Amount this is the total invoiced amount, Any amount here will be 
    actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction. 
    for developer/test accounts, this money will be reversed automatically by midnight.
  */
  
  $PartyA = strval("254$mobile") ;// This is your phone number, 
  $AccountReference = 'Pharmacy System';
  $TransactionDesc = 'Pay Gym and Trainer';
  $Amount = strval( $amount ) ;
 echo $PartyA;
  # Get the timestamp, format YYYYmmddhms -> 20181004151020
  $Timestamp = date('YmdHis');    
  
  # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
  $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);

  $CallBackURL = 'http://josh.unaux.com/callback_url.php';  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token)); //setting custom header
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => $BusinessShortCode,
    'Password' => $Password,
    'Timestamp' => $Timestamp,
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount' => $Amount,
    'PartyA' => $PartyA,
    'PartyB' => $BusinessShortCode,
    'PhoneNumber' => $PartyA,
    'CallBackURL' => $CallBackURL,
    'AccountReference' => $AccountReference,
    'TransactionDesc' => $TransactionDesc
  );
  
  $data_string = json_encode($curl_post_data);
  echo $data_string;
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
  echo $curl_response;

  

}
?>



