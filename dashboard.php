<?php

/**
 * Template Name: dashboard
 */


// Checking authorization

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: " . home_url('/login')); // login page redirect
    exit();
}

require 'db.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching user data
$promo_code = $_SESSION['promo_code'];
$sql = "SELECT * FROM ambasador_pmb_purchases WHERE promo_code='$promo_code'";
$result = $conn->query($sql);

get_header();
?>

<main class="main-dashboard">
    <div class="dashboard-container">
        <h1>Witaj <span><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Ambasadorze'; ?></span></h1>
        <p>Sprawdź swoje osiągnięcia i odkryj nowe możliwości.</p>
        <a href="<?php echo home_url('/dashboard-panel'); ?>"><button>Sprawdź</button></a>

    </div>
</main>
<section class="bonus-section">
    <div class="bonus-section__container">
        <div class="text">
            <h3>Jak ambasadorzy mogą zdobywać bonusy za swoje działania i aktywności</h3>
            <p>
                Ambasadorzy mogą zdobywać bonusy za polecanie produktów i realizację sprzedaży za pomocą swojego indywidualnego kodu.
                Im więcej osób skorzysta z Twoich poleceń, tym większe bonusy możesz zdobyć, co motywuje do dalszej aktywności i zwiększania zysków.
            </p>
        </div>
        <div class="image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/output.jpg" alt="Metal Box">
        </div>
    </div>
    <div class="bonus-container">
        <div class="bonus-section">
            <h2>Sprawdź swoje aktualne bonusy i nagrody</h2>
            <p class="bonus-description">Na swoim koncie możesz łatwo sprawdzić liczbę zdobytych bonusów oraz ich wartość. Zyskaj dostęp do pełnej historii nagród i ciesz się swoimi osiągnięciami.</p>
            <div class="bonus-boxes">
                <div class="bonus-box">
                    <h3>Historia Nagród</h3>
                    <p>Przeglądaj swoją historię nagród.</p>
                    <a href="<?php echo home_url('/dashboard-panel#historia'); ?>"><button>Sprawdź</button></a>
                </div>
                <div class="bonus-box">
                    <h3>Twoje Bonusy</h3>
                    <p>Zobacz, ile bonusów zdobyłeś.</p>
                    <a href="<?php echo home_url('/dashboard-panel#bonusy'); ?>"><button>Sprawdź</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="steps-container steps-container--dashboard">
        <div class="step">
            <div class="step-circle">1</div>
            <p class="step-title">Polecaj Parking Metal Box znajomym</p>
            <p class="step-text">Polecaj nasze produkty i zarabiaj za każdą sprzedaż dokonaną z Twoim kodem. Im więcej osób skorzysta, tym więcej zarobisz.</p>
        </div>
        <div class="step">
            <div class="step-circle">2</div>
            <p class="step-title"> Twórz posty w mediach społecznościowych</p>
            <p class="step-text">Dziel się swoimi doświadczeniami z naszymi produktami na Instagramie, Facebooku czy TikToku i zdobywaj bonusy za każdą sprzedaż przez Twój kod.</p>
        </div>
        <div class="step">
            <div class="step-circle">3</div>
            <p class="step-title">Promuj nasze produkty w różnych kanałach</p>
            <p class="step-text"> Korzystaj z różnych mediów, takich jak blogi, grupy, aby dotrzeć do szerszej grupy osób i zdobywać nagrody za każdą realizację sprzedaży.</p>
        </div>
    </div>
</section>
<section class="faq">
    <h2 class="faq-title">Najczęściej zadawane pytania</h2>
    <p class="faq-desc">Oto odpowiedzi na najczęściej zadawane pytania dotyczące korzystania z panelu
        administracyjnego.</p>

    <div class="faq-item">
        <button class="faq-question">Jak zarejestrować konto? <span class="arrow">&#9662;</span></button>
        <div class="faq-answer">Po prostu zarejestruj się, przeczytaj Regulamin i gotowe! Aby móc otrzymać wypłatę, musisz wypełnić dane dotyczące wypłaty w swoim panelu użytkownika. Pamiętaj, że dane te są wymagane do naliczenia środków.</div>
    </div>

    <div class="faq-item">
        <button class="faq-question">Kto może zostać Ambasadorem? <span class="arrow">&#9662;</span></button>
        <div class="faq-answer">Ambasadorem może zostać osoba fizyczna, która spełnia następujące warunki:
            <br><br> A) ma ukończone 18 lat i posiada pełną zdolność do czynności prawnych, <br>
            B) nie prowadzi zarejestrowanej działalności gospodarczej,<br>
            C) jest polskim rezydentem podatkowym,`<br>
            D) zaakceptowała Regulamin.<br>
        </div>
    </div>
    <div class="faq-item">
        <button class="faq-question">Jakie korzyści oferuje Kod rabatowy Ambasadora? <span class="arrow">&#9662;</span></button>
        <div class="faq-answer">Po nawiązaniu współpracy Organizator przekazuje Ambasadorowi unikatowy kod rabatowy, który uprawnia do rabatu 100 zł brutto na zakup każdego boxu garażowego w sklepie internetowym <a href="https://parkingMetal.box">Parking Metal box</a>. Rabat nie dotyczy akcesoriów, a kod rabatowy jest ważny przez 12 miesięcy od daty przekazania.</div>
    </div>

    <div class="faq-item">
        <button class="faq-question">Jak sprawdzić bonusy? <span class="arrow">&#9662;</span></button>
        <div class="faq-answer">W panelu użytkownika znajdziesz sekcję 'Moje bonusy', gdzie możesz sprawdzić
            aktualny stan swoich punktów. Możesz również zobaczyć historię przyznanych nagród. To miejsce daje pełen
            wgląd w Twoje osiągnięcia.</div>
    </div>
    <div class="faq-item">
        <button class="faq-question">Czy mogę wielokrotnie używać mojego kodu rabatowego? <span class="arrow">&#9662;</span></button>
        <div class="faq-answer">Tak, kod rabatowy może być wykorzystany wielokrotnie, ale jest aktywny tylko przez 12 miesięcy od daty jego przekazania przez Organizatora. Po zakończeniu współpracy kod wygasa.</div>
    </div>
    <div class="faq-item">
        <button class="faq-question">Jakie materiały mogę wykorzystać w ramach współpracy jako Ambasador? <span class="arrow">&#9662;</span></button>
        <div class="faq-answer">Ambasador jest uprawniony do wykorzystywania materiałów, informacji i dokumentów przekazanych przez Organizatora, jak również materiałów zamieszczonych na stronie internetowej Organizatora oraz na profilach w mediach społecznościowych. Możesz używać filmów, zdjęć i innych zasobów dostarczonych przez Organizatora.</div>
    </div>
    <div class="faq-footer">
        <h4 class="faq-subtitle">Masz jeszcze pytania?</h4>
        <p class="faq-text">Nie wahaj się z nami skontaktować!</p>
        <?php if ($status_message): ?>
            <div id="statusMessage" class="status-message">
                <p class="yellow-text"><?php echo htmlspecialchars($status_message); ?></p>
            </div>
        <?php endif; ?>
        <a class="kontakt-btn" href="<?php echo home_url('/kontakty'); ?>">Kontakt</a>
    </div>

    <!-- MODAL WINDOW. start -->
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeContactModal()">&times;</span>
            <form id="kontakt" action="https://api.web3forms.com/submit" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="access_key" value="YOUR-ACCESS-KEY-HERE">
                <input type="hidden" name="subject" value="Marketing Contact Form Submission">
                <input type="hidden" name="from_name" value="PMB Marketing Form">
                <input type="checkbox" name="botcheck" class="honeypot" style="display: none;">

                <div class="item__field">
                    <label for="yourName">Imię i nazwisko</label>
                    <input type="text" id="yourName" name="yourName" placeholder="Imię i nazwisko" autocomplete="off" required>
                </div>
                <div class="item__field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Twój adres email" autocomplete="off" required>
                </div>
                <div class="item__field">
                    <label for="phone">Telefon</label>
                    <input type="tel" id="phone" name="phone" placeholder="Twój numer telefonu" autocomplete="off" required>
                </div>
                <div class="item__field">
                    <label for="message">Treść wiadomości</label>
                    <textarea id="message" name="message" placeholder="Treść wiadomości" autocomplete="off" required maxlength="500"></textarea>
                    <div class="counter"><span id="charCount">0</span>/500</div>
                </div>

                <div class="checkbox-group">
                    <div class="first-group">
                        <label class="checkbox-item">
                            <input type="checkbox" name="agreeDataProcessing" required>
                            <span class="checkmark"></span>
                            Wyrażam zgodę na przetwarzanie przez PMB Sp. z o.o. z siedzibą przy ul. Armii Krajowej nr 8, 17-300 Siemiatycze, NIP 4142341443, REGON 385240060, e-mail: marketing@parkingMetalbox.com, dalej jako "Administrator", moich danych osobowych - adresu poczty elektronicznej, przekazanych za pośrednictwem formularza kontaktowego, w celu i zakresie koniecznym do przedstawienia oferty marketingowej produktów i usług własnych Administratora.
                        </label>

                        <label class="checkbox-item">
                            <input type="checkbox" name="agreeTelecom" required>
                            <span class="checkmark"></span>
                            Wyrażam zgodę na używanie przez PMB Sp. z o.o. z siedzibą przy ul. Armii Krajowej nr 8, 17-300 Siemiatycze, NIP 4142341443, REGON 385240060, e-mail: marketing@parkingMetalbox.com, dalej jako "Administrator", telekomunikacyjnych urządzeń końcowych, których jestem użytkownikiem, w celu prowadzenia marketingu bezpośredniego za pośrednictwem połączeń telefonicznych oraz wysyłania wiadomości sms/mms zgodnie z art. 172 ustawy z dnia 16 lipca 2004 r. Prawo telekomunikacyjne.
                        </label>
                    </div>
                </div>
                <p id="error-message" class="error-message error-message--modal "></p>
                <button class="modal-btn" type="submit">Wyślij</button>
            </form>
        </div>
    </div>

    <!-- MODAL WINDOW. End -->

    <div class="contact-info">
        <div class="contact-item contact-email">
            <a href="mailto:kontakt@parkingMetalbox.com" class="dh-email">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/mail-icon.svg" alt="Email" class="contact-icon">
                <span>Email</span>
                kontakt@parkingMetalbox.com
            </a>
        </div>

        <div class="contact-item contact-phone">
            <a href="tel:504505718" class="contact-link">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/telephone.svg" alt="Phone" class="contact-icon">
                <span>Telefon</span>
                +48 504 505 718
            </a>
        </div>
        <div class="contact-item contact-map">
            <a href="https://www.google.com/maps?q=BARTYCKA+46+Warszawa" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/map.svg" alt="Map" class="contact-icon">
                <span>Punkt Pokazowy</span>
                Warszawa, ul. Bartycka 26
                <a style="margin-top: 10px; text-decoration: underline;" href="https://www.google.com/maps/place/Parking+Metal+Box+-+producent+szaf+gara%C5%BCowych/@52.2148637,21.0548037,15z/data=!4m2!3m1!1s0x0:0x51411929e6e3df61?sa=X&amp;ved=2ahUKEwj9g4mcmLGAAxXAFhAIHW4lDEAQ_BJ6BAhOEAA&amp;ved=2ahUKEwj9g4mcmLGAAxXAFhAIHW4lDEAQ_BJ6BAhqEAk" target="_blank" rel="nofollow">Zobacz na mapie</a>
            </a>
        </div>
    </div>
</section>
<?php
get_footer();

$conn->close();
?>