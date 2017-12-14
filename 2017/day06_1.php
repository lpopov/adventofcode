<?php
class Day06_1 {
	private $inputArr;
	private $inputLength;
	private $steps;
	private $previousSteps;
	
	public function __construct($input) {
	
		$this->inputArr = explode("\t", $input);
		$this->inputLength = sizeof($this->inputArr);
		
		$this->steps = 0;
		$this->previousSteps = [];
	}
	
	public function run() {
		
		
		do {
			$this->previousSteps[] = $this->inputArr;
			$maxValueIndex = $this->getMaxValueIndex();
			$valueToRedistribute = $this->inputArr[$maxValueIndex];
			$this->inputArr[$maxValueIndex] = 0;
			for($i = 0; $i < $valueToRedistribute; $i ++) {
				$index = ($maxValueIndex + 1 + $i) % $this->inputLength;
				$this->inputArr[$index]++;
			}
			$this->steps++;
		}while (!$this->doesPreviousConfigurationExists($this->inputArr));
		
	}
	
	private function getMaxValueIndex() {
		$index = 0;
		foreach ($this->inputArr as $key => $value){
			if($value > $this->inputArr[$index]) {
				$index = $key;
			}
		}
		
		return $index;
	}
	
	private function doesPreviousConfigurationExists($array) {
		foreach($this->previousSteps as $previousStep) {
			if($previousStep === $array) {
				return true;
			}
		}
		
		return false;
	}
	
	public function getSteps() {
		return $this->steps;
	}
}

$inputs = [
	"0	2	7	0",
	"4	1	15	12	0	9	9	5	5	8	7	3	14	5	12	3",
];

foreach($inputs as $input) {
	$day = new Day06_1($input);
	$day->run();
	echo "Steps: " . $day->getSteps() . "\n";
}
