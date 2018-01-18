<?php


if(count($_POST)>0){
  $product = new ProductData();
  $product->barcode = $_POST["barcode"];
  $product->name = $_POST["name"];
  $product->price_in = $_POST["price_in"];
  $product->price_out = $_POST["price_out"];
  $product->unit = $_POST["unit"];
  $product->description = $_POST["description"];
  $product->presentation = $_POST["presentation"];
  //$product->inventary_min = $_POST["inventary_min"];
  $category_id="NULL";
  if($_POST["category_id"]!=""){ $category_id=$_POST["category_id"];}
  $inventary_min="\"\"";
  if($_POST["inventary_min"]!=""){ $inventary_min=$_POST["inventary_min"];}

  $product->category_id=$category_id;
  $product->inventary_min=$inventary_min;
  $product->user_id = $_SESSION["user_id"];

/*
  if(isset($_FILES["image"])){

    $image = new Upload($_FILES['image']); 

    if ($image->uploaded) {
   // save uploaded image with no changes
     $image->Process('storage/products/');
     $product->image = $image->file_dst_name;

     if ($image->processed) {
       echo 'original image copied';
     } else {
       echo 'error : ' . $image->error;
     }
   // save uploaded image with a new name
     $image->file_new_name_body = 'image';
     $image->Process('storage/products/');
     if ($image->processed) {
       echo 'image renamed "image" copied';
     } else {
       echo 'error : ' . $image->error;
     }   
   // save uploaded image with a new name,
   // resized to 100px wide
     $image->file_new_name_body = 'image_resized';
     $image->image_resize = true;
     $image->image_convert = gif;
     $image->image_x = 100;
     $image->image_ratio_y = true;
     $image->Process('storage/products/');
     if ($image->processed) {
       echo 'image renamed, resized x=100
       and converted to GIF';
       $image->Clean();
     } else {
       echo 'error : ' . $image->error;
       $prod= $product->add();
     } 
   }
 }
 else{

  $prod= $product->add();

}
*/


if(isset($_FILES["image"])){

  $image = new Upload($_FILES["image"]);
  if($image->uploaded){
    $image->Process("storage/products/");

    if($image->processed){

      $product->image = $image->file_dst_name;
      $image->Process("storage/products/");
      $prod = $product->add_with_image();

    }
  }else{

    $prod= $product->add();
  }
}
else{

  $prod= $product->add();

}




if($_POST["q"]!="" || $_POST["q"]!="0"){
 $op = new OperationData();
 $op->product_id = $prod[1] ;
 $op->operation_type_id=OperationTypeData::getByName("entrada")->id;
 $op->q= $_POST["q"];
 $op->sell_id="NULL";
 $op->is_oficial=1;
 $op->add();
}

print "<script>window.location='index.php?view=products';</script>";


}


?>