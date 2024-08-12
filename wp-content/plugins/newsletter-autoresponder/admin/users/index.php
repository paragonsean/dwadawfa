<?php
/* @var $this NewsletterAutoresponderAdmin */
/* @var $controls NewsletterControls */

$autoresponders = $this->get_autoresponders();
?>

<table class="widefat">
    <thead>
        <tr>
            <th>Id</th>
            <th>&nbsp;</th>
            <th>Name</th>

            <th>Status</th>
            <th>Step</th>
            <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($autoresponders as $autoresponder) { ?>
            <?php
            $step = $this->get_step($user->id, $autoresponder->id);
            ?>
            <tr>
                <td><?php echo esc_html($autoresponder->id) ?></td>
                <td>
                    <span class="tnp-led-<?php echo!empty($autoresponder->status) ? 'green' : 'gray' ?>">&#x2B24;</span>
                </td>
                <td><?php echo esc_html($autoresponder->name) ?></td>
                <td style="white-space: nowrap">
                    <?php
                    if ($step) {
                        echo esc_html($this->get_status_label($step->status));
                    } else {
                        echo 'Not active on this series';
                    }
                    ?>
                </td>

                <td style="white-space: nowrap">
                    <?php
                    if ($step) {
                        echo $step->step + 1;
                        if (NEWSLETTER_DEBUG) {
                            echo ' <code>[#', $step->id, ']</code>';
                        }
                    }
                    ?>
                </td>




                <td style="white-space: nowrap">

                    <?php
                    if ($user->status === TNP_User::STATUS_CONFIRMED) {
                        if ($step) {

                            switch ($step->status) {

                                case TNP_Autoresponder_Step::STATUS_NOT_IN_LIST:
                                case TNP_Autoresponder_Step::STATUS_NOT_CONFIRMED:
                                case TNP_Autoresponder_Step::STATUS_STOPPED:
                                    $controls->button_icon('restore', 'fa-unlock', 'Re-enable this subscriber from its last step', $autoresponder->id, true);
                                    break;
                                case TNP_Autoresponder_Step::STATUS_COMPLETED:
                                    if (count($autoresponder->emails) > $s->step + 1) {
                                        $controls->button_icon('continue', 'fa-forward', 'Continue the series for this subscriber', $autoresponder->id, true);
                                    }
                                    break;
                                case TNP_Autoresponder_Step::STATUS_RUNNING:
                                    $controls->button_icon('stop', 'fa-stop', 'Stop the series for this subscriber', $step->id, true);
                                    break;
                            }

                            if ($user->status === TNP_User::STATUS_CONFIRMED && $step->step > 0) {
                                $controls->button_icon('restart', 'fa-redo', 'Restart from step 1', $step->id, true);
                            }
                        } else {
                            if (!$autoresponder->list) {
                                $controls->button_icon('attach', 'fa-play', 'Attach this subscriber', $autoresponder->id, true);
                            }
                        }
                    }
                    ?>
                </td>

            </tr>
        <?php } ?>

    </tbody>
</table>

