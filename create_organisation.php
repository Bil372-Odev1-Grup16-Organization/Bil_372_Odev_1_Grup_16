<?php
include ("connect.php");
include 'functions.php';
$msg = '';
if(isset($_POST['submit'])) {
    $orgName = mysqli_real_escape_string($conn,$_POST['org-name']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $cityName = mysqli_real_escape_string($conn,$_POST['city']);
    $sql="SELECT CITY_ID FROM COUNTRY_CITY WHERE CITY_NAME = \"$cityName\"";
    $result = mysqli_query($conn,$sql);
    $row =mysqli_fetch_assoc($result);
    $city= $row["CITY_ID"];
    $district = mysqli_real_escape_string($conn,$_POST['district']);
    if(isset($_POST['abstract'])){
        $abstract = 1;
    }
    else{
        $abstract=0;
    }
    $typeString=mysqli_real_escape_string($conn,$_POST['type']);
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

    $sql = "INSERT   INTO ORGANISATIONS (ORG_NAME, PARENT_ORG , ORG_ABSTRACT, ORG_ADDRESS, ORG_CITY,ORG_DISTRICT,ORG_TYPE) VALUES ('$orgName',$parentid,$abstract,'$address',$city,'$district',$type)";
    if (!mysqli_query($conn, $sql)){
        if(strpos(mysqli_error($conn), "Duplicate")){
            $error = "A Organisation which has this name and parent already exists ". "<br>";
        }
        else{
            echo "Error: "  . mysqli_error($conn);
        }

    }
    $msg = "Created Successfully";
}
?>
<style>
select {
  width: 400px;
  height:43px;
  border-radius: 4px;
}
</style>


<?=template_header('Create')?>

<div class="content update">
	<h2>Create Organisation</h2>
    <form action="create_organisation.php" method="post">
        <label for="org-name">Org_name</label>
        <label for="parent">Parent</label>
        <input type="text" name="org-name" placeholder="Organisation Name" required="required" autofocus >
        <select  name="parent"  required="required" >
                <option value="" disabled selected>   Select your parent Company   </option>
                <option>NONE</option>
                <?php  $sql = "SELECT * FROM ORGANISATIONS";
                       $result = mysqli_query($conn,$sql);
                       while($row = mysqli_fetch_assoc($result)) {
                        if($row['ORG_ABSTRACT'] == 0):
                            $tmp= $row["ORG_ID"];
                            if($row["PARENT_ORG"]== 0){ ?>
                                <option><?php echo $row["ORG_NAME"]. "--" ."NONE" ;  ?></option>
                            <?php }
                            $sql2="SELECT ORG_NAME,ORG_ABSTRACT FROM ORGANISATIONS WHERE PARENT_ORG = $tmp ";
                            $result2 = mysqli_query($conn,$sql2);
                            while($row2=mysqli_fetch_assoc($result2)){     ?>
                              <?php  if($row2["ORG_ABSTRACT"] == 0): ?>
                                    <option><?php echo $row2["ORG_NAME"]. "--" .$row["ORG_NAME"] ;  ?></option>
                              <?php    endif;               ?>
                        <?php   } endif; }               ?>
        </select>

        <label for="ORG_ADDRESS">ORG_ADDRESS</label>
        <label for="ORG_TYPE">Type</label>
        <input type="text" name="address" placeholder="example value" >
        <select  name="type"  >
                <option>Supplier</option>
                <option>Consumer</option>
                <option>Both</option>
        </select>

        <label for="ORG_DISTRICT">ORG_DISTRICT</label>
        <label for="ORG_CITY">City</label>
        <input type="text" name="district" placeholder="example value" >
        <select  name="city"  required="required"  >
                <option value="" disabled selected>City</option>
                <?php  $sql = "SELECT CITY_NAME FROM COUNTRY_CITY";
                       $result = mysqli_query($conn,$sql);
                       while($row = mysqli_fetch_assoc($result)) {        ?>
                            <option><?php echo $row["CITY_NAME"] ;  ?></option>
                       <?php   }           ?>
        </select>

        <!-- need debug here -->
        <label for="ORG_ABSTRACT">Is Abstract? </label>
        <label></label>
        <label><input style="width: 20px" type="checkbox" name="abstract" value="1" > Yes</label>
        <label></label>

        <!--<label for="created">Created on </label>
         <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" -->
        <input type="submit" name="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?php echo("<script>alert('$msg')</script>");
     echo("<script>window.location = 'read_organisations.php';</script>");    ?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
