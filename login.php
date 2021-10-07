

<html>
    <head>
        <title>Pharmacy Management System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="A pharmacy Management System">
        <meta name="author" content="Tom">

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="assets/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <p><br><br></p>
            <div style="display: flex;justify-content: center;">

                <img src="assets/images/logo.png" class="img-fluid" width="10%" alt="Logo">

            </div>
            <p style="text-align: center;">Pharmacy Management System</p>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card p-5">
                    <div id="message"></div>
                        <form >
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" id="usernameLogin" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="username">Password</label>
                                <input type="password" id="passwordLogin" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="username">Select Level:</label>
                                <select id="levelLogin" class="form-control">
                                    <option value="">Select Level</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Pharmacist</option>
                                    <option value="3">Cashier</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" id="login"  onclick="login();">Login</button>
                                <br>
                                <p><a href="index.php">Home</a></p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
        <!-- Menu Toggle Script -->
    <script>
    $(document).ready(function(){
       
       
       
        $("#login").click(function(){
            
        var username = $('#usernameLogin').val();      
        var password = $('#passwordLogin').val();    
        var level = $('#levelLogin').val(); 
        
        if($.trim(username) == "")
        {
           alert("Input username");
        }else if($.trim(password) == "")
        {
           alert("input password");
        }else  if($.trim(level) == "")
        {
           alert("Select level ");
        }else{

            $.ajax({
                url: "includes/action.php",
                type: "post",
                data: {
                    username: username,
                    password: password,
                    level: level
                },
                success: function(data){
                    if($.trim(data) == "no match"){
                        alert('No Matching Credentials')
                    }else if(level == '3'){
                        window.location.href = "cashier/index.php";
                    }
                    else if(level == '2'){
                        window.location.href = "pharmacist/index.php";
                    }
                    else if(level == '1'){
                        window.location.href = "admin/index.php";
                    }
                }
            })
        }

    });
   
    });
    
 
   

 
    </script>
</html>