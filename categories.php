
 <?php  include "header.php"?>
<!-- start content-->
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10"><h4>Categories</h4><br></div>
                        <div class="col-md-2"><button class="btn btn-primary" data-toggle="modal" data-target="#addCat">+Add</button></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <div id="card table-responsive">
                            <table id="example" class="table table-striped table-bordered" style="border-radius: 20px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $number = 1;
                                $sql = "SELECT * FROM categories";
                                $result = mysqli_query($con, $sql);
                                while($row = mysqli_fetch_array($result))
                                {

                                
                            
                            ?>
                                <tr>
                                    <td><?php echo $number; ?></td>
                                    <td><?php echo $row['cat_name']; ?></td>
                                    <td><?php echo $row['cat_desc']; ?></td>
                                    
                                    <td><button class="btn btn-primary" onclick="getCatDetails(<?php echo $row['cat_id']; ?>);">Edit</button></td>
                                        <td><button class="btn btn-danger" onclick="deleteCat(<?php echo $row['cat_id']; ?>);">Delete</button></td>
                            
                            </tr>

                            <?php 
                                $number++;
                                } ?>
                        </tbody>
                    </table>

            <?php  include "footer.php"?>

<!-- ALL the modals appear here -->
<!-- Add modal -->
                    <div class="modal" id="addCat">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Category</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                            <form>
                                <div class="form-group">
                                    <label for="catname">Category name</label>
                                    <input type="text" id="catName" class="form-control" placeholder="name">
                                </div>
                                <div class="form-group">
                                    <label for="catname">Category Desc:</label>
                                    <textarea id="catDesc" cols="10" rows="10" class='form-control'>
                                    </textarea>
                                </div>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="addCat();" data-dismiss="modal" class="btn btn-primary submitBtn">Add</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end add modal -->
<!-- update modal -->
<div class="modal" id="updateCat">
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
                            <form>
                                <div class="form-group">
                                    <label for="catname">Category name</label>
                                    <input type="text" id="catNameUpdate" class="form-control" placeholder="name">
                                </div>
                                <div class="form-group">
                                    <label for="catname">Category Desc:</label>
                                    <textarea id="catDescUpdate" cols="10" rows="10" class='form-control'>
                                    </textarea>
                                </div>
                                <input type="hidden" id="hidden_cat_id">
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="updateCat();" data-dismiss="modal" class="btn btn-primary submitBtn">Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end update modal -->

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
                $('#example').DataTable({
                    "paging":   false,
                "ordering": false,
                "info":     false
                }); 
             
            });
            
            function addCat(){
                var catName = $('#catName').val();
                var catDesc = $('#catDesc').val();

                if($.trim(catName)== ""|| $.trim(catDesc) == "")
                {
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
          $.ajax({
              url: "../includes/action.php",
              type: "post",
              data: {
                  catName : catName,
                  catDesc : catDesc
              },
              success: function(data){
                  displayCat();
              }
          })
      }
                }
    function deleteCat(deleteCatId){
      var conf = confirm("Are you Sure?");
      if(conf==true){
        $.ajax({
          url: "../includes/action.php",
          type: "post",
          data: {
            deleteCatId: deleteCatId
          },
          success: function(data, status){
            displayCat();
          }
        });
        
      }
    }
    function getCatDetails(cat_id)
    {
        $('#hidden_cat_id').val(cat_id);

        $.post("../includes/action.php", {
          cat_id:cat_id
        }, function(data, status){
          var cat = JSON.parse(data);

          $('#catNameUpdate').val(cat.cat_name);

          $('#catDescUpdate').val(cat.cat_desc);
         



        }

        );
        $('#updateCat').modal("show");
    }
    function updateCat(){
        var updateCatName = $('#catNameUpdate').val();
        var updateCatDesc = $('#catDescUpdate').val();
        var updateId = $('#hidden_cat_id').val();

        if($.trim(updateCatName)== ""|| $.trim(updateCatDesc) == "")
                {
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
                }else{
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        updateId:       updateId,
                        updateCatName : updateCatName,
                        updateCatDesc : updateCatDesc
                    },
                    success: function(data){
                        displayCat();
                    }
                })
            }
    }
            
        </script>

        </body>

</html>