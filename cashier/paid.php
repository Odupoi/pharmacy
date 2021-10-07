<?php  
    include "../includes/dbconnect.php";
    session_start();
    $server =$_SESSION['username'];
    if($_SESSION['user_group'] != '3')
    {
        header("location: ../index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Management SYstem</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body>
	<div class="container">
    <div style="text-align: center;">
        <p><b>Logged in as: </b><?php echo $_SESSION['username'];?> (Cashier)</p>
        <a style="text-decoration: none; text-color: white;" href="../logout.php"><button class="btn btn-primary">Logout</button></a>
    </div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-md-6">
				<a href="index.php">
					<div class="card p-1    ">
						<img src="../assets/images/unpaid.png" class="img-fluid" width="100px" alt="Admin image">
						<p class="txt-card">Unpaid</p>
					</div>
				</a>
			</div>
			<div class="col-md-6">
				<a href="paid.php">
					<div class="card p-4">
						<img src="../assets/images/paid.png" class="img-fluid" width="100px" alt="Admin image">
						<p class="txt-card">Paid</p>
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

                    <th>No.</th>
                        <th>Patient Name</th>
                        <th>Amount</th>
                        <th>Date Prescribed</th>
                        <th>Payment Date</th>
                        <th>Receipt</th>
                       
                       
                       

                    </tr>
                </thead>
                <tbody id="contentPaid">
                        
                </tbody>
            </table>
                    </div>
                </div>
            </div>
        </div>

	</div>
    <div id="receipt">

</div>
 
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script>
    var pdfdoc = new jsPDF();
    var specialElementHandlers = {
        '#ignoreContent': function (element, renderer){
            return true;    
        }
    };
    $(document).ready(function(){
        document.getElementById("receipt").style.visibility = "hidden"; 
 
        displayPaid();
        $('#stockP').DataTable({
            "paging":   false,
        "ordering": false,
        "info":     false
        }); 
      
    });
        function displayPaid(){
           
                var readStatusPaid = "readStatusPaid";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readStatusPaid : readStatusPaid
                    },
                    success: function(data){
                      
                        $("#contentPaid").html(data);
                    }
                });

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
                         pdfdoc.save('reciept.pdf')
                         
                     }
                 });
            }
            function markPaid(patient_id){
                
                var p_id_mark = patient_id;
                $.ajax({
                     url: "../includes/action.php",
                     type: "post",
                     data: {
                        p_id_mark : p_id_mark
                     },
                     success: function(data){
                         
                    
                         
                     }
                 });
            }
            function promptPay(patient_mobile, patient_id){
                var conf = confirm("Are you Sure you want "+patient_mobile+" to pay?");
                var p_mobile = patient_mobile;
                var p_id_pay = patient_id;

                $.ajax({
                     url: "../includes/action.php",
                     type: "post",
                     data: {
                        p_mobile : p_mobile,
                        p_id_pay:p_id_pay
                     },
                     success: function(data){
                         alert(data);
                    
                         
                     }
                 });
            }
                
</script>
</html>