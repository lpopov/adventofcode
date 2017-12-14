<?php
class Day04_1 {
	private $inputArr;
	private $validPassphrases;
	
	public function __construct($input) {
	
		$this->inputArr = explode("\n", $input);
		
		$this->validPassphrases = 0;
	}
	
	public function run() {
		foreach($this->inputArr as $passphrase) {
			if($this->isPassphraseValid($passphrase)) {
				$this->validPassphrases++;
			}
		}
	}
	
	private function isPassphraseValid($passphrase) {
		$wordsArr = explode(' ', $passphrase);
		
		return sizeof($wordsArr) === sizeof(array_unique($wordsArr));
	}

	public function getValidPassphrases() {
		return $this->validPassphrases;
	}
}

$inputs = [
	"aa bb cc dd ee
aa bb cc dd aa
aa bb cc dd aaa",
];

foreach($inputs as $input) {
	$day = new Day04_1($input);
	$day->run();
	echo "Valid passphrases: " . $day->getValidPassphrases() . "\n";
}

$day = new Day04_1(file_get_contents("input.day04.txt"));
$day->run();
echo "-------------\n";
echo "Valid passphrases: " . $day->getValidPassphrases() . "\n";