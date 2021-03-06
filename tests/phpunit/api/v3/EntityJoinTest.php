<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2016                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */

/**
 * Test APIv3 ability to join across multiple entities
 *
 * @package CiviCRM_APIv3
 * @group headless
 */
class api_v3_EntityJoinTest extends CiviUnitTestCase {

  public function setUp() {
    parent::setUp();
    $this->useTransaction(TRUE);
  }

  public function testJoinEmailToContact() {
    $first = 'firstthisisatest';
    $last = 'lastthisisatest';
    $org = $this->organizationCreate(array('organization_name' => 'Employer of one'));
    $person1 = $this->individualCreate(array('employer_id' => $org, 'first_name' => $first, 'last_name' => $last));
    $person2 = $this->individualCreate(array(), 1);
    $result = $this->callAPISuccessGetSingle('Email', array(
      'return' => 'contact_id.employer_id.display_name',
      'contact_id.last_name' => $last,
      'contact_id.first_name' => $first,
    ));
    $this->assertEquals('Employer of one', $result['contact_id.employer_id.display_name']);
  }

}
