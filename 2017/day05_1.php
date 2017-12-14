<?php
class Day05_1 {
	private $inputArr;
	private $steps;
	
	public function __construct($input) {
	
		$this->inputArr = explode("\n", $input);
		
		$this->steps = 0;
	}
	
	public function run() {
		$currentIndex = 0;
		do{
			$oldIndex = $currentIndex;
			$currentIndex += $this->inputArr[$currentIndex];
			$this->inputArr[$oldIndex]++;
			$this->steps++;
			
		}while($currentIndex>=0 && $currentIndex< sizeof($this->inputArr));
	}
	
	public function getSteps() {
		return $this->steps;
	}
}

$inputs = [
	"0
3
0
1 
-3",
];

foreach($inputs as $input) {
	$day = new Day05_1($input);
	$day->run();
	echo "Steps: " . $day->getSteps() . "\n";
}

$day = new Day05_1(file_get_contents("input.day05.txt"));
$day->run();
echo "-------------\n";
echo "Steps: " . $day->getSteps() . "\n";