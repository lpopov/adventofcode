<?php
use Ds\Deque;

class Day17_1 {
	private $steps;
	private $deque;
	
	public function __construct($input) {
		$this->steps = $input;
		
		$this->deque = new Deque();
		$this->deque->insert(0,0);
	}
	
	public function run() {
		for($i = 1; $i <= 2017; $i++){
			$this->deque->rotate(-$this->steps);
			$this->deque->insert(1,$i);
		}
	}
	
	public function getNextValue() {
		return $this->deque->get(0);
	}
}

$inputs = [
//	3,
	380
];

foreach($inputs as $input) {
	$day = new Day17_1($input);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Next value: " . $day->getNextValue() . "\n";
	echo "-----------\n";
}