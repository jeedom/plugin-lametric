<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
require_once dirname(__FILE__) . '/../../3rdparty/Lametric.php';
require_once dirname(__FILE__) . '/../../3rdparty/LametricException.php';

class lametric extends eqLogic {

    /*     * ***********************Methode static*************************** */
	
	public function postSave() {	

		$lametricCmd = $this->getCmd(null, 'message');
		if (!is_object($lametricCmd)) {
			$lametricCmd = new lametricCmd();
			$lametricCmd->setName(__('Message', __FILE__));
		}
		$lametricCmd->setEqLogic_id($this->getId());
		$lametricCmd->setLogicalId('message');
		$lametricCmd->setType('action');
		$lametricCmd->setSubType('message');
		$lametricCmd->setDisplay('title_placeholder', __('ID de l\'icone', __FILE__));
		$lametricCmd->setDisplay('message_placeholder', __('Texte', __FILE__));
		$lametricCmd->setIsVisible(true);
		$lametricCmd->save();
		
		$lametricCmd = $this->getCmd(null, 'clear');
		if (!is_object($lametricCmd)) {
			$lametricCmd = new lametricCmd();
			$lametricCmd->setName(__('Vider', __FILE__));
		}
		$lametricCmd->setEqLogic_id($this->getId());
		$lametricCmd->setLogicalId('clear');
		$lametricCmd->setType('action');
		$lametricCmd->setSubType('other');
		$lametricCmd->setIsVisible(true);
		$lametricCmd->save();

	}
	
}

class lametricCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    

    public function execute($_options = null) {
    	log::add('lametric', 'info', 'Debut de l action');	
		$lametricEq = $this->getEqLogic();
    	$lametric2 = new Lametric2(array(
			'localIP' => $lametricEq->getConfiguration('localip'),
		    'token' => $lametricEq->getConfiguration('token'),
		));
    	if ($this->type == 'action' && isset($_options['message'])) {
    		$messages = explode('|', $_options['message']);
    		if(count($messages > 1)){
				$titles = explode('|', $_options['title']);
				if(count($titles) > count($messages)){
					$lametric2->setSound($titles[0]);	
				}
    			$i = 1;
    			foreach($messages as $message){
					$lametric2->addFrame($message,$titles[$i]);
					$i++;	
				}
    		}else{
    			$lametric2->addFrame($_options['message'], $_options['title']);		
			}
		
			$lametric2->push();
			return true;
		}else{
			$lametric2->addFrame('JEEDOM', '4515');	
			$lametric2->push();
			return true;
		}
	}
}
?>