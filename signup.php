<?php
//city dropdown olarak verilecek
include("connect.php");
$error="";
$isOkay=FALSE;
if(isset($_POST['submit'])) {
    $orgName = mysqli_real_escape_string($conn,$_POST['org-name']);
    $name = mysqli_real_escape_string($conn,$_POST['name']); 
    $surname = mysqli_real_escape_string($conn,$_POST['surname']);
    $email = mysqli_real_escape_string($conn,$_POST['email']); 
    $tel = mysqli_real_escape_string($conn,$_POST['tel']);
    $fax = mysqli_real_escape_string($conn,$_POST['fax']); 
    $adress = mysqli_real_escape_string($conn,$_POST['adress']);
    $cityName = mysqli_real_escape_string($conn,$_POST['city']);

    $sql="SELECT CITY_ID FROM COUNTRY_CITY WHERE CITY_NAME = \"$cityName\"";
    $result = mysqli_query($conn,$sql);
    $row =mysqli_fetch_assoc($result);
    
    $city= $row["CITY_ID"];


    $district = mysqli_real_escape_string($conn,$_POST['district']);     
    if(isset($_POST['checkbox'])){
        $abstract = 1;
    }
    else{
        $abstract=0;
    }
    $typeString=mysqli_real_escape_string($conn,$_POST['dropdown']); 
    if(strcmp($typeString,"Supplier") == 0){
        $type=0;
    }
    else if(strcmp($typeString,"Consumer") == 0){
        $type=1;
    }
    else{
        $type=2;
    }
    $parents=mysqli_real_escape_string($conn,$_POST['parent']); 
    if(strcmp($parents,"NONE")==0){
        $parentid=0;
    }
    else{
    $arr=explode("--", $parents);
    $parent=$arr[0];
    $parentOfParent=$arr[1];
    if(strcmp($parentOfParent, "NONE")==0){
        $sql="SELECT ORG_ID FROM ORGANISATIONS WHERE ORG_NAME = \"$parent\" AND PARENT_ORG = 0";
        $result = mysqli_query($conn,$sql);
        $row =mysqli_fetch_assoc($result);
        $parentid= $row["ORG_ID"];
    }
    
    $sql="SELECT ORG_ID FROM ORGANISATIONS WHERE ORG_NAME = \"$parentOfParent\"";
    $result = mysqli_query($conn,$sql);
    while( $row = mysqli_fetch_assoc($result)){
            $parentOfParent_id= $row["ORG_ID"];
            $sql2="SELECT ORG_ID FROM ORGANISATIONS WHERE PARENT_ORG = $parentOfParent_id AND ORG_NAME = \"$parent\" ";
            $result2 = mysqli_query($conn,$sql2);
            if(mysqli_num_rows($result2)<1){
                continue;
            }
            $row2=mysqli_fetch_assoc($result2);
            $parentid= $row2["ORG_ID"];
    }
    }  
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $confirmpass= mysqli_real_escape_string($conn,$_POST['repassword']);
    if($password != $confirmpass){
        $error ="THE PASSWORDS DO NOT MATCH" ;  
        
    }  


    if(strlen($error) == 0 )
             $isOkay=TRUE;




    if($isOkay){
    $sql = "INSERT IGNORE  INTO ORG_OWNER (ORG_NAME, NAME , SURNAME, EMAIL, PHONE,FAX,ADRESS) VALUES ('$orgName','$name','$surname','$email','$tel','$fax','$adress')";
    if (!mysqli_query($conn, $sql))  
        echo "Error: " . mysqli_error($conn);

    $sql = "INSERT   INTO ORGANISATIONS (ORG_NAME, PARENT_ORG , ORG_ABSTRACT, ORG_ADDRESS, ORG_CITY,ORG_DISTRICT,ORG_TYPE) VALUES ('$orgName',$parentid,$abstract,'$adress','$city','$district',$type)";
    if (!mysqli_query($conn, $sql)){  
        if(strpos(mysqli_error($conn), "Duplicate") !== false){
            $error = "A Organisation which has this name and parent already exists ". "<br>";
        }   
        else{
            echo "Error: "  . mysqli_error($conn); 
        }             

    } 
    $sql = "INSERT INTO USERS (NAME,PASSWORD,USERNAME) VALUES ('$name $surname','$password','$username')";
    if (!mysqli_query($conn, $sql)){
        if(strpos(mysqli_error($conn), "Duplicate") !== false){
            $error .= "This username already exists" . "<br>";
        }   
        else{
            echo "Error: "  . mysqli_error($conn); 
        }         
    } 
    header("location: logins.php");
    }     

}


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
.error {
    font-size:18px;
    color:#cc0000; 
    margin-top:30px
}
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


<div class="error text-center"><?php echo $error; ?> </div>
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
            <input type="tel" class="form-control" name="tel" placeholder="888 888 8888" pattern="[0-9]{3} [0-9]{3} [0-9]{4}" maxlength="12"   required/>    
            <label style="font-size:10px;padding-left:20px"> Eg : 552 222 2224  </label>         
        </div>
        
        <div class="form-group">
            <input type="tel" class="form-control" name="fax" placeholder="90 555 555 8888" pattern="[0-9]{2} [0-9]{3} [0-9]{3} [0-9]{4}" maxlength="15"   required/>    
            <label style="font-size:10px;padding-left:20px"> Eg : 90 334 222 2224  </label>         
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="adress" placeholder="Adress" required="required" >
        </div>
        
        <div class="form-group">       
            <select class="form-control" name="city"  required="required" >
                <option value="" disabled selected>City</option>
                <?php  $sql = "SELECT CITY_NAME FROM COUNTRY_CITY";
                       $result = mysqli_query($conn,$sql);  
                       while($row = mysqli_fetch_assoc($result)) {        ?>
                            <option><?php echo $row["CITY_NAME"] ;  ?></option>
                       <?php   }           ?>      
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="district" placeholder="District" >
        </div>
        <div class="clearfix form-group">
            <label class="float-left form-check-label"><input name="checkbox" type="checkbox"> Abstract</label>
        </div>   
        <div class="form-group">       
            <select class="form-control" name="dropdown"  >
                <option>Supplier</option>
                <option>Consumer</option>
                <option>Both</option>            
            </select>
        </div>
        <div class="form-group">       
            <select class="form-control" name="parent"  required="required" >
                <option value="" disabled selected>Select your parent Company</option>
                <option>NONE</option>
                <?php  $sql = "SELECT * FROM ORGANISATIONS";
                       $result = mysqli_query($conn,$sql);  
                       while($row = mysqli_fetch_assoc($result)) {
                        $a= $row["ORG_ID"];
                        if($row["PARENT_ORG"]== 0){ ?>
                            <option><?php echo $row["ORG_NAME"]. "--" ."NONE" ;  ?></option> 
                        <?php }    
                        $sql2="SELECT ORG_NAME FROM ORGANISATIONS WHERE PARENT_ORG = $a ";
                        $result2 = mysqli_query($conn,$sql2);
                        while($row2=mysqli_fetch_assoc($result2)){  
                                            ?>
                            <option><?php echo $row2["ORG_NAME"]. "--" .$row["ORG_NAME"] ;  ?></option>
                        <?php   }}               ?>      
            </select>
        </div>
        <label style="font-size:10px;padding-left:20px"> Usage : A -- B = Your parent is company A whose parent company is B  </label> 
        <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" required="required" >
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password" minlength="4" required="required" >
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
