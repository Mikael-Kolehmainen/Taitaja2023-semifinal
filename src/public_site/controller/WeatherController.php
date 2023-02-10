<?php

namespace public_site\controller;

use api\manager\SessionManager;
use api\model\Database;
use api\model\UserModel;

class WeatherController
{
    /** @var string */
    private $dataFilePath = __DIR__."/../../data/weatherdata.json";

    /** @var Database */
    private $db;

    /** @var int */
    private $startDay = 1;

    /** @var int */
    private $endDay = 8;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function showWeatherPage()
    {
        $homeController = new HomeController();
        $homeController->showHeader();

        echo "
            <main>
                <section>
                    <article>
                        <h1 class='hero'>Kuopio</h1>";
                        $this->displayWeatherDataDesktop();
                        $this->displayWeaterDataMobile();
                        $this->displayAdminTools();
        echo "
                    </article>
                </section>
            </main>
        ";
        $homeController->showFooter();
    }

    private function displayWeatherDataDesktop(): void
    {
        if (file_exists($this->dataFilePath)) {
            $data = file_get_contents($this->dataFilePath);
            $weathers = json_decode($data);
            echo "<p>Säätiedot " . $this->getDateRange($weathers) . "</p>";
            echo "<table id='table-desktop-version'>";
            echo "<tr>";
            echo "<td></td>";
            $i = 0;
            foreach ($weathers as $weather) {

                if ($i < $this->startDay) {
                    $i++;
                    continue;
                }
                if ($i == $this->endDay) {
                    break;
                }

                $day = $this->addZeroToStart($weather->Pv);
                $month = $this->addZeroToStart($weather->Kk);
                $year = $this->addZeroToStart($weather->Vuosi);

                echo "
                    <td>$day.$month.$year</td>
                ";
                $i++;
            }
            echo "</tr>";
            echo "<tr>";
            echo "<td><i class='fa fa-cloud-rain'></i> Sademäärä (mm)</td>";
            $this->echoDataCells($weathers, "Sademäärä (mm)");
            echo "</tr>";
            echo "<tr>";
            echo "<td><i class='fa fa-snowflake'></i> Lumensyvyys (cm)</td>";
            $this->echoDataCells($weathers, "Lumensyvyys (cm)");
            echo "</tr>";
            echo "<tr>";
            echo "<td><i class='fa fa-temperature-high'></i> Ylin lämpötila (degC)</td>";
            $this->echoDataCells($weathers, "Ylin lämpötila (degC)");
            echo "</tr>";
            echo "<tr>";
            echo "<td><i class='fa fa-temperature-low'></i> Alin lämpötila (degC)</td>";
            $this->echoDataCells($weathers, "Alin lämpötila (degC)");
            echo "</tr>";
            echo "</table>";
        } else {
            echo "<p>Dataa ei löydy.</p>";
        }
    }

    private function getDateRange($values): string
    {
        $from = $this->addZeroToStart($values[$this->startDay]->Pv) . "." . $this->addZeroToStart(($values[$this->startDay]->Kk)) . "." . $values[$this->startDay]->Vuosi;
        $to = $this->addZeroToStart($values[$this->endDay-1]->Pv) . "." . $this->addZeroToStart($values[$this->endDay-1]->Kk) . "." . $values[$this->endDay-1]->Vuosi;
        return $from." - ".$to;
    }

    private function addZeroToStart($value): string
    {
        if ($value < 10) {
            $value = "0" . $value;
        }

        return $value;
    }

    private function echoDataCells($values, $key): void
    {
        $i = 0;
        foreach ($values as $value) {
            if ($i < $this->startDay) {
                $i++;
                continue;
            }
            if ($i == $this->endDay) {
                break;
            }

            $valueToEcho = $value->{"$key"};
            echo "
                <td>$valueToEcho</td>
            ";
            $i++;
        }
    }

    private function displayWeaterDataMobile(): void
    {
        if (file_exists($this->dataFilePath)) {
            $data = file_get_contents($this->dataFilePath);
            $weathers = json_decode($data);
            echo "<table id='table-mobile-version'>";
            echo "<tr>";
            echo "<td></td>";
            echo "<td><i class='fa fa-cloud-rain'></i>(mm)</td>";
            echo "<td><i class='fa fa-snowflake'></i>(cm)</td>";
            echo "<td><i class='fa fa-temperature-high'></i>(degC)</td>";
            echo "<td><i class='fa fa-temperature-low'></i>(degC)</td>";
            echo "</tr>";
            $i = 0;
            foreach ($weathers as $weather) {
                if ($i < $this->startDay) {
                    $i++;
                    continue;
                }
                if ($i == $this->endDay) {
                    break;
                }

                $day = $this->addZeroToStart($weather->Pv);
                $month = $this->addZeroToStart($weather->Kk);
                $year = $this->addZeroToStart($weather->Vuosi);
                $amountOfRain = $weather->{"Sademäärä (mm)"};
                $snowDepth = $weather->{"Lumensyvyys (cm)"};
                $highestTemp = $weather->{"Ylin lämpötila (degC)"};
                $lowestTemp = $weather->{"Alin lämpötila (degC)"};

                echo "<tr>";
                echo "<td>$day.$month.$year</td>";
                echo "<td>$amountOfRain</td>";
                echo "<td>$snowDepth</td>";
                echo "<td>$highestTemp</td>";
                echo "<td>$lowestTemp</td>";
                echo "</tr>";
                $i++;
            }
            echo "</table>";
        } else {
            echo "<p>Dataa ei löydy.</p>";
        }
    }

    private function displayAdminTools(): void
    {
        $userModel = new UserModel($this->db);
        $userModel->session = SessionManager::getUserSession();
        $user = $userModel->loadWithSession();

        if ($user->role == "admin") {
            echo "
                <a href='#'>Muokkaa dataa</a>
            ";
        }
    }
}