<?php
class Day13_2 {
	private $inputArr;
	
	private $severity;
	private $lastLevelIndex;
	private $delay;
	
	public function __construct($input) {
		$tmpArr = explode("\n", $input);
		foreach($tmpArr as $inputStr) {
			$tmpArr = explode(': ', $inputStr);
			$this->inputArr[(int) $tmpArr[0]] = (int) $tmpArr[1];
			$this->lastLevelIndex = (int) $tmpArr[0];
		}
		
		$this->severity = 0;
		$this->delay = 0;
	}
	
	public function run() {
		$passedThrough = false;
		while(!$passedThrough) {
			for($currentLevel = 0; $currentLevel <= $this->lastLevelIndex; $currentLevel++ ) {
				if(!isset($this->inputArr[$currentLevel])) {
					continue;
				}

				if($this->isCaught($currentLevel, $currentLevel + $this->delay)) {
					$this->delay++;
					break;
				} else {
					if($currentLevel == $this->lastLevelIndex) {
						$passedThrough = true;
					}
				}
			}
		}
		
	}
	
	private function isCaught($level, $seconds) {
		return ($seconds % ($this->inputArr[$level] * 2 - 2)) == 0;
	}
	
	public function getDelay() {
		return $this->delay;
	}
}

$inputs = [
	"0: 3
1: 2
4: 4
6: 4"
];

foreach($inputs as $input) {
	$day = new Day13_2($input);
	$day->run();
	echo "Input: \n" . $input . "\n";
	echo "Delay: " . $day->getDelay() . "\n";
}

$day = new Day13_2(file_get_contents("input.day13.txt"));
$day->run();
echo "-------------\n";
echo "Delay: " . $day->getDelay() . "\n";