<?php
class Day17_2 {
	private $steps;
	private $output;
	
	public function __construct($input) {
		$this->steps = $input;
		
		$this->output = null;
	}
	
	public function run() {
		$position = 1;
		for($i = 1; $i <= 50000001; $i++){
			$position = (($position + $this->steps) % $i) +1;
			
			if($position == 1) {
				$this->output = $i;
			}
		}
	}
	
	public function getOutput() {
		return $this->output;
	}
}

$inputs = [
	380
];

foreach($inputs as $input) {
	$day = new Day17_2($input);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Next value: " . $day->getOutput() . "\n";
	echo "-----------\n";
}