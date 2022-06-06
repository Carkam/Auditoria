<?php 

    class Correo
    {
        public function CompraRealizada($to,$subject,$message)
        {
            $headers = 'From: bryana3@gmail.com' . "\r\n" .
            'Reply-To: bryana3@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

            mail($to,$subject,$message,$headers);

        }
        
    }
    

?>