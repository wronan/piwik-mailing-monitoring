<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\MailingMonitoring\tests\System;

use Piwik\Plugins\MailingMonitoring\tests\Fixtures\MailingMonitoringFixture;
use Piwik\Tests\Framework\TestCase\SystemTestCase;

class MailingMonitoringSystemTest extends SystemTestCase
{
    public static $fixture = null;

    public function getApiForTesting()
    {
        $apiToTest = array();
        $apiToCall = array();

        $apiToCall[] = "MailingMonitoring.getPPReport";
        $apiToCall[] = "MailingMonitoring.getAIDReport";

        $apiToTest[] = array(
			$apiToCall,
			array(
				'idSite'  => self::$fixture->idSite,
				'date'    => self::$fixture->dateTime,
				'periods' => array('day')
			)
		);

        return $apiToTest;
    }

    /**
     * @dataProvider getApiForTesting
     */
    public function testApi($api, $params)
    {
		$this->runApiTests($api, $params);
    }

}

MailingMonitoringSystemTest::$fixture = new MailingMonitoringFixture();