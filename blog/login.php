
<?php  
 include 'config.php';
include 'header.php';
session_start();
if(isset($_SESSION['user_data']))
{
    header ("location:http://localhost/blog/admin/index.php");
}
 ?>
 
 <div  class ="container ">
    <div class="row">
        <div class ="col-xl-5 col-md-4 m-auto p-5 mt-5 bg-info">
            <form action =" "  method="POST">
            <p class="text-center"> Login To Your Account</p>
            <div class="mb-3">
                <input type ="email" name="email" placeholder=" Enter  Email" class=" form-control" required>
            </div>
            <div class="mb-3">
                <input type ="password" name="password" placeholder=" Enter Password" class=" form-control" required >
            </div>
            <div class="mb-3">
                <input type ="submit" name="login_btn" class=" btn btn-primary" value="Login">
            </div>
            </div>
            
            <?php
            if(isset($_SESSION['error']))
            {
               $error= $_SESSION['error'] ;
               echo "<p class='bg-danger p-2 text-white'>" .$error."</p>";;
               unset($_SESSION['error']);
            }
        ?>
</form>
        </div>


   </div>
</div>

';

<?php
include 'footer.php';
if(isset($_POST['login_btn']))
{
    $email= mysqli_real_escape_string( $config,$_POST['email']);
    $pass=mysqli_real_escape_string($config, sha1($_POST['password']));

 $sql=" Select * from  user  where email='{$email}' and password ='{$pass}'";
$query=mysqli_query( $config,$sql);
$data=mysqli_num_rows( $query);
if($data)
{
   // echo "Login";
   $result=mysqli_fetch_assoc($query);
   $user_data=array($result['user_id'],$result['username'],$result['role']);
   $_SESSION['user_data']=$user_data;
    header("location:admin/index.php");

}
else
{
    
    $_SESSION['error']="Invalid email/Password";
    header("location:login.php");




}
}
?>