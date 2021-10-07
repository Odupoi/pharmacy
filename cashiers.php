
 <?php  include "header.php"?>
<!-- start content-->
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10"><h4>Cashiers</h4><br></div>
                        <div class="col-md-2"><button class="btn btn-primary" data-toggle="modal" data-target="#addCashier">+Add Cashier</button></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="contentCashiers">

            <?php  include "footer.php"?>

<!-- ALL the modals appear here -->
<!-- Add modal -->
                    <div class="modal" id="addCashier">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Cashiers</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                            <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="catname">Cashier name</label>
                                        <input type="text" id="cashierName" class="form-control" placeholder="Username">
                                    </div>
                                <div class="form-group">
                                    <label for="catname">Cashier email</label>
                                    <input type="email" id="cashierEmail" class="form-control" placeholder="Email">
                                </div>
                                <div class="custom-file form-group">
                                    <input type="file" class="custom-file-input form-control" required id="profilePic" name="profilePic">
                                    <label class="custom-file-label" for="customFile">Profile Pic</label>
                                    <br>
                                </div>
                                <div class="form-group">
                                    <label for="password">Cashier Password</label>
                                    <input type="password" id="cashierPassword" class="form-control">
                                </div>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="addCashier();" data-dismiss="modal" class="btn btn-primary submitBtn">Add Cashier</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end add modal -->
<!-- update modal -->
<div class="modal" id="updateCashier">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update Category</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                        <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="catname">Cashier name</label>
                                        <input type="text" id="cashierNameUpdate" class="form-control" placeholder="Username">
                                    </div>
                                <div class="form-group">
                                    <label for="catname">Cashier email</label>
                                    <input type="email" id="cashierEmailUpdate" class="form-control" placeholder="Email">
                                </div>
                                <div class="custom-file form-group">
                                    <input type="file" class="custom-file-input form-control" required id="profilePicUpdate" name="profilePic">
                                    <label class="custom-file-label" for="customFile">Profile Pic</label>
                                    <br>
                                </div>
                                <div class="form-group">
                                    <label for="password">Cashier Password</label>
                                    <input type="password" id="cashierPasswordUpdate" class="form-control">
                                </div>
                                <input type="hidden" id="hidden_user_id">
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="updateCashier();" data-dismiss="modal" class="btn btn-primary submitBtn">Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end update modal -->

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
                
                displayCashiers();
            });
            function displayCashiers(){
                var readCashier = "readCashier";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readCashier : readCashier
                    },
                    success: function(data){
                        $("#contentCashiers").html(data);
                    }
                });

            }
            function addCashier(){
               
                var cashierName = $('#cashierName').val();
                var cashierEmail = $('#cashierEmail').val();
                var cashierPassword = $('#cashierPassword').val();

                if($.trim(cashierName)== ""|| $.trim(cashierEmail) == ""|| $.trim(cashierPassword) == "")
                {
                    alert("fill all fields");
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
        var file_data = $("#profilePic").prop("files")[0]; // Getting the properties of file from file field
         var form_data = new FormData(); // Creating object of FormData class
         form_data.append("profilePic", file_data); // Appending parameter named file with properties of file_field to form_data
         form_data.append("cashierName", cashierName); // Adding extra parameters to form_data
         form_data.append("cashierEmail", cashierEmail);
         form_data.append("cashierPassword", cashierPassword);
        

        //now lets submit the data
            $.ajax({
              url: "../includes/action.php",
              dataType: 'script',
              cache: false,
              contentType: false,
              processData: false,
              type: "post",
              data: form_data,
              success : function(data){
                  alert(data);


                document.getElementById("message").innerHTML =
                  "<br><div class='alert alert-danger alert-dismissible fade show'>"+data+"</div>";
                  displayCashiers();

            }
        });
      }
                }
    function deleteUser(deleteUserId){
      var conf = confirm("Are you Sure?");
      if(conf==true){
        $.ajax({
          url: "../includes/action.php",
          type: "post",
          data: {
            deleteUserId: deleteUserId
          },
          success: function(data, status){
            displayCashiers();
          }
        });
        
      }
    }
    function getUserDetails(user_id)
    {
        $('#hidden_user_id').val(user_id);

        $.post("../includes/action.php", {
          user_id:user_id
        }, function(data, status){
          var user = JSON.parse(data);

          $('#cashierNameUpdate').val(user.username);

          $('#cashierEmailUpdate').val(user.user_email);
         



        }

        );
        $('#updateCashier').modal("show");
    }
    function updateCashier(){
       
        var updateId = $('#hidden_user_id').val();
        var updateCashierName = $('#cashierNameUpdate').val();
        var updateCashierEmail = $('#cashierEmailUpdate').val();
        var updateCashierPassword = $('#cashierPasswordUpdate').val();

    if($.trim(updateCashierName)== ""|| $.trim(updateCashierEmail) == ""|| $.trim(updateCashierPassword) == "")
                {
                    alert("fill all fields");
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
       
        var file_data = $("#profilePicUpdate").prop("files")[0]; // Getting the properties of file from file field
         var form_data = new FormData(); // Creating object of FormData class
         form_data.append("profilePicUpdate", file_data); // Appending parameter named file with properties of file_field to form_data
         form_data.append("updateCashierName", updateCashierName); // Adding extra parameters to form_data
         form_data.append("updateCashierEmail", updateCashierEmail);
         form_data.append("updateId", updateId);
         form_data.append("updateCashierPassword", updateCashierPassword);
        
            
        //now lets submit the data
            $.ajax({
              url: "../includes/action.php",
              dataType: 'script',
              cache: false,
              contentType: false,
              processData: false,
              type: "post",
              data: form_data,
              success : function(data){
                  alert(data);


                document.getElementById("message").innerHTML =
                  "<br><div class='alert alert-danger alert-dismissible fade show'>"+data+"</div>";
                  displayCashiers();

            }
        });
      }
    }
            
        </script>

        </body>

</html>