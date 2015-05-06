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
use Piwik\Plugin\Dimension\ActionDimension;
use Piwik\Plugin\Segment;
use Piwik\Tracker\ActionPageview;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;
use Piwik\Tracker\Action;

class MailingMonitoringArticleID extends ActionDimension
{
	protected $columnName = 'mlmon_article_id';

	public function getName()
	{
		return Piwik::translate('MailingMonitoring_ArticleID');
	}

	public function onNewAction(Request $request, Visitor $visitor, Action $action)
	{
		if (!($action instanceof ActionPageview))
		{
			return false;
		}

		$tracked_url_vars = array();
		parse_str(parse_url($_GET['url'], PHP_URL_QUERY), $tracked_url_vars);

		$value = Common::getRequestVar('ArticleId', 0, 'int', $tracked_url_vars);

		if($value == 0)
		{
			return false;
		}
		else
		{
			return $value;
		}
    }
}