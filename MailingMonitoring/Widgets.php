<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MailingMonitoring;

use Piwik\View;
use Piwik\WidgetsList;
use Piwik\Piwik;

class Widgets extends \Piwik\Plugin\Widgets
{
    protected $category = 'General_Visitors';

    protected function init()
    {
         $this->addWidget(Piwik::translate('MailingMonitoring_BaseName') . ' - ' . Piwik::translate('MailingMonitoring_PPReport'), 'MailingMonitoringPPWidget');
         $this->addWidget(Piwik::translate('MailingMonitoring_BaseName') . ' - ' . Piwik::translate('MailingMonitoring_AIDReport'), 'MailingMonitoringAIDWidget');
    }

    public function MailingMonitoringPPWidget()
    {
        $view = \Piwik\ViewDataTable\Factory::build(
            $defaultType = 'table',
            $apiAction = 'MailingMonitoring.getPPReport',
            $controllerMethod = 'MailingMonitoring.getPPReport'
        );
		$view->config->translations['label'] = Piwik::translate('MailingMonitoring_PaywallPlan');
		$view->config->translations['value'] = Piwik::translate('MailingMonitoring_Visitors');
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

    public function MailingMonitoringAIDWidget()
    {
        $view = \Piwik\ViewDataTable\Factory::build(
            $defaultType = 'table',
            $apiAction = 'MailingMonitoring.getAIDReport',
            $controllerMethod = 'MailingMonitoring.getAIDReport'
        );
		$view->config->translations['label'] = Piwik::translate('MailingMonitoring_ArticleID');
		$view->config->translations['value'] = Piwik::translate('MailingMonitoring_Actions');
		$view->requestConfig->filter_sort_column = 'value';
		$view->requestConfig->filter_sort_order = 'desc';
        $view->config->show_insights = false;
        $view->config->show_search = true;
        $view->config->show_goals = true;
        $view->config->show_limit_control = true;
        $view->config->show_footer_icons = true;
        $view->requestConfig->filter_limit = 25;

        return $view->render();
    }
}
