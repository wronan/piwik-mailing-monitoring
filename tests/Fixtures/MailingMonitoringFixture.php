<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link    http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\MailingMonitoring\tests\Fixtures;


use Piwik\Tests\Framework\Fixture;
use Piwik\Date;

class MailingMonitoringFixture extends Fixture
{
    public $dateTime = '2015-01-01 01:32:12';
    public $idSite = 1;
    private $paywallPlan = array('test1', 'test2');

    public function setUp()
    {
        $this->setUpWebsite();
        $this->trackVisits();
    }

    public function tearDown()
    {

    }

    private function setUpWebsite()
    {
        if (!self::siteCreated($this->idSite)) {
            $idSite = self::createWebsite($this->dateTime);
            $this->assertSame($this->idSite, $idSite);
        }
    }
    
    private function modifyUrl($url, $varsToSet)
    {
        $curVars = array();
        $p = parse_url($url);
        parse_str($p['query'], $curVars);

        foreach ($varsToSet as $k=>$v) {
            $curVars[$k] = $v;
        }

        $p['query'] = http_build_query($curVars);

        $ret = $p['scheme'] . '://' . $p['host'];
        if (isset($p['port']) && !empty($p['port'])) {
            $ret .= ':' . $p['port'];
        }
        if (isset($p['path']) && !empty($p['path'])) {
            $ret .= $p['path'];
        }
        if (isset($p['query']) && !empty($p['query'])) {
            $ret .= '?' . $p['query'];
        }
        return $ret;
    }

    private function trackVisits()
	{

        $tracker = self::getTracker(
            $this->idSite,
            $this->dateTime,
            $defaultInit = false
        );
        $tracker->setTokenAuth(self::getTokenAuth());

        for ($i=0; $i<16; $i++) {
            $tracker->setForceVisitDateTime(
                Date::factory($this->dateTime)->addHour($i)->getDatetime()
            );

            $nvars = array(
                'PaywallPlan'=>$this->paywallPlan[$i % 2],
                'ArticleId'=>$i % 4 + 1
            );

            $url = $tracker->setUrl($this->modifyUrl($tracker->pageUrl, $nvars));
            $url = $tracker->doTrackPageView("Viewing homepage");
            self::checkResponse($url);
        }
    }
}