<?php
/* @var $this NewsletterReports */

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

wp_enqueue_script('tnp-chart');

$email = Newsletter::instance()->get_email((int) $_GET['id'] ?? 0);
if (!$email) {
    die('Email not found');
}

if (!$email) {
    die('Newsletter not found');
}

$countries = $wpdb->get_results($wpdb->prepare(
                                    "select n.country as country, count(*) as total, count(case when open>0 then 1 else null end) as opens,
count(case when open>1 then 1 else null end) as clicks
 from {$wpdb->prefix}newsletter_sent ns
join {$wpdb->prefix}newsletter n on n.id=ns.user_id

where  ns.email_id=%d
and n.country<>''

group by n.country order by total desc", $email->id));

$world_opens = [];
$world_sent = [];
foreach ($countries as $country) {
    $code = strtolower($country->country);
    $world_opens[$code] = round($country->opens/$country->total*100, 1);
    $world_sent[$code] = (int) $country->total;
}
?>


<link rel="stylesheet" href="<?php echo esc_attr(plugins_url('newsletter-reports')) ?>/admin/style.css?ver=<?php echo $this->version?>" type="text/css">

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <?php include __DIR__ . '/view-heading.php' ?>


    <div id="tnp-body" style="min-width: 500px">
        <?php $controls->show(); ?>

        <p>Geo data is computed only for geolocated subscribers.</p>


            <form action="" method="post">
                <?php $controls->init(); ?>


                <div class="tnp-cards-container">
                    <div class="tnp-card">
                        <div class="tnp-card-title">Sent</div>
                        <div class="tnp-card-chart">


                            <?php if (empty($countries)) : ?>
                                <p class="tnp-map-legend">No data available, just wait some time to let the
                                    processor work to resolve the countries. Thank you.</p>
                            <?php else: ?>
                                <div id="tnp-map-sent" class="tnp-map-chart"></div>
                            <?php endif; ?>

                        </div>
                        <?php if (!class_exists('NewsletterGeo')) : ?>
                            <div class="tnp-note">Geo data is available with the Geo Addon</div>
                        <?php endif; ?>
                    </div>

                    <div class="tnp-card">
                        <div class="tnp-card-title">Opens (%)</div>
                        <div class="tnp-card-chart">

                            <?php if (empty($countries)) : ?>
                                <p class="tnp-map-legend">No data available, just wait some time to let the
                                    processor work to resolve the countries. Thank you.</p>
                            <?php else: ?>
                                <div id="tnp-map-opens" class="tnp-map-chart"></div>
                            <?php endif; ?>

                        </div>
                        <?php if (!class_exists('NewsletterGeo')) : ?>
                            <div class="tnp-note">Geo data is available with the Geo Addon</div>
                        <?php endif; ?>
                    </div>



                </div>



            </form>

    </div>


    <table class="widefat" style="width: auto">
                <thead>
                    <tr class="text-left">
                        <th>Country</th>
                        <th>Sent</th>
                        <th>Opens</th>
                        <th>Clicks</th>
                        <th>Reactivity</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($countries as $country) { ?>
                        <tr>
                            <td>
                                <?php echo esc_html($controls->countries[$country->country]) ?>
                                (<?php echo esc_html($country->country) ?>)
                            </td>
                            <td>
                                <?php echo esc_html($country->total) ?>
                            </td>
                            <td>
                                <?php if ($country->total) { ?>
                                <?php echo esc_html($country->opens) ?> (<?php echo round($country->opens/$country->total*100, 1) ?>%)
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($country->total) { ?>
                                <?php echo esc_html($country->clicks) ?> (<?php echo round($country->clicks/$country->total*100, 1) ?>%)
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($country->opens) { ?>
                                <?php echo esc_html(round((float)$country->clicks/(float)$country->opens*100, 1)) ?>%
                                <?php } ?>
                            </td>

                        </tr>
                    <?php } ?>

                </tbody>
            </table>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php' ?>

</div>

<script type="text/javascript">
    jQuery(document).ready(function ($) {



        var world_sent = <?php echo wp_json_encode($world_sent) ?>;
        $('#tnp-map-sent').vectorMap({
            map: 'world_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: world_sent,
            scaleColors: ['#C8EEFF', '#006491'],
            normalizeFunction: 'polynomial',
            onLabelShow: function (event, label, code) {
                label.text(label.text() + ': ' + world_sent[code]);
            }
        });

        var world_opens = <?php echo wp_json_encode($world_opens) ?>;
        $('#tnp-map-opens').vectorMap({
            map: 'world_en',
            backgroundColor: null,
            color: '#ffffff',
            hoverOpacity: 0.7,
            selectedColor: '#666666',
            enableZoom: true,
            showTooltip: true,
            values: world_opens,
            scaleColors: ['#C8EEFF', '#006491'],
            normalizeFunction: 'polynomial',
            onLabelShow: function (event, label, code) {
                label.text(label.text() + ': ' + world_opens[code] + '%');
            }
        });



    });

</script>
