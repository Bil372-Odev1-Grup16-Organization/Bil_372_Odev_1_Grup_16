<?php
include("connect.php");
//eklenecek




?>




<!DOCTYPE html>
<html lang="en">
<head>
 <!-- Required meta tags -->
 <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<style>
.form-group {
    margin-bottom: 10px;
}
.login-form {
    width: 500px;
    margin: 8px auto;
  	font-size: 15px;
}
.login-form form {
    margin-bottom: 10px;
    background: #f7f7f7;
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 20px;
}
.login-form h2 {
    margin: 0 0 5 5px;
}

</style>
</head>
<body>



<div class="login-form">
    <form action = "" method = "post" class="form-signin">
        <h2 class="text-center">Sign Up</h2>       
        <div class="form-group">
            <input type="text" class="form-control" name="org-name" placeholder="Organisation Name" required="required" autofocus >
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name" required="required">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="surname" placeholder="Surname" required="required" >
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="required" >
        </div>
        <div class="form-group">
            <input type="tel" class="form-control" name="telphone" placeholder="888 888 8888" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12"   required/>    
            <label style="font-size:10px;padding-left:20px"> Eg : 552 222 2224  </label>         
        </div>
        
        <div class="form-group">
            <input type="tel" class="form-control" name="fax" placeholder="90 888 888 8888" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12"   required/>    
            <label style="font-size:10px;padding-left:20px"> Eg : 90 334 222 2224  </label>         
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="adress" placeholder="Adress" required="required" >
        </div>
        
        <div class="form-group">
            <input type="text" class="form-control" name="city" placeholder="City" required="required" >
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="district" placeholder="District" >
        </div>
        <div class="clearfix form-group">
            <label class="float-left form-check-label"><input type="checkbox"> Abstract</label>
        </div>   
        <div class="form-group">
            
            <select class="form-control" placeholder="Type" >
            <option>Supplier</option>
            <option>Consumer</option>
            <option>Both</option>            
        </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" required="required" >
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="repassword" placeholder="Confirm Password" required="required">
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-lg btn-primary btn-block">Sign Up</button>
        </div>
            
    </form>
    
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
