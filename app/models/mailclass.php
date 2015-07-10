<?php
    //define("_MEXEC","OK");
    require_once("../../system/load.php");

    $emailAddress = 'booking@roomista.com';
    //echo $_SESSION['random_number'];
    require "../../smtpmailclass/class.phpmailer.php";
    require "../../smtpmailclass/class.smtp.php";

    class mailClass
    {
        function clientRegistration($clientTitle, $clientFirstName, $clientLastName, $clientUsername, $clientEmail, $customerPassword)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'You have Successfully Registered with www.roomista.com';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br/>
                    Dear <strong> ' . $clientTitle . '&nbsp;' . $clientFirstName . '&nbsp;' . $clientLastName . '</strong>, <br/><br/>
                    Welcome to roomista.com... Asia\'s hottest hotel booking system.<br/>
                    Please use the following link and log-in details to access your hotel details:<br/>

                    You may log in to your Account/  Online hotel booking system from the
                    <span style="list-style:square; color:#069;"><a href="' . HTTP_PATH . 'clients/?q=l" target="_blank">Login Panel</a></span>
                    <br/><br/><br/>

                    <strong>Panel Username :</strong> ' . $clientUsername . '<br/>
                    <strong>Panel Password :</strong> <span style="color:#F00"><strong> ' . $customerPassword . '</strong> </span><br/>
                    <br/><br/>
                    <br/>
                    <p>Wishing you a happy booking experience.<br/>
                    System Administrator<br/>
                    <strong>ROOMISTA  - on ' . date('Y-m-d h:i a') . '</strong><br/>


                    <hr/>
                    <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">This e-mail is confidential. It may also be legally privileged. If you are not the intended recipient or have received it in error, please delete it and all copies from your system and notify the sender immediately by return e-mail. Any unauthorized reading, reproducing, printing or further dissemination of this e-mail or its contents is strictly prohibited and may be unlawful. Internet communications cannot be guaranteed to be timely, secure, error or virus-free. The sender does not accept liability for any errors or omissions.</span>
                    </td>
                    </tr>
                    </table>
            ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password
            $mail->From = $systemSetting->sySettingReservationEmail(); //$_REQUEST['email'];
            $mail->FromName = 'Roomista Reservations';
            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($clientEmail, $clientLastName);
            //$mail->AddCC(, "");
            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        // end of function

        function MemberRegistration($memberTitle, $memberFirstName, $memberLastName, $memberUsername, $memberEmail, $memberPassword)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'You have Successfully Registered with www.roomista.com';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br>
                    Dear <strong> ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '</strong>, <br/><br/>
                    Welcome to roomista.com... Asia\'s hottest hotel booking system.<br/><br/>

                    Please use the following link and log-in details to access your hotel details:<br/><br/><br/>

                    You may log in to your Account from the
                    <span style="list-style:square; color:#069;"><a href="' . HTTP_PATH . 'register/?q=l" target="_blank">Login Panel</a></span>
                    <br/><br/>
                    <strong>Panel Username :</strong> ' . $memberUsername . '<br/>
                    <strong>Panel Password :</strong> <span style="color:#F00"><strong> ' . $memberPassword . '</strong> </span>
                    <br/><br/>

                    <br/>
                    <p>Wishing you a happy stay.<br/>
                    System Administrator<br/><br/><br/>
                    <strong>ROOMISTA  - on ' . date('Y-m-d h:i a') . '</strong><br/>

                    <hr/>
                    <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">This e-mail is confidential. It may also be legally privileged. If you are not the intended recipient or have received it in error, please delete it and all copies from your system and notify the sender immediately by return e-mail. Any unauthorized reading, reproducing, printing or further dissemination of this e-mail or its contents is strictly prohibited and may be unlawful. Internet communications cannot be guaranteed to be timely, secure, error or virus-free. The sender does not accept liability for any errors or omissions.</span>
                    </td>
                    </tr>
                    </table>
                ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingReservationEmail();
            $mail->FromName = 'Roomista Reservations';

            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($memberEmail, $memberLastName);

            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        function MemberChangeLogin($memberTitle, $memberFirstName, $memberLastName, $memberUsername, $memberEmail, $newPassword)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'You have Successfully Changed Your Login Details';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br>
                    Dear <strong> ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '</strong>, <br/><br/>
                    You have successfully changed your login details.<br/><br/>

                    Please use the following link and New Log-In details to access your hotel details:<br/><br/><br/>

                    You may log in to your Account from the
                    <span style="list-style:square; color:#069;"><a href="' . HTTP_PATH . 'register/?q=l" target="_blank">Login Panel</a></span>
                    <br/><br/>
                    <strong>Panel Username :</strong> ' . $memberUsername . '<br/>
                    <strong>Panel Password :</strong> <span style="color:#F00"><strong> ' . $newPassword . '</strong> </span>
                    <br/><br/>

                    <br/>
                    <p>Wishing you a happy stay.<br/>
                    System Administrator<br/><br/><br/>
                    <strong>ROOMISTA  - on ' . date('Y-m-d h:i a') . '</strong><br/>

                    <hr/>
                    <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">This e-mail is confidential. It may also be legally privileged. If you are not the intended recipient or have received it in error, please delete it and all copies from your system and notify the sender immediately by return e-mail. Any unauthorized reading, reproducing, printing or further dissemination of this e-mail or its contents is strictly prohibited and may be unlawful. Internet communications cannot be guaranteed to be timely, secure, error or virus-free. The sender does not accept liability for any errors or omissions.</span>
                    </td>
                    </tr>
                    </table>
                ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingReservationEmail();
            $mail->FromName = 'Roomista Reservations';

            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($memberEmail, $memberLastName);

            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        function HotelRegistration($memberTitle, $memberFirstName, $memberLastName, $memberEmail, $hotelName, $hotelUsername, $hotelPassword)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'You have Successfully Registered Your Hotel with www.roomista.com';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br>
                    Dear <strong> ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '</strong>, <br/><br/>
                    Your "'.$hotelName.'" successfully added to roomista.com.<br/><br/>

                    Please use the following link and log-in details to access your hotel profile:<br/><br/><br/>

                    You may log in to your Hotel\'s Account from the
                    <span style="list-style:square; color:#069;"><a href="' . HTTP_PATH . 'hotels/" target="_blank">Login Panel</a></span>
                    <br/><br/>
                    <strong>Panel Username :</strong> ' . $hotelUsername . '<br/>
                    <strong>Panel Password :</strong> <span style="color:#F00"><strong> ' . $hotelPassword . '</strong> </span>
                    <br/><br/>

                    <br/>
                    <p>Wishing you a happy stay.<br/>
                    System Administrator<br/><br/><br/>
                    <strong>ROOMISTA  - on ' . date('Y-m-d h:i a') . '</strong><br/>

                    <hr/>
                    <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">This e-mail is confidential. It may also be legally privileged. If you are not the intended recipient or have received it in error, please delete it and all copies from your system and notify the sender immediately by return e-mail. Any unauthorized reading, reproducing, printing or further dissemination of this e-mail or its contents is strictly prohibited and may be unlawful. Internet communications cannot be guaranteed to be timely, secure, error or virus-free. The sender does not accept liability for any errors or omissions.</span>
                    </td>
                    </tr>
                    </table>
                ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingReservationEmail();
            $mail->FromName = 'Roomista Reservations';

            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($memberEmail, $memberLastName);

            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        function HotelActivationSuccess($memberTitle, $memberFirstName, $memberLastName, $memberEmail, $hotelName, $hotelSEOUrl)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'Hotel Activation Success.';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br>
                    Dear <strong> ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '</strong>, <br/><br/>
                    Congratulation! your hotel profile is successfully activated and you are ready for bookings. Following are the details of your freshly created hotel profile;
                    <br>
                    <br>
                    Hotel Name: <a href="' . HTTP_PATH . $hotelSEOUrl . '.html">' . $hotelName . '</a>
                    <br>
                    <br/>
                    <br/>
                    <p>Wishing you the best roomista experience.<br/>
                    Team Roomista<br/><br/><br/>
                    <strong>Roomista.com - on ' . date('Y-m-d h:i a') . '</strong><br/>
                    <hr/>
                    <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">This e-mail is confidential. It may also be legally privileged. If you are not the intended recipient or have received it in error, please delete it and all copies from your system and notify the sender immediately by return e-mail. Any unauthorized reading, reproducing, printing or further dissemination of this e-mail or its contents is strictly prohibited and may be unlawful. Internet communications cannot be guaranteed to be timely, secure, error or virus-free. The sender does not accept liability for any errors or omissions.</span>
                    </td>
                    </tr>
                    </table>
                ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingAdminEmail();
            $mail->FromName = 'Roomista System Administrator';

            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($memberEmail, $memberLastName);

            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        function HotelDeactivationRequest($memberTitle, $memberFirstName, $memberLastName, $hotelName)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'Hotel Deactivation Request.';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br>
                    Dear Admin,
                    <br>
                    <br>
                    This is an automated notification to inform you that the following hotelier is requesting a hotel profile deactivation.
                    <br>
                    <br>
                    Hotel Name: ' . $hotelName . '
                    <br>
                    Hotelier Name: ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '
                    <br>
                    <br/>
                    <strong>Roomista.com</strong><br/>
                    </td>
                    </tr>
                    </table>
                ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingAdminEmail();
            $mail->FromName = 'Roomista Hotelier Admin Panel';

            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($systemSetting->sySettingAdminEmail(), "System Administrator");

            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        function HotelDeactivationRequestCancel($memberTitle, $memberFirstName, $memberLastName, $hotelName)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'Hotel Deactivation Request.';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br>
                    Dear Admin,
                    <br>
                    <br>
                    A hotel profile deactivation request has been cancelled by the hotelier. Following are the details of the respective account.
                    <br>
                    <br>
                    Hotel Name: ' . $hotelName . '
                    <br>
                    Hotelier Name: ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '
                    <br>
                    <br/>
                    <strong>Roomista.com</strong><br/>
                    </td>
                    </tr>
                    </table>
                ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingAdminEmail();
            $mail->FromName = 'Roomista Hotelier Admin Panel';

            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($systemSetting->sySettingReservationEmail(), "System Administrator");

            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        function HotelDeactivationSuccess($memberTitle, $memberFirstName, $memberLastName, $memberEmail, $hotelName)
        {
            $systemSetting = new systemSetting();
            $systemSetting->extractor($systemSetting->getSettings());
            $subject = 'Hotel Deactivation Request.';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                    <tr>
                    <td width="-34" bgcolor="#02487B" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                    <td width="699" align="left" bgcolor="#02487B"><img src="' . HTTP_PATH . 'images/roomista_logo_pdf.png" alt=""  /></td>
                    </tr>
                    <tr>
                    <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                    <br>
                    Dear <strong> ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '</strong>, <br/><br/>
                    This is to inform you that we have processed your deactivation request, and your hotel profile is deactivated, which bears the following details.
                    <br>
                    <br>
                    Hotel Name: ' . $hotelName . '
                    <br>
                    Hotelier Name: ' . $memberTitle . '&nbsp;' . $memberFirstName . '&nbsp;' . $memberLastName . '
                    <br>
                    <br>
                    If you would like to renew your account and join us again, do send an email to admin@roomista.com requesting an activation mentioning the hotel name.
                    <br>
                    <p>Wishing you well,<br/>
                    System Admin<br/><br/><br/>
                    <strong>Roomista.com  - on ' . date('Y-m-d h:i a') . '</strong><br/>
                    <hr/>
                    <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">This e-mail is confidential. It may also be legally privileged. If you are not the intended recipient or have received it in error, please delete it and all copies from your system and notify the sender immediately by return e-mail. Any unauthorized reading, reproducing, printing or further dissemination of this e-mail or its contents is strictly prohibited and may be unlawful. Internet communications cannot be guaranteed to be timely, secure, error or virus-free. The sender does not accept liability for any errors or omissions.</span>
                    </td>
                    </tr>
                    </table>
                ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingAdminEmail();
            $mail->FromName = 'Roomista System Administrator';

            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($memberEmail, $memberLastName);

            $mail->IsHTML(true); // send as HTML

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        }

        function contactUsForm($name, $telephone, $email, $country, $message)
        {

            $subject = "Freight Bids (PVT) Online Shipping portal - Request for contract us.. !";
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
	  <tr>
	  <td width="-34" bgcolor="#0000FF" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
	  <td width="699" align="left" bgcolor="#0000FF"><img src="' . HTTP_PATH . 'images/logo.png" alt=""  /></td>
	  </tr>
	  <tr>
	  <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
	  <br>
	  Dear <strong> Freight Bids (PVT) Online Shipping portal - Administrator,</strong>, <br/><br/>
      <br>
	 <br>
	 <p>
	  
	  <strong>name :</strong> ' . $name . '<br/>
	  <strong>telephone :</strong> ' . $telephone . '<br/>
	  <strong>email :</strong> ' . $email . '<br/>
	  <strong>country :</strong> ' . $country . '<br/>
	  <strong>message :</strong> ' . $message . '<br/>
	  <br/><br/>
	  
	  <br>
	  <p>
	 Thanking you for taking the time in Shipping online with us.
  <br/>
	 Freight Bids (PVT) Online Shipping portal<br/><br/>
	  
	  Best Regards,<br/>
	  Web Administrator<br/>
	  <strong>Freight Bids (PVT)  - on ' . date('Y-m-d h:i a') . '</strong><br/>
	  </p>
	  
	  
	  <hr/>
	  <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the Freight Bids (PVT) Online Shipping  portal. If you have not made any registration or unaware of the same, please email administrator at Info@gmail.com to remove you from this panel.</span>
	  </td>
	  </tr>
	  </table>
';

            $headers = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/html; charset=iso-8859-1";
            $headers[] = "From: Sender Name <sender@domain.com>";
            $headers[] = "Bcc: sandun <sandun.hndit@gmail.com>";
            $headers[] = "Reply-To: Recipient Name <receiver@domain3.com>";
            $headers[] = "Subject: {$subject}";
            $headers[] = "X-Mailer: PHP/" . phpversion();

            mail($customerEmail, $subject, $EmailMessage, implode("\r\n", $headers));
            return true;

        }

        // end of function

        function addBids($bidsShipperId, $bidsAmount, $bidsQuoteId)
        {
            $customer = new customer();
            $customer2 = new customer();
            $request = new request();

            $customer->setCustomerId($bidsShipperId);
            $customer->extractor($customer->getCustomerById());

            $request->setRequestId($bidsQuoteId);
            $request->extractor($request->getRequestById());

            $customer2->setCustomerId($request->requestClientId());
            $customer2->extractor($customer2->getCustomerById());

            $subject = ' Freight Bids (PVT) Online Shipping portal  New Bids in Your Request !';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
	  <tr>
	  <td width="-34" bgcolor="#333333" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
	  <td width="699" align="left" bgcolor="#333333"><img src="' . HTTP_PATH . 'images/logo.png" alt=""  /></td>
	  </tr>
	  <tr>
	  <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
	  <br>
	  Dear <strong> ' . $customer2->customerTitle() . '&nbsp;' . $customer2->customerName() . '</strong>, <br/><br/>
	 
	  
      
	  
	  <ul>
	  <li style="list-style:square; color:#069;">Request Id     :-<strong>' . $request->requestReffNo() . '</strong></li>
	  <li style="list-style:square; color:#069;">Bids Amount    :- <strong>$ &nbsp; ' . $bidsAmount . ' &nbsp; USD</strong></li>
      <li style="list-style:square; color:#069;">Shipper  Name  :- <strong>' . $customer->customerCompany() . '</strong></li>
      <li style="list-style:square; color:#069;">Shipper  Email :- <strong>' . $customer->customerEmail() . '</li>
	  <li style="list-style:square; color:#069;">Shipper  Address :- <strong>' . $customer->customerAddress1() . '</li>
      </ul>

	
	  
	  
	  
	  <br>
	  <p>
	 Thanking you for taking the time in Shipping online with us.
  <br/>
	 Freight Bids (PVT) Online Shipping portal<br/><br/>
	  
	  Best Regards,<br/>
	  Web Administrator<br/>
	  <strong>Freight Bids (PVT)  - on ' . date('Y-m-d h:i a') . '</strong><br/>
	  </p>
	  
	  
	  <hr/>
	  <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the Freight Bids (PVT) Online Shipping  portal. If you have not made any registration or unaware of the same, please email administrator at Info@gmail.com to remove you from this panel.</span>
	  </td>
	  </tr>
	  </table>
';

            $headers = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/html; charset=iso-8859-1";
            $headers[] = "From: Sender Name <sender@domain.com>";
            $headers[] = "Bcc: sandun <sandun.hndit@gmail.com>";
            $headers[] = "Reply-To: Recipient Name <receiver@domain3.com>";
            $headers[] = "Subject: {$subject}";
            $headers[] = "X-Mailer: PHP/" . phpversion();

            mail($customer2->customerEmail(), $subject, $EmailMessage, implode("\r\n", $headers));
            return true;

        }

        // end of function

        function acceptMail($requestId)
        {
            $customer = new customer();
            $request = new request();
            $bids = new bids();

            $request->setRequestId($requestId);
            $request->extractor($request->getRequestById());
            $bids->bidsId($request->requestBidsId());
            $bids->extractor($bids->getBidsById());

            $customer->setCustomerId($request->requestAcceptShiper());
            $customer->extractor($customer->getCustomerById());

            $subject = ' Freight Bids (PVT) Online Shipping portal  Clent Accepet Your Bids !';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
	  <tr>
	  <td width="-34" bgcolor="#333333" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
	  <td width="699" align="left" bgcolor="#333333"><img src="' . HTTP_PATH . 'images/logo.png" alt=""  /></td>
	  </tr>
	  <tr>
	  <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
	  <br>
	  Dear <strong> ' . $customer->customerTitle() . '&nbsp;' . $customer->customerName() . '</strong>, <br/><br/>
	 
	  
      
	  
	  <ul>
	  <li style="list-style:square; color:#069;">Request Id     :-<strong>' . $request->requestReffNo() . '</strong></li>
	  <li style="list-style:square; color:#069;">Bids Amount    :- <strong>$ &nbsp; ' . $bids->bidsAmount() . ' &nbsp; USD</strong></li>
      </ul>

	
	  
	  
	  
	  <br>
	  <p>
	 Thanking you for taking the time in Shipping online with us.
  <br/>
	 Freight Bids (PVT) Online Shipping portal<br/><br/>
	  
	  Best Regards,<br/>
	  Web Administrator<br/>
	  <strong>Freight Bids (PVT)  - on ' . date('Y-m-d h:i a') . '</strong><br/>
	  </p>
	  
	  
	  <hr/>
	  <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the Freight Bids (PVT) Online Shipping  portal. If you have not made any registration or unaware of the same, please email administrator at Info@gmail.com to remove you from this panel.</span>
	  </td>
	  </tr>
	  </table>
';

            $headers = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/html; charset=iso-8859-1";
            $headers[] = "From: Sender Name <sender@domain.com>";
            $headers[] = "Bcc: sandun <sandun.hndit@gmail.com>";
            $headers[] = "Reply-To: Recipient Name <receiver@domain3.com>";
            $headers[] = "Subject: {$subject}";
            $headers[] = "X-Mailer: PHP/" . phpversion();

            mail($customer->customerEmail(), $subject, $EmailMessage, implode("\r\n", $headers));
            return true;

        }

        // end of function

        function fogetPasswordConformAdmin($adminId, $adminActivationkey)
        {
            $systemSetting = new systemSetting();
            $common = new common();
            $systemSetting->extractor($systemSetting->getSettings());
            $CONFORMATION_CODE = $common->setActivationkey($adminActivationkey);
            // echo $CONFORMATION_CODE;
            $CODE = common :: setGenerateCode(5);
            $adminId_CODE = $adminId . $CODE;
            $adminId_CODE = base64_encode($adminId_CODE);

            $Administrator = new administrator();
            $Administrator->setAdminId($adminId);
            $Administrator->extractor($Administrator->getAdministratorByAdminId());

            $subject = $systemSetting->sySettingCompanyName() . "  Change Your Password Conformation!";
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
	  <tr>
	  <td width="-34" bgcolor="#333333" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
	  <td width="699" align="left" bgcolor="#333333"><img src="' . DOC_ROOT . 'uplode-img/company-logo/' . $systemSetting->sySettingCompanyLogo() . '"  /></td>
	  </tr>
	  <tr>
	  <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
	  <br>
	  Dear <strong> ' . $Administrator->getAdminName() . '</strong>, <br/><br/>
	 
      
      Kindly follow the below mentioned steps in Change Your Password Conformation
      <br><br>
      Activation Link   <a href="' . HTTP_PATH . 'manager/ajax-lode/password-conformation.php?q=' . $CONFORMATION_CODE . '&k=' . $adminId_CODE . '" style=" text-decoration:none;">Please click on this link to activate account. </a>
      <br><br>
	 <br>
	  <p>
	 Thanking you for taking the time in shopping online with us.
  <br/>
	  ' . $systemSetting->sySettingCompanyName() . '<br/><br/>
	  
	  Best Regards,<br/>
	  Web Administrator<br/>
	  <strong>' . $systemSetting->sySettingCompanyName() . '  - on ' . date('Y-m-d h:i a') . '</strong><br/>
	  </p>
	  
	  
	  <hr/>
	  <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the ' . $systemSetting->sySettingCompanyName() . ' Online Shoping cart  portal. If you have not made any registration or unaware of the same, please email administrator at ' . $systemSetting->sySettingCompanyEmail() . ' to remove you from this panel.</span>
	  </td>
	  </tr>
	  </table>
';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = 'smtp.gmail.com'; // sets GMAIL as the SMTP server
            $mail->Port = 465; // set the SMTP port

            $mail->Username = 'mujaconfig@gmail.com'; // GMAIL username
            $mail->Password = '1weblook'; // GMAIL password

            $mail->From = 'Roomista.com';
            $mail->FromName = 'Roomista.com';
            $mail->Subject = "You have a Contact us Request";
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($Administrator->getAdminEmail(), "alankara.com");

            $mail->IsHTML(true); // send as HTML

            $mail->Send();

        }

        // end of function

        function fogetPassword($adminId, $adminPW)
        {
            $systemSetting = new systemSetting();
            $common = new common();
            $systemSetting->extractor($systemSetting->getSettings());
            $Administrator = new administrator();
            $Administrator->setAdminId($adminId);
            $Administrator->extractor($Administrator->getAdministratorByAdminId());

            $subject = $systemSetting->sySettingCompanyName() . " &nbsp;Reset Your Password !";
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
	  <tr>
	  <td width="-34" bgcolor="#333333" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
	  <td width="699" align="left" bgcolor="#333333"><img src="' . DOC_ROOT . 'uplode-img/company-logo/' . $systemSetting->sySettingCompanyLogo() . '" /></td>
	  </tr>
	  <tr>
	  <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
	  <br>
	  Dear <strong> ' . $Administrator->getAdminName() . '</strong>, <br/><br/>
	 Thank you for confirming, following is your username and temporary password. 
      <br>
	 <br>
	 <p>
	  
	  <strong>Panel Username :</strong> ' . $Administrator->getAdminUsername() . '<br/>
	  <strong>Panel Password :</strong> <span style="color:#F00"><strong> ' . $adminPW . '</strong> </span><br/>
	  <br/><br/>
	  
	  <p>
	 Thanking you for taking the time in shopping online with us.
  <br/>
	  ' . $systemSetting->sySettingCompanyName() . '<br/><br/>
	  
	  Best Regards,<br/>
	  Web Administrator<br/>
	  <strong>' . $systemSetting->sySettingCompanyName() . '  - on ' . date('Y-m-d h:i a') . '</strong><br/>
	  </p>
	  
	  
	  <hr/>
	  <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the ' . $systemSetting->sySettingCompanyName() . ' Online Shoping cart  portal. If you have not made any registration or unaware of the same, please email administrator at ' . $systemSetting->sySettingCompanyEmail() . ' to remove you from this panel.</span>
	  </td>
	  </tr>
	  </table>
';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingSmtpUsername();
            $mail->FromName = $systemSetting->sySettingFromName();
            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($Administrator->getAdminEmail(), $systemSetting->sySettingCompanyName());
            $mail->IsHTML(true); // send as HTML

            $mail->Send();
            return true;

        }

        // end of function

        function fogetPasswordConformCustomer($customer_id, $adminActivationkey)
        {
            $systemSetting = new systemSetting();
            $common = new common();
            $systemSetting->extractor($systemSetting->getSettings());
            $CONFORMATION_CODE = $common->setActivationkey($adminActivationkey);
            // echo $CONFORMATION_CODE;
            $CODE = common :: setGenerateCode(5);
            $customer_id_CODE = $customer_id . $CODE;
            $customer_id_CODE = base64_encode($customer_id_CODE);

            $customer = new customer();
            $customer->setCustomerId($customer_id);
            $customer->extractor($customer->getCustomerById());

            $subject = $systemSetting->sySettingCompanyName() . "  Change Your Password Conformation!";
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
	  <tr>
	  <td width="-34" bgcolor="#333333" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
	  <td width="699" align="left" bgcolor="#333333"><img src="' . DOC_ROOT . 'uplode-img/company-logo/' . $systemSetting->sySettingCompanyLogo() . '"  /></td>
	  </tr>
	  <tr>
	  <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
	  <br>
	  Dear <strong> ' . $customer->customerTitle() . ' &nbsp;' . $customer->customerName() . '</strong>, <br/><br/>
	 
      
      Kindly follow the below mentioned steps in Change Your Password Conformation
      <br><br>
      Activation Link   <a href="' . HTTP_PATH . 'login/reset-pw-conformation.php?q=' . $CONFORMATION_CODE . '&k=' . $customer_id_CODE . '" style=" text-decoration:none;">Please click on this link to activate account. </a>
      <br><br>
	 <br>
	  <p>
	 Thanking you for taking the time in shopping online with us.
  <br/>
	  ' . $systemSetting->sySettingCompanyName() . '<br/><br/>
	  
	  Best Regards,<br/>
	  Web Administrator<br/>
	  <strong>' . $systemSetting->sySettingCompanyName() . '  - on ' . date('Y-m-d h:i a') . '</strong><br/>
	  </p>
	  
	  
	  <hr/>
	  <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the ' . $systemSetting->sySettingCompanyName() . ' Online Shoping cart  portal. If you have not made any registration or unaware of the same, please email administrator at ' . $systemSetting->sySettingCompanyEmail() . ' to remove you from this panel.</span>
	  </td>
	  </tr>
	  </table>
';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingSmtpUsername();
            $mail->FromName = $systemSetting->sySettingFromName();
            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($customer->customerEmail(), $systemSetting->sySettingCompanyName());
            $mail->IsHTML(true); // send as HTML

            $mail->Send();
            return true;

        }

        // end of function

        function fogetPasswordClient($customerId, $adminPW)
        {
            $systemSetting = new systemSetting();
            $common = new common();
            $systemSetting->extractor($systemSetting->getSettings());
            $customer = new customer();
            $customer->setCustomerId($customerId);
            $customer->extractor($customer->getCustomerById());

            $subject = $systemSetting->sySettingCompanyName() . "  Reset Your Password !";
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
                <tr>
                <td width="-34" bgcolor="#333333" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
                <td width="699" align="left" bgcolor="#333333"><img src="' . HTTP_PATH . 'company-logo/' . $systemSetting->sySettingCompanyLogo() . '"  /></td>
                </tr>
                <tr>
                <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
                <br>
                Dear <strong> ' . $customer->customerTitle() . ' &nbsp;' . $customer->customerName() . '</strong>, <br/><br/>
                Thank you for confirming, following is your username and temporary password.
                <br>
                <br>
                <p>

                <strong>Panel Username :</strong> ' . $customer->customerUsername() . '<br/>
                <strong>Panel Password :</strong> <span style="color:#F00"><strong> ' . $adminPW . '</strong> </span><br/>
                <br/><br/>

                <p>
                Thanking you for taking the time in shopping online with us.
                <br/>
                ' . $systemSetting->sySettingCompanyName() . '<br/><br/>

                Best Regards,<br/>
                Web Administrator<br/>
                <strong>' . $systemSetting->sySettingCompanyName() . '  - on ' . date('Y-m-d h:i a') . '</strong><br/>
                </p>


                <hr/>
                <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the ' . $systemSetting->sySettingCompanyName() . ' Online Shoping cart  portal. If you have not made any registration or unaware of the same, please email administrator at ' . $systemSetting->sySettingCompanyEmail() . ' to remove you from this panel.</span>
                </td>
                </tr>
                </table>
            ';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingSmtpUsername();
            $mail->FromName = $systemSetting->sySettingFromName();
            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($customer->customerEmail(), $systemSetting->sySettingCompanyName());
            $mail->IsHTML(true); // send as HTML

            $mail->Send();
            return true;

        }

        // end of function

        function orderCreate($orderId)
        {

            $systemSetting = new systemSetting();
            $order = new order();
            $customer = new customer();
            $currency_object = new CurrencyWord();
            $currency = new currency();
            $orderProduct = new orderProduct();
            $payment = new payment();
            $country = new country();

            $order->setOrderId($orderId);
            $order->extractor($order->getOrderById());

            $orderProduct->setOrderPOrderId($order->orderId());
            $orderProduct_rows = $orderProduct->getProductsByOrderId();

            $payment->setPaymentOrderId($order->orderId());
            $result = $orderProduct->getTotalDetailByOrderId();

            $systemSetting->extractor($systemSetting->getSettings());

            $customer->setCustomerId($order->orderCustomerId());
            $customer->extractor($customer->getCustomerById());

            $currency->setCurrId(1);
            $currencyName = $currency->getCurrencyNameById();

            $country->setCountryId($order->orderDeliveryCity());
            $countryName = $country->getCountryNameById();

            $filename = $systemSetting->sySettingDocumentName() . 'Invoice_' . $order->orderInvoiceRefNumber() . '.pdf';

            $subject = $systemSetting->sySettingCompanyName() . " -  New Order Place....!";
            $strContent = '
<table width="800" border="0" style="font-family:Arial, Helvetica, sans-serif; background:#eee; font-size:12px; color:#333333;">
<tr>
<td colspan="3" rowspan="8" align="left" valign="top">
<img src="' . DOC_ROOT . 'uplode-img/company-logo/' . $systemSetting->sySettingCompanyLogo() . '"  />
</br>

<div style="padding-left:20px;font-size:16px; font-weight:bold; margin-bottom:8px;margin-top:20px;">' . $systemSetting->sySettingCompanyName() . ' </div>
<div style="padding-left:30px;margin-bottom:5px;font-size:10px;font-size:13px;">' . $systemSetting->sySettingCompanyAddress() . '</div>
<div style="padding-left:30px;margin-bottom:5px;font-size:10px;font-size:13px;">Telephone &nbsp; : &nbsp;&nbsp;' . $systemSetting->sySettingCompanyPhon() . '</div>
<div style="padding-left:30px;margin-bottom:5px;font-size:10px;font-size:13px;">Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp; ' . $systemSetting->sySettingCompanyEmail() . '</div>



</td>

<td colspan="3" bgcolor="#CC0000" style="color:#FFF; font-size:14px; padding:5px; text-align:right; font-weight:700; letter-spacing:1px;">C u s t o m e r &nbsp; I n v o i c e</td>
</tr>

<tr>
<td >&nbsp;</td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td >&nbsp;</td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td style="padding:3px; border-bottom:1px #484848 dotted;"><div style=" width:80px;background-color:#ddd; float:left; margin-top:2px; padding:2px 5px;">Date</div></td>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;text-align:right;">' . date('l jS \of F Y ', strtotime($order->orderCreatedDate())) . '</td>
</tr>
<tr>
<td style="padding:3px; border-bottom:1px #484848 dotted;"><div style=" width:80px;background-color:#ddd; float:left; margin-top:2px; padding:2px 5px;">Invoice No</div></td>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;text-align:right;">' . $order->orderInvoiceRefNumber() . '</td>
</tr>
<tr>
<td style="padding:3px; border-bottom:1px #484848 dotted;"><div style=" width:80px;background-color:#ddd; float:left; margin-top:2px; padding:2px 5px;">Order No</div></td>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;text-align:right;">' . $order->orderRefNumber() . '</td>
</tr>



<tr>
<td colspan="3" >&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="6" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px;">To</td>
</tr>
<tr>
  <td colspan="6" style="padding:3px; border-bottom:1px #484848 dotted;">
    <div style="margin-bottom:5px; margin-top:5px; font-weight:700;">' . $customer->customerName() . ' </div>
    <div style="font-size:10px;font-size:10px;">' . $customer->customerAddress() . '</div></td>
  </tr>
<tr>
  <td colspan="6">&nbsp;</td>
</tr>
<tr>
<td width="19%" align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px; width:5%;">No</td>
<td width="11%" align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px; width:15%">Item Code</td>
<td width="11%" align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px; width:35%">Description</td>
<td align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px; width:10%">Quantity</td>
<td width="22%" align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px; width:15%">Unit Price</td>
<td width="23%" align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px; width:20%">Total Price</td>
</tr>';
            $count = 1;
            for ($i = 0; $i < count($orderProduct_rows); $i++) {
                $orderProduct->extractor($orderProduct_rows, $i);
                $strContent .= '
<tr>
<td align="center" style="padding:3px; border-bottom:1px #484848 dotted;">' . $count . '</td>
<td align="center" style="padding:3px; border-bottom:1px #484848 dotted;">' . $orderProduct->orderPProductCode() . '</td>
<td align="center" style="padding:3px; border-bottom:1px #484848 dotted;">' . $orderProduct->orderPProductName() . '</td>
<td align="center" valign="bottom" style="padding:3px; border-bottom:1px #484848 dotted;">' . $orderProduct->orderPProductQuantity() . '</td>
<td align="right" valign="bottom" style="padding:3px; border-bottom:1px #484848 dotted;">' . $currency->convetNumberFormatDefault($orderProduct->orderPProductUnitPrice()) . '</td>
<td align="right" valign="bottom" style="padding:3px; border-bottom:1px #484848 dotted;">' . $currency->convetNumberFormatDefault($orderProduct->orderPProductTotalPrice()) . '</td>
</tr>
';
                $count++;
            }
            $strContent .= '
<tr>
<td colspan="5" style="padding:3px; border-bottom:1px #484848 dotted;">';
            $TOTAL_VAL = $result[0]['PRI'];
            $strContent .=
                $currency_object->get_bd_amount_in_text($result[0]['PRI'], 'Say &nbsp;&nbsp; &nbsp; ' . $currencyName . '&nbsp;&nbsp;&nbsp;', '&nbsp;Cents&nbsp;');
            $strContent .= '
</td>
<td style="padding:3px; border-bottom:2px #000 double;" align="right"><span style="border-bottom:1px #909090 dashed; float:right; text-align:right;">
' . $currency->convetNumberFormatDefault($TOTAL_VAL) . '</span></td>
</tr>



<tr>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="6" bgcolor="#333333" style="font-size:12px; color:#FFF; padding:5px;" >General Terms And Conditions</td>
</tr>
<tr>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;"><div style="padding:3px 10px; width:200px; float:left; font-weight:700;">Invoice Price Currency</div></td>
<td colspan="4" style="padding:3px; border-bottom:1px #484848 dotted;">' . $currencyName . '</td>
</tr>
<tr>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;"><div style="padding:3px 10px; width:200px; float:left; font-weight:700;">Validity of Price Till</div></td>
<td colspan="4" style="padding:3px; border-bottom:1px #484848 dotted;">&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td colspan="6">&nbsp;</td>
</tr>

<tr>
<td colspan="6" bgcolor="#333333" style="font-size:12px; color:#FFF; padding:5px;" >Product Preferences</td>
</tr>
<tr>
<td colspan="6" style="padding:3px; border-bottom:1px #484848 dotted;">' . $order->orderClientNote() . '</td>

</tr>

<tr>
<td colspan="2">&nbsp;</td>
<td colspan="4">&nbsp;</td>
</tr>


<tr>
<td colspan="6" bgcolor="#333333" style="font-size:12px; color:#FFF; padding:5px;" >Delivery Details</td>
</tr>
<tr>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;"><div style="padding:3px 10px; width:200px; float:left; font-weight:700;">Delivery Address</div></td>
<td colspan="4" style="padding:3px; border-bottom:1px #484848 dotted;">' . $order->orderDeliveryAddress() . '</td>
</tr>
<tr>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;"><div style="padding:3px 10px; width:200px; float:left; font-weight:700;">Delivery Note</div></td>
<td colspan="4" style="padding:3px; border-bottom:1px #484848 dotted;">' . $order->orderDeliveryNote() . '</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td colspan="6">&nbsp;</td>
</tr>
<tr>
<td colspan="6"> <br>
<p>
Looking forward to see you online<br/>
' . $systemSetting->sySettingCompanyName() . '<br/><br/>
Best Regards,<br/>
Web Admin Team<br/>
<strong>' . $systemSetting->sySettingCompanyName() . ' - on ' . date('Y-m-d h:i a') . '</strong><br/>
</p>
<hr/>
<span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the ' . $systemSetting->sySettingCompanyName() . ' Online Shoping cart portal. If you have not made any registration or unaware of the same, please email administrator at ' . $systemSetting->sySettingCompanyEmail() . ' to remove you from this panel.</span></td>
</tr>
</table>
';

            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingSmtpUsername();
            $mail->FromName = $systemSetting->sySettingFromName();
            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($strContent);
            $mail->AddAddress($customer->customerEmail(), $systemSetting->sySettingCompanyName());
            $mail->AddCC($systemSetting->sySettingCompanyEmail(), $systemSetting->sySettingCompanyName());
            $mail->IsHTML(true); // send as HTML
            $mail->AddAttachment(DOC_ROOT . "my-account/invoice-pdf/" . $filename);
            $mail->Send();
            unlink(DOC_ROOT . "my-account/invoice-pdf/" . $filename);
            return true;

        }

        // end of function

        function VoucherCreate($VoucherId)
        {

            $voucher = new voucher();
            $customer = new customer();
            $currency = new currency();

            $voucher->setVoucherId($VoucherId);
            $voucher->extractor($voucher->getVoucherById());

            $systemSetting = new systemSetting();
            $common = new common();
            $systemSetting->extractor($systemSetting->getSettings());

            $customer->setCustomerId($voucher->voucherCustomerId());
            $customer->extractor($customer->getCustomerById());
            $filename = $systemSetting->sySettingDocumentName() . 'voucher_' . $voucher->voucherId() . '.pdf';

            $subject = $systemSetting->sySettingCompanyName() . ' - New Discount Voucher received from ' . $voucher->voucherFromName() . '!!!';
            $EmailMessage = '<table width="785" border="0" cellpadding="20" cellspacing="0">
	  <tr>
	  <td width="-34" bgcolor="#333333" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; padding:4px 0 4px 5px;">&nbsp;</td>
	  <td width="699" align="left" bgcolor="#333333"><img src="' . DOC_ROOT . 'uplode-img/company-logo/' . $systemSetting->sySettingCompanyLogo() . '"  /></td>
	  </tr>
	  <tr>
	  <td colspan="2" bgcolor="#f0f0f0" style=" font-family:arial; font-size:13px;">
	  <br>
	  Dear <strong> Mr/Miss/Mrs&nbsp;' . $voucher->voucherToName() . '</strong>, <br/><br/>
	  We are pleased to inform you that <strong>' . $voucher->voucherFromName() . '</strong> has gifted you a voucher worth <strong>' . $currency->convetNumberFormatDefault($voucher->voucherAmount()) . ' </strong>.<br>
	  
	  Your Voucher Code ..<br/><br/>

	  <strong>#</strong> <span style="color:#F00"><strong> ' . $voucher->voucherCode() . '</strong> </span><br/>
	  <br/><br/>
	  br>
	  <p>
	 Thanking you for taking the time in shopping online with us.
  <br/>
	  ' . $systemSetting->sySettingCompanyName() . '<br/><br/>
	  
	  Best Regards,<br/>
	  Web Administrator<br/>
	  <strong>' . $systemSetting->sySettingCompanyName() . '  - on ' . date('Y-m-d h:i a') . '</strong><br/>
	  </p>
	  
	  
	  <hr/>
	  <span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the ' . $systemSetting->sySettingCompanyName() . ' Online Shoping cart  portal. If you have not made any registration or unaware of the same, please email administrator at ' . $systemSetting->sySettingCompanyEmail() . ' to remove you from this panel.</span>
	  </td>
	  </tr>
	  </table>
';
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingSmtpUsername();
            $mail->FromName = $systemSetting->sySettingFromName();
            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($voucher->voucherToEmail(), $systemSetting->sySettingCompanyName());
            $mail->AddCC($customer->customerEmail(), $systemSetting->sySettingCompanyName());
            $mail->IsHTML(true); // send as HTML

            $mail->Send();
            return true;

        }

        // end of function

        function VoucherInvoice($VoucherId)
        {

            $voucher = new voucher();
            $customer = new customer();
            $currency_object = new CurrencyWord();
            $currency = new currency();

            $voucher->setVoucherId($VoucherId);
            $voucher->extractor($voucher->getVoucherById());

            $systemSetting = new systemSetting();
            $common = new common();
            $systemSetting->extractor($systemSetting->getSettings());

            $customer->setCustomerId($voucher->voucherCustomerId());
            $customer->extractor($customer->getCustomerById());
            $filename = $systemSetting->sySettingDocumentName() . 'voucher_In_' . $voucher->voucherId() . '.pdf';

            $subject = $systemSetting->sySettingCompanyName() . ' - New Voucher Invoice!!!';
            $EmailMessage = '<table width="800" border="0" style="font-family:Arial, Helvetica, sans-serif; background:#eee; font-size:12px; color:#333333;">
<tr>
<td colspan="2" rowspan="7" align="left" valign="top"><img src="' . DOC_ROOT . 'uplode-img/company-logo/' . $systemSetting->sySettingCompanyLogo() . '"  /></td>
<td colspan="2" rowspan="7"> <div style="font-size:13px; font-weight:bold; margin-bottom:10px;">' . $systemSetting->sySettingCompanyName() . ' </div>
<div style="margin-bottom:5px;font-size:10px;">' . $systemSetting->sySettingCompanyAddress() . '</div>
<div style="margin-bottom:5px;font-size:10px;">Telephone &nbsp; : &nbsp;&nbsp;' . $systemSetting->sySettingCompanyPhon() . '</div>
<div style="margin-bottom:5px;font-size:10px;">Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp; ' . $systemSetting->sySettingCompanyEmail() . '</div></td>
<td colspan="2" bgcolor="#CC0000" style="color:#FFF; font-size:14px; padding:5px; text-align:right; font-weight:700; letter-spacing:1px;">V o u c h e r &nbsp;&nbsp;&nbsp;I n v o i c e</td>
</tr>
<tr>
<td width="521">&nbsp;</td>
<td width="475">&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td style="padding:3px; border-bottom:1px #484848 dotted;"><div style="width:55px; background-color:#ececec; font-size:10px; padding:3px 5px; float:left;">Date</div></td>
<td style="padding:3px; border-bottom:1px #484848 dotted;">' . date('l jS \of F Y ', strtotime($voucher->voucherCreatedDate())) . '</td>
</tr>
<tr>
<td style="padding:3px; border-bottom:1px #484848 dotted;"><div style="width:55px; background-color:#ececec; font-size:10px; padding:3px 5px; float:left;">Voucher Code</div></td>
<td style="padding:3px; border-bottom:1px #484848 dotted;">' . $voucher->voucherCode() . '</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td width="410">&nbsp;</td>
<td width="222">&nbsp;</td>
<td colspan="2">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="3" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px;">From</td>
<td colspan="3" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px;">To</td>
</tr>
<tr>
<td  style="padding:3px; border-bottom:1px #484848 dotted;">
<div style=" width:60px;background-color:#ececec; float:left; margin-top:2px; padding:2px 5px;">Name</div></td>
<td  style="padding:3px; border-bottom:1px #484848 dotted;">
<div style="font-size:10px;">' . $voucher->voucherFromName() . '</div></td>
<td  style="padding:3px; border-bottom:1px #484848 dotted;"></td>

<td style="padding:3px; border-bottom:1px #484848 dotted;">
<div style=" width:60px;background-color:#ececec; float:left; margin-top:2px; padding:2px 5px;">Name</div></td>
<td style="padding:3px; border-bottom:1px #484848 dotted;">' . $voucher->voucherToName() . '</td>
<td  style="padding:3px; border-bottom:1px #484848 dotted;">3</td>
</tr>
<tr>
<td  style="padding:3px; border-bottom:1px #484848 dotted;"><div style=" width:60px;background-color:#ececec; float:left; margin-top:2px; padding:2px 5px;">Email</div></td>
<td  style="padding:3px; border-bottom:1px #484848 dotted;">' . $voucher->voucherFromEmail() . '</td>
<td  style="padding:3px; border-bottom:1px #484848 dotted;"></td>
<td style="padding:3px; border-bottom:1px #484848 dotted;">
<div style=" width:60px;background-color:#ececec; float:left; margin-top:2px; padding:2px 5px;">Email</div></td>
<td style="padding:3px; border-bottom:1px #484848 dotted;">' . $voucher->voucherToEmail() . '</td>
<td  style="padding:3px; border-bottom:1px #484848 dotted;">3</td>
</tr>


<tr>
<td colspan="8">&nbsp;</td>
</tr>
<tr>
<td align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px;">Item Code</td>
<td colspan="4" align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px;">Description</td>
<td align="center" bgcolor="#333333" style="color:#fff; padding:3px 0 3px 8px; font-weight:bold; font-size:13px;">Total Price</td>
</tr>
<tr>
<td height="30" align="center" style="padding:3px; border-bottom:1px #484848 dotted;"> 1 </td>
<td colspan="4" style="padding:3px; border-bottom:1px #484848 dotted;">Voucher Invoice</td>
<td align="right" valign="bottom" style="padding:3px; border-bottom:1px #484848 dotted;">' . $voucher->voucherAmount() . '</td>
</tr>
<tr>
<td colspan="5" style="padding:3px; border-bottom:1px #484848 dotted;">';
            $strContent .=
                $currency_object->get_bd_amount_in_text($voucher->voucherAmount(), 'Say &nbsp;&nbsp; &nbsp; ' . $currencyName . '&nbsp;&nbsp;&nbsp;', '&nbsp;Cents&nbsp;');
            $strContent .= '
</td>
<td style="padding:3px; border-bottom:2px #000 double;" align="right"><span style="border-bottom:1px #909090 dashed; float:right; text-align:right;">' .
                $voucher->voucherAmount() . '
</span></td>
</tr>



<tr>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td colspan="2">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="6" bgcolor="#333333" style="font-size:12px; color:#FFF; padding:5px;" >General Terms And Conditions</td>
</tr>
<tr>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;"></td>
<td colspan="4" style="padding:3px; border-bottom:1px #484848 dotted;"></td>
</tr>
<tr>
<td colspan="2" style="padding:3px; border-bottom:1px #484848 dotted;"><div style="padding:3px 10px; width:200px; float:left; font-weight:700;">Validity of Price Till</div></td>
<td colspan="4" style="padding:3px; border-bottom:1px #484848 dotted;">&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td colspan="6">&nbsp;</td>
</tr>




<tr>
<td colspan="6"> <br>
<p>
Looking forward to see you online<br/>
' . $systemSetting->sySettingCompanyName() . '<br/><br/>
Best Regards,<br/>
Web Admin Team<br/>
<strong>' . $systemSetting->sySettingCompanyName() . ' - on ' . date('Y-m-d h:i a') . '</strong><br/>
</p>
<hr/>
<span style="color:#666; font-size:11px; font-family:Arial, Helvetica, sans-serif;">You are receiving this email, because an account has been registered at the ' . $systemSetting->sySettingCompanyName() . ' Online Shoping cart portal. If you have not made any registration or unaware of the same, please email administrator at ' . $systemSetting->sySettingCompanyEmail() . ' to remove you from this panel.</span></td>
</tr>
</table>
';
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
            $mail->Host = $systemSetting->sySettingHost(); // sets GMAIL as the SMTP server
            $mail->Port = $systemSetting->sySettingPort(); // set the SMTP port

            $mail->Username = $systemSetting->sySettingSmtpUsername(); // GMAIL username
            $mail->Password = $systemSetting->sySettingSmtpPassword(); // GMAIL password

            $mail->From = $systemSetting->sySettingSmtpUsername();
            $mail->FromName = $systemSetting->sySettingFromName();
            $mail->Subject = $subject;
            $mail->WordWrap = 50; // set word wrap

            $mail->MsgHTML($EmailMessage);
            $mail->AddAddress($customer->customerEmail(), $systemSetting->sySettingCompanyName());
            $mail->AddCC($customer->customerEmail(), $systemSetting->sySettingCompanyName());
            $mail->IsHTML(true); // send as HTML
            $mail->AddAttachment(DOC_ROOT . "gift-voucher/voucher-invoice/" . $filename);
            $mail->Send();
            unlink(DOC_ROOT . "gift-voucher/voucher-invoice/" . $filename);
            $mail->Send();
            return true;

        }
        // end of function
    } // end of class
?>