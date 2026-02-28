<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';


$name    = $_POST['name'];
$email   = $_POST['email'];
$phone   = $_POST['phone'];
$message = $_POST['message'];
$formType = $_POST['form_type'];

// ===============================
// ADMIN EMAIL CONFIG
// ===============================
$adminEmail = "connect@aquaj1.com"; // admin mail
$smtpHost   = "smtp.hostinger.com";
$smtpUser   = "gaurav@tubelaser.in"; // SMTP email
$smtpPass   = "admin pass"; // Gmail App Password
$smtpPort   = 587;

$mail = new PHPMailer(true);

try {
    // SMTP SETTINGS
    $mail->isSMTP();
    $mail->Host       = "smtp.hostinger.com";
    $mail->SMTPAuth   = true;
    $mail->Username   = "my mail";
    $mail->Password   = "my pass";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $smtpPort;

    // ===============================
    // 1️⃣ MAIL TO USER (AUTO REPLY)
    // ===============================
    $mail->setFrom("gaurav@tubelaser.in", "Wellworth Facilities Pvt Ltd");
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = "We’ve Received Your Request – Wellworth Facilities";
    $mail->Body = "
        <div style='max-width:600px;margin:0 auto;font-family:Arial,Helvetica,sans-serif;
            background:#ffffff;border:1px solid #e6e6e6;border-radius:8px;overflow:hidden;'>

  <!-- HEADER -->
  <div style='background:#0b1c39;padding:20px;text-align:center;'>
    <h2 style='color:#ffffff;margin:0;'>Wellworth Facilities Pvt Ltd</h2>
    <p style='color:#cfd6e3;margin:5px 0 0;'>Compliance-Driven Facility & Manpower Services</p>
  </div>

  <!-- BODY -->
  <div style='padding:25px;color:#333;'>
    <p>Dear <strong>$name</strong>,</p>

    <p>
      Thank you for contacting <strong>Wellworth Facilities Pvt Ltd</strong>.
      We have successfully received your <strong>$formType</strong> request.
    </p>

    <div style='background:#f5f7fa;padding:15px;border-radius:6px;margin:20px 0;'>
      <h4 style='margin-top:0;color:#0b1c39;'>📋 Your Submitted Details</h4>

      <p><strong>Phone:</strong> $phone</p>
      <p><strong>Requirement:</strong><br>
      ".nl2br($message)."</p>
    </div>

    <p>
      Our team will review your request and get in touch with you within
      <strong>24 business hours</strong>.
    </p>

    <p style='margin-top:30px;'>
      Regards,<br>
      <strong>Wellworth Facilities Pvt Ltd</strong><br>
      <span style='color:#666;font-size:13px;'>Compliance & Workforce Experts</span>
    </p>
  </div>

  <!-- FOOTER -->
  <div style='background:#f0f2f5;padding:15px;text-align:center;font-size:12px;color:#666;'>
    © ".date('Y')." Wellworth Facilities Pvt Ltd. All rights reserved.
  </div>

</div>
";

    $mail->send();

    // ===============================
    // 2️⃣ MAIL TO ADMIN (LEAD ALERT)
    // ===============================
    $mail->clearAddresses();
    $mail->addAddress($adminEmail);

    $mail->Subject = "New Website Lead – $formType";
    $mail->Body = "
        <h2 style='color:#0b1c39;'>📩 New Lead Received</h2>

<table cellpadding='8' cellspacing='0' style='border-collapse:collapse; font-family:Arial, sans-serif;'>
  <tr>
    <td><strong>Form Type:</strong></td>
    <td>$formType</td>
  </tr>
  <tr>
    <td><strong>Full Name:</strong></td>
    <td>$name</td>
  </tr>
  <tr>
    <td><strong>Email:</strong></td>
    <td>$email</td>
  </tr>
  <tr>
    <td><strong>Phone:</strong></td>
    <td>$phone</td>
  </tr>
  <tr>
    <td><strong>Services Requested:</strong></td>
    <td>$Services</td>
  </tr>
</table>

<hr>

<h4>Client Requirement</h4>
<p style='background:#f5f7fa; padding:12px; border-left:4px solid #0b1c39;'>
  ".nl2br($message)."
</p>

<p style='font-size:12px; color:#666;'>
This lead was generated from the Wellworth Facilities website.
</p>
";

    $mail->send();

    // ===============================
    // REDIRECT AFTER SUCCESS
    // ===============================
    header("Location: thank-you.html");
    exit();

} catch (Exception $e) {
    echo "Mail Error: {$mail->ErrorInfo}";
}

