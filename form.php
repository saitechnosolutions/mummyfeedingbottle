<?php
    
    if(isset($_POST['submit']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['pnumber'];
        $message = $_POST['message'];
        $subject =$_POST['subject'];

        $to = 'goldenbabyproducts78@gmail.com';
        
        $subject = "Form Submission";
        $message = "  Name :".$name. "\n"   . " email :".$email. "\n" ."pnumber :". $phone.  "\n"  ."message :". $message. "\n" ."subject :".$subject ;
        


        if(mail($to,$subject,$message))
        {
            echo "<script>alert('Mail Sent Successfully...')</script>";
            echo "<script>window.location='contact.php'</script>";
        }
        else
        {
            echo "<script>alert('Mail Not Sent...')</script>";
            echo "<script>window.location='contact.php</script>";
        }
    }
?>