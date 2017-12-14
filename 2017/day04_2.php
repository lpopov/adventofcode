<?php
class Day04_2 {
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
		
		foreach($wordsArr as $index => $word) {
			$lettersArr = str_split($word);
			sort($lettersArr);
			$newWord = implode('', $lettersArr);
			$wordsArr[$index] = $newWord;
		}
		
		return sizeof($wordsArr) === sizeof(array_unique($wordsArr));
	}

	public function getValidPassphrases() {
		return $this->validPassphrases;
	}
}

$inputs = [
	"abcde fghij
abcde xyz ecdab
a ab abc abd abf abj
iiii oiii ooii oooi oooo
oiii ioii iioi iiio",
];

foreach($inputs as $input) {
	$day = new Day04_2($input);
	$day->run();
	echo "Valid passphrases: " . $day->getValidPassphrases() . "\n";
}

$day = new Day04_2(file_get_contents("input.day04.txt"));
$day->run();
echo "-------------\n";
echo "Valid passphrases: " . $day->getValidPassphrases() . "\n";