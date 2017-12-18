<?php

class Program {
	private $instructionsArr;
	private $registersArr;
	private $instructionIndex;
	private $programId;
	
	private $recieveQueue;
	private $sendQueue;
	
	private $sentValues;
	
	public function __construct($instructionsArr, $registersArr, $programId, &$recieveQueue, &$sendQueue) {
		$this->instructionsArr = $instructionsArr;
		$this->registersArr = $registersArr;
		
		$this->registersArr['p'] = $programId;
		
		$this->instructionIndex = 0;
		$this->programId = $programId;
		
		$this->recieveQueue = &$recieveQueue;
		$this->sendQueue = &$sendQueue;
		$this->sentValues = 0;
	}
	
	public function run() {
		while($this->instructionIndex >= 0 && $this->instructionIndex < sizeof($this->instructionsArr)) {
			$instruction = $this->instructionsArr[$this->instructionIndex];
			switch($instruction[0]) {
				case "snd":
					array_push($this->sendQueue, (int) $this->getValue($instruction[1]));

					$this->sentValues++;
					$this->instructionIndex++;
					break;
				
				case "set":
					$this->registersArr[$instruction[1]] = $this->getValue($instruction[2]);
					$this->instructionIndex++;
					break;
				
				case "add":
					$this->registersArr[$instruction[1]] += $this->getValue($instruction[2]);
					$this->instructionIndex++;
					break;
				
				case "mul":
					$this->registersArr[$instruction[1]] *= $this->getValue($instruction[2]);
					$this->instructionIndex++;
					break;
				
				case "mod":
					$this->registersArr[$instruction[1]] %= $this->getValue($instruction[2]);
					$this->instructionIndex++;
					break;
				
				case "rcv":
					$value = array_shift($this->recieveQueue);

					if($value == null) {
						return true;
					}

					$this->registersArr[$instruction[1]] = $value;
					$this->instructionIndex++;
					break;
					
				case "jgz":
					$condition = $this->getValue($instruction[1]);
					$jump = $this->getValue($instruction[2]);

					if($condition > 0) {
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
	
	public function getSentValues() {
		return $this->sentValues;
	}
}
class Day18_2 {
	private $program0;
	private $queue0;
	private $program1;
	private $queue1;
	
	public function __construct($input) {
		$instructionsArr = explode("\n", $input);
		foreach($instructionsArr as $key => $instruction) {
			$instructionsArr[$key] = explode(" ", $instruction);
			if(!is_numeric($instructionsArr[$key][1])) {
				$registersArr[$instructionsArr[$key][1]] = 0;
			}
		}
		
		$this->queue0 = [];
		$this->queue1 = [];
		
		$this->program0 = new Program($instructionsArr, $registersArr, 0, $this->queue1, $this->queue0);
		$this->program1 = new Program($instructionsArr, $registersArr, 1, $this->queue0, $this->queue1);
	}
	
	public function run() {
		$result0 = null;
		$result1 = null;
		
		do {
			$result0 = $this->program0->run();
			$result1 = $this->program1->run();
		}while(!(
				($result0 == false && $result1 == false)
				|| ($result0 == true && $result1 == true
				&& empty($this->queue0) && empty($this->queue1))
				|| ($result0 == true && $result1 == false
				&& empty($this->queue0))  
				|| ($result0 == false && $result1 == true
				&& empty($this->queue1))
		));
	}
	
	public function getProgram1SentValues() {
		return $this->program1->getSentValues();
	}
}

$inputs = [
	"snd 1
snd 2
snd p
rcv a
rcv b
rcv c
rcv d",
];

foreach($inputs as $input) {
	$day = new Day18_2($input);
	$day->run();
	echo "Program 1 sent values: " . $day->getProgram1SentValues() . "\n";
}

$day = new Day18_2(file_get_contents("input.day18.txt"));
$day->run();
echo "-------------\n";
echo "Program 1 sent values: " . $day->getProgram1SentValues() . "\n";