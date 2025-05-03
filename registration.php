<?php
require 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: " . home_url('/dashboard'));
    exit();
}

ob_start(); // Output buffering
header('Content-Type: text/html; charset=UTF-8');

/**
 * Template Name: registration page
 */
get_header();

$conn->set_charset("utf8mb4");

// Generating a unique promo code
function generatePromoCode($conn)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';

    do {
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Check if the promo code exists in the database
        $stmt = $conn->prepare("SELECT id FROM ambasador_pmb_users WHERE promo_code = ?");
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $stmt->store_result();
    } while ($stmt->num_rows > 0);
    return $code;
}

// Registration form handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $phone = $_POST['telefon'];

    // handling checkboxes
    $facebook = isset($_POST['promotion']) && in_array('facebook', $_POST['promotion']) ? 1 : 0;
    $instagram = isset($_POST['promotion']) && in_array('instagram', $_POST['promotion']) ? 1 : 0;
    $recommend = isset($_POST['promotion']) && in_array('recommend', $_POST['promotion']) ? 1 : 0;
    $tiktok = isset($_POST['promotion']) && in_array('tiktok', $_POST['promotion']) ? 1 : 0;
    $youtube = isset($_POST['promotion']) && in_array('youtube', $_POST['promotion']) ? 1 : 0;
    $other_platform = null;
    if (isset($_POST['promotion']) && in_array('other', $_POST['promotion'])) {
        if (!empty($_POST['other_promotion'])) {
            $other_platform = $_POST['other_promotion'];
        } else {
            $other_platform = 'Nieokreślone';
        }
    }
    // validation
    if (!preg_match('/^[a-zA-Zа-яА-ЯąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$/u', $username)) {
        echo '<div class="error-message">Nazwa użytkownika może zawierać tylko litery i spacje! <span class="close-btn" onclick="this.parentElement.remove()">x</span></div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="error-message">Nieprawidłowy adres email! <span class="close-btn" onclick="this.parentElement.remove()">x</span></div>';
    } elseif (strlen($_POST['password']) < 8) {
        echo '<div class="error-message">Hasło musi zawierać co najmniej 8 znaków! <span class="close-btn" onclick="this.parentElement.remove()">x</span></div>';
    } elseif (!isset($_POST['regulamin'])) {
        echo '<div class="error-message">Proszę zaakceptować regulamin! <span class="close-btn" onclick="this.parentElement.remove()">x</span></div>';
    } else {
        // Validation if user exists
        $check_user = $conn->prepare("SELECT id FROM ambasador_pmb_users WHERE username = ? OR email = ?");
        $check_user->bind_param("ss", $username, $email);
        $check_user->execute();
        $check_user->store_result();

        if ($check_user->num_rows > 0) {
            echo '<div class="error-message">Użytkownik o podanym imieniu lub adresie email już istnieje! <span class="close-btn" onclick="this.parentElement.remove()">x</span></div>';
        } else {

            $promo_code = generatePromoCode($conn);

            // insert to DB
            $stmt = $conn->prepare("INSERT INTO ambasador_pmb_users (username, password, email, promo_code, phone, facebook, instagram, recommend, tiktok, youtube, other_promotion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssiiiiis", $username, $password, $email, $promo_code, $phone, $facebook, $instagram, $recommend, $tiktok, $youtube, $other_platform);

            if ($stmt->execute()) {
                // set session
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['username'] = $username;
                $_SESSION['promo_code'] = $promo_code;

                // redirect to thanks page
                $_SESSION['registration_message'] = "Rejestracja zakończona sukcesem! Twój kod promocyjny: <span> $promo_code </span>";
                wp_redirect(home_url('/welcome/'));
                exit();
            } else {
                echo '<div class="error-message">Błąd: ' . $stmt->error . ' <span class="close-btn" onclick="this.parentElement.remove()">x</span></div>';
            }

            $stmt->close();
        }

        $check_user->close();
    }
}

$conn->close();
?>
<style>
    .other-promotion-label {
        width: 100%;
        padding: 8px;
        border: 3px solid var(--primary-yellow);
        border-radius: 4px;
        background-color: transparent;
        color: #fff;
        font-size: 22px !important;
    }
</style>

