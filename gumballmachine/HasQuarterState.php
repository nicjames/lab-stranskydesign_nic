<?php

/**
 * Description of HasQuarterState
 *
 * @author nic.stransky
 */
class HasQuarterState implements State {
	private $gumballMachine;
	
	public function __construct(GumballMachine $gumballMachine) {
		$this->gumballMachine = $gumballMachine;
	}
	
	public function insertQuarter() {
		out("You have attempted to insert a quarter, but there is already a quarter in the machine.");
		//$this->gumballMachine->setState($this->gumballMachine->getHasQuarterState());
	}
	
	public function ejectQuarter() {
		out("You have ejected the quarter that was in the machine.");
		$this->gumballMachine->setState($this->gumballMachine->getNoQuarterState());
	}
	
	public function turnCrank() {
		out("You have turned the crank while a quarter is in the machine.");
		out("Checking if there is at least 1 gumball to give you.");
		if($this->gumballMachine->getCount() > 0) {
			out("There is at least 1 gumball.");
			$isWinner = rand(0,9);
			if($isWinner == 0) {
				$this->gumballMachine->setState($this->gumballMachine->getWinnerState());
			} else {
				$this->gumballMachine->setState($this->gumballMachine->getSoldState());
			}
		} else {
			out("Sorry, there are no gumballs to dispense. Please eject your quarter.");
		}
	}

	public function dispense() {
		out("Dispensing error - this should never occur. Dispensing from HasQuarterState is not possible.");
	}
	
	public function __toString() {
		return "HasQuarterState. The machine contains a quarter.";
	}
	
}

?>
