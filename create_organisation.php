<?php
// Front-end kismi gelene kadar gecici, sonrasinda duzenlenecek.
include ("connect.php");
include 'functions.php';
$msg = '';
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
}
?>
<style>
select {
  width: 400px;
  height:43px;
  border-radius: 4px;
  background-color: #f1f1f1;
}


</style>




<?=template_header('Create')?>

<div class="content update">
	<h2>Create Organisation</h2>
    <form action="create_organisation.php" method="post">
        <label for="org_name">Org_name</label>
        <label for="parent">Parent</label>
        <input type="text" name="org-name" placeholder="Organisation Name" required="required" autofocus >
        <select  name="parent"  required="required" >
                <option value="" disabled selected>   Select your parent Company   </option>
                <option>NONE</option>
                <?php  $sql = "SELECT * FROM ORGANISATIONS";
                       $result = mysqli_query($conn,$sql);  
                       while($row = mysqli_fetch_assoc($result)) {
                        $tmp= $row["ORG_ID"];
                        if($row["PARENT_ORG"]== 0){ ?>
                            <option><?php echo $row["ORG_NAME"]. "--" ."NONE" ;  ?></option> 
                        <?php }    
                        $sql2="SELECT ORG_NAME FROM ORGANISATIONS WHERE PARENT_ORG = $tmp ";
                        $result2 = mysqli_query($conn,$sql2);
                        while($row2=mysqli_fetch_assoc($result2)){  
                                            ?>
                            <option><?php echo $row2["ORG_NAME"]. "--" .$row["ORG_NAME"] ;  ?></option>
                        <?php   }}               ?>      
            </select>

        <label for="ORG_ABSTRACT">Is Abstract? </label>
        <label for="ORG_ADRESS">ORG_ADRESS</label>
        <input type="text" name="ORG_ABSTRACT" placeholder="evample value" >
        <input type="text" name="ORG_ADDRESS" placeholder="example value" >

        <label for="ORG_DISTRICT">ORG_DISTRICT</label>
        <label for="ORG_CITY">City</label>
        <input type="text" name="ORG_DISTRICT" placeholder="example value" >
        <select  name="city"  required="required" class= 'select' >
                <option value="" disabled selected>City</option>
                <?php  $sql = "SELECT CITY_NAME FROM COUNTRY_CITY";
                       $result = mysqli_query($conn,$sql);  
                       while($row = mysqli_fetch_assoc($result)) {        ?>
                            <option><?php echo $row["CITY_NAME"] ;  ?></option>
                       <?php   }           ?>      
            </select>
                       
        <label for="ORG_TYPE">Type</label>
        <label for="ORG_TYPE"> </label>
        <select  name="dropdown"  >
                <option>Supplier</option>
                <option>Consumer</option>
                <option>Both</option>            
            </select>
        <!--<label for="created">Created on </label>
         <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" -->                
        <input type="submit" value="Create" style="margin: 0px 0px 0px 100px ;">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
