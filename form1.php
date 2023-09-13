<?php


	
	if(isset($_POST['submit']))
	{
		 $name = $_POST['name'];
        
        $phone = $_POST['pnumber'];
       
        $email = $_POST['email'];
        $Message = $_POST['message'];
        $subject =$_POST['subject'];



   
    $subject = "Resume Submission";
    // $message = $_POST['message'];
    
    // Check whether submitted data is not empty
    if(!empty($customername) && !empty($orderdate)){
        
        
        if(filter_var($name, FILTER_SANITIZE_STRING) === false){
            $statusMsg = 'Please enter your name.';
        }else{
            $uploadStatus = 1;
            
            // Upload attachment file
            if(!empty($_FILES["invoice"]["name"])){
                
                // File path config
                $targetDir = "../assets/uploads/";
                $fileName = basename($_FILES["invoice"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                
                // Allow certain file formats
                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
                if(in_array($fileType, $allowTypes)){
                    // Upload file to the server
                    if(move_uploaded_file($_FILES["invoice"]["tmp_name"], $targetFilePath)){
                        $uploadedFile = $targetFilePath;
                    }else{
                        $uploadStatus = 0;
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                }else{
                    $uploadStatus = 0;
                    $statusMsg = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
                }
            }
            
            if($uploadStatus == 1){
                
                // Recipient
                $toEmail = "goldenbabyproducts78@gmail.com";

                // Sender
                // $from = $email;
                $fromName =  $name;
                
                // Subject
                $emailSubject = 'Mail Submission '. $name;
                
                // Message 
               $htmlContent = '<table style="border:1px solid black;">';
                $htmlContent .= '<tr style="border:1px solid black;">';
                $htmlContent .= '<td style=""></td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr style="border:1px solid black;">';
                $htmlContent .= '<td style="border:1px solid black;">Name</td>';
                $htmlContent .= '<td style="border:1px solid black;">'.$name.'</td>';
                $htmlContent .= '<tr style="border:1px solid black;">';
                $htmlContent .= '<td style="border:1px solid black;">Phone Number</td>';
                $htmlContent .= '<td style="border:1px solid black;">'.$phone.'</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr style="border:1px solid black;">';
                $htmlContent .= '<td style="border:1px solid black;">Email Id</td>';
                $htmlContent .= '<td style="border:1px solid black;">'.$email.'</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr style="border:1px solid black;">';
                $htmlContent .= '<td style="border:1px solid black;">Mobile Number</td>';
                $htmlContent .= '<td style="border:1px solid black;">'.$phone.'</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr style="border:1px solid black;">';
                $htmlContent .= '<td style="border:1px solid black;">Message</td>';
                $htmlContent .= '<td style="border:1px solid black;">'.$Message.'</td>';
                $htmlContent .= '</tr>';
                $htmlContent .= '<tr style="border:1px solid black;">';
                $htmlContent .= '<td style="border:1px solid black;">subject</td>';
                $htmlContent .= '<td style="border:1px solid black;">'.$subject.'</td>';
                $htmlContent .= '</tr>';
               $htmlContent .= '</table>';
                
                
                    
                
                // Header for sender info
                $headers = "From: $fromName";

                if(!empty($uploadedFile) && file_exists($uploadedFile)){
                    
                    // Boundary 
                    $semi_rand = md5(time()); 
                    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
                    
                    // Headers for attachment 
                    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
                    
                    // Multipart boundary 
                    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                    "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
                    
                    // Preparing attachment
                    
                    $message .= "--{$mime_boundary}--";
                    // $returnpath = "-f" . $email;
                    
                    // Send email
                    $mail = mail($toEmail, $emailSubject, $message, $headers);
                    
                    // Delete attachment file from the server
                    @unlink($uploadedFile);
                }else{
                     // Set content-type header for sending HTML email
                    $headers .= "\r\n". "MIME-Version: 1.0";
                    $headers .= "\r\n". "Content-type:text/html;charset=UTF-8";
                    
                    // Send email
                    $mail = mail($toEmail, $emailSubject, $htmlContent, $headers); 
                }
                
                // If mail sent
                if($mail){
                    $statusMsg = 'Your contact request has been submitted successfully !';
                    // $msgClass = 'succdiv';
                    
                    // $postData = '';
                    $dispatchdate = date('Y-m-d');
                    echo "<script>alert('Mail Sent successfully..')</script>";
                  
                    echo "<script>window.location='home.php'</script>";
                }else{
                    $statusMsg = 'Your contact request submission failed, please try again.';
                }
            }
        }
    }else{
        $statusMsg = 'Please fill all the fields.';
    }
}
?>