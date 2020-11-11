<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$msg = '';

//check if the given item with the primary key exists
if (isset($_GET['M_SYSCODE'])) {
    $stmt = $pdo->prepare('SELECT * FROM PRODUCT WHERE M_SYSCODE = ?');
    $stmt->execute([$_GET['M_SYSCODE']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        exit('Product doesn\'t exist with that primary key!');
    }

    //Asking the users second time if they really want to delete the item
    if (isset($_GET['confirm']) and isset($_GET['option'])) {
        if ($_GET['confirm'] == 'yes') {
            //$stmt = $pdo->prepare('DELETE FROM PRODUCT WHERE M_SYSCODE = ?');
            //$stmt->execute([$_GET['M_SYSCODE']]);          
                if($_GET['option'] == 'cascade'){ 
                    //urun abstract ise inactive yap degilse cascade sil 
                    //select that product's id
                    //delete that product
                    //delete all product  have that id as parent-code
                    //update other tables also

                    $msg = 'You have deleted the selected product! (CASCADE)';
                }
                else if ($_GET['option'] == 'link'){
                    //abstract ise secilemez degilse bu urunu parent alanlarin parentini guncelle.
                    //abstract olmayan urunler zaten diger tablolarda yer alamaz. kategori belirtiyorlar aslinda.
                    //select that product's  parent id
                    //delete that product
                    //update all products parent id 


                    $msg = 'You have deleted the selected product! (LINK)';
                }          
        } else {
            header('Location: read_product.php');
            exit;
        }
    }
    if(isset($_GET['confirm'])){
        if($_GET['confirm'] == 'no'){
            header('Location: read_product.php');
            exit;
        }
    }    
} else {
    exit('No primary key has been specified!');
}
?>

<?=template_header('Delete')?>

<div class="product delete">
	<h2>Delete Product #<?=$product['M_SYSCODE']?></h2>
    <?php if ($msg): ?>
    <p><?php  
    echo("<script>alert('$msg')</script>");
    echo("<script>window.location = 'read_product.php';</script>");  
     ?></p>
    <?php else: ?>
     <?php if (!isset($_GET['confirm'])) : ?>
	<p>Are you sure you want to delete the selected product #<?=$product['M_SYSCODE']?>?</p>
    <div class="yesno">
        <a href="delete_product.php?M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=yes">Yes</a>
        <a href="delete_product.php?M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=no">No</a>
    </div>
        <?php elseif ($_GET['confirm'] == 'yes'):?> 

        <p>Cascade Delete or Other #<?=$product['M_SYSCODE']?>?</p>
        <div class="yesno">
            <a href="delete_product.php?M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=yes&option=cascade">Cascade</a>
            <a href="delete_product.php?M_SYSCODE=<?=$product['M_SYSCODE']?>&confirm=yes&option=link">Link child products to the my parent</a>
        </div> 
        <?php endif ?> 
    <?php endif ?> 
</div>

<?=template_footer()?>
