<?php

/**
 * Description of SoldState
 *
 * @author nic.stransky
 */
class SoldState implements State {
	private $gumballMachine;
	
	public function __construct(GumballMachine $gumballMachine) {
		$this->gumballMachine = $gumballMachine;
	}
	
	public function insertQuarter() {
		out("You have attempted to insert a quarter, but the machine is still in the process of dispensing.");
	}
	
	public function ejectQuarter() {
		out("You have attempted to eject a quarter, but the machine is already in the process of dispensing.");
	}
	
	public function turnCrank() {
		out("You have turned the crank, but the machine is already in the process of dispensing.");
	}
	
	public function dispense() {
		$this->gumballMachine->releaseBall();
		if($this->gumballMachine->getCount() > 0) {
			$this->gumballMachine->setState($this->gumballMachine->getNoQuarterState());
		} else {
			$this->gumballMachine->setState($this->gumballMachine->getSoldOutState());
		}
	}
	
	public function __toString() {
		return "SoldState. Dispensing a gumball.";
	}
	
}

?>
