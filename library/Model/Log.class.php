<?php
/**
 * Handles inserting a log into the database
 * 
 * @copyright   2012 Christopher Hill <cjhill@gmail.com>
 * @author      Christopher Hill <cjhill@gmail.com>
 * @version     0.1
 * @since       22/10/2012
 */

class Model_Log
{
    /**
     * Parameters sent to this class
     *
     * Array(
     *      'company'       = Model_Company,
     *      'employee'      = Model_Employee,
     *      'action'        = 'invoice-add',
     *      'status'        = 'success|error',
     *      'description'   = '...'
     * )
     *
     * @var array $params
     */
    private $_params = array();

    /**
     * Insert an action into the database.
     *
     * @param array $params
     */
	public function insert($params) {
        // Set the parameter
        $this->_params = $params;
        unset($params);

        // Insert the log item
	    $query = new Model_Query();
		$query->query("
			INSERT INTO `log`
				(
				    `company_id`,
				    `employee_id`,
				    `log_page`,
				    `log_action`,
				    `log_status`,
				    `log_description`,
				    `log_ip`,
				    `log_user_agent`,
				    `log_created`
				)
			VALUES
				(
					" . (int)$this->_params['company']->getInfo('company_id') . ",
					" . (int)$_SESSION['employee']['id'] . ",
					'" . Model_Format::parseDbInput($_SERVER['REQUEST_URI']) . "',
					'" . Model_Format::parseDbInput($this->_params['action']) . "',
					'" . Model_Format::parseDbInput($this->_params['status']) . "',
					'" . Model_Format::parseDbInput($this->_params['description']) . "',
                    '" . Model_Format::parseDbInput($_SERVER['REMOTE_ADDR']) . "',
					'" . Model_Format::parseDbInput($_SERVER['HTTP_USER_AGENT']) . "',
					" . (int)$_SERVER['REQUEST_TIME'] . "
				)
		");
	}
}