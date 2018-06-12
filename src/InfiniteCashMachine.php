<?php
namespace CashMachine;

use \InvalidArgumentException;

class InfiniteCashMachine
{
    /**
     * @var int[]
     */
    private $availableNotes = [10, 20, 50, 100];

    /**
     * @param array $notes
     * @throws InvalidArgumentException
     */
    public function setAvailableNotes(array $notes) {
        if (count($notes) == 0) {
            throw  new InvalidArgumentException('Notes should not be empty');
        }
        $this->availableNotes = sort(array_unique($notes));
    }

    /**
     * @param int $amount
     * @return int[]
     * @throws NoteUnavailableException
     */
    public function withdraw(int $amount): array {
        $returnNotes = [];
        $availableNotes = $this->availableNotes;
        $this->validateAmount($amount);
        $note = array_pop($availableNotes);
        while($amount>0) {
            if ($note > $amount) {
                $note = array_pop($availableNotes);
                continue;
            }
            $amount -= $note;
            $returnNotes[] = $note;
        }

        return $returnNotes;
    }

    /**
     * @return int
     */
    private function getMinimalNote(): int {
        return $this->availableNotes[0];
    }

    /**
     * @param int $amount
     * @throws NoteUnavailableException
     * @throws InvalidArgumentException
     */
    private function validateAmount(int $amount) {
        if ($amount < 0) {
            throw  new InvalidArgumentException('Amount could not be negative');
        }
        if ($amount % $this->getMinimalNote() > 0) {
            throw new NoteUnavailableException(
                sprintf('Amount should be aliquot to minimal note value(%s)', $this->getMinimalNote())
            );
        }
    }
}