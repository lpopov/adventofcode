<?php
class Day05_2 {
	private $inputArr;
	private $steps;
	
	public function __construct($input) {
	
		$this->inputArr = explode("\n", $input);
		
		$this->steps = 0;
	}
	
	public function run() {
		$currentIndex = 0;
//		echo $currentIndex . " " . implode(" ", $this->inputArr) . "\n";
		do{
			$oldIndex = $currentIndex;
			$currentIndex += $this->inputArr[$currentIndex];
			if($this->inputArr[$oldIndex] >= 3) {
				$this->inputArr[$oldIndex]--;
			} else {
				$this->inputArr[$oldIndex]++;
			}
			
			$this->steps++;
//			echo $currentIndex . " " . implode(" ", $this->inputArr) . "\n";
			
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
	$day = new Day05_2($input);
	$day->run();
	echo "Steps: " . $day->getSteps() . "\n";
}

$day = new Day05_2(file_get_contents("input.day05.txt"));
$day->run();
echo "-------------\n";
echo "Steps: " . $day->getSteps() . "\n";