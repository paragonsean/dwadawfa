<?php
/* @var $this NewsletterReports */
/* @var $wpdb wpdb */

global $wpdb;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

if ($controls->is_action('update')) {
    $this->save_options($controls->data);
}

$controls->data = $this->get_options();
if (!is_array($controls->data)) {
    $controls->data = [];
}
$controls->data = array_merge(['type' => 'message', 'days' => 180], $controls->data);



$email_type = $controls->data['type'];
$send_mode = $this->get_email_send_mode($email_type);

if (!isset($controls->data['days'])) {
    $controls->data['days'] = 180;
}

$days = (int) $controls->data['days'];

// Emails generated by Autoresponder should be managed in a particular way
$autoresponder = strpos($email_type, 'autoresponder') !== false;
$welcome = strpos($email_type, 'welcome') !== false;
$is_continuous = $send_mode === 'continuous' || $autoresponder || $welcome;

if (!$is_continuous) {
    if (empty($days)) {
        $emails = $wpdb->get_results($wpdb->prepare("select send_on, id, subject, total, sent, type, status, stats_time, open_count, click_count, error_count, unsub_count from " . NEWSLETTER_EMAILS_TABLE . " where status='sent' and type=%s order by send_on desc", $email_type));
    } else {
        $emails = $wpdb->get_results($wpdb->prepare("select send_on, id, subject, total, sent, type, status, stats_time, open_count, click_count, error_count, unsub_count from " . NEWSLETTER_EMAILS_TABLE . " where status='sent' and type=%s and send_on>unix_timestamp()-$days*24*3600 order by send_on desc", $email_type));
    }
} else {
    // TODO: Get the emails IDs from the autoresponder!
    // TODO: Delegate Autoresponder to extract the email list? Should be a good idea!
    $emails = $wpdb->get_results($wpdb->prepare("select send_on, id, subject, total, sent, type, status, stats_time, open_count, click_count, error_count, unsub_count from " . NEWSLETTER_EMAILS_TABLE . " where status='sent' and type=%s", $email_type));
}


// Calculates the aggregates
$email_ids = [];
foreach ($emails as $email) {
    // Get updated statistics for each newsletter (cound be very slow if many newsletters need to be updated)
    $data = $this->get_statistics($email);

    $email_ids[] = $email->id;

    if (empty($data->total)) {
        //continue;
    }

    // Used later for the tabled view
    $email->report = $data;



}


?>

<link rel="stylesheet" href="<?php echo plugins_url('newsletter-reports') ?>/admin/style.css?ver=<?php echo $this->version ?>" type="text/css">


