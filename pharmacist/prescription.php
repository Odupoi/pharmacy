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
					<div class="card p-4">
						<img src="../assets/images/patients.png" class="img-fluid" width="100px" alt="Admin image">
						<p class="txt-card">Add Patient</p>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="stock.php">
					<div class="card p-4">
						<img src="../assets/images/stock.png" class="img-fluid" width="100px" alt="Admin image">
						<p class="txt-card">Stock</p>
					</div>
				</a>
			</div>
            <div class="col-md-4">
				<a href="prescription.php">
					<div class="card p-4">
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
                <table id="patientsP" class="table" style="border-radius: 20px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Patient</th>
                        <th>Mobile</th>
                        <th>Age</th>
                        <th>Comments</th>
                        <th>Patient Date</th>
                        <th>Action Edit</th>
                        <th>Action Delete</th>
                        
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sql = "SELECT * FROM patients";
                    $result = mysqli_query($con, $sql);
                    $number = 1;
                    while($row = mysqli_fetch_array($result))
                    {
                ?>
                <tr>
                <td><?php echo $number; ?></td> 
                     <td><?php echo $row['patient_name']; ?></td> 
                     <td><?php echo $row['patient_mobile']; ?></td> 
                     <td><?php echo $row['patient_age']; ?></td>
                     <td><?php echo $row['patient_comments']; ?></td> 
                     <td><?php echo $row['patient_date']; ?></td> 
                     <td><button class="btn btn-primary btn-sm" onclick="addPrescription(<?php echo $row['patient_id']; ?>);">Create</button></td>
                     <td><button class="btn btn-success btn-sm" onclick="showPrescription(<?php echo $row['patient_id']; ?>);">Prescriptions</button></td>
                    
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
    <!-- MOdal create prescription -->
            <div class="modal" id="addPrescriptionModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Create Prescription</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                        <form enctype="multipart/form-data">
                        <?php
                                    
                                    $result = mysqli_query($con,"SELECT * FROM stock");
                                    while($row = mysqli_fetch_array($result)) {
                                        ?>
                                 <input type="hidden" id="sellingPrice" value="<?php  echo $row['selling_price']; ?>">       
                                 <?php }?>
                                <div class="form-group">
                                    <label for="catname">Medicine Name/Barcode</label>
                                    <select class="form-control" id="medicineName">
                                        <option value="">Select Name</option>
                                        <?php
                                        $result = mysqli_query($con,"SELECT * FROM stock");
                                        while($row = mysqli_fetch_array($result)) {
                                        ?>
                                            <option value="<?php echo $row['id'];?>"><?php echo $row["medicine_name"].'-'.$row['bar_code'];?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                               
                                <div class="form-group">
                                    <label for="times">NO. of times per day:</label>
                                    <input type="number" id="dailyTimes" class="form-control">
                                </div>
                                <input type="hidden" id="patientId">
                                <div class="form-group">
                                    <label for="pills">No of pills per time:</label>
                                    <input type="number" id="pillsDaily" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="days">NO. of days:</label>
                                    <input type="number" id="days" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="pills">Total pills:</label>
                                    <input type="number" disabled id="totalPills" class="form-control">
                                </div>
                                <input type="hidden" id="server" value="<?php echo $server; ?>">
                           
                                
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="addPrescriptionDetails();" data-dismiss="modal" class="btn btn-primary submitBtn">Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                </div>


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

<div id="receipt">

</div>
 <!-- Add modal -->
 <div class="modal" id="prescriptionModal" width="80%">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">View Prescription</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                        <div class="table-responsive">
                            <table id="patientsP" class="table" style="border-radius: 20px;">
                            <thead>
                                <tr>
                                    
                                    <th>Medicine name</th>
                                    <th>Times per day</th>
                                    <th>Pills per day</th>
                                    <th>No. of days</th>
                                    <th>Total pills</th>
                                    <th>Total price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="contentPrescriptions">
                                    
                            </tbody>
                        </table>
                    </div> 
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                      
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/popper.min.js"></script>

<script type="text/javascript">
    var pdfdoc = new jsPDF();
    var specialElementHandlers = {
        '#ignoreContent': function (element, renderer){
            return true;    
        }
    };
    $(document).ready(function(){
        document.getElementById("receipt").style.visibility = "hidden";  
        $("#btnPrint").click(function () {
           pdfdoc.fromHTML($('#receipt').html(), 10, 10,{
               'width': 100,
               'elementHandlers': specialElementHandlers
           });
           pdfdoc.save('First.pdf')
        });
    });
    </script>
<script>
     $(document).ready(function(){
        
         
        displayPatients();
        $(document).ready(function() {
    $('#patientsP').DataTable();
} );
      
        $("#dailyTimes").bind("change paste keyup", function() {

            var times = $("#dailyTimes").val();
            var pills = $("#pillsDaily").val();
            var days = $("#days").val();
            if($.trim(times) == '0' || $.trim(pills) == '0' || $.trim(days) == '0' ){
                alert("field input cannot be null")
            }

            
            $("#totalPills").val(times * pills*days);
            
        
        });
        $("#pillsDaily").bind("change paste keyup", function() {

            var times = $("#dailyTimes").val();
            var pills = $("#pillsDaily").val();
            var days = $("#days").val();
            if($.trim(times) == '0' || $.trim(pills) == '0' || $.trim(days) == '0' ){
                alert("field input cannot be null")
            }

            $("#totalPills").val(times * pills*days);


            });
            $("#days").bind("change paste keyup", function() {

                var times = $("#dailyTimes").val();
                var pills = $("#pillsDaily").val();
                var days = $("#days").val();
                if( $.trim(times) == '0' || $.trim(pills) == '0' || $.trim(days) == '0' ){
                alert("field input cannot be null")
            }

                $("#totalPills").val(times * pills*days);


                });

            });
    function displayPatients(){
                var readPatientP = "readPatientP";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readPatientP : readPatientP
                    },
                    success: function(data){
                        $("#contentPatients").html(data);
                      
                    }
                });

            }
            function addPrescription(patient_id){
                $('#addPrescriptionModal').modal("show");   
                $('#patientId').val(patient_id);


                
            }
            function viewReceipt(patient_id){
                
               var p_id = patient_id;
             
               $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        p_id : p_id
                    },
                    success: function(data){
                        
                        $("#receipt").html(data);
                        pdfdoc.fromHTML($('#receipt').html(), 10, 10,{
                            'width': 100,
                            'elementHandlers': specialElementHandlers
                        });
                        pdfdoc.save('First.pdf')
                        
                    }
                });


                
            }
            function showPrescription(patient_id){
                $('#prescriptionModal').modal("show");   
                 var prescription_id = patient_id;
                   // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        prescription_id : prescription_id
                    },
                    success: function(data){
                        $("#contentPrescriptions").html(data);
                      
                    }
                });


                
            }
            function addPrescriptionDetails(){
                
                var id = $("#patientId").val();
                var name = $("#medicineName").val();
                var times = $("#dailyTimes").val();
                var pills = $("#pillsDaily").val();
                var days = $("#days").val();
                var total = $("#totalPills").val();
                
                var sellingPrice = $("#sellingPrice").val();
                var price = total*sellingPrice;
                var served_by = $("#server").val();



                if($.trim(name) == ''|| $.trim(times) == ''|| $.trim(pills) == ''||$.trim(days) == '' || $.trim(total) == ''){
                    alert('input all fields');
                }else{
                    $.ajax({
                        method: "post",
                        url: "../includes/action.php",
                        data: {
                            id:id,
                            name: name,
                            times: times,
                            pills: pills,
                            days: days,
                            total: total,
                            price: price,
                            served_by: served_by
                        },
                        success: function(data){
                            
                        }
                    })
                }
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