<?php

/**
 * Description of WinerState
 *
 * @author nic.stransky
 */
class WinnerState implements State {
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
		out("YOU LUCKY BASTARD! You just won an EXTRA gumball! If there are enough gumballs left in the machine, you're going to get two instead of one!");
		$this->gumballMachine->releaseBall();
		if($this->gumballMachine->getCount() > 0) {
			$this->gumballMachine->releaseBall();
			if($this->gumballMachine->getCount() > 0) {
				$this->gumballMachine->setState($this->gumballMachine->getNoQuarterState());
			} else {
				$this->gumballMachine->setState($this->gumballMachine->getSoldOutState());
			}
		} else {
			out("Ah shit! Sorry, you won but there was only 1 gumball left in the machine. We owe you one!");
			$this->gumballMachine->setState($this->gumballMachine->getSoldOutState());
		}

	}
	
	public function __toString() {
		return "SoldState. Dispensing a gumball.";
	}
	
}

?>
