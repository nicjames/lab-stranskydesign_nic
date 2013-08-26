<?php


/**
 * Description of GumballMachine
 *
 * @author nic.stransky
 */
class GumballMachine {
	
	private $soldOutState;
	private $noQuarterState;
	private $hasQuarterState;
	private $soldState;
	private $winnerState;

	private $state;
	private $count = 0;

	public function __construct($numberGumballs) {
		$this->soldOutState = new SoldOutState($this);
		$this->noQuarterState = new NoQuarterState($this);
		$this->hasQuarterState = new HasQuarterState($this);
		$this->soldState = new SoldState($this);
		$this->winnerState = new WinnerState($this);

		$this->state = $this->soldOutState;

		$this->count = $numberGumballs;
		if($numberGumballs > 0) {
			$this->state = $this->noQuarterState;
		}

	}

	public function insertQuarter() {
		$this->state->insertQuarter();
	}

	public function ejectQuarter() {
		$this->state->ejectQuarter();
	}
	
	public function turnCrank() {
		$this->state->turnCrank();
		$this->state->dispense();
	}
	
	public function dispense() {
		$this->state->dispense();
	}

	public function releaseBall() {
		if($this->count > 0) {
			$this->count--;
			out("A gumball rolls down the chute and makes a clinking sound when it hits the door on the slot.");
		} else {
			out("releaseBall was called even though the count was not greater than 0 - this should not be possible.");
		}
	}
	
	public function setState(State $state) {
		$this->state = $state;
	}

	public function getState() {
		return $this->state;
	}
	
	public function getCount() {
		return $this->count;
	}

	public function getHasQuarterState() {
		return $this->hasQuarterState;
	}
	
	public function getNoQuarterState() {
		return $this->noQuarterState;
	}

	public function getSoldState() {
		return $this->soldState;
	}

	public function getSoldOutState() {
		return $this->soldOutState;
	}

	public function getWinnerState() {
		return $this->winnerState;
	}

	public function __toString() {
		$result = "
			<li>Gumball Machine #303. 
			<li>Inventory: {$this->count}
			<li>State: {$this->state}
			";
		
		return $result;
	}
	
}

?>
