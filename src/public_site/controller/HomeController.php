<?php

namespace public_site\controller;

use api\manager\SessionManager;

class HomeController
{
    public function showHeader(): void
    {
        echo '
        </head>
        <header>
            <div class="row">
                <div class="col">
                    <img src="/src/public_site/media/logo_light.png" alt="Weather Oy logo" />
                </div>
                <div class="col">
                    <nav>
                        <ul>';
                        if (!SessionManager::issetUserSession()) {
                            echo '<li><a href="/index.php/kirjaudu" class="btn secondary" id="desktop-login-btn">Kirjaudu</a></li>';
                        } else {
                            echo '<li><a href="/index.php/log-out" class="btn secondary" id="desktop-login-btn">Kirjaudu ulos</a></li>';
                        }
        echo                    '<li class="hamburger" id="header-dropdown-btn">
                                <a class="icon">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <div class="dropdown" style="display: none;" id="header-dropdown">';
                        if (!SessionManager::issetUserSession()) {
                            echo '<a href="/index.php/kirjaudu" class="btn secondary">Kirjaudu</a>';
                        } else {
                            echo '<a href="/index.php/log-out" class="btn secondary">Kirjaudu ulos</a>';
                        }
        echo                   '</div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        ';
    }

    public function showFooter(): void
    {
        echo '
        <footer>
            <div class="footer-info">
                <p style="font-weight: bold;">Mikael Kolehmainen | Vamia</p>
                <p><small> &#169; Taitaja 2023</small></p>
            </div>
        </footer>
        ';
    }

    public function showHomePage(): void
    {
        $this->showHeader();
        echo '
            <main>
            <section>
                <div class="row">
                    <div class="col">
                        <h1 class="hero">Tervetuloa, kirjaudu sisälle nähdäksesi säätiedot</h1>
                        <p class="hero-subtitle">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc
                            dignissim lacinia justo id molestie. Nulla facilisi. Duis eu enim
                            et augue consequat rhoncus.
                        </p>
                        <a href="/index.php/kirjaudu" class="btn primary" id="btn-over-image">Kirjaudu</a>
                    </div>
                    <div class="col">
                        <img src="/src/public_site/media/weather.png" alt="kuvakaappaus sääpalvelusta" />
                        <!-- Lisä tänne sun kuvakaapaus sääpalvelusta -->
                    </div>
                    <a href="/index.php/kirjaudu" class="btn primary" id="btn-below-image">Kirjaudu</a>
                </div>
            </section>
        </main>
        ';
        $this->showFooter();
    }
}