<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_ADMIN_HEADER ?>
    <div id="tnp-heading">

        <?php $controls->title_help('/reports-extension') ?>
        <h2><?php echo esc_html_e('Reports', 'newsletter') ?></h2>
        <?php include __DIR__ . '/index-nav.php' ?>

    </div>

    <div id="tnp-body" class="tnp-statistics">

        <?php include __DIR__ . '/index-filter-form.php'?>

        <table data-sortable class="widefat">
            <thead>
                <tr class="text-left">
                    <th>#</th>
                    <th>Subject</th>
                    <th>Sent</th>
                    <th>Opens (%) <i class="fas fa-sort"></i></th>
                    <th>Reactivity (%) <i class="fas fa-sort"></i></th>
                    <th>Clicks (%) <i class="fas fa-sort"></i></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emails as $email) { ?>
                    <tr>
                        <td><?php echo $email->id ?></td>
                        <td><?php echo esc_html($email->subject ?: 'Newsletter #' . $email->id) ?></td>
                        <td><?php echo $email->report->total ?></td>
                        <td><?php echo $email->report->open_rate ?></td>
                        <td><?php echo $email->report->reactivity ?></td>
                        <td><?php echo $email->report->click_rate ?></td>
                        <td><?php $controls->button_icon_statistics('?page=newsletter_reports_view&id=' . $email->id);?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>



        <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>



    </div>
</div>

<script>
    /*! sortable.js 0.8.0 */
    (function(){var a, b, c, d, e, f, g; a = "table[data-sortable]", d = /^-?[£$¤]?[\d,.]+%?$/, g = /^\s+|\s+$/g, c = ["click"], f = "ontouchstart"in document.documentElement, f && c.push("touchstart"), b = function(a, b, c){return null != a.addEventListener?a.addEventListener(b, c, !1):a.attachEvent("on" + b, c)}, e = {init:function(b){var c, d, f, g, h; for (null == b && (b = {}), null == b.selector && (b.selector = a), d = document.querySelectorAll(b.selector), h = [], f = 0, g = d.length; g > f; f++)c = d[f], h.push(e.initTable(c)); return h}, initTable:function(a){var b, c, d, f, g, h; if (1 === (null != (h = a.tHead)?h.rows.length:void 0) && "true" !== a.getAttribute("data-sortable-initialized")){for (a.setAttribute("data-sortable-initialized", "true"), d = a.querySelectorAll("th"), b = f = 0, g = d.length; g > f; b = ++f)c = d[b], "false" !== c.getAttribute("data-sortable") && e.setupClickableTH(a, c, b); return a}}, setupClickableTH:function(a, d, f){var g, h, i, j, k, l; for (i = e.getColumnType(a, f), h = function(b){var c, g, h, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D; if (b.handled === !0)return!1; for (b.handled = !0, m = "true" === this.getAttribute("data-sorted"), n = this.getAttribute("data-sorted-direction"), h = m?"ascending" === n?"descending":"ascending":i.defaultSortDirection, p = this.parentNode.querySelectorAll("th"), s = 0, w = p.length; w > s; s++)d = p[s], d.setAttribute("data-sorted", "false"), d.removeAttribute("data-sorted-direction"); if (this.setAttribute("data-sorted", "true"), this.setAttribute("data-sorted-direction", h), o = a.tBodies[0], l = [], m){for (D = o.rows, v = 0, z = D.length; z > v; v++)g = D[v], l.push(g); for (l.reverse(), B = 0, A = l.length; A > B; B++)k = l[B], o.appendChild(k)} else{for (r = null != i.compare?i.compare:function(a, b){return b - a}, c = function(a, b){return a[0] === b[0]?a[2] - b[2]:i.reverse?r(b[0], a[0]):r(a[0], b[0])}, C = o.rows, j = t = 0, x = C.length; x > t; j = ++t)k = C[j], q = e.getNodeValue(k.cells[f]), null != i.comparator && (q = i.comparator(q)), l.push([q, k, j]); for (l.sort(c), u = 0, y = l.length; y > u; u++)k = l[u], o.appendChild(k[1])}return"function" == typeof window.CustomEvent && "function" == typeof a.dispatchEvent?a.dispatchEvent(new CustomEvent("Sortable.sorted", {bubbles:!0})):void 0}, l = [], j = 0, k = c.length; k > j; j++)g = c[j], l.push(b(d, g, h)); return l}, getColumnType:function(a, b){var c, d, f, g, h, i, j, k, l, m, n; if (d = null != (l = a.querySelectorAll("th")[b])?l.getAttribute("data-sortable-type"):void 0, null != d)return e.typesObject[d]; for (m = a.tBodies[0].rows, h = 0, j = m.length; j > h; h++)for (c = m[h], f = e.getNodeValue(c.cells[b]), n = e.types, i = 0, k = n.length; k > i; i++)if (g = n[i], g.match(f))return g; return e.typesObject.alpha}, getNodeValue:function(a){var b; return a?(b = a.getAttribute("data-value"), null !== b?b:"undefined" != typeof a.innerText?a.innerText.replace(g, ""):a.textContent.replace(g, "")):""}, setupTypes:function(a){var b, c, d, f; for (e.types = a, e.typesObject = {}, f = [], c = 0, d = a.length; d > c; c++)b = a[c], f.push(e.typesObject[b.name] = b); return f}}, e.setupTypes([{name:"numeric", defaultSortDirection:"descending", match:function(a){return a.match(d)}, comparator:function(a){return parseFloat(a.replace(/[^0-9.-]/g, ""), 10) || 0}}, {name:"date", defaultSortDirection:"ascending", reverse:!0, match:function(a){return!isNaN(Date.parse(a))}, comparator:function(a){return Date.parse(a) || 0}}, {name:"alpha", defaultSortDirection:"ascending", match:function(){return!0}, compare:function(a, b){return a.localeCompare(b)}}]), setTimeout(e.init, 0), "function" == typeof define && define.amd?define(function(){return e}):"undefined" != typeof exports?module.exports = e:window.Sortable = e}).call(this);
</script>