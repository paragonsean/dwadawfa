<?php
/* @var $this NewsletterReports */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

wp_enqueue_script('tnp-chart');

$email_id = (int) $_GET['id'] ?? 0;
$email = Newsletter::instance()->get_email($email_id);

$report = $this->get_statistics($email);

$is_autoresponder = strpos($email->type, 'autoresponder') === 0;
if ($is_autoresponder) {
    $send_mode = 'continuous';
} else {
    $send_mode = $this->get_email_send_mode($email->type);
}

$is_continuous = $send_mode === 'continuous';

if (empty($email->track)) {
    $controls->warnings[] = __('This newsletter has the tracking disabled. No statistics will be available.', 'newsletter');
}
?>


<link rel="stylesheet" href="<?php echo esc_attr(plugins_url('newsletter-reports')) ?>/admin/style.css?ver=<?php echo rawurlencode($this->version) ?>" type="text/css">

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <?php include __DIR__ . '/view-heading.php' ?>


    <div id="tnp-body" style="min-width: 500px">
        <?php $controls->show(); ?>



        <form action="" method="post">
            <?php $controls->init(); ?>

            <div class="tnp-cards-container">
                <div class="tnp-card">
                    <div class="tnp-card-title">Reach</div>
                    <div class="tnp-card-value">
                        <span class="tnp-counter-animationx"><?php echo (int) $report->total ?></span>
                        <div class="tnp-card-description">Total people that got your email</div>
                    </div>
                    <div class="tnp-card-icon"><div class="tnp-card-icon-business-contact"></div></div>

                </div>
                <div class="tnp-card">
                    <div class="tnp-card-title">Opens</div>
                    <div class="tnp-card-value">
                        <span class="tnp-counter-animationx percentage"><?php echo esc_html($report->open_rate); ?></span>%
                        <div class="tnp-card-description">
                            <span class="value"><?php echo (int) $report->open_count ?></span> total people that
                            opened your email
                        </div>
                    </div>
                    <div class="tnp-card-icon"><div class="tnp-card-icon-preview"></div></div>

                </div>
                <div class="tnp-card">
                    <div class="tnp-card-title">Clicks</div>
                    <div class="tnp-card-value">
                        <span class="tnp-counter-animationx percentage"><?php echo esc_html($report->click_rate); ?></span>%
                        <div class="tnp-card-description">
                            <span class="value"><?php echo (int) $report->click_count ?></span> total people that
                            clicked a link in your email
                        </div>
                    </div>
                    <div class="tnp-card-icon"><div class="tnp-card-icon-mouse"></div></div>

                </div>
                <div class="tnp-card">
                    <div class="tnp-card-title">Reactivity</div>
                    <div class="tnp-card-value">
                        <span class="tnp-counter-animationx percentage"><?php echo esc_html($report->reactivity) ?></span>%
                        <div class="tnp-card-description">
                            <span class="value"><?php echo (int) $report->click_count ?></span> clicks out of
                            <span class="value"><?php echo (int) $report->open_count ?></span> opens
                        </div>
                    </div>
                    <div class="tnp-card-icon"><div class="tnp-card-icon-rabbit"></div></div>
                </div>
            </div>
            <div class="tnp-cards-container">
                <div class="tnp-card">
                    <div class="tnp-card-title">Opens/Sent</div>
                    <div class="tnp-card-chart">
                        <canvas id="tnp-opens-sent-chart" class="mini-chart"></canvas>
                    </div>
                </div>
                <div class="tnp-card">
                    <div class="tnp-card-title">Clicks/Opens</div>
                    <div class="tnp-card-chart">
                        <canvas id="tnp-clicks-opens-chart" class="mini-chart"></canvas>
                    </div>
                </div>
                <div class="tnp-card">
                    <div class="tnp-card-title">Unsubscribed</div>
                    <div class="tnp-card-value">
                        <span class="tnp-counter-animationx"><?php echo (int) $report->unsub_count ?></span>
                        <div class="tnp-card-description">
                            Cancellations started from this newsletter (cannot always be tracked)
                        </div>
                    </div>
                    <div class="tnp-card-icon"><div class="tnp-card-icon-filter-remove"></div></div>
                </div>
                <div class="tnp-card">
                    <div class="tnp-card-title">Errors</div>
                    <div class="tnp-card-value">
                        <span class="tnp-counter-animationx"><?php echo (int) $report->error_count ?></span>
                        <div class="tnp-card-description">
                            Errors encountered while delivery, usually due to a faulty mailing service.
                        </div>

                    </div>
                    <div class="tnp-card-icon"><div class="tnp-card-icon-remove"></div></div>
                </div>
            </div>

            <div class="tnp-cards-container">

                <?php
                $days = 10;
                if ($send_mode == 'standard') {
                    $start_time = $email->send_on;
                } else {
                    $start_time = time() - 90 * DAY_IN_SECONDS;
                    $days = 91;
                }
                ?>

                <div class="tnp-card">
                    <div class="tnp-card-title">Interactions over time</div>
                    <div class="tnp-card-chart h-400">
                        <?php
                        $open_events = $this->get_open_events($email_id);

                        $events_data = array();
                        $events_labels = array();

                        for ($i = 0; $i < $days; $i++) {
                            $events_labels[] = date("Y-m-d", $start_time + $i * 86400);
                            $opens = 0;
                            foreach ($open_events as $e) {
                                if (date("Y-m-d", $start_time + $i * 86400) == $e->event_day) {
                                    $opens = (int) $e->events_count;
                                }
                            }
                            $events_data[] = $opens;
                        }
                        ?>
                        <?php if (empty($events_data)) : ?>
                            <p>Still no data.</p>
                        <?php else: ?>
                            <canvas id="tnp-events-chart-canvas"></canvas>
                        <?php endif; ?>
                    </div>
                </div>

            </div>



        </form>

    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php' ?>

