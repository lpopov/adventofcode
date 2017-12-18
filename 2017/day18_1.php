<?php
class Day18_1 {
	private $instructionsArr;
	private $registersArr;
	private $soundBuffer;
	private $recoveredSound;
	
	public function __construct($input) {
		$this->instructionsArr = explode("\n", $input);
		foreach($this->instructionsArr as $key => $instruction) {
			$this->instructionsArr[$key] = explode(" ", $instruction);
			if(!is_numeric($this->instructionsArr[$key][1])) {
				$this->registersArr[$this->instructionsArr[$key][1]] = 0;
			}
		}
		
		$this->recoveredSound = null;
	}
	
	public function runOne() {
		
	}
	public function run() {
		$i = 0;
		do{
			$instruction = $this->instructionsArr[$i];
			switch($instruction[0]) {
				case "snd":
					$this->soundBuffer = $this->getValue($instruction[1]);
					$i++;
					break;
				
				case "set":
					$this->registersArr[$instruction[1]] = $this->getValue($instruction[2]);
					$i++;
					break;
				
				case "add":
					$this->registersArr[$instruction[1]] += $this->getValue($instruction[2]);
					$i++;
					break;
				
				case "mul":
					$this->registersArr[$instruction[1]] *= $this->getValue($instruction[2]);
					$i++;
					break;
				
				case "mod":
					$this->registersArr[$instruction[1]] %= $this->getValue($instruction[2]);
					$i++;
					break;
				
				case "rcv":
					if($this->soundBuffer) {
						$this->recoveredSound = $this->soundBuffer;
					}
					$i++;
					break;
					
				case "jgz":
					$condition = $this->getValue($instruction[1]);
					$jump = $this->getValue($instruction[2]);
					
					if($condition) {
						$i += $jump;
					} else {
						$i++;
					}
					break;
			}
		}while($i >= 0 && $i < sizeof($this->instructionsArr) && !$this->recoveredSound);
	}
	
	private function getValue($value) {
		if(is_numeric($value)) {
			return $value;
		}
		
		return $this->registersArr[$value];
	}
	
	public function getRecoveredSound() {
		return $this->recoveredSound;
	}
}

$inputs = [
	"set a 1
add a 2
mul a a
mod a 5
snd a
set a 0
rcv a
jgz a -1
set a 1
jgz a -2",
];

foreach($inputs as $input) {
	$day = new Day18_1($input);
	$day->run();
	echo "Recovered sound: " . $day->getRecoveredSound() . "\n";
}

$day = new Day18_1(file_get_contents("input.day18.txt"));
$day->run();
echo "-------------\n";
echo "Recovered sound: " . $day->getRecoveredSound() . "\n";