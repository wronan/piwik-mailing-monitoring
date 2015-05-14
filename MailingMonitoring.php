<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MailingMonitoring;

use Piwik\Common;
use Piwik\Db;

class MailingMonitoring extends \Piwik\Plugin
{
	public function install()
	{
		try {
			$q1 = "ALTER TABLE `" . Common::prefixTable("log_visit") . "` ADD `mlmon_paywall_plan` VARCHAR( 50 ) NULL DEFAULT NULL; ";
			Db::exec($q1);
		} catch (Exception $e) {
			if (!Db::get()->isErrNo($e, '1060')) {  // ingore exsisting column error
				throw $e;
			}
		}

		try {
			$q1 = "ALTER TABLE `" . Common::prefixTable("log_link_visit_action") . "` ADD `mlmon_article_id` INT UNSIGNED NULL DEFAULT NULL; ";
			Db::exec($q1);
		} catch (Exception $e) {
			if (!Db::get()->isErrNo($e, '1060')) {  // ingore exsisting column error
				throw $e;
			}
		}
	}

	public function uninstall()
	{
		try {
			$q1 = "ALTER TABLE `" . Common::prefixTable("log_visit") . "` DROP `mlmon_paywall_plan`; ";
			Db::exec($q1);
		} catch (Exception $e) {
			if (!Db::get()->isErrNo($e, '1091')) {  // ingore non-exsisting column error
				throw $e;
			}
		}

		try {
			$q1 = "ALTER TABLE `" . Common::prefixTable("log_link_visit_action") . "` DROP `mlmon_article_id`; ";
			Db::exec($q1);
		} catch (Exception $e) {
			if (!Db::get()->isErrNo($e, '1091')) {  // ingore non-exsisting column error
				throw $e;
			}
		}
	}
}
