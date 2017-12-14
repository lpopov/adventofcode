<?php
class Day09 {
	private $input;
	
	private $totalScore;
	private $garbageNonCanceledChars;
	
	public function __construct($input) {
		$this->input = $input;
		
		$this->totalScore = 0;
		$this->garbageNonCanceledChars = 0;
	}
	
	public function run() {
		$groupLevel = 0;
		$ignoreChar = false;
		$isGarbage = false;
		for($i = 0; $i < strlen($this->input); $i++) {
			if($ignoreChar) {
				$ignoreChar = false;
				continue;
			}

			$char = $this->input[$i];
			
			if($char == '!') {
				$ignoreChar = true;
				continue;
			}
			
			if($isGarbage) {
				if($char == '>') {
					$isGarbage = false;
				} else {
					$this->garbageNonCanceledChars++;
				}
				continue;
			}
			
			switch($char) {
				case '{':
					$groupLevel++;
					break;
				case '}':
					$this->totalScore += $groupLevel;
					$groupLevel--;
					break;
				case '<':
					$isGarbage = true;
					break;
			}
			
			if($char != '!') {
				$ignoreChar = false;
			}
		}
	}
	
	public function getTotalScore() {
		return $this->totalScore;
	}
	
	public function getGarbageNonCanceledChars() {
		return $this->garbageNonCanceledChars;
	}
}

$inputs = [
	"{}",
	"{{{}}}",
	"{{},{}}",
	"{{{},{},{{}}}}",
	"{<a>,<a>,<a>,<a>}",
	"{{<ab>},{<ab>},{<ab>},{<ab>}}",
	"{{<!!>},{<!!>},{<!!>},{<!!>}}",
	"{{<a!>},{<a!>},{<a!>},{<ab>}}",
	"<>",
	"<random characters>",
	"<<<<>",
	"<{!>}>",
	"<!!>",
	"<!!!>>",
	"<{o\"i!a,<{i<a>",
	
];

$day = new Day09(file_get_contents("input.day09.txt"));
$day->run();
echo "Total score: " . $day->getTotalScore() . "\n";
echo "Garbage non canceled chars: " . $day->getGarbageNonCanceledChars() . "\n";