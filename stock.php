
 <?php  include "header.php"?>
 <?php  include "../includes/dbconnect.php"?>
<!-- start content-->
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10"><h4>Medicine stock</h4><br></div>
                        <div class="col-md-2"><button class="btn btn-primary" data-toggle="modal" data-target="#addMedicine">+Add Stock</button></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        
                        <div class="card table-responsive p-3">
                        <table id="example" class="table" style="border-radius: 20px; width: 100%;">
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
                            <tbody>
                            <?php 
                                $number = 1;
                                $sql = "SELECT stock.id, stock.bar_code, stock.medicine_name, stock.pic, categories.cat_name, stock.quantity, stock.used_quantity, stock.remain_quantity, stock.register_date, stock.expire_date, stock.company, stock.actual_price, stock.selling_price, stock.profit_price, stock.status FROM stock, categories WHERE stock.cat_id = categories.cat_id";
                                $result = mysqli_query($con, $sql);
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
                                    <td><?php echo $row['actual_price']; ?></td>
                                    <td><?php echo $row['selling_price']; ?></td>
                                    <td><?php echo $row['profit_price']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td><button class="btn btn-primary" onclick="getStockDetails(<?php echo $row['id']; ?>);">Edit</button></td>
                                    <td><button class="btn btn-danger" onclick="deleteMedicine(<?php echo $row['id']; ?>);">Delete</button></td>
                            
                            </tr>

                            <?php 
                                $number++;
                                } ?>
                        </tbody>
                    </table>

            <?php  include "footer.php"?>

<!-- ALL the modals appear here -->
<!-- Add modal -->
                    <div class="modal" id="addMedicine">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Medicine</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                            <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="barcode">Bar Code</label>
                                        <input type="text" id="barCode" class="form-control">
                                    </div>
                                <div class="form-group">
                                    <label for="name">Medicine name</label>
                                    <input type="text" id="medicineName" class="form-control">
                                </div>
                                <div class="custom-file form-group">
                                    <input type="file" class="custom-file-input form-control" required id="medicinePic" name="profilePic">
                                    <label class="custom-file-label" for="customFile">Medicine Photo</label>
                                    <br>
                                </div>
                             
                                <div class="form-group">
                                    <label for="category">Medicine Category</label>
                                    <select name="medCat" id="medicineCategory" class="form-control">
                                        <option value="">Select Category</option>
                                    <?php
                                    
                                        $result = mysqli_query($con,"SELECT * FROM categories");
                                        while($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?php echo $row['cat_id'];?>"><?php echo $row["cat_name"];?></option>
                                    <?php
                                        }
                                    ?>
                                       
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Medicine Quantity</label>
                                    <input type="number" id="medicineQuantity" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="date">Expiry Date</label>
                                    <input type="date" id="medicineExpiry" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Company Name</label>
                                    <input type="text" id="companyName" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="price">Acual Price in KSH.</label>
                                    <input type="number" id="actualPrice" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="price">Selling Price</label>
                                    <input type="number" id="sellingPrice" class="form-control">
                                </div>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="addStock();" data-dismiss="modal" class="btn btn-primary submitBtn">Add Stock</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                        </div>
                    </div>
                    </div>
