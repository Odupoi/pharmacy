<?php  
    include "../includes/dbconnect.php";
    session_start();
    $server =$_SESSION['username'];
    if($_SESSION['user_group'] != '1')
    {
        header("location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Pharmacy Management System</title>

        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="../assets/css/app.css" rel="stylesheet">

    </head>

        <body>


            <div class="d-flex" id="wrapper">

<!--my sidebar-->
                <div class="bg-light border-right" id="sidebar-wrapper">
                    <div class="sidebar-heading">
                        <img src="../assets/images/logo.png" class="img-fluid" width="20%" style="margin-right: -700px;" alt="Logo"><br>
                        <h4><b>MAYIAN</b></h4></div>

                    <div class="list-group list-group-flush">
                        <a href="index.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-dashboard"></i> Dashboard</a>
                        <a href="stock.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-houzz"></i> Stock</a>
                        <a href="pharmacists.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-medkit"></i> Pharmacists</a>
                        <a href="cashiers.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-money"></i> Cashiers</a>
                        <a href="patients.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-user"></i> Patients</a>
                        <a href="categories.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-list-alt"></i> Categories</a>
                        <a href="prescription.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-file"></i> Prescription Report</a>
                        <a href="paid.php" class="list-group-item list-group-item-action bg-light"><i class="fa fa-file"></i> Payment Report</a>
                    </div>
                </div>
                <!-- end of my sidebar -->

                <!-- code for the Top navigation bar-->
                <div id="page-content-wrapper">

                    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                        <button class="btn btn-outline-primary" id="menu-toggle">Toggle Menu</button>

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                                
                            <a class="nav-link" href="#">Welcome Admin <span class="sr-only">(current)</span></a>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="../logout.php">Logout</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
<!--End of top navigation bar-->