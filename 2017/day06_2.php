<?php
class Day06_2 {
	private $inputArr;
	private $inputLength;
	private $steps;
	private $previousSteps;
	private $loopSize;
	
	public function __construct($input) {
	
		$this->inputArr = explode("\t", $input);
		$this->inputLength = sizeof($this->inputArr);
		
		$this->steps = 0;
		$this->previousSteps = [];
		$this->loopSize = 0;
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
			$previousConfigurationIndex = $this->getPreviousConfigurationIndex($this->inputArr);
		}while ($previousConfigurationIndex === false);
		
		$this->loopSize = $this->steps - $previousConfigurationIndex;
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
	
	private function getPreviousConfigurationIndex($array) {
		foreach($this->previousSteps as $index => $previousStep) {
			if($previousStep === $array) {
				return $index;
			}
		}
		
		return false;
	}
	
	public function getSteps() {
		return $this->steps;
	}
	
	public function getLoopSize() {
		return $this->loopSize;
	}
}

$inputs = [
	"0	2	7	0",
	"4	1	15	12	0	9	9	5	5	8	7	3	14	5	12	3",
];

foreach($inputs as $input) {
	$day = new Day06_2($input);
	$day->run();
	echo "Steps: " . $day->getSteps() . "\n";
	echo "Loop size: " . $day->getLoopSize() . "\n";
}
