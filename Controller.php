<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\MailingMonitoring;

use Piwik\Piwik;

class Controller extends \Piwik\Plugin\Controller
{
    static function MailingMonitoringDataTable($api, $labels)
    {
        $view = \Piwik\ViewDataTable\Factory::build(
            $defaultType = 'table',
            $apiAction = 'MailingMonitoring.' . $api,
            $controllerMethod = 'MailingMonitoring.' . $api
        );
        $view->config->translations['label'] = Piwik::translate($labels['label']);
        $view->config->translations['value'] = Piwik::translate($labels['value']);
        $view->requestConfig->filter_sort_column = 'label';
        $view->requestConfig->filter_sort_order = 'asc';
        $view->config->show_insights = false;
        $view->config->show_search = true;
        $view->config->show_goals = true;
        $view->config->show_limit_control = true;
        $view->config->show_footer_icons = true;
        $view->requestConfig->filter_limit = 25;

        return $view->render();
    }

    public function getPPReport()
    {
        return self::MailingMonitoringDataTable(
            'getPPReport',
            array('label'=>'MailingMonitoring_PaywallPlan', 'value'=>'MailingMonitoring_Visitors')
        );
    }

    public function getAIDReport()
    {
        return self::MailingMonitoringDataTable(
            'getAIDReport', 
            array('label'=>'MailingMonitoring_ArticleID', 'value'=>'MailingMonitoring_Actions')
        );
    }
}
