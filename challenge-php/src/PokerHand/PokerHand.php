<?php

namespace PokerHand;

class PokerHand
{
    public $cards = array();

    public function __construct($hand)
    {
        $cards = explode(' ', $hand);
        for ( $i=0; $i<count($cards); $i++ ) {
            $card['suit'] = substr($cards[$i], -1);
            $num = substr($cards[$i], 0, -1);
            if ( '1'<$num && $num<='10') {
                $num = (int) $num;
            }
            else {
                switch ($num) {
                    case 'J': $num = 11; break;
                    case 'Q': $num = 12; break;
                    case 'K': $num = 13; break;
                    case 'A': $num = 14; break;
                }
            }
            $card['num'] = $num;
            $this->cards[] = $card;
        }
    }

    public function isFlush() {
        $suit = $this->cards[0]['suit'];
        for ( $i=1; $i<count($this->cards); $i++ ) {
            if ( $this->cards[$i]['suit'] != $suit ) {
                return false;
            }
        }
        return true;
    }

    public function isRoyal() {
        $totalNum = 0;
        for ( $i=0; $i<count($this->cards); $i++ ) {
            $totalNum += $this->cards[$i]['num'];
        }
        if ( $totalNum == (14+13+12+11+10) ) {
            return true;
        }
        return false;
    }

    public function countNumFrequency() {
        $frequencies[$this->cards[0]['num']] = 1;
        for ( $i=1; $i<count($this->cards); $i++ ) {
            foreach ( $frequencies as $num => $frequency ) {
                if ( $this->cards[$i]['num'] == $num ) {
                    $frequencies[$num]++;
                }
                else {
                    $frequencies[$this->cards[$i]['num']] = 1;
                }
            }
        }
        return $frequencies;
    }

    public function isTwoPair() {
        $frequencies = $this->countNumFrequency();
        $npair = 0;
        foreach ( $frequencies as $num => $frequency) {
            if ( $frequency == 2) {
                $npair++;
            }
        }

        if ( $npair == 2 ) {
            return true;
        }
        return false;
    }

    public function getRank()
    {
        if ( $this->isFlush() ) {
            if ( $this->isRoyal() ) {
                return 'Royal Flush';
            }
            else {
                return 'Flush';
            }
        }

        if ( $this->isTwoPair() ) {
            return 'Two Pair';
        }
        return 'Not a Flush and not two pair';

    }
}
