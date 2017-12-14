<?php
class Day13_1 {
	private $inputArr;
	
	private $severity;
	private $lastLevelIndex;
	
	public function __construct($input) {
		$tmpArr = explode("\n", $input);
		foreach($tmpArr as $inputStr) {
			$tmpArr = explode(': ', $inputStr);
			$this->inputArr[(int) $tmpArr[0]] = (int) $tmpArr[1];
			$this->lastLevelIndex = (int) $tmpArr[0];
		}
		
		$this->severity = 0;
	}
	
	public function run() {
		for($currentLevel = 0; $currentLevel <= $this->lastLevelIndex; $currentLevel++ ) {
			if(!isset($this->inputArr[$currentLevel])) {
				continue;
			}
			
			if(($currentLevel % ($this->inputArr[$currentLevel] - 1)) == 0
					&& (floor($currentLevel / ($this->inputArr[$currentLevel] - 1)) % 2) == 0) {
				
				$this->severity += $currentLevel * $this->inputArr[$currentLevel];
			}
		}
	}
	
	public function getSeverity() {
		return $this->severity;
	}
}

$inputs = [
	"0: 3
1: 2
4: 4
6: 4"
];

foreach($inputs as $input) {
	$day = new Day13_1($input);
	$day->run();
	echo "Input: \n" . $input . "\n";
	echo "Severity: " . $day->getSeverity() . "\n";
}

$day = new Day13_1(file_get_contents("input.day13.txt"));
$day->run();
echo "-------------\n";
echo "Severity: " . $day->getSeverity() . "\n";