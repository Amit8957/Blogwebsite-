<?php
include "header.php";

//getting the blog id 
 echo $blogID=$_GET['id'];
 if(empty($blogID))
 {
  header("location:index.php");
 }
 
if(isset($_SESSION['user_data']))
{
    $author_id=$_SESSION['user_data']['0'];
}
//fetch categories 
$sql="SELECT * FROM categories";
$query=mysqli_query($config,$sql);

 $sql2="SELECT * FROM blog LEFT JOIN categories ON blog.category=categories.cat_id LEFT JOIN user  ON blog.author_id=user.user_id WHERE blog_id='$blogID'
 ";
 
 $query2=mysqli_query($config, $sql2);
$result=mysqli_fetch_assoc($query2);






?>
   <div class ="container ">
<h5 class ="mb-2 text-grey-800" > Blogs</h5>
<div class="row">


<div class="col-xl-8 col-lg-6">
<div class="card">
<div class="card-header">

<h6 class="font-weight-bold text-primary mt-2">Publish blog or Article</h6>

</div>
<div class="card-body">
<form action="" method="POST" enctype="multipart/form-data">
<div class="mb-3">
<input type="text" name="blog_title" placeholder="Blog Title" class="form-control" required value="<?=$result['blog_title']?>">
</div>
<div class="mb-3">
<label>Body/Description</label>
<textarea class="form-control"  name="blog_body" rows="2" id="blog" required <?=$result['blog_body']?>>

</textarea>
</div>
<div class="mb-3">
<input type="file" name="blog_image"class="form-control" required>
<img src="upload/<?=$result['blog_image']?>" width="100px" class="border">
</div>
<div class="mb-3">
<select class="form-control" name="category" required>


<?php while($cats=mysqli_fetch_assoc($query))
{ ?>

  
<option vlaue="<?= $cats['cat_id'] ?>">

<?php
if($result['category']==$cats['cat_id'] )
{
echo " selected";
}
else
{
    echo "";
}
?>
<?= $cats['cat_name'] ?>

</option>
<?php } ?>
</select>
</div>

<div class= "mb-3" >
<input type="submit" name="add_blog" value="Update" class="btn btn-primary">
<a href="index.php" class="btn btn-secondary" >Back</a>
</div>
</form>
</div>
</div>
</div>
</div>

</div>

<?php
include "footer.php" ;
if(isset($_POST['edit_blog']))
{
    $title=mysqli_real_escape_string($config,$_POST['blog_title']);
    $body=mysqli_real_escape_string($config,$_POST['blog_body']);
    $filename=$_FILES['blog_image']['name'];
    
    $tmp_name=$_FILES['blog_image']['tmp_name'];
    $size=$_FILES['blog_image']['size'];
    $image_ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    $allow_type=['jpg' ,'png','jpeg'];
    $destination="upload/".$filename;
    $category=mysqli_real_escape_string($config ,$_POST['category']);
    if(!empty($filename))
    {
      //  echo " post update with image ";
      if(in_array($image_ext,$allow_type))
      {
          echo "Ok";
          if($size <= 2000000 )
          {
             // echo "Ok";
             $unlink="upload/".$result['blog_image'];
             unlink($unlink);
             move_uploaded_file($tmp_name,$destination);
             $sql3="UPDATE blog  SET blog_title='$title' ,blog_body='$body',blog_image=' $filename' , category='$category',author_id='$author_id' WHERE
              blog_id='$blogID'";
             $query3=mysqli_query($config,$sql3);
             if($query3)
             {
              $msg=['Post updated  Successfully','alert-success'];
              $_SESSION['msg']=$msg;
              header("location:index.php");
          
             }
             else
             {
              $msg= ['Failed  Please try again','alert-danger'];
              $_SESSION['msg']=$msg;
              header("location:index.php");
          
             }
          }
          else{
             // echo " image size should not be greater than 2mb";
             $msg= ['Failed  Please try again','alert-danger'];
             $_SESSION['msg']=$msg;
             header("location:index.php");
          }
      }
      else{
        //  echo "File type is not allowed (only jpg, png, and jpeg)";
        $msg= ['File type is not allowed (only jpg, png, and jpeg)','alert-danger'];
        $_SESSION['msg']=$msg;
        header("location:index.php");
      }
  }
  
  
    }
    else{
       // echo " post update without image ";
       $sql3="UPDATE blog  SET blog_title='$title' ,blog_body='$body', category='$category',author_id='$author_id' WHERE
       blog_id='$blogID'";
      $query3=mysqli_query($config,$sql3);
      if($query3)
      {
       $msg=['Post updated  Successfully','alert-success'];
       $_SESSION['msg']=$msg;
       header("location:index.php");
   
      }
      else
      {
       $msg= ['Failed  Please try again','alert-danger'];
       $_SESSION['msg']=$msg;
       header("location:index.php");
   
      }
    }


?> 


