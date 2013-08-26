<?php

/**
 * Description of NoQuarterState
 *
 * @author nic.stransky
 */
class NoQuarterState implements State {
	private $gumballMachine;
	
	public function __construct(GumballMachine $gumballMachine) {
		$this->gumballMachine = $gumballMachine;
	}
	
	public function insertQuarter() {
		out("You inserted a quarter.");
		$this->gumballMachine->setState($this->gumballMachine->getHasQuarterState());
	}
	
	public function ejectQuarter() {
		out("You have attempted to eject a quarter, but there is no quarter to eject.");
	}
	
	public function turnCrank() {
		out("You have turned the crank, but there is no quarter in the machine. No free gumballs!");
	}

	public function dispense() {
		out("Dispensing error - this should never occur. Dispensing from NoQuarterState is not possible.");
	}
	
	public function __toString() {
		return "NoQuarterState. Waiting for quarter.";
	}
	
}

?>
