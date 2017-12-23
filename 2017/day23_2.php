<?php

class Day23_2 {
	private $registersArr;
	
	public function __construct() {
		$this->registersArr = [
			'a' => 1,
			'b' => 0,
			'c' => 0,
			'd' => 0,
			'e' => 0,
			'f' => 0,
			'g' => 0,
			'h' => 0,
		];
	}
	
	public function run() {
		$this->registersArr['b'] = 57;
		$this->registersArr['c'] = $this->registersArr['b'];
		
		$this->registersArr['b'] *= 100;
		$this->registersArr['b'] += 100000;
		
		$this->registersArr['c'] = $this->registersArr['b'] + 17000;
		
		do{
			$this->registersArr['f'] = 1;
			$this->registersArr['d'] = 2;
			for($d = $this->registersArr['d']; $d * $d < $this->registersArr['b']; ++$d) {
				if($this->registersArr['b'] % $d === 0) {
					$this->registersArr['f'] = 0;
					break;
				} 
			}
			
			if($this->registersArr['f'] === 0) {
				$this->registersArr['h']++;
			}
			
			$this->registersArr['g'] = $this->registersArr['b'] - $this->registersArr['c'];
			$this->registersArr['b'] += 17;
		}while($this->registersArr['g'] != 0);
	}
	
	public function getRegisterH() {
		return $this->registersArr['h'];
	}
}

$day = new Day23_2();
$day->run();
echo "-------------\n";
echo "Register 'h' final value: " . $day->getRegisterH() . "\n";