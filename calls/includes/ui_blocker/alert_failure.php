<?php
    include_once('..'.DIRECTORY_SEPARATOR.'init.php');
    include_once('..'.DIRECTORY_SEPARATOR.'functions.php');
    $session = new Session();
?>
<div class="outter_pad">
<div class="inner_pad">
    <table>
        <tr>
            <td style="vertical-align:middle;">
                <div class="alert_icon" style="background-position: -160px -39px;margin-right:15px;"></div>
            </td>
            <td class="font15 dark_gray" style="vertical-align:middle;">
                Failed! Please, Try Again.
                <?php echo $session->get_session_message();$session->set_session_message(""); ?>
            </td>
        </tr>
    </table>
</div>
</div>