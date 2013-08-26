<?php

/**
 * Description of SoldOutState
 *
 * @author nic.stransky
 */
class SoldOutState implements State {
	private $gumballMachine;
	
	public function __construct(GumballMachine $gumballMachine) {
		$this->gumballMachine = $gumballMachine;
	}
	
	public function insertQuarter() {
		out("You attempted to insert a quarter, but the machine currently has no gumballs and can't accept your money. Sorry!");
		$this->gumballMachine->setState($this->gumballMachine->getHasQuarterState());
	}
	
	public function ejectQuarter() {
		out("You have attempted to eject a quarter, but there is no quarter to eject.");
	}
	
	public function turnCrank() {
		out("You have turned the crank, but there is no quarter in the machine. No free gumballs!");
	}

	public function dispense() {
		out("Dispensing error - this should never occur. Dispensing from SoldOutState is not possible.");
	}
	
	public function __toString() {
		return "SoldOutState. Waiting to be refilled.";
	}
	
}

?>
