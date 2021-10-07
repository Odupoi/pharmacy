<?php  
    include "../includes/dbconnect.php";
    session_start();
    $server =$_SESSION['username'];
    if($_SESSION['user_group'] != '2')
    {
        header("location: ../index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Management SYstem</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> 
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
	<div class="container">
    <div style="text-align: center;">
        <p><b>Logged in as: </b><?php echo $_SESSION['username'];?> (Pharmacist)</p>
        <a style="text-decoration: none; text-color: white;" href="../logout.php"><button class="btn btn-primary">Logout</button></a>
    </div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-4">
				<a data-toggle="modal" data-target="#addPatient" href="#">
					<div class="card p-2">
						<img src="../assets/images/patients.png" class="img-fluid" width="100px" alt="Admin image">
						<p class="txt-card">Add Patient</p>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="stock.php">
					<div class="card p-2">
						<img src="../assets/images/stock.png" class="img-fluid" width="100px" alt="Admin image">
						<p class="txt-card">Stock</p>
					</div>
				</a>
			</div>
            <div class="col-md-4">
				<a href="index.php">
					<div class="card p-2">
						<img src="../assets/images/prescription.png" class="img-fluid" width="100px" alt="Admin image">
						<p class="txt-card">Prescriptions</p>
					</div>
				</a>
			</div>
		</div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12 ">
                <div class="card p-4">

                    <div class="table-responsive">
                    <table id="stockP" class="table table-striped" style="border-radius: 20px;">
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
                        <th> Price</th>
                         <th>Status</th>

                    </tr>
                </thead>
 
                <tbody>
                <?php 
                    $sql = "SELECT stock.id, stock.bar_code, stock.medicine_name, stock.pic, categories.cat_name, stock.quantity, stock.used_quantity, stock.remain_quantity, stock.register_date, stock.expire_date, stock.company, stock.actual_price, stock.selling_price, stock.profit_price, stock.status FROM stock, categories WHERE stock.cat_id = categories.cat_id";
                    $result = mysqli_query($con, $sql);
                    $number = 1;
                    while($row = mysqli_fetch_array($result))
                    {
                ?>
                <tr>
                <td><?php echo $number; ?></td> 
                     <td><?php echo $row['medicine_name']; ?></td> 
                     <td><?php echo $row['cat_name']; ?></td> 
                     <td><?php echo $row['quantity']; ?></td>
                     <td><?php echo $row['used_quantity']; ?></td> 
                     <td><?php echo $row['remain_quantity']; ?></td> 
                     <td><?php echo $row['expire_date']; ?></td> 
                     <td><?php echo $row['company']; ?></td>
                     <td><?php echo $row['selling_price']; ?></td> 
                     <td><?php echo $row['status']; ?></td> 
                     
                    
                </tr>
                     <?php 
                    $number = $number + 1;
                    }
                    
                    ?>
                </tbody>
            </table>

                    </div>
                </div>
            </div>
        </div>

	</div>

    <!-- MODALS -->



                <!-- Add modal -->
                <div class="modal" id="addPatient">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Patient</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                            <form>
                                <div class="form-group">
                                    <label for="name">Patient name</label>
                                    <input type="text" id="patientName" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Patient Mobile:</label>
                                    <input type="number" id="patientMobile" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="age">Patient Age:</label>
                                    <input type="number" id="patientAge" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="comments">Patient Comments:</label>
                                    <textarea id="patientComments" cols="10" rows="10" class='form-control'>
                                    </textarea>
                                </div>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="addPatient();" data-dismiss="modal" class="btn btn-primary submitBtn">Add Patient</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end add modal -->
 
</body>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script>
     $(document).ready(function(){
        
 
        displayStock();
        $('#stockP').DataTable({
            "paging":   false,
        "ordering": false,
        "info":     false
        }); 
      
    });
        function displayStock(){
           
                var readStockP = "readStockP";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readStockP : readStockP
                    },
                    success: function(data){
         
                        $("#contentStock").html(data);
                    }
                });

            }
            function addPatient(){
                var patientName = $('#patientName').val();
                var patientMobile = $('#patientMobile').val();
                var patientAge = $('#patientAge').val();
                var patientComments = $('#patientComments').val();

                if($.trim(patientName)== ""|| $.trim(patientMobile) == "" || $.trim(patientAge) == "" || $.trim(patientComments) == "")
                {
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
          $.ajax({
              url: "../includes/action.php",
              type: "post",
              data: {
                patientName : patientName,
                patientMobile : patientMobile,
                patientAge: patientAge,
                patientComments: patientComments
              },
              success: function(data){
                  displayPatient();
              }
          })
      }
                }
                
</script>
</html>