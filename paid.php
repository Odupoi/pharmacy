
 <?php  include "header.php"?>
<!-- start content-->
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10"><h4>Payments</h4><br></div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="table-responsive">
                    <table id="paymentReporti" class="table table-striped" style="border-radius: 20px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Patient Name</th>
                        <th>Prescription</th>
                        <th>Total pills</th>
                        <th>Total Price</th>
                       <th>Served by</th>
                        <th>Status</th>
                        <th>Date</th>
                       

                    </tr>
                </thead>
                <tbody id="paymentReport">
                        
             

            <?php  include "footer.php"?>



            </div>
            <script src="../assets/js/jquery.min.js"></script>
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
       
 
        displayPaymentReport();  
       
      
    });
        function displayPaymentReport(){
         
                var readPaymentReport = "readPaymentReport";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readPaymentReport : readPaymentReport
                    },
                    success: function(data){
                      
                        $("#paymentReport").html(data);
                    }
                });

            }
           
           
                
</script>

        </body>

</html>