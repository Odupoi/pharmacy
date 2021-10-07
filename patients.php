
 <?php  include "header.php"?>
<!-- start content-->
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10"><h4>Patients</h4><br></div>
                        <div class="col-md-2"><button class="btn btn-primary" data-toggle="modal" data-target="#addPatient">+Add Patient</button></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="card table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="border-radius: 20px;">
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
                                <tbody>
                                <?php 
                                $number = 1;
                                $sql = "SELECT * FROM patients";
                                $result = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_array($result))
                                {

                                
                            
                            ?>
                                <tr>
                                    <td><?php echo $number; ?></td>
                                    <td><?php echo $row['patient_name']; ?></td>
                                    <td><?php echo $row['patient_mobile']; ?></td>
                                    <td><?php echo $row['patient_age']; ?></td>
                                    <td><?php echo $row['patient_comments']; ?></td>
                                    <td><button class="btn btn-primary" onclick="getPatientDetails(<?php echo $row['patient_id'];?>);">Edit</button></td>
                                        <td><button class="btn btn-danger" onclick="deletePatient(<?php echo $row['patient_id'];?>);">Delete</button></td>
                            
                            </tr>

                            <?php 
                                $number++;
                                } ?>
                        </tbody>
                    </table>

            <?php  include "footer.php"?>

<!-- ALL the modals appear here -->
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
<!-- update modal -->
<div class="modal" id="updatePatient">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update Patient</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                            <form>
                                <div class="form-group">
                                    <label for="name">Patient name</label>
                                    <input type="text" id="patientNameUpdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Patient Mobile:</label>
                                    <input type="number" id="patientMobileUpdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="age">Patient Age:</label>
                                    <input type="number" id="patientAgeUpdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="comments">Patient Comments:</label>
                                    <textarea id="patientCommentsUpdate" cols="10" rows="10" class='form-control'>
                                    </textarea>
                                </div>
                                <input type="hidden" id="hidden_patient_id">
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="updatePatient();" data-dismiss="modal" class="btn btn-primary submitBtn">Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end update modal -->

            </div>
            <script src="../assets/js/jquery.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
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
                $('#example').DataTable();
                displayPatient();
                
            });
            function displayPatient(){
                var readPatient = "readPatient";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readPatient : readPatient
                    },
                    success: function(data){
                        $("#contentPatients").html(data);
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
    function deletePatient(deletePatientId){
      var conf = confirm("Are you Sure?");
      if(conf==true){
        $.ajax({
          url: "../includes/action.php",
          type: "post",
          data: {
            deletePatientId: deletePatientId
          },
          success: function(data, status){
            displayPatient();
          }
        });
        
      }
    }
    function getPatientDetails(patient_id)
    {
        $('#hidden_patient_id').val(patient_id);

        $.post("../includes/action.php", {
            patient_id:patient_id
        }, function(data, status){
          var patient = JSON.parse(data);

          $('#patientNameUpdate').val(patient.patient_name);
          $('#patientMobileUpdate').val(patient.patient_mobile);
          $('#patientAgeUpdate').val(patient.patient_age);
          $('#patientCommentsUpdate').val(patient.patient_comments);
         



        }

        );
        $('#updatePatient').modal("show");
    }
    function updatePatient(){
        var updateId = $('#hidden_patient_id').val();
        var updatePatientName = $('#patientNameUpdate').val();
        var updatePatientMobile = $('#patientMobileUpdate').val();
        var updatePatientAge = $('#patientAgeUpdate').val();
        var updatePatientComments = $('#patientCommentsUpdate').val();

        if($.trim(updatePatientName)== ""|| $.trim(updatePatientMobile) == "" || $.trim(updatePatientAge) == "" || $.trim(updatePatientComments) == "")
                {
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
                }else{
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        updateId:       updateId,
                        updatePatientName : updatePatientName,
                        updatePatientMobile: updatePatientMobile,
                        updatePatientAge : updatePatientAge,
                        updatePatientComments : updatePatientComments
                    },
                    success: function(data){
                        displayPatient();
                    }
                })
            }
    }
            
        </script>

        </body>

</html>