</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {

        var opensSentChartData = {
            labels: [
                "Sent",
                "Opens"
            ],
            datasets: [
                {
                    data: [<?php echo (int) ($report->total - $report->open_count); ?>, <?php echo (int) $report->open_count ?>],
                    backgroundColor: [
                        "#49a0e9",
                        "#27AE60",
                    ]
                }]
        };
        var opensSentChartConfig = {
            type: "doughnut",
            data: opensSentChartData,
            options: {
                responsive: true,
                legend: {display: false},
                elements: {
                    arc: {borderWidth: 0}
                }
            }
        };
        new Chart('tnp-opens-sent-chart', opensSentChartConfig);


        var clicksOpensChartData = {
            labels: [
                "Opens",
                "Clicks"
            ],

            datasets: [
                {
                    data: [<?php echo (int) ($report->open_count - $report->click_count); ?>, <?php echo (int) $report->click_count ?>],
                    backgroundColor: [
                        "#49a0e9",
                        "#27AE60",
                    ]
                }]
        };
        var clicksOpensChartConfig = {
            type: "doughnut",
            data: clicksOpensChartData,
            options: {
                responsive: true,
                legend: {display: false},
                elements: {
                    arc: {borderWidth: 0}
                }
            }
        };
        new Chart('tnp-clicks-opens-chart', clicksOpensChartConfig);

        var events_data = {
            labels: <?php echo wp_json_encode($events_labels) ?>,
            datasets: [
                {
                    label: "Interactions",
                    fill: false,
                    strokeColor: "#2980b9",
                    backgroundColor: "#2980b9",
                    borderColor: "#2980b9",
                    pointBorderColor: "#2980b9",
                    pointBackgroundColor: "#2980b9",
                    data: <?php echo wp_json_encode($events_data) ?>
                }
            ]
        };
        new Chart('tnp-events-chart-canvas', {
            type: "line",
            data: events_data,
            options: {
                maintainAspectRatio: false,
                scales: {
                    xAxes: [
                        {
                            type: "category",
                            gridLines: {display: true},
                            ticks: {fontColor: "#444"}
                        }
                    ],
                    yAxes: [
                        {
                            type: "linear",
                            gridLines: {display: true},
                            ticks: {fontColor: "#444"}
                        }
                    ]
                },
                legend: {
                    labels: {
                        fontColor: "#444"
                    }
                }
            }
        });

    });

</script>
