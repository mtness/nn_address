<?php

namespace NN\NnAddress\Controller;

use \NN\NnAddress\Utility\AbcListActionHelper as AbcListActionHelper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Hendrik Reimers <h.reimers@neonaut.de>, Neonaut GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Main controller of this extension
 *
 * @package nn_address
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PersonController extends \NN\NnAddress\Mvc\Controller\BasicController
{

    /**
     * personRepository
     *
     * @var \NN\NnAddress\Domain\Repository\PersonRepository
     * @inject
     */
    protected $personRepository;

    /**
     * groupRepository
     *
     * @var \NN\NnAddress\Domain\Repository\GroupRepository
     * @inject
     */
    protected $groupRepository;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        // Database ordering
        $this->setOrderings($this->personRepository, 'lastName');

        // Get all contacts
        //$persons = $this->getPersons();
        $persons = $this->getPersonsByDemand();

        // Give it to fluid
        $this->view->assign('persons', $persons);
        $this->setSearchPresets();
    }

	/**
	 * action birthdayList
	 *
	 * @return void
	 */
	public function birthdayListAction() {
		// Database ordering
		$this->setOrderings($this->personRepository,'lastName');
		
		// Get all contacts
		$persons = $this->personRepository->getUpcomingBirthdays( $this->settings['limit'] );
		
		// Give it to fluid
		$this->view->assign('persons', $persons);
		$this->setSearchPresets();
	}

    /**
     * action abcList
     *
     * @return void
     */
    public function abcListAction()
    {
        // Database ordering
        $this->setOrderings($this->personRepository, 'lastName');

        // Init basic variables
        $persons = $this->getPersonsByDemand();
        $charset = AbcListActionHelper::getSystemCharset();
        $range = array();
        $personCount = 0;
        $groupedPersons = array();
        $filterChar = $this->getRequestArgument('char', '/^([A-Z]{1}|NUM)$/');
        $filterChar = ($filterChar === 'NUM') ? '#' : $filterChar;

        // Create grouping Array
        AbcListActionHelper::createGroupArrays($range, $groupedPersons);

        // Put persons into groupedPerson array
        foreach ($persons->toArray() as $person) {
            $firstChar = AbcListActionHelper::getFirstChar($person, $charset, $this->orderBy);

            if (!empty($filterChar)) { // If filter by Char activated, show only the selected
                if ($filterChar === $firstChar) { // Add them to A-Z Group
                    AbcListActionHelper::groupPerson($firstChar, $range, $personCount, $groupedPersons, $person);
                } elseif (($filterChar === '#') && (!array_key_exists($firstChar, $range))) { // Add them to # Group
                    AbcListActionHelper::groupPerson($firstChar, $range, $personCount, $groupedPersons, $person);
                } else { // Just count
                    AbcListActionHelper::pullUpRange($firstChar, $range);
                }
            } else { // Show all Addresses
                AbcListActionHelper::groupPerson($firstChar, $range, $personCount, $groupedPersons, $person);
            }
        }

        // Free memory
        unset($persons);

        // Give it to fluid
        $this->view->assign('range', $range);
        $this->view->assign('groupedPersons', $groupedPersons);
        $this->view->assign('personCount', $personCount);
        $this->setSearchPresets();
    }

    /**
     * action show
     *
     * @param \NN\NnAddress\Domain\Model\Person $person
     *
     * @return void
     */
    public function showAction(\NN\NnAddress\Domain\Model\Person $person)
    {
        $this->view->assign('person', $person);
    }

    /**
     * action single
     * Manual selected persons in own order.
     *
     * @return void
     */
    public function singleAction()
    {
        $persons = array();
        $personList = \TYPO3\CMS\Core\Utility\GeneralUtility::intExplode(",",$this->settings['persons']);

        foreach ($personList as $personId) {
            $persons[] = $this->personRepository->findByUid($personId);
        }
        $descriptions = explode(PHP_EOL, $this->settings['descriptions']);
        $this->view->assignMultiple(['persons'=> $persons, 'descriptions' => $descriptions]);
    }

    /**
     * action grouplist
     *
     * @return void
     */
    public function grouplistAction()
    {
        if ($this->request->hasArgument('group')) {
            $groupId = $this->request->getArgument('group');
            $groups = $this->groupRepository->findOneByUid($groupId)->getChildGroups();
            $this->view->assign('groups', $groups);
        }
    }

    /**
     * Lifecycle-Event
     * wird nach der Initialisierung des Objekts und nach dem Auflösen der Dependencies aufgerufen.
     *
     * public function initializeObject() {
     * $this->databaseHandle = $GLOBALS['TYPO3_DB'];
     * $this->databaseHandle->explainOutput = 2;
     * $this->databaseHandle->store_lastBuiltQuery = TRUE;
     * $this->databaseHandle->debugOutput = 2;
     * }
     */

}

?>