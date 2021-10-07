
 <?php  include "header.php"?>
<!-- start content-->
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10"><h4>Prescriptions</h4><br></div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                   
                       
                    <div class="table-responsive">
                    <table id="stockP" class="table table-striped" style="border-radius: 20px;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Patient Name</th>
                        <th>Amount</th>
                        <th>Date Prescribed</th>
                        <th>Status</th>
                        <th>Receipt</th>
                       
                       
                       

                    </tr>
                </thead>
                <tbody id="contentUnpaidAdmin">
                        
                </tbody>
            </table>
                    </div>
                    
             

            <?php  include "footer.php"?>



            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
        <!-- Menu Toggle Script -->
        <script>
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        </script>
        <script>
       
    $(document).ready(function(){
       
 
        displayPrescription();
       
      
    });
        function displayPrescription(){
           
                var readStatusAdmin = "readStatusAdmin";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readStatusAdmin : readStatusAdmin
                    },
                    success: function(data){
                     
                        $("#contentUnpaidAdmin").html(data);
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
          
                
</script>

        </body>

</html>