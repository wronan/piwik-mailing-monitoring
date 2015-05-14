<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\MailingMonitoring;

use Piwik\DataTable;
use Piwik\Archive;
use Piwik\Metrics;
use Piwik\Piwik;

class API extends \Piwik\Plugin\API
{
    protected function getDataTable($name, $idSite, $period, $date, $segment)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $archive = Archive::build($idSite, $period, $date, $segment);
        $dataTable = $archive->getDataTable($name);
        return $dataTable;
    }

    public function getPPReport($idSite, $period, $date, $segment = false)
    {
        return $this->getDataTable(Archiver::MAILMON_ARCHIVE_PP_RECORD, $idSite, $period, $date, $segment);
    }

    public function getAIDReport($idSite, $period, $date, $segment = false)
    {
        return $this->getDataTable(Archiver::MAILMON_ARCHIVE_AID_RECORD, $idSite, $period, $date, $segment);
    }
}