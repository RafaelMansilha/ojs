<?php

/**
 * @file controllers/grid/issueGalleys/IssueGalleyGridRow.inc.php
 *
 * Copyright (c) 2014-2015 Simon Fraser University Library
 * Copyright (c) 2003-2015 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class IssueGalleyGridRow
 * @ingroup issue_galley
 *
 * @brief Handle issue galley grid row requests.
 */

import('lib.pkp.classes.controllers.grid.GridRow');

class IssueGalleyGridRow extends GridRow {
	/**
	 * Constructor
	 */
	function IssueGalleyGridRow($issueId) {
		parent::GridRow();
		$this->setRequestArgs(
			array_merge(
				((array) $this->getRequestArgs()),
				array('issueId' => $issueId)
			)
		);
	}

	//
	// Overridden template methods
	//
	/*
	 * Configure the grid row
	 * @param $request PKPRequest
	 */
	function initialize($request) {
		parent::initialize($request);

		// Is this a new row or an existing row?
		$issueGalleyId = $this->getId();
		if (!empty($issueGalleyId) && is_numeric($issueGalleyId)) {
			$issue = $this->getData();
			assert(is_a($issue, 'IssueGalley'));
			$router = $request->getRouter();

			import('lib.pkp.classes.linkAction.request.AjaxModal');
			$this->addAction(
				new LinkAction(
					'edit',
					new AjaxModal(
						$router->url(
							$request, null, null, 'edit', null,
							array_merge($this->getRequestArgs(), array('issueGalleyId' => $issueGalleyId))
						),
						__('editor.issues.editIssueGalley'),
						'modal_edit',
						true),
					__('grid.action.edit'),
					'edit'
				)
			);

			import('lib.pkp.classes.linkAction.request.RemoteActionConfirmationModal');
			$this->addAction(
				new LinkAction(
					'delete',
					new RemoteActionConfirmationModal(
						__('common.confirmDelete'),
						__('grid.action.delete'),
						$router->url(
							$request, null, null, 'delete', null,
							array($this->getRequestArgs(), array('issueGalleyId' => $issueGalleyId))
						),
						'modal_delete'
					),
					__('grid.action.delete'),
					'delete'
				)
			);
		}
	}
}

?>
