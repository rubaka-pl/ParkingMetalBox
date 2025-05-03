<?php

/**
 * Template Name: dashboard panel
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    wp_redirect(home_url('/login'));
    exit();
}

global $wpdb;

// Handle box order
if (isset($_POST['insert_box_order']) && wp_verify_nonce($_POST['insert_box_nonce_field'], 'insert_box_nonce')) {
    $box_type = sanitize_text_field($_POST['box_type']);
    $quantity = intval($_POST['quantity']);
    $promo_code = $_SESSION['promo_code'] ?? 'BRAK';

    $wpdb->insert('pmb_zamowienia', [
        'date' => current_time('mysql'),
        'firstName' => 'User',
        'lastName' => 'lastName',
        'street' => 'Ulica',
        'postalCode' => '00-000',
        'city' => 'Miasto',
        'phone' => '123456789',
        'email' => 'email@example.com',
        'message' => 'Zamówione przez dashboard',
        'employerNIP' => '0000000000',
        'employerName' => 'Firma',
        'cenaSuma' => 3500,
        'cenaBox' => 3600,
        'cenaAsortyment' => 0,
        'produktZamowienie' => $box_type,
        'asortymentZamowienie' => '0',
        'szerokoscBoxa' => '900',
        'wysokoscSkrzyni' => '2200',
        'wysokoscPodstawy' => '400',
        'md5sum' => md5(uniqid()),
        'securityCode' => substr(md5(rand()), 0, 10),
        'platnosc' => 'online',
        'cenaTransport' => 400.00,
        'wojewodztwo' => 'mazowieckie',
        'crc' => strtoupper(uniqid()),
        'status' => 'nowe',
        'czy_rabat' => 'tak',
        'kod_rabatowy' => $promo_code,
        'kwota_rabatu' => '100',
        'zrodlo' => 'dashboard',
        'notka' => 'Formularz zamówienia boksu',
        'data_ponowny_kontakt' => '',
        'data_montazu' => null,
        'opiekun' => null,
        'quantity' => $quantity
    ]);

    wp_safe_redirect(home_url('/dashboard-panel'));
    exit();
}

if (isset($_POST['submit_payout']) && wp_verify_nonce($_POST['payout_nonce'], 'payout_form_nonce')) {
    $user_id = $_SESSION['user_id'];

    $data = [
        'user_id' => $user_id,
        'imie' => sanitize_text_field($_POST['imie']),
        'nazwisko' => sanitize_text_field($_POST['nazwisko']),
        'data_urodzenia' => sanitize_text_field($_POST['data_urodzenia']),
        'numer_rachunku' => sanitize_text_field($_POST['numer_rachunku']),
        'nazwa_banku' => sanitize_text_field($_POST['nazwa_banku']),
        'ulica' => sanitize_text_field($_POST['ulica']),
        'miasto' => sanitize_text_field($_POST['miasto']),
        'kod_pocztowy' => sanitize_text_field($_POST['kod_pocztowy']),
        'urzad_skarbowy' => sanitize_text_field($_POST['urzad_skarbowy']),
        'email' => sanitize_email($_POST['email']),
        'telefon' => sanitize_text_field($_POST['telefon']),
        'pesel' => sanitize_text_field($_POST['pesel']),
        'data_zgloszenia' => current_time('mysql')
    ];
    $result = $wpdb->query($wpdb->prepare(
        "INSERT INTO ambasador_pmb_users_data
        (user_id, imie, nazwisko, data_urodzenia, numer_rachunku, nazwa_banku, ulica, miasto, kod_pocztowy, urzad_skarbowy, email, telefon, pesel, data_zgloszenia)
        VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        $data['user_id'],
        $data['imie'],
        $data['nazwisko'],
        $data['data_urodzenia'],
        $data['numer_rachunku'],
        $data['nazwa_banku'],
        $data['ulica'],
        $data['miasto'],
        $data['kod_pocztowy'],
        $data['urzad_skarbowy'],
        $data['email'],
        $data['telefon'],
        $data['pesel'],
        $data['data_zgloszenia']
    ));

    if ($result !== false) {
        echo '<div class="success-msg">Dane zostały zapisane!</div>';
    } else {
        echo '<div class="error-msg">Błąd zapisu: ' . $wpdb->last_error . '</div>';
    }
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: " . home_url('/login'));
    exit();
}

global $wpdb;

// Retrieving user data
$promo_code = $_SESSION['promo_code'];
$username = $_SESSION['username'];

// number of sold boxes and the total bonus amount
$query = $wpdb->prepare(
    "SELECT 
        SUM(p.quantity) as total_sold, 
        MAX(p.purchase_date) as last_purchase_date,
        u.paid_bonus,
        u.current_bonus
    FROM ambasador_pmb_purchases p
    JOIN ambasador_pmb_users u 
    ON p.kod_rabatowy = u.promo_code
    WHERE p.kod_rabatowy = %s",
    $promo_code
);

error_log("SQL Query: " . $query);
$result = $wpdb->get_row($query, ARRAY_A);

error_log("Query Result: " . print_r($result, true));
$last_purchase_date = "Brak danych";

if ($result) {
    $total_sold = $result['total_sold'] ?? 0;
    $total_bonus = $result['current_bonus'] ?? 0;
    $last_purchase_date = $result['last_purchase_date'] ?? "Brak danych";
    if ($last_purchase_date != "Brak danych") {
        $date_obj = new DateTime($last_purchase_date);
        $last_purchase_date = $date_obj->format('Y-m-d');
    }
}

$wpdb->query("SET SESSION group_concat_max_len = 10000");

$history_query = $wpdb->prepare(
    "SELECT 
        crc,
        firstName,
        GROUP_CONCAT(produktZamowienie SEPARATOR ', ') as models,
        SUM(quantity) as quantity,
        MAX(purchase_date) as purchase_date,
        (SUM(quantity) * 200) as bonus,
        status
    FROM ambasador_pmb_purchases 
    WHERE kod_rabatowy = %s 
    GROUP BY crc
    ORDER BY purchase_date DESC",
    $promo_code
);

$history_results = $wpdb->get_results($history_query, ARRAY_A);


$has_confirmed = false;
if ($history_results) {
    foreach ($history_results as $row) {
        if ($row['status'] === 'potwierdzona') {
            $has_confirmed = true;
            break;
        }
    }
}
get_header();


?>

<style>
    .table_component {
        overflow: auto;
        width: 100%;
    }

    .table_component table {
        border: 1px solid var(--primary-yellow);
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .table_component th {
        border-bottom: 1px solid var(--primary-yellow);
        background-color: transparent;
        color: var(--primary-yellow);
        padding: 10px;
    }

    .table_component td {
        border: 1px solid var(--primary-yellow);
        background-color: transparent;
        color: #fff;
        padding: 10px;
    }

    .table_component caption {
        caption-side: top;
        text-align: left;
        margin-bottom: 10px;
    }



    .panel-box {
        width: 600px;
        min-height: 215px;
        border: 1px solid var(--primary-yellow);
        text-align: center;
        padding: 8px;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .panel-container {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
        margin: 150px auto;
        justify-content: center;
    }

    .code {
        font-size: 4rem;
    }

    .copy-btn {
        display: inline-block;
        margin-left: 10px;
        font-size: 16px;
        color: var(--primary-yellow);
        cursor: pointer;
        text-decoration: underline;
    }

    .status-badge {
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        min-width: 100px;
        text-align: center;
        padding: 10px;
    }

    .status-nowe {
        background-color: #ffffff;
        color: #000000;
    }

    .status-oczekujaca {
        background-color: rgba(0, 123, 255, 0.2);
    }

    .status-odrzucona {
        background-color: #f8d7da;
        color: red;
    }

    .status-potwierdzona {
        background: green;
    }

    .payout-button {
        margin-top: 5px;
        background: linear-gradient(45deg, #ffd700, #ffc966ba);
        border-radius: 10px;
    }
</style>
<section class="dashboard-panel" id="bonusy">
    <div class="dashboard-container">
        <h1>Witaj <span><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Ambasadorze'; ?></span></h1>
        <p>Sprawdź swoje osiągnięcia i odkryj nowe możliwości.</p>
    </div>

    <div class="dashboard-panel">
        <div class="panel-container">
            <div class="panel-box">
                <h3>Sprawdź swoje dostępne bonusy i nagrody</h3>
                <p>Zbieraj bonusy za sprzedaż boksów garażowych. Im więcej sprzedasz, tym większe nagrody możesz zdobyć.</p>
            </div>
            <div class="panel-box">
                <h3>Twój indywidualny kod:</h3>
                <p class="yellow-text code"><?php echo htmlspecialchars($promo_code); ?></p>
                <span class="copy-btn">Kopiuj</span>
            </div>
            <div class="panel-box">
                <h3>Twoje osiągnięcia</h3>
                <p>Ilość sprzedanych boksów z kodem:
                    <?php echo $total_sold; ?>
                </p>
            </div>
            <div class="panel-box">
                <h3>Dostępne bonusy</h3>

                <!-- Display bonus amount -->
                <p>Kwota bonusów do wypłaty: <?php echo ($has_confirmed) ? number_format($total_bonus, 2, ',', ' ') . ' zł' : '0,00 zł'; ?></p>

                <p class="payout-date">
                    Przewidywany okres rozliczeniowy:
                    <strong>
                        <?php
                        $payout_from = get_option('payout_date_from');
                        $payout_to = get_option('payout_date_to');

                        if ($payout_from && $payout_to) {
                            echo date('d.m.Y', strtotime($payout_from)) . ' – ' . date('d.m.Y', strtotime($payout_to));
                        } else {
                            echo '<span class="no-date">nie ustalono</span>';
                        }
                        ?>
                    </strong>
                </p>

                <!--  if ($total_bonus > 0 && $has_confirmed):  -->
                <a href="<?php echo home_url('/wniosek'); ?>" class="payout-button action-btn">
                    Złóż wniosek o wypłatę
                </a>

                </d iv>
                <?php
                // endif; 
                ?>
                <div id="historia"></div>
            </div>
            <div class="panel-box">
                <h3>Symulacja zakupu (domyslne to na innej stronie firmy)</h3>
                <button id="buy-box-btn" class="payout-button action-btn">Kup boks</button>
            </div>
        </div>

        <div class="steps-container steps-container--dashboard">
            <div class="step">
                <div class="step-circle">1</div>
                <p class="step-title">Złóż wniosek o wypłatę</p>
                <p class="step-text">Aby nasz dział finansowy mógł zrealizować przelew w odpowiednim terminie, konieczne jest złożenie wniosku o wypłatę. Brak tego kroku może spowodować opóźnienia.</p>
            </div>
            <div class="step">
                <div class="step-circle">2</div>
                <p class="step-title">Zbieraj bonusy i czekaj na okres wypłat</p>
                <p class="step-text">Okres wypłat znajdziesz powyżej w sekcji <strong>Dostępne bonusy</strong>. To Twoje centrum informacji - sprawdzisz tam aktualny okres, liczbę zebranych bonusów i zaktualizujesz dane.</p>
            </div>
            <div class="step">
                <div class="step-circle">3</div>
                <p class="step-title">Oczekuj przelewu na swoje konto</p>
                <p class="step-text">Środki zostaną przelane na rachunek bankowy podany we wniosku. Ciesz się zarobkami i nie przestawaj polecać naszych produktów!</p>
            </div>
        </div>

        <div class="table_component" role="region" tabindex="0">
            <table style="overflow-x:auto;">
                <caption style="font-size:48px; margin: 40px auto">Historia sprzedaży</caption>
                <thead>
                    <tr>
                        <th>Numer zamówienia</th>
                        <th>Imię</th>
                        <th>Model</th>
                        <th>Ilość</th>
                        <th>Data</th>
                        <th>Status płatności</th>
                        <!-- <th>Bonusy</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($history_results) {
                        foreach ($history_results as $row) {
                            $status = $row['status'] ?: 'oczekujaca';
                            $status_class = 'status-' . $status;

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['crc']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['models']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['purchase_date']) . "</td>";
                            echo "<td><span class='status-badge $status_class'>" . htmlspecialchars($status) . "</span></td>";
                            // echo "<td>" . ($row['quantity'] * 200) . " zł</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Brak danych o sprzedaży.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div style="
    text-align: center;
    margin: 60px;"
                class="wyplata_container">
                <a href="<?php echo home_url('/wniosek'); ?>"
                    class="payout-button action-btn">
                    Złóż wniosek o wypłatę
                </a>
            </div>
        </div>

        <div class="status-explanation" style="margin-top: 20px;font-size: 1.1em;color: #ffffff;">
            <p>* Objaśnienie statusów płatności:</p>
            <ul style="list-style: none; padding-left: 0;">
                <li>Nowe - Zamówienie zostało przyjęte, oczekuje na potwierdzenie płatności</li>
                <li>Oczekująca - Zaliczka została przyjęta, a pełna płatność zamówienia jest oczekiwana</li>
                <li>Potwierdzona - Płatność została zweryfikowana, bonus trafił do Twojego konta</li>
                <li>Odrzucona - Płatność nie została potwierdzona lub została anulowana</li>
            </ul>
        </div>
    </div>
</section>
<div id="boxModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index:9999; justify-content:center; align-items:center;">
    <form method="post" style="background:#1a1a1a; padding:30px; border-radius:10px; max-width:400px; width:90%; color:white;">
        <h3 style="margin-bottom:15px;">Wybierz boks</h3>
        <label for="box_type">Typ boksa:</label>
        <select name="box_type" id="box_type" required style="width:100%; padding:8px;">
            <option value="">-- Wybierz --</option>
            <option value="jednomodulowy">Jednomodulowy</option>
            <option value="dwumodulowy">Dwumodulowy</option>
            <option value="podjazdowy">Podjazdowy</option>
        </select>
        <label for="quantity" style="margin-top:15px;">Ilość:</label>
        <input type="number" name="quantity" id="quantity" required min="1" value="1" style="width:100%; padding:8px; margin-bottom:15px;">

        <input type="hidden" name="insert_box_order" value="1">
        <?php wp_nonce_field('insert_box_nonce', 'insert_box_nonce_field'); ?>
        <button type="submit" class="action-btn">Zamów</button>
        <button type="button" onclick="document.getElementById('boxModal').style.display='none'" style="margin-top:10px; background:#444; color:white;">Anuluj</button>
    </form>
</div>
<script>
    document.getElementById('buy-box-btn').addEventListener('click', function() {
        document.getElementById('boxModal').style.display = 'flex';
    });
</script>
<?php
get_footer();
?>