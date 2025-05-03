<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Обработка данных формы
    $your_name = htmlspecialchars(trim($_POST['yourName']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Валидация
    $errors = [];

    if (empty($your_name)) $errors[] = "Proszę podać imię i nazwisko";
    if (!$email) $errors[] = "Nieprawidłowy adres email";
    if (empty($phone)) $errors[] = "Proszę podać numer telefonu";
    if (empty($message)) $errors[] = "Proszę wpisać treść wiadomości";
    if (!isset($_POST['agreeDataProcessing'])) $errors[] = "Wymagana zgoda na przetwarzanie danych";
    if (!isset($_POST['agreeTelecom'])) $errors[] = "Wymagana zgoda marketingowa";

    if (empty($errors)) {
        ini_set("SMTP", "parkingmagicbox1.atthost24.pl");
        ini_set("smtp_port", 587);
        ini_set("sendmail_from", "parkingmagicbox@attthost24.pl");

        $to = "marketing@parkingmagicbox.com";
        $subject = "Nowe zapytanie kontaktowe";
        $headers = "From: parkingmagicbox@attthost24.pl\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $body = "Imię: $your_name\nEmail: $email\nTelefon: $phone\n\n$message";

        if (mail($to, $subject, $body, $headers)) {
            $_SESSION['status'] = "Wiadomość została wysłana!";
        } else {
            $_SESSION['status'] = "Błąd podczas wysyłania wiadomości";
        }
    } else {
        $_SESSION['status'] = implode("<br>", $errors);
    }

    header("Location: index.php");
    exit();
}
