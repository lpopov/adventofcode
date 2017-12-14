<?php
class Day11 {
	private $inputArr;
	
	private $coordinates;
	private $maxSteps;
	
	public function __construct($input) {
		$this->inputArr = explode(",", $input);
		
		$this->coordinates = [
			'x'	=>	0,
			'y'	=>	0,
			'z'	=>	0,
		];
		$this->maxSteps = 0;
	}
	
	public function run() {
		foreach($this->inputArr as $direction) {
			switch($direction) {
				case "n":
					$this->coordinates['y'] -= 1;
					break;
				case "ne":
					$this->coordinates['y'] -= 1;
					$this->coordinates['x'] += 1;
					break;
				case "nw":
					$this->coordinates['y'] += 0;
					$this->coordinates['x'] -= 1;
					break;
				case "s":
					$this->coordinates['y'] += 1;
					break;
				case "se":
					$this->coordinates['y'] -= 0;
					$this->coordinates['x'] += 1;
					break;
				case "sw";
					$this->coordinates['y'] += 1;
					$this->coordinates['x'] -= 1;
					break;
			}
			
			$this->coordinates['z'] = ($this->coordinates['x'] + $this->coordinates['y'] ) * -1;
			
			$steps = $this->getMinimumSteps();
			if($steps > $this->maxSteps) {
				$this->maxSteps = $steps;
			}
		}
	}
	
	public function getMinimumSteps() {
		return max(
			abs($this->coordinates['x']), 
			abs($this->coordinates['y']), 
			abs($this->coordinates['z'])
		);
	}
	
	public function getMaximumSteps() {
		return $this->maxSteps;
	}
}

$inputs = [
	"ne,ne,ne",
	"ne,ne,sw,sw",
	"ne,ne,s,s",
	"se,sw,se,sw,sw",
];

foreach($inputs as $input) {
	$day = new Day11($input);
	$day->run();
	echo "Input: " . $input . "\n";
	echo "Minimum steps: " . $day->getMinimumSteps() . "\n";
	echo "Maximum steps: " . $day->getMaximumSteps() . "\n";
}

$day = new Day11(file_get_contents("input.day11.txt"));
$day->run();
echo "-------------\n";
echo "Minimum steps: " . $day->getMinimumSteps() . "\n";
echo "Maximum steps: " . $day->getMaximumSteps() . "\n";