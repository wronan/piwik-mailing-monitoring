<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MailingMonitoring;

use Piwik\Menu\MenuAdmin;
use Piwik\Menu\MenuReporting;
use Piwik\Menu\MenuTop;
use Piwik\Menu\MenuUser;
use Piwik\Piwik;

class Menu extends \Piwik\Plugin\Menu
{
    public function configureReportingMenu(MenuReporting $menu)
    {
        $menu->addVisitorsItem(
            Piwik::translate('MailingMonitoring_PPReport'),
            $this->urlForAction('getPPReport'),
            $orderId = 81
        );
        $menu->addVisitorsItem(
            Piwik::translate('MailingMonitoring_AIDReport'),
            $this->urlForAction('getAIDReport'),
            $orderId = 82
        );
    }
}
