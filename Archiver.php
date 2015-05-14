<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */
namespace Piwik\Plugins\MailingMonitoring;

use Piwik\Metrics;
use Piwik\DataTable;
use Piwik\DataTable\Row;
use Piwik\Piwik;
use Piwik\Log;

class Archiver extends \Piwik\Plugin\Archiver
{
    const MAILMON_ARCHIVE_PP_RECORD = "MailingMonitoring_archive_PP_record";
    const MAILMON_ARCHIVE_AID_RECORD = "MailingMonitoring_archive_AID_record";
    const MAILMON_PP_DIM = 'mlmon_paywall_plan';
    const MAILMON_AID_DIM = 'mlmon_article_id';

	private function aggregateData($record_name, $dim, $aggFunction, $metrics)
	{
		$data = new DataTable();

        if (!method_exists($this->getLogAggregator(), $aggFunction)) {
            Log::warning('Class ' . get_class($this->getLogAggregator()) . ': no such method ' . $aggFunction . ';');
            return;
        }

        $query = $this->getLogAggregator()->$aggFunction(
            array($dim),
            $where = $dim . ' IS NOT NULL',
            $additionalSelects = array(),
            array($metrics)
        );

        if ($query === false) {
            Log::warning('Class ' . get_class($this) . ': prop ' . $aggFunction . ': query error;');
            return;
        }

        while ($row = $query->fetch()) {
			$data->addRowFromArray(array(Row::COLUMNS => array('label' => $row[$dim], 'value' => $row[$metrics])));
        }

        $report = $data->getSerialized($this->maximumRows, $this->maximumRows, $metrics);
        $this->getProcessor()->insertBlobRecord($record_name, $report);
	}

    public function aggregateDayReport()
    {
		$this->aggregateData(
            self::MAILMON_ARCHIVE_PP_RECORD,
            self::MAILMON_PP_DIM,
            'queryVisitsByDimension',
            Metrics::INDEX_NB_VISITS
        );
		$this->aggregateData(
            self::MAILMON_ARCHIVE_AID_RECORD,
            self::MAILMON_AID_DIM,
            'queryActionsByDimension',
            Metrics::INDEX_NB_ACTIONS
        );
    }

    public function aggregateMultipleReports()
    {
        $this->getProcessor()->aggregateDataTableRecords(
            self::MAILMON_ARCHIVE_PP_RECORD,
            $this->maximumRows,
            $maximumRowsInSubDataTable = null,
            $columnToSortByBeforeTruncation = null,
            $columnsAggregationOperation,
            $columnsToRenameAfterAggregation = null,
            $countRowsRecursive = array()
		);

        $this->getProcessor()->aggregateDataTableRecords(
            self::MAILMON_ARCHIVE_AID_RECORD,
            $this->maximumRows,
            $maximumRowsInSubDataTable = null,
            $columnToSortByBeforeTruncation = null,
            $columnsAggregationOperation,
            $columnsToRenameAfterAggregation = null,
            $countRowsRecursive = array()
		);
    }
}