<!-- end add modal -->
<!-- update modal -->
<div class="modal" id="updateStock">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update Stock</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                        <div id="message"></div>
                        <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="barcode">Bar Code</label>
                                        <input type="text" id="barCodeUpdate" class="form-control">
                                    </div>
                                <div class="form-group">
                                    <label for="name">Medicine name</label>
                                    <input type="text" id="medicineNameUpdate" class="form-control">
                                </div>
                                <div class="custom-file form-group">
                                    <input type="file" class="custom-file-input form-control" required id="medicinePicUpdate" name="profilePic">
                                    <label class="custom-file-label" for="customFile">Medicine Photo</label>
                                    <br>
                                </div>
                             
                                <div class="form-group">
                                    <label for="category">Medicine Category</label>
                                    <select name="medCat" id="medicineCategoryUpdate" class="form-control">
                                        <option value="">Select Category</option>
                                    <?php
                                    
                                        $result = mysqli_query($con,"SELECT * FROM categories");
                                        while($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?php echo $row['cat_id'];?>"><?php echo $row["cat_name"];?></option>
                                    <?php
                                        }
                                    ?>
                                       
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">Medicine Quantity</label>
                                    <input type="number" id="medicineQuantityUpdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="date">Expiry Date</label>
                                    <input type="date" id="medicineExpiryUpdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Company Name</label>
                                    <input type="text" id="companyNameUpdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="price">Acual Price in KSH.</label>
                                    <input type="number" id="actualPriceUpdate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="price">Selling Price</label>
                                    <input type="number" id="sellingPriceUpdate" class="form-control">
                                </div>
                                <input type="hidden" id="hidden_medicine_id">
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button  id="btnAddCode" onclick="updateStock();" data-dismiss="modal" class="btn btn-primary submitBtn">Update</button>
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
                
                displayStock();
                $('#example').DataTable({
                    "paging":   false,
                "ordering": false,
                "info":     false
                }); 
            });
            function displayStock(){
                var readStock = "readStock";
                // sending the ajax responsive to action.php
                $.ajax({
                    url: "../includes/action.php",
                    type: "post",
                    data: {
                        readStock : readStock
                    },
                    success: function(data){
                        $("#contentStock").html(data);
                    }
                });

            }
            function addStock(){
               
                var barCode = $('#barCode').val();
                var medicineName = $('#medicineName').val();
                var medicineCategory = $('#medicineCategory').val();
                var medicineQuantity = $('#medicineQuantity').val();
                var medicineExpiry = $('#medicineExpiry').val();
                var companyName = $('#companyName').val();
                var actualPrice = $('#actualPrice').val();
                var sellingPrice = $('#sellingPrice').val();

                if($.trim(barCode)== ""|| $.trim(medicineName) == ""|| $.trim(medicineCategory) == ""| $.trim(medicineQuantity) == ""|| $.trim(medicineExpiry) == ""
                | $.trim(companyName) == ""|| $.trim(actualPrice) == ""| $.trim(sellingPrice) == "")
                {
                    alert("fill all fields");
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
        var file_data = $("#medicinePic").prop("files")[0]; // Getting the properties of file from file field
         var form_data = new FormData(); // Creating object of FormData class
         form_data.append("medicinePic", file_data); // Appending parameter named file with properties of file_field to form_data
         form_data.append("barCode", barCode);
         form_data.append("medicineName", medicineName); // Adding extra parameters to form_data
         form_data.append("medicineCategory", medicineCategory);
         form_data.append("medicineQuantity", medicineQuantity);
         form_data.append("medicineExpiry", medicineExpiry);
         form_data.append("companyName", companyName); // Adding extra parameters to form_data
         form_data.append("actualPrice", actualPrice);
         form_data.append("sellingPrice", sellingPrice);
        

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
                  displayStock();

            }
        });
      }
                }
    function deleteMedicine(deleteMedicineId){
      var conf = confirm("Are you Sure?");
      if(conf==true){
        $.ajax({
          url: "../includes/action.php",
          type: "post",
          data: {
            deleteMedicineId: deleteMedicineId
          },
          success: function(data, status){
            displayStock();
          }
        });
        
      }
    }
    function getStockDetails(medicine_id)
    {
        $('#hidden_medicine_id').val(medicine_id);

        $.post("../includes/action.php", {
            medicine_id:medicine_id
        }, function(data, status){
          var medicine = JSON.parse(data);
          $('#barCodeUpdate').val(medicine.bar_code);
          $('#medicineNameUpdate').val(medicine.medicine_name);
          $('#medicineCategoryUpdate').val(medicine.category);
          $('#medicineQuantityUpdate').val(medicine.quantity);
          $('#medicineExpiryUpdate').val(medicine.expire_date);
          $('#companyNameUpdate').val(medicine.company);
          $('#actualPriceUpdate').val(medicine.actual_price);
          $('#sellingPriceUpdate').val(medicine.selling_price);
         



        }

        );
        $('#updateStock').modal("show");
    }
    function updateStock(){
                var updateId = $('#hidden_medicine_id').val();
                var updateBarCode = $('#barCodeUpdate').val();
                var updateMedicineName = $('#medicineNameUpdate').val();
                var updateMedicineCategory = $('#medicineCategoryUpdate').val();
                var updateMedicineQuantity = $('#medicineQuantityUpdate').val();
                var updateMedicineExpiry = $('#medicineExpiryUpdate').val();
                var updateCompanyName = $('#companyNameUpdate').val();
                var updateActualPrice = $('#actualPriceUpdate').val();
                var updateSellingPrice = $('#sellingPriceUpdate').val();

                if($.trim(updateBarCode)== ""|| $.trim(updateMedicineName) == ""|| $.trim(updateMedicineCategory) == ""| $.trim(updateMedicineQuantity) == ""|| $.trim(updateMedicineExpiry) == ""
                | $.trim(updateCompanyName) == ""|| $.trim(updateActualPrice) == ""| $.trim(updateSellingPrice) == "")
                {
                    alert("fill all fields");
                    document.getElementById("message").innerHTML =
          "<br><div class='alert alert-danger alert-dismissible fade show'>Fill in all the fields!</div>";
      }else{
        var file_data = $("#medicinePicUpdate").prop("files")[0]; // Getting the properties of file from file field
         var form_data = new FormData(); // Creating object of FormData class
         form_data.append("medicinePicUpdate", file_data); // Appending parameter named file with properties of file_field to form_data
         form_data.append("updateId", updateId);
         form_data.append("updateBarCode", updateBarCode);
         form_data.append("updateMedicineName", updateMedicineName   ); // Adding extra parameters to form_data
         form_data.append("updateMedicineCategory", updateMedicineCategory);
         form_data.append("updateMedicineQuantity", updateMedicineQuantity);
         form_data.append("updateMedicineExpiry", updateMedicineExpiry); // Adding extra parameters to form_data
         form_data.append("updateCompanyName", updateCompanyName);
         form_data.append("updateActualPrice", updateActualPrice);
         form_data.append("updateSellingPrice", updateSellingPrice);
        

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
                  displayStock();

            }
        });
      }
}

            
        </script>

        </body>

</html>