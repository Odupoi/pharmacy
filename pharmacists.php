
 <?php  include "header.php"?>
<!-- start content-->
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10"><h4>Pharmacists</h4><br></div>
                        <div class="col-md-2"><button class="btn btn-primary" data-toggle="modal" data-target="#addpharmacist">+Add Pharmacist</button></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="contentPharmacists">

            <?php  include "footer.php"?>

<!-- ALL the modals appear here -->
<!-- Add modal -->
                    <div class="modal" id="addpharmacist">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Pharmacist</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                            <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="catname">Pharmacist name</label>
                                        <input type="text" id="pharmacistName" class="form-control" placeholder="Username">
                                    </div>
                                <div class="form-group">
                                    <label for="catname">Pharmacist email</label>
                                    <input type="email" id="pharmacistEmail" class="form-control" placeholder="Email">
                                </div>
                                <div class="custom-file form-group">
                                    <input type="file" class="custom-file-input form-control" required id="profilePic" name="profilePic">
                                    <label class="custom-file-label" for="customFile">Profile Pic</label>
                                    <br>
                                </div>
                                <div class="form-group">
                                    <label for="password">Pharmacist Password</label>
                                    <input type="password" id="pharmacistPassword" class="form-control">
                                </div>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="addPharmacist();" data-dismiss="modal" class="btn btn-primary submitBtn">Add Pharmacist</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end add modal -->
<!-- update modal -->
<div class="modal" id="updatePharmacist">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update Pharmacist</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                        <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="catname">Pharmacist name</label>
                                        <input type="text" id="pharmacistNameUpdate" class="form-control" placeholder="Username">
                                    </div>
                                <div class="form-group">
                                    <label for="catname">Pharmacist email</label>
                                    <input type="email" id="pharmacistEmailUpdate" class="form-control" placeholder="Email">
                                </div>
                                <div class="custom-file form-group">
                                    <input type="file" class="custom-file-input form-control" required id="profilePicUpdate" name="profilePic">
                                    <label class="custom-file-label" for="customFile">Profile Pic</label>
                                    <br>
                                </div>
                                <div class="form-group">
                                    <label for="password">Pharmacist Password</label>
                                    <input type="password" id="pharmacistPasswordUpdate" class="form-control">
                                </div>
                                <input type="hidden" id="hidden_user_id">
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="updatePharmacist();" data-dismiss="modal" class="btn btn-primary submitBtn">Update</button>
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
                
                displayPharmacist();
            });
            function displayPharmacist(){
                var readPharmacist = "readPharmacist";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readPharmacist : readPharmacist
                    },
                    success: function(data){
                        $("#contentPharmacists").html(data);
                    }
                });

            }
            function addPharmacist(){
               
                var pharmacistName = $('#pharmacistName').val();
                var pharmacistEmail = $('#pharmacistEmail').val();
                var pharmacistPassword = $('#pharmacistPassword').val();

                if($.trim(pharmacistName)== ""|| $.trim(pharmacistEmail) == ""|| $.trim(pharmacistPassword) == "")
                {
                    alert("fill all fields");
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
        var file_data = $("#profilePic").prop("files")[0]; // Getting the properties of file from file field
         var form_data = new FormData(); // Creating object of FormData class
         form_data.append("profilePic", file_data); // Appending parameter named file with properties of file_field to form_data
         form_data.append("pharmacistName", pharmacistName); // Adding extra parameters to form_data
         form_data.append("pharmacistEmail", pharmacistEmail);
         form_data.append("pharmacistPassword", pharmacistPassword);
        

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
                  displayPharmacist();

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
            displayPharmacist();
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
          var users = JSON.parse(data);

          $('#pharmacistNameUpdate').val(users.username);

          $('#pharmacistEmailUpdate').val(users.user_email);
         



        }

        );
        $('#updatePharmacist').modal("show");
    }
    function updatePharmacist(){
       
        var updateId = $('#hidden_user_id').val();
        var updatePharmacistName = $('#pharmacistNameUpdate').val();
        var updatePharmacistEmail = $('#pharmacistEmailUpdate').val();
        var updatePharmacistPassword = $('#pharmacistPasswordUpdate').val();

    if($.trim(updatePharmacistName)== ""|| $.trim(updatePharmacistEmail) == ""|| $.trim(updatePharmacistPassword) == "")
                {
                    alert("fill all fields");
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
       
        var file_data = $("#profilePicUpdate").prop("files")[0]; // Getting the properties of file from file field
         var form_data = new FormData(); // Creating object of FormData class
         form_data.append("profilePicUpdate", file_data); // Appending parameter named file with properties of file_field to form_data
         form_data.append("updatePharmacistName", updatePharmacistName); // Adding extra parameters to form_data
         form_data.append("updatePharmacistEmail", updatePharmacistEmail);
         form_data.append("updateId", updateId);
         form_data.append("updatePharmacistPassword", updatePharmacistPassword);
        
            
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
                  displayPharmacist();

            }
        });
      }
    }
            
        </script>

        </body>

</html>