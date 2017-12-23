<?php

class Day23_1 {
	private $instructionsArr;
	private $registersArr;
	private $instructionIndex;
	
	private $multipliedTimes;
	
	public function __construct($input) {
		$this->instructionsArr = explode("\n", $input);
		foreach($this->instructionsArr as $key => $instruction) {
			$this->instructionsArr[$key] = explode(" ", $instruction);
			if(!is_numeric($this->instructionsArr[$key][1])) {
				$this->registersArr[$this->instructionsArr[$key][1]] = 0;
			}
		}

		$this->instructionIndex = 0;
		$this->multipliedTimes = 0;
	}
	
	public function run() {
		while($this->instructionIndex >= 0 && $this->instructionIndex < sizeof($this->instructionsArr)) {
			$instruction = $this->instructionsArr[$this->instructionIndex];
			switch($instruction[0]) {

				case "set":
					$this->registersArr[$instruction[1]] = $this->getValue($instruction[2]);
					$this->instructionIndex++;
					break;

				case "sub":
					$this->registersArr[$instruction[1]] -= $this->getValue($instruction[2]);
					$this->instructionIndex++;
					break;
				
				case "mul":
					$this->registersArr[$instruction[1]] *= $this->getValue($instruction[2]);
					$this->instructionIndex++;
					$this->multipliedTimes++;
					break;
				
				case "jnz":
					$condition = $this->getValue($instruction[1]);
					$jump = $this->getValue($instruction[2]);

					if($condition != 0) {
						$this->instructionIndex += $jump;
					} else {
						$this->instructionIndex++;
					}
					break;
			}
		};
		
		return false;
	}
	
	private function getValue($value) {
		if(is_numeric($value)) {
			return $value;
		}
		
		return $this->registersArr[$value];
	}
	
	public function getMultipliedTimes() {
		return $this->multipliedTimes;
	}
}

$day = new Day23_1(file_get_contents("input.day23.txt"));
$day->run();
echo "-------------\n";
echo "Multiplied times: " . $day->getMultipliedTimes() . "\n";