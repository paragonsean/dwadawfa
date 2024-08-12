<?php
/* @var $this NewsletterAutoresponderAdmin */
/* @var $wpdb wpdb */
global $wpdb;

require_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$autoresponder = $this->get_autoresponder((int) $_GET['id']);
if (!$autoresponder) {
    die('Autoresponder not found.');
}

$debug = isset($_GET['debug']) || NEWSLETTER_DEBUG;

if ($controls->is_action()) {
    if ($controls->is_action('reset')) {
        $controls->data = [];
    }
    $controls->data['search_page'] = (int) $controls->data['search_page'] - 1;
} else {
    $controls->data['search_page'] = 0;
}

if ($controls->is_action('restore')) {
    $user = Newsletter::instance()->get_user($controls->button_data);
    if (!empty($autoresponder->list)) {
        Newsletter::instance()->set_user_list($user, $autoresponder->list, 1);
    }
    $wpdb->query(
            $wpdb->prepare(
                    "update {$wpdb->prefix}newsletter_autoresponder_steps set status=0 where user_id=%d and autoresponder_id=%d limit 1", $user->id, $autoresponder->id
            )
    );
    $controls->add_toast_done();
}

if ($controls->is_action('restart')) {
    $user = Newsletter::instance()->get_user($controls->button_data);
    if (!empty($autoresponder->list)) {
        Newsletter::instance()->set_user_list($user, $autoresponder->list, 1);
    }

    NewsletterAutoresponder::instance()->create_step($user, $autoresponder);
    $controls->add_toast_done();
}

if ($controls->is_action('continue')) {

    $user = Newsletter::instance()->get_user($controls->button_data);
    $step = $this->get_step($user->id, $autoresponder->id);
    $step->step++;

    $emails = $autoresponder->emails;
    $email = Newsletter::instance()->get_email($emails[$step->step]);

    if (!$email) {
        $controls->errors = 'No new steps available';
    } else {
        $this->move_completed_subscriber_to_next_step($user->id, $autoresponder->id, $email);
    }
    $controls->add_toast_done();
}

if ($controls->is_action('restart')) {
    $user = Newsletter::instance()->get_user($controls->button_data);

//            if (!empty($autoresponder->list)) {
//                $list = (int) $autoresponder->list;
//                Newsletter::instance()->set_user_list($user, $list, 1);
//            }

    $emails = $autoresponder->emails;
    $email = Newsletter::instance()->get_email($emails[0]);
    $send_at = time() + $email->options['delay'] * 3600;
    $wpdb->query($wpdb->prepare("update " . $wpdb->prefix . "newsletter_autoresponder_steps set status=0, step=0, send_at=%d where user_id=%d and autoresponder_id=%d limit 1", $send_at, $user->id, $autoresponder->id));
    $controls->add_toast_done();
}

if ($controls->is_action('stop')) {
    $this->set_step_status($controls->button_data, TNP_Autoresponder_Step::STATUS_STOPPED);
    $controls->add_toast_done();
}

if ($controls->is_action('forward')) {
    $this->do_next_step($autoresponder->id, $controls->button_data);
    $controls->add_toast_done();
}




$query = "select u.id, u.email, u.name, u.surname, u.status, s.user_id, s.status as steps_status, s.step, s.send_at, s.id as steps_id from {$wpdb->prefix}newsletter_autoresponder_steps s left join " . NEWSLETTER_USERS_TABLE . " u on s.user_id=u.id where s.autoresponder_id=%d ";
$query_count = "select count(*) from {$wpdb->prefix}newsletter_autoresponder_steps s left join " . NEWSLETTER_USERS_TABLE . " u on s.user_id=u.id where s.autoresponder_id=%d ";
/*
  if (isset($controls->data['status'])) {
  if ($controls->data['status'] == 'error') {
  $query .= " and s.status=1";
  } else if ($controls->data['status'] == 'success') {
  $query .= " and s.status=0";
  }
  }
 */

if (!empty($controls->data['send_at'])) {
    if ($controls->data['send_at'] == 'past') {
        $query .= ' and s.send_at<' . time() . ' and s.status=0 ';
        $query_count .= ' and s.send_at<' . time() . ' and s.status=0 ';
    } else {
        $query .= ' and s.send_at>' . time() . ' and s.status=0 ';
        $query_count .= ' and s.send_at>' . time() . ' and s.status=0 ';
    }
}

//echo $query;

$count = $wpdb->get_var($wpdb->prepare($query_count, $autoresponder->id));

$items_per_page = 20;
$last_page = floor($count / $items_per_page) - ($count % $items_per_page == 0 ? 1 : 0);
if ($last_page < 0)
    $last_page = 0;
if ($controls->is_action('last')) {
    $controls->data['search_page'] = $last_page;
}
if ($controls->is_action('first')) {
    $controls->data['search_page'] = 0;
}
if ($controls->is_action('next')) {
    $controls->data['search_page'] = (int) $controls->data['search_page'] + 1;
}
if ($controls->is_action('prev')) {
    $controls->data['search_page'] = (int) $controls->data['search_page'] - 1;
}
if ($controls->is_action('search')) {
    $controls->data['search_page'] = 0;
}

// Eventually fix the page
if ($controls->data['search_page'] < 0) {
    $controls->data['search_page'] = 0;
}
if ($controls->data['search_page'] > $last_page) {
    $controls->data['search_page'] = $last_page;
}



