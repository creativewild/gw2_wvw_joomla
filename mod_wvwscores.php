<?php
/**
* WvW Scores Modules
*
* @version              $Id: mod_wvwscores.php 172 2013-05-23 01:44:00Z omniomi $
* @license              GNU/GPL - http://www.gnu.org/copyleft/gpl.html
*/

// No direct access
defined('_JEXEC') or die;

// Required
require (dirname(__FILE__).'/src/vesu/SDK/Gw2/Gw2SDK.php');
require (dirname(__FILE__) .'/src/vesu/SDK/Gw2/Gw2Exception.php');
use \vesu\SDK\Gw2\Gw2SDK;
use \vesu\SDK\Gw2\TwitchException;
$homeworld = $params->get('homeserver');
$gw2 = new Gw2SDK(dirname(__FILE__).'/cache');

$matches = $gw2->getMatchByWorldId($homeworld);

foreach($matches as $match):
    // This grabs just the scores from the match details
    $scores = $gw2->getScoresByMatchId($match->wvw_match_id);
    // This grabs the start time from the match
    $start_date = implode(".",array_reverse(explode("-",array_shift(explode("T",$match->start_time)))));
    // This grabs the end time from the match
    $end_date = implode(".",array_reverse(explode("-",array_shift(explode("T",$match->end_time)))));
?>

<div class="wvw_match">
    <h4>Home Server: <?php echo $gw2->parseWorldName($homeworld) ?></h4><br/>
    <div style="margin-top:-10px;">Data: <?php echo $start_date ?> - <?php echo $end_date ?></div><br />
    <div class="server red" style="color: #b80202;font-weight: bold;font-size:large;"><?php echo $gw2->parseWorldName($match->red_world_id) ?>: <span style="color: #b80202;font-weight: normal;font-size:large;"><?php echo number_format($scores[0]); ?></span></div><br />
    <div class="server blue" style="color: #3d63d1;font-weight: bold;font-size:large;"><?php echo $gw2->parseWorldName($match->blue_world_id) ?>: <span style="color: #3d63d1;font-weight: normal;font-size:large;"><?php echo number_format($scores[1]); ?></span></div><br />
    <div class="server green" style="color: green;font-weight: bold;font-size:large;"><?php echo $gw2->parseWorldName($match->green_world_id) ?>: <span style="color: green;font-weight: normal;font-size:large;"><?php echo number_format($scores[2]); ?></span></div>
</div>

<?php
endforeach;

// END

?>