<?php

namespace public_site\controller;

class LogInController
{
    public function showLogInForm(): void
    {
        $homeController = new HomeController();
        $homeController->showHeader();
        echo "
            <main id='login-page'>
                <section>
                    <article class='box'>
                        <h1>Kirjaudu</h1>
                        <form action='/index.php/authenticate-user' method='POST'>
                            <input type='text' name='username' placeholder='Käyttäjätunnus'>
                            <input type='password' name='pw' placeholder='Salasana'>
                            <input type='submit' value='Kirjaudu' class='btn primary'>
                        </form>
                        <a href='/index.php/' class='btn secondary'>Takaisin</a>
                    </article>
                </section>
            </main>
        ";
        $homeController->showFooter();
    }
}