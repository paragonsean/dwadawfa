<?php

// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared

global $wpdb;
$months = $wpdb->get_results("select count(*) as c, concat(year(created), '-', date_format(created, '%m')) as d from " . NEWSLETTER_USERS_TABLE . " where status='C' group by concat(year(created), '-', date_format(created, '%m')) order by d desc limit 30");
$days = $wpdb->get_results("select count(*) as c, date(created) as d from " . NEWSLETTER_USERS_TABLE . " where status='C' group by date(created) order by d desc limit 70");
$time_offset = get_option('gmt_offset') * 3600;

$mm = array();
for ($i = 24; $i >= 0; $i--) {
    $mm[gmdate("Y-m", strtotime('-' . $i . ' months') + $time_offset)] = 0;
}

foreach ($months as $day) {
    if (!isset($mm[$day->d])) {
        continue;
    }
    $mm[$day->d] = $day->c;
}
$d = array();
for ($i = 60; $i >= 0; $i--) {
    $d[gmdate("Y-m-d", strtotime('-' . $i . ' days') + $time_offset)] = 0;
}

foreach ($days as $day) {
    if (!isset($d[$day->d])) {
        continue;
    }
    $d[$day->d] = $day->c;
}
?>
<div class="row">
    <div class="col-md-6">
        <h3>Last 60 days</h3>
        <canvas id="tnp-days-chart" style="width: 100%; height: 300px"></canvas>



        <script type="text/javascript">

            var days_data = {
                labels: <?php echo wp_json_encode(array_keys($d)) ?>,
                datasets: [
                    {
                        label: "Totals",
                        backgroundColor: "#30A9DE",
                        borderColor: "#30A9be",
                        hoverBackgroundColor: "#FFEEE4",
                        hoverBorderColor: "#FFEEE4",
                        data: <?php echo wp_json_encode(array_values($d)) ?>
                    }
                ]
            };

            jQuery(document).ready(function ($) {
                genderCtx = $('#tnp-days-chart').get(0).getContext("2d");
                genderChart = new Chart(genderCtx, {type: 'bar', data: days_data});
            });

        </script>
    </div>
    <div class="col-md-6">

        <h3>Last 24 months</h3>
        <canvas id="tnp-months-chart" style="width: 100%; height: 300px"></canvas>

        <script type="text/javascript">

            var months_data = {
                labels: <?php echo wp_json_encode(array_keys($mm)) ?>,
                datasets: [
                    {
                        label: "Totals",
                        backgroundColor: "#30A9DE",
                        borderColor: "#30A9be",
                        hoverBackgroundColor: "#30A9DE",
                        hoverBorderColor: "#30A9be",
                        data: <?php echo wp_json_encode(array_values($mm)) ?>
                    }
                ]
            };

            jQuery(document).ready(function ($) {
                genderCtx = $('#tnp-months-chart').get(0).getContext("2d");
                genderChart = new Chart(genderCtx, {type: 'bar', data: months_data});
            });

        </script>
    </div>
</div>

<h3>Tabular format</h3>
<div class="row">
    <div class="col-md-6">
        <h4>Last 60 days</h4>
        <table class="widefat" style="width: 100%">
            <thead>
                <tr valign="top">
                    <th>Date</th>
                    <th>Subscribers</th>
                </tr>
            </thead>
            <?php foreach ($d as $date => $count) { ?>
                <tr valign="top">
                    <td><?php echo esc_html($date); ?></td>
                    <td><?php echo esc_html($count); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="col-md-6">
        <h4>Last 2 years</h4>
        <table class="widefat" style="width: 100%">
            <thead>
                <tr valign="top">
                    <th>Date</th>
                    <th>Subscribers</th>
                </tr>
            </thead>
            <?php foreach ($mm as $date => $count) { ?>
                <tr valign="top">
                    <td><?php echo esc_html($date); ?></td>
                    <td><?php echo esc_html($count); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>