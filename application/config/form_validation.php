<?php
	$config = array(
        'addCase' => array(
                array(
                        'field' => 'caseTitle',
                        'label' => 'Case Title',
                        'rules' => 'required|trim'
                )
            ),
        'deadline' => array(
                array(
                        'field' => 'deadlineTitle',
                        'label' => 'Rule Title',
                        'rules' => 'required|trim'
                ),
                array(
                        'field' => 'deadLineDays',
                        'label' => 'Deadline Days',
                        'rules' => 'required|trim'
                )
            ),
        'edit-deadline' => array(
                array(
                        'field' => 'deadlineUpdatedTitle',
                        'label' => 'Deadline Title',
                        'rules' => 'required|trim'
                ),
                array(
                        'field' => 'deadlineUpdatedDays',
                        'label' => 'Deadline Days',
                        'rules' => 'required|trim'
                )
            ),
        'rule' => array(
                array(
                        'field' => 'ruleTitle',
                        'label' => 'Rule Title',
                        'rules' => 'required|trim'
                ),
                array(
                        'field' => 'ruleDescription',
                        'label' => 'Rule Description',
                        'rules' => 'required|trim'
                )
            ),
        'rule-update' => array(
                array(
                        'field' => 'ruleUpdatedTitle',
                        'label' => 'Rule Title',
                        'rules' => 'required|trim'
                ),
                array(
                        'field' => 'ruleDesc',
                        'label' => 'Rule Description',
                        'rules' => 'required|trim'
                )
            ),
        'admin-credentials' => array(
                array(
                        'field' => 'newAdminName',
                        'label' => 'Admin Email',
                        'rules' => 'required|trim|valid_email'
                ),
                array(
                        'field' => 'newAdminPassword',
                        'label' => 'Admin Password',
                        'rules' => 'required|trim'
                )
            )
);
?>