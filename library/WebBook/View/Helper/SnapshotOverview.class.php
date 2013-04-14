<?php
namespace WebBook\View\Helper;
use Core, WebBook\Utility;

/**
 * Outputs the snapshot overview table.
 *
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 */
class SnapshotOverview extends Core\ViewHelper
{
	/**
	 * Outputs the chapter overview view.
	 *
	 * <code>
	 * array(
	 *     'bookSnapshots' => array()
	 * )
	 * </code>
	 *
	 * @access public
	 * @param  array  $params A collection of variables that has been passed to us.
	 * @return string         A rendered View Helper Partial template file.
	 */
	public function render($params = array()) {
		// Has the user actually created any snapshots?
		if (count($params['bookSnapshots']) <= 0) {
			return $this->renderPartial('SnapshotOverviewEmpty');
		}

		// Create a container for the snapshot table HTML
		$snapshotHtml = '';

		// Loop over each snapshot and generate its HTML
		foreach ($params['bookSnapshots'] as $snapshot) {
			$snapshotHtml .= $this->renderPartial('SnapshotOverviewItem', array(
				'bookId'             => Core\StoreRequest::get('book')->book_id,
				'snapshotId'         => $snapshot['snapshot_created'],
				'snapshotCreated'    => Utility\Date::getDate($snapshot['snapshot_created']),
				'snapshotCreatedAgo' => Utility\Date::getDifference(
					$snapshot['snapshot_created'],
					Core\Request::server('REQUEST_TIME')
				),
				'urlBookSnapshot'    => Utility\Url::bookViewSnapshot(
					Core\StoreRequest::get('book'),
					$snapshot['snapshot_created']
				)
			));
		}

		return $snapshotHtml;
	}
}