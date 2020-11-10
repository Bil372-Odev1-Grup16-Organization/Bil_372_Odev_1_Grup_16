<?php
// Front-end kismi gelene kadar gecici, sonrasinda duzenlenecek.
include ("connect.php");
if(isset($_POST['submit'])) {
    $orgName = mysqli_real_escape_string($conn,$_POST['org-name']);
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

    $sql = "INSERT   INTO ORGANISATIONS (ORG_NAME, PARENT_ORG , ORG_ABSTRACT, ORG_ADDRESS, ORG_CITY,ORG_DISTRICT,ORG_TYPE) VALUES ('$orgName',$parentid,$abstract,'$adress','$city','$district',$type)";
    if (!mysqli_query($conn, $sql)){  
        if(strpos(mysqli_error($conn), "Duplicate") !== false){
            $error = "A Organisation which has this name and parent already exists ". "<br>";
        }   
        else{
            echo "Error: "  . mysqli_error($conn); 
        }             

    } 
    header("location: logins.php");
        

}

?>