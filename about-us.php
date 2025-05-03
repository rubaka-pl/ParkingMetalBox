<?php
/*
Template Name: about-us
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

get_header();
?>

<main>
    <div class="main-wrapper wrapper-about-us">
        <div>
            <h1><a href="<?php echo esc_url(home_url('/')); ?>" class="pmb-link">PMB</a> » <span class="yellow-text">O nas</span></h1>
            <p class="quote"><em>"Mniej znaczy więcej"</em></p>
            <p>Spełniamy marzenia naszych Klientów o dodatkowej przestrzeni do przechowywania, oferując innowacyjne rozwiązania, które doskonale łączą funkcjonalność z nowoczesnym designem.</p>
        </div>
    </div>
</main>

<section class="about-us-section">
    <div class="about-us-content">
        <div class="history-section">
            <div class="text-content--about">
                <h2>Nasza <span class="yellow-text">historia</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis autem atque eum tempora. Sequi eos consequuntur recusandae sapiente nulla voluptate consectetur, laudantium asperiores maiores, dolorum sunt in voluptatum consequatur labore?</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit libero vel, nisi numquam consectetur harum debitis accusantium id dicta enim ullam praesentium maxime fuga minus repellat a aliquam magnam. Quae.</p>
            </div>
        </div>

        <div class="business-section">
            <div class="text-content--about">
                <h2>Wspólny <span class="yellow-text">biznes</span></h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem rerum excepturi error, quidem fugiat, ea nemo enim eligendi autem itaque eaque ex aperiam! Blanditiis odit ratione quae tempore deleniti eveniet?</p>
            </div>
        </div>

        <div class="challenges-section">
            <div class="text-content--about">
                <h2>Wyzwania na <span class="yellow-text">starcie</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem assumenda possimus maxime optio aspernatur in quos! Officia mollitia architecto, aliquam eaque ab incidunt iusto voluptate accusamus beatae ad dolorum excepturi.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio alias aliquid consectetur adipisci eos et incidunt vel voluptatibus, temporibus quae tempore soluta earum dignissimos sapiente saepe. Corporis consequatur perferendis illum?</p>
            </div>
        </div>

        <div class="team-section">

            <div class="text-content--about">
                <h2>Nasz <span class="yellow-text">zespół</span></h2>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis, magnam quos laudantium officiis omnis corporis non expedita dolores, veritatis deserunt distinctio iste! Nobis, deleniti! Sit architecto doloremque laudantium maxime odio.</p>
            </div>
        </div>

        <div class="quality-section">
            <div class="text-content--about">
                <h2>Jakość i <span class="yellow-text">satysfakcja</span></h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. In voluptatibus nam quam numquam officiis hic blanditiis repellendus magnam laborum? Unde rerum accusantium maxime dolore voluptatum ut dolor suscipit commodi cupiditate!</p>
            </div>
        </div>

        <div class="experience-section">
            <div class="text-content--about">
                <h2><span class="yellow-text">Doświadczenie</span></h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, quis aperiam ea excepturi id minus reprehenderit non dolorem nostrum praesentium illo fuga qui quos cumque. Veniam alias dignissimos voluptas aperiam!</p>
            </div>
            <div class="image-content">
                <img loading="lazy" src="<?php echo get_template_directory_uri(); ?>/assets/img/relacja-z-wydarzenia-polski-rynem-mieszkaniowy-1050x500.jpg" alt="Doświadczenie">
            </div>
        </div>
    </div>
</section>

<section class="contact-info">
    <div class="contact-item contact-email">
        <a href="mailto:kontakt@parkingmagicbox.com" class="dh-email">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/mail-icon.svg" alt="Email" class="contact-icon">
            <span>Email</span>
            kontakt@parkinmetalbox.com
        </a>
    </div>

    <div class="contact-item contact-phone">
        <a href="tel:504505718" class="contact-link">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/telephone.svg" alt="Phone" class="contact-icon">
            <span>Telefon</span>
            +48 123-456-789
        </a>
    </div>
    <div class="contact-item contact-map">
        <a href="https://www.google.com/maps?q=Homer+12+Warszawa" target="_blank">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/map.svg" alt="Map" class="contact-icon">
            <span>Punkt Pokazowy</span>
            Warszawa, ul. Homer 12
            <a style="margin-top: 10px; text-decoration: underline;" href="https://www.google.com/maps/place/Parking+Magic+Box+-+producent+szaf+gara%C5%BCowych/@52.2148637,21.0548037,15z/data=!4m2!3m1!1s0x0:0x51411929e6e3df61?sa=X&amp;ved=2ahUKEwj9g4mcmLGAAxXAFhAIHW4lDEAQ_BJ6BAhOEAA&amp;ved=2ahUKEwj9g4mcmLGAAxXAFhAIHW4lDEAQ_BJ6BAhqEAk" target="_blank" rel="nofollow">Zobacz na mapie</a>
        </a>
    </div>
</section>

<?php get_footer(); ?>