//$query = "select * from " . NEWSLETTER_USERS_TABLE . ' ' . $where . " order by id desc";
$query .= " limit " . ($controls->data['search_page'] * $items_per_page) . "," . $items_per_page;

$list = $wpdb->get_results($wpdb->prepare($query, $autoresponder->id));

// Move to base 1
$controls->data['search_page']++;
?>

<div class="wrap" id="tnp-wrap">

    <?php include NEWSLETTER_ADMIN_HEADER; ?>

    <div id="tnp-heading">
        <?php include __DIR__ . '/nav.php' ?>
    </div>

    <div id="tnp-body">


        <?php $controls->show(); ?>
        <p>
            Only confirmed subscribers can be restarted and/or re-enabled.<br>
            Subscribers deleted, unsubscribed, bounced or no more in the target list may temporary be shown as active:
            they'll be processed periodically or when the next message should be sent.
        </p>

        <form id="channel" method="post" action="">
            <?php $controls->init(); ?>


            <div class="tnp-filters">
                <?php //$controls->select('status', array('' => 'Any status', 'error' => 'Error', 'success' => 'Success'))   ?>

            </div>

            <div class="tnp-paginator">
                <?php $controls->button('first', '«'); ?>
                <?php $controls->button('prev', '‹'); ?>
                <?php $controls->text('search_page', 3); ?> of <?php echo $last_page + 1 ?> <?php $controls->button('go', __('Go', 'newsletter')); ?>
                <?php $controls->button('next', '›'); ?>
                <?php $controls->button('last', '»'); ?>
                <?php echo $count ?> <?php _e('subscriber(s) found', 'newsletter') ?>

                <?php $controls->select('send_at', ['' => 'All', 'past' => 'Processing now or late']) ?>
                <?php $controls->button('apply', __('Apply', 'newsletter')) ?>
            </div>



            <table class="widefat">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Series</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Step</th>
                        <th>Send at</th>
                        <th>Late</th>
                    </tr>
                </thead>

                <?php foreach ($list as $s) { ?>
                    <tr>

                        <td>
                            <?php if (!empty($s->email)) { ?>
                                <img src="https://www.gravatar.com/avatar/<?php echo md5($s->email) ?>?s=50" style="width: 50px; height: 50px">
                            <?php } ?>
                        </td>

                        <td>
                            <?php if (!empty($s->email)) { ?>
                                <a href="admin.php?page=newsletter_users_edit&id=<?php echo $s->id ?>" target="_blank"><?php echo esc_html($s->email) ?></a>
                                <br>
                                <?php echo esc_html($s->name) ?> <?php echo esc_html($s->surname) ?>
                            <?php } else { ?>
                                [SUBSCRIBER DELETED]
                                <?php
                                if ($debug) {
                                    echo ' <code>(user ID: ', $s->user_id, ')</code>';
                                }
                                ?>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo TNP_User::get_status_label($s->status, true); ?>
                        </td>

                        <td style="white-space: nowrap">
                            <?php echo esc_html($this->get_status_label($s->steps_status)) ?>
                        </td>
                        <td>
                            <?php
                            if ($s->status === TNP_User::STATUS_CONFIRMED) {

                                switch ($s->steps_status) {

                                    case TNP_Autoresponder_Step::STATUS_NOT_IN_LIST:
                                    case TNP_Autoresponder_Step::STATUS_NOT_CONFIRMED:
                                    case TNP_Autoresponder_Step::STATUS_STOPPED:
                                        $controls->button_icon('restore', 'fa-unlock', 'Re-enable this subscriber from its last step', $s->id, true);
                                        break;
                                    case TNP_Autoresponder_Step::STATUS_COMPLETED:
                                        if (count($autoresponder->emails) > $s->step + 1) {
                                            $controls->button_icon('continue', 'fa-forward', 'Continue the series for this subscriber', $s->id, true);
                                        }
                                        $controls->button_icon('restart', 'fa-redo', 'Restart from step 1', $s->id, true);
                                        break;
                                    case TNP_Autoresponder_Step::STATUS_RUNNING:
                                        $controls->button_icon('stop', 'fa-stop', 'Stop the series for this subscriber', $s->steps_id, true);
                                        if (NEWSLETTER_DEBUG) {
                                            $controls->button_icon('forward', 'fa-fast-forward', 'Force next step', $s->id, true);
                                        }
                                        break;
                                }
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            if ($s->status === TNP_User::STATUS_CONFIRMED && $s->step > 0) {
                                $controls->button_icon('restart', 'fa-redo', 'Restart from step 1', $s->id, true);
                            }
                            ?>
                        </td>
                        <td style="white-space: nowrap">
                            <?php echo $s->step + 1 ?>
                            <?php if ($debug) { ?>
                                <code>[#<?php echo esc_html($s->steps_id) ?>]</code>
                            <?php } ?>
                        </td>

                        <td>
                            <?php if ($s->steps_status == TNP_Autoresponder_Step::STATUS_RUNNING) { ?>
                                <?php echo $controls->print_date($s->send_at, false, false) ?>
                            <?php } ?>
                        </td>

                        <td>
                            <?php if ($s->steps_status == TNP_Autoresponder_Step::STATUS_RUNNING && $s->send_at < time()) { ?>
                                <?php echo $controls->delta_time(time() - $s->send_at) ?>
                            <?php } ?>
                        </td>


                    </tr>
                <?php } ?>
            </table>

        </form>
    </div>
</div>
