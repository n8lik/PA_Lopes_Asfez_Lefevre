<link href="css/bailleur.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="/css/base.css">
<?php
require 'includes/functions/functions.php';


$type = $_GET['type'];
if($type == 'housing'){

$housingid = $_GET['id'];
$reservations = getCalendarByHousingId($housingid);

}else if ($type == 'provider'){
    $housingid = $_GET['id'];
    $reservations = getCalendarByPerformanceId($providerid);
}
$month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');


?>
<div class="calendar-container">
    <?php
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
    $months = [
        'January' => 'Janvier',
        'February' => 'Février',
        'March' => 'Mars',
        'April' => 'Avril',
        'May' => 'Mai',
        'June' => 'Juin',
        'July' => 'Juillet',
        'August' => 'Août',
        'September' => 'Septembre',
        'October' => 'Octobre',
        'November' => 'Novembre',
        'December' => 'Décembre'
    ];

    $englishMonth = date('F', mktime(0, 0, 0, $month, 1, $year));
    $frenchMonth = $months[$englishMonth];
    $daysInMonth = date('t', mktime(0, 0, 0, $month, 1, $year));
    $firstDayOfMonth = date('N', mktime(0, 0, 0, $month, 1, $year));
    $lastDayOfMonth = date('N', mktime(0, 0, 0, $month, $daysInMonth, $year));

    $calendar = [];

    for ($i = 1; $i <= $daysInMonth; $i++) {
        $calendar[] = $i;
    }

    $previousMonth = $month - 1;
    $previousYear = $year;
    if ($previousMonth < 1) {
        $previousMonth = 12;
        $previousYear--;
    }

    $nextMonth = $month + 1;
    $nextYear = $year;
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }
    ?>
    <div class="nav-bar">
        <a href="?id=<?=$housingid ?>&month=<?= $previousMonth ?>&year=<?= $previousYear ?>">Précédent</a>
        <span class="month-year"><?= $frenchMonth . ' ' . $year ?></span>

        <a href="?id=<?=$housingid ?>&month=<?= $nextMonth ?>&year=<?= $nextYear ?>">Suivant</a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr class="header-row">
                    <th>
                        <center>Lun</center>
                    </th>
                    <th>
                        <center>Mar</center>
                    </th>
                    <th>
                        <center>Mer</center>
                    </th>
                    <th>
                        <center>Jeu</center>
                    </th>
                    <th>
                        <center>Ven</center>
                    </th>
                    <th>
                        <center>Sam</center>
                    </th>
                    <th>
                        <center>Dim</center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dayOfWeek = 1;
                $weekRowOpen = false;
                for ($i = 0; $i < $firstDayOfMonth - 1; $i++, $dayOfWeek++) {
                    if ($dayOfWeek == 1) {
                        echo '</tr><tr class="week-row">';
                        $weekRowOpen = true;
                    }
                    $weekendClass = ($dayOfWeek == 6 || $dayOfWeek == 7) ? ' weekend' : '';
                    echo "<td class='day-cell{$weekendClass} '></td>";
                }
                for ($i = 1; $i <= $daysInMonth; $i++, $dayOfWeek++) {
                    if ($dayOfWeek == 1) {
                        if ($weekRowOpen) {
                            echo '</tr>';
                        }
                        echo '<tr class="week-row">';
                        $weekRowOpen = true;
                    }

                    // vérification de si le $i est dans les périodes de réservation
                    $isReserved = false;
                    foreach ($reservations as $reservation) {
                        $start_date = $reservation['start_date'];
                        $end_date = $reservation['end_date'];
                        $start_date = new DateTime($start_date);
                        $end_date = new DateTime($end_date);
                        $current_date = new DateTime($year . '-' . $month . '-' . $i);
                        if ($current_date >= $start_date && $current_date <= $end_date) {
                            $isReserved = true;
                            break;
                        }
                    }

                    $weekendClass = ($dayOfWeek == 6 || $dayOfWeek == 7) ? ' weekend' : '';
                    $todayClass = ($i == date('j') && $month == date('n') && $year == date('Y')) ? ' today' : '';
                    $reservedClass = $isReserved ? ' reserved-day' : '';
                    echo "<td class='day-cell $weekendClass $todayClass $reservedClass '>{$i}";
                    
                    echo "</td>";
                    if ($dayOfWeek == 7) {
                        echo '</tr>';
                        $weekRowOpen = false;
                        $dayOfWeek = 0;
                    }
                }

                if ($weekRowOpen) {
                    echo '</tr>';
                }

                ?>



            </tbody>
        </table>
    </div>
</div>
