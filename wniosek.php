<?php

/**
 * Template Name: Wniosek o wypłatę
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: " . home_url('/login'));
    exit();
}

global $wpdb;

// Обработка формы
if (isset($_POST['submit_payout']) && wp_verify_nonce($_POST['payout_nonce'], 'payout_form_nonce')) {
    $user_id = $_SESSION['user_id'];


    $data_urodzenia = sanitize_text_field($_POST['data_urodzenia']);
    $dob = new DateTime($data_urodzenia);
    $current_date = new DateTime();
    $age = $current_date->diff($dob)->y;

    if ($age < 18) {
        $error_message = 'Nie możesz składać wniosku, ponieważ masz mniej niż 18 lat.';
    } else {
        // Проверка, чтобы запомнить данные, если чекбокс был выбран
        if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
            // Сохранение данных в сессии
            $_SESSION['payout_data'] = [
                #
            ];
        } else {
            // Если не выбрано запоминание, очистить сессию
            unset($_SESSION['payout_data']);
        }

        $data = [
     #
        ];

        $result = $wpdb->query($wpdb->prepare(
            "#",
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#'],
            $data['#']
        ));

        if ($result !== false) {
            $_SESSION['form_success'] = true;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            $error_message = 'Błąd zapisu: ' . $wpdb->last_error;
        }
    }
}
get_header();

if (isset($_SESSION['form_success'])) {
    echo '
    <div id="fullscreen-message" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        backdrop-filter: blur(10px);
    ">
        <div style="text-align: center; padding: 30px; max-width: 600px;">
            <h2 style="color: #4CAF50; font-size: 2.5em; margin-bottom: 20px;">✓ Sukces!</h2>
            <p style="font-size: 1.2em; margin-bottom: 30px;">Dane zostały pomyślnie zapisane!</p>
            <a href="' . home_url('/dashboard-panel') . '" 
                style="
                    padding: 12px 30px;
                    font-size: 1.1em;
                    background: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    text-decoration: none;
                    display: inline-block;
                ">
                Zamknij i wróć do panelu
            </a>
        </div>
    </div>';
    unset($_SESSION['form_success']);
}
?>

<style>
    .wniosek-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 30px;
        background: #1a1a1a;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    .wniosek-title {
        color: #ffd700;
        text-align: center;
        margin-bottom: 30px;
        font-size: 2em;
    }

    .payout-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input-group.full-width {
        grid-column: span 2;
    }

    label {
        display: block;
        color: #fff;
        margin-bottom: 8px;
        font-size: 0.9em;
    }

    input,
    select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ffd700;
        border-radius: 4px;
        background: #2a2a2a;
        color: #fff;
        font-size: 1em;
    }

    .submit-btn {
        grid-column: span 2;
        background: linear-gradient(45deg, #ffd700, #ffc966ba);
        color: #000;
        border: none;
        padding: 15px;
        font-size: 1.1em;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 20px;
    }

    .success-msg {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        grid-column: span 2;
    }

    .error-msg {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        grid-column: span 2;
    }

    @media (max-width: 768px) {
        .payout-form {
            grid-template-columns: 1fr;
        }

        .input-group.full-width {
            grid-column: span 1;
        }

        .submit-btn {
            grid-column: span 1;
        }
    }
</style>

<body>
    <div class="wniosek-container">
        <h1 class="wniosek-title">Wniosek o wypłatę bonusów</h1>

        <?php if (isset($error_message)): ?>
            <div class="error-msg"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" class="payout-form" id="payout-form">
            <div class="input-group">
                <label>Imię</label>
                <input pattern="^[A-Za-zÀ-ÖØ-öø-ÿ\s\-]+$" type="text" name="imie" maxlength="50" value="<?php echo isset($_SESSION['payout_data']['imie']) ? $_SESSION['payout_data']['imie'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <label>Nazwisko</label>
                <input pattern="^[A-Za-zÀ-ÖØ-öø-ÿ\s\-]+$" type="text" name="nazwisko" maxlength="50" value="<?php echo isset($_SESSION['payout_data']['nazwisko']) ? $_SESSION['payout_data']['nazwisko'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <label>Adres E-mail</label>
                <input type="email" name="email" maxlength="70" value="<?php echo isset($_SESSION['payout_data']['email']) ? $_SESSION['payout_data']['email'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <label>Numer telefonu</label>
                <div style="display: flex; gap: 6px;">
                    <input type="text" value="+48" disabled
                        style="width: 55px; text-align: center;  border-radius: 4px;" />

                    <input type="tel"
                        name="telefon"
                        placeholder="123 456 789"
                        value="<?php echo isset($_SESSION['payout_data']['telefon']) ? $_SESSION['payout_data']['telefon'] : ''; ?>"
                        required
                        pattern="\d{3}[\s\-]?\d{3}[\s\-]?\d{3}"
                        maxlength="9"
                        style="flex: 1;" />
                </div>
            </div>


            <div class="input-group">
                <label>Data urodzenia</label>
                <input    
  title="Musisz mieć ukończone 18 lat dla złożenia wniosku."  
  maxlength="8" type="date" 
  name="data_urodzenia" 
  value="<?php echo isset($_SESSION['payout_data']['data_urodzenia']) ? $_SESSION['payout_data']['data_urodzenia'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <label>PESEL</label>
                <input
                    type="text"
                    name="pesel"
                    value="<?php echo isset($_SESSION['payout_data']['pesel']) ? $_SESSION['payout_data']['pesel'] : ''; ?>"
                    required
                    pattern="\d{11}"
                    placeholder="Wprowadź 11 cyfr"
                    title="Proszę podać 11-cyfrowy numer PESEL"
                    maxlength="11">


            </div>

            <div class="input-group full-width">
                <label>Numer rachunku bankowego</label>
                <div style="display: flex; gap: 6px;">
                    <input type="text" value="PL" disabled style="width: 50px; text-align: center;   border-radius: 4px;" />

                    <input
                        name="numer_rachunku"
                        type="text"
                        id="iban"
                        placeholder="00 0000 0000 0000 0000 0000 0000"
                        pattern="[0-9\s]{26,34}"
                        title="Wprowadź numer rachunku zawierający 26 cyfr (z lub bez spacji)"
                        required
                        style="flex: 1;" />
                </div>
                <small class="input-hint">Wprowadź numer w formacie <strong>PL00 0000 0000 0000 0000 0000 0000</strong></small>
            </div>

            <div class="input-group">
                <label>Nazwa banku</label>
                <input type="text" maxlength="50" name="nazwa_banku" value="<?php echo isset($_SESSION['payout_data']['nazwa_banku']) ? $_SESSION['payout_data']['nazwa_banku'] : ''; ?>" required>
                <small>Proszę podać nazwę banku, w którym posiadasz konto.</small>

            </div>

            <div class="input-group">
                <label>Urząd Skarbowy</label>
                <input type="text" maxlength="50" name="urzad_skarbowy" value="<?php echo isset($_SESSION['payout_data']['urzad_skarbowy']) ? $_SESSION['payout_data']['urzad_skarbowy'] : ''; ?>" required>
                <small>Wprowadź nazwę Urzędu Skarbowego zgodną z Twoim miejscem zamieszkania.</small>

            </div>

            <div class="input-group full-width">
                <label>Ulica i numer</label>
                <input type="text" maxlength="65" name="ulica" value="<?php echo isset($_SESSION['payout_data']['ulica']) ? $_SESSION['payout_data']['ulica'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <label>Miasto</label>
                <input type="text" maxlength="65" name="miasto" value="<?php echo isset($_SESSION['payout_data']['miasto']) ? $_SESSION['payout_data']['miasto'] : ''; ?>" required>
            </div>

            <div class="input-group">
                <label>Kod pocztowy</label>
                <input type="text" maxlength="6"
                    name="kod_pocztowy" value="<?php echo isset($_SESSION['payout_data']['kod_pocztowy']) ? $_SESSION['payout_data']['kod_pocztowy'] : ''; ?>" required pattern="\d{2}-\d{3}" placeholder="00-000">
            </div>

            <div class="input-group full-width">
                <label style="
    display: flex;
    align-items: center;
    gap: 10px;
">
                    <input style="
    width: 30px;
    height: 30px;"
                        type="checkbox" name="remember_me"> Jeśli chcesz, aby Twoje dane były automatycznie uzupełniane przy kolejnych wnioskach, zaznacz to pole
                </label>
            </div>

            <?php wp_nonce_field('payout_form_nonce', 'payout_nonce'); ?>
            <button type="submit" name="submit_payout" class="submit-btn">Wyślij wniosek</button>
        </form>

    </div>
</body>
<script>

    document.querySelector('input[name="numer_rachunku"]').addEventListener('input', function() {
        let input = this.value;

        input = input.replace(/\D/g, '').substring(0, 26);

        let formatted = '';
        if (input.length > 0) formatted += input.substring(0, 2);
        if (input.length > 2) formatted += ' ' + input.substring(2, 6);
        if (input.length > 6) formatted += ' ' + input.substring(6, 10);
        if (input.length > 10) formatted += ' ' + input.substring(10, 14);
        if (input.length > 14) formatted += ' ' + input.substring(14, 18);
        if (input.length > 18) formatted += ' ' + input.substring(18, 22);
        if (input.length > 22) formatted += ' ' + input.substring(22, 26);

        this.value = formatted;
    });
</script>
<?php get_footer(); ?>
