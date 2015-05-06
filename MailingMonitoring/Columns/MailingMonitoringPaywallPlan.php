<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\MailingMonitoring\Columns;

use Piwik\Common;
use Piwik\Piwik;
use Piwik\Plugin\Dimension\VisitDimension;
use Piwik\Plugin\Segment;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;
use Piwik\Tracker\Action;

class MailingMonitoringPaywallPlan extends VisitDimension
{
	protected $columnName = 'mlmon_paywall_plan';

    public function getName()
    {
        return Piwik::translate('MailingMonitoring_PaywallPlan');
    }

	private function getVarValue(Request $request, Visitor $visitor, $action)
	{
		if (empty($action))
		{
			return false;
		}

		$tracked_url_vars = array();
		parse_str(parse_url($_GET['url'], PHP_URL_QUERY), $tracked_url_vars);

		$value = Common::getRequestVar('PaywallPlan', false, 'string', $tracked_url_vars);

		if($value !== false)
		{
			$value = trim($value);
			$value = substr($value, 0, 50);
		}
		return $value;
	}

	public function onNewVisit(Request $request, Visitor $visitor, $action)
	{
		return $this->getVarValue($request, $visitor, $action);
	}

    public function onExistingVisit(Request $request, Visitor $visitor, $action)
    {
		return $this->getVarValue($request, $visitor, $action);
    }

}