<body>
    <main>
        <div class="main-wrapper">
            <div class="text-content">
                <h1>Witaj Ambasadorze!</h1>
                <p>Rozpocznij swoją przygodę z Parking Magic Box i zyskaj wyjątkowe nagrody za swoją aktywność.</p>
            </div>
        </div>
    </main>

    <div class="registration-wrapper">
        <form action="" method="POST">
            <h2>Rejestracja</h2>
            <p>Zarejestruj się jako ambasador Parking Magic Box</p>
            <div class="registration-fields">
                <label>Imię*:</label>
                <input type="text" name="username" required value="<?= htmlspecialchars($old_data['username'] ?? '') ?>">

                <label>Email*:</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($old_data['email'] ?? '') ?>">

                <label>Hasło*:</label>
                <input type="password" name="password" required>

                <label>Numer telefonu:</label>
                <div style="display: flex; gap: 5px;">
                    <input type="text" value="+48" disabled style="width: 65px;">
                    <input required type="tel"
                        autocomplete="off"
                        name="telefon"
                        value="<?= htmlspecialchars($old_data['telefon'] ?? '') ?>"
                        pattern="^(\d{9}|\d{3}-\d{3}-\d{3})$"
                        maxlength="11" placeholder="123 456 789">
                </div>

                <div class="promotion-section">
                    <h3>Gdzie planujesz promować naszą firmę?</h3>
                    <div class="checkbox-group">
                        <div class="first-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="promotion[]" value="facebook">
                                <span class="checkmark"></span>
                                Facebook
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="promotion[]" value="instagram">
                                <span class="checkmark"></span>
                                Instagram
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="promotion[]" value="recommend">
                                <span class="checkmark"></span>
                                Będę polecać znajomym
                            </label>
                        </div>
                        <div class="second-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="promotion[]" value="tiktok">
                                <span class="checkmark"></span>
                                TikTok
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="promotion[]" value="youtube">
                                <span class="checkmark"></span>
                                YouTube
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="promotion[]" value="other" id="promotion-other">
                                <span class="checkmark"></span>
                                Inne
                            </label>
                            <div id="other-promotion-input" style="display: none; flex-direction: column; gap: 8px; margin-bottom: 20px;">
                                <input type="text" name="other_promotion" id="other-promotion" placeholder="Gdzie dokładnie" style="height: 40px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="registration-actions">
                    <label class="checkbox-item required-field">
                        <input type="checkbox" name="regulamin" required onchange="this.setCustomValidity('')">
                        <span class="checkmark"></span>
                        Akceptuję
                        <a href="<?php echo home_url('/wp-content/uploads/2025/05/REGULAMIN.pdf'); ?>" target="_blank" class="regulamin-link yellow-text">regulamin</a>
                        <span class="required-hint">(wymagane)</span>
                    </label>
                    <button class="action-btn register-btn" type="submit">Zarejestruj się</button>
                </div>
        </form>
    </div>
    </div>
</body>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const promotionOtherCheckbox = document.getElementById('promotion-other');
        const otherPromotionInput = document.getElementById('other-promotion-input');

        promotionOtherCheckbox.addEventListener('change', function() {
            if (promotionOtherCheckbox.checked) {
                otherPromotionInput.style.display = 'flex';
            } else {
                otherPromotionInput.style.display = 'none';
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const errorBox = document.getElementById('form-error-box');
        const errorList = errorBox.querySelector('ul');
        const phone = form.querySelector('input[name="telefon"]');
        const phoneValue = phone.value.replace(/\s+/g, '');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            let hasErrors = false;
            errorList.innerHTML = '';
            errorBox.style.display = 'none';

            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.classList.remove('error');
            });

            const username = form.querySelector('input[name="username"]');
            if (!username.value.match(/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+$/)) {
                hasErrors = true;
                username.classList.add('error');
                errorList.innerHTML += `<li>Imię może zawierać tylko litery i spacje.</li>`;
            }

            const email = form.querySelector('input[name="email"]');
            if (!email.value || !/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email.value)) {
                hasErrors = true;
                email.classList.add('error');
                errorList.innerHTML += `<li>Nieprawidłowy adres email.</li>`;
            }

            const password = form.querySelector('input[name="password"]');
            if (!password.value || password.value.length < 8) {
                hasErrors = true;
                password.classList.add('error');
                errorList.innerHTML += `<li>Hasło musi zawierać co najmniej 8 znaków.</li>`;
            }

            const regulamin = form.querySelector('input[name="regulamin"]');
            if (!regulamin.checked) {
                hasErrors = true;
                errorList.innerHTML += `<li>Musisz zaakceptować regulamin.</li>`;
            }
            if (!/^\d{9}$/.test(phoneValue)) {
                hasErrors = true;
                phone.classList.add('error');
                errorList.innerHTML += `<li>Numer telefonu musi zawierać dokładnie 9 cyfr.</li>`;
            }
            if (hasErrors) {
                errorBox.style.display = 'block';
                setTimeout(() => errorBox.style.display = 'none', 5000);
            } else {
                form.submit();
            }
        });
    });
</script>
<?php get_footer(); ?>
<?php
ob_end_flush();
?>