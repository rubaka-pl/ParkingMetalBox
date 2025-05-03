<?php
/*
Template Name: contacts
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

get_header();
?>

<body>
    <div id="inner-content" class="home-content">
        <section class="contact-header">
            <div class="container">
                <div class="header-content">
                    <div class="breadcrumbs">
                        <span>
                            <span><a href="<?php echo home_url('/'); ?>">PMB</a></span> »
                            <span class="breadcrumb-last" aria-current="page">Skontaktuj się z nami</span>
                        </span>
                    </div>
                    <h1 class="main-title"><strong>Skontaktuj się</strong> z&nbsp;nami</h1>
                </div>
            </div>
        </section>

        <section class="contact-main">
            <div class="container">
                <div class="contact-row">
                    <div class="contact-info contact-info-column">
                        <div class="contact-card sales-department">
                            <div class="contact-card--item">
                                <div class="contact-card--title">
                                    <h3>Dział Handlowy</h3>
                                </div>
                                <a href="tel:504505718" class="contact-phone">+48 123-456-789</a>
                                <a href="mailto:kontakt@parkingmetalbox.com" class="contact-email">kontakt@parkingmetalbox.com</a>
                                <a href="mailto:biuro@parkingmetalbox.com" class="contact-email">biuro@parkingmetalbox.com</a>

                            </div>

                            <div class="contact-card--item">
                                <div class="contact-card--title">
                                    <h3>Status zamówienia:</h3>
                                </div>
                                <a href="tel:882819858" class="contact-phone">+48 882 819 858</a>
                                <a href="mailto:serwis@parkingmetalbox.com" class="contact-email">serwis@parkingmetalbox.com</a>
                            </div>
                        </div>

                        <div class="contact-card--wrapper">
                            <div class="contact-card invoice-details">
                                <h2>Dane do faktury</h2>
                                <p>
                                    <strong>PMB Sp. z o.o.</strong><br>
                                    ul. Armii Krajowej 23, 16-200 Siemiatycze<br>
                                    NIP: 5331241443<br>
                                    REGON: 28654060<br>
                                    KRS: 0400137630
                                </p>
                            </div>

                            <div class="contact-card bank-details">
                                <h2>Dane bankowe</h2>
                                <p>
                                    Santander Bank Polska S.A.<br>
                                    <strong>29 2190 3590 4050 0001 4468 1533</strong>
                                </p>
                            </div>
                            <div class="contact-card location-card">
                                <h2 class="section-title"><span>Samoobsługowe</span> punkty pokazowe</h2>
                                <strong>Warszawa</strong>
                                <div class="location-address">BARTYCKA 54 <br>ul. Bartycka 54 | Pawilon 54</div>
                                <a style="color: var(--primary-yellow);" href="https://www.google.com/maps/place/Parkinngmetal+Box+-+producent+szaf+gara%C5%BCowych/@52.2148637,21.0548037,15z/data=!4m2!3m1!1s0x0:0x51411929e6e3df61?sa=X&amp;ved=2ahUKEwj9g4mcmLGAAxXAFhAIHW4lDEAQ_BJ6BAhOEAA&amp;ved=2ahUKEwj9g4mcmLGAAxXAFhAIHW4lDEAQ_BJ6BAhqEAk" target="_blank" rel="nofollow">Zobacz na mapie</a>
                            </div>
                            <div id="modal" class="modal">
                                <span class="close">&times;</span>
                                <img class="modal-content" id="modal-img">
                                <div id="caption"></div>
                            </div>
                        </div>


                    </div>

                    <div class="modal-content">
                        <form id="kontakt" action="<?php echo admin_url('admin-post.php'); ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="send_contact_email">
                            <input type="hidden" name="redirect" value="<?php echo home_url('/kontakty/'); ?>">
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
                                        Wyrażam zgodę na przetwarzanie przez PMB Sp. z o.o. z siedzibą przy ul. Armii Krajowej nr 8, 17-300 Siemiatycze, NIP 5441541443, REGON 385900060, e-mail: marketing@parkingmetalbox.com, dalej jako "Administrator", moich danych osobowych - adresu poczty elektronicznej, przekazanych za pośrednictwem formularza kontaktowego, w celu i zakresie koniecznym do przedstawienia oferty marketingowej produktów i usług własnych Administratora.
                                    </label>

                                    <label class="checkbox-item">
                                        <input type="checkbox" name="agreeTelecom" required>
                                        <span class="checkmark"></span>
                                        Wyrażam zgodę na używanie przez PMB Sp. z o.o. z siedzibą przy ul. Armii Krajowej nr 8, 17-300 Siemiatycze, NIP 5441541443, REGON 385900060, e-mail: marketing@parkingmetalbox.com, dalej jako "Administrator", telekomunikacyjnych urządzeń końcowych, których jestem użytkownikiem, w celu prowadzenia marketingu bezpośredniego za pośrednictwem połączeń telefonicznych oraz wysyłania wiadomości sms/mms zgodnie z art. 172 ustawy z dnia 16 lipca 2004 r. Prawo telekomunikacyjne.
                                    </label>
                                </div>
                            </div>
                            <p id="error-message" class="error-message error-message--modal "></p>
                            <button class="modal-btn" type="submit">Wyślij</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function submitForm(event) {
            event.preventDefault();

            const form = document.getElementById('kontakt');
            const formData = new FormData(form);

            fetch(form.action, {
                    method: form.method,
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Email wysłany!');
                        window.location.href = form.querySelector('[name="redirect"]').value;
                    } else {
                        document.getElementById('error-message').textContent = 'Błąd podczas wysyłania wiadomości.';
                    }
                })
                .catch(error => {
                    document.getElementById('error-message').textContent = 'Wystąpił błąd. Spróbuj ponownie później.';
                });
        }
    </script>

</body>

<?php get_footer(); ?>