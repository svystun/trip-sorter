<?php

namespace TripSorter;

use TripSorter\Repositories\Cards;

class TripCardsSorter
{
    /**
     * @var Cards
     */
    private $cards;
    
    /**
     * TripSorter constructor.
     *
     * @param array $cards
     */
    public function __construct($cards = [])
    {
        $this->cards = new Cards($cards);
    }
    
    /**
     * Build the journey cards
     *
     * @return string of HTML for journey description
     */
    public function buildJourney()
    {
        $cardsArray = $this->cards->getCards();
        $cardsCount = count($cardsArray);

        // Do random order of cards.
        shuffle($cardsArray);

        $sortedCards = $this->recursiveSort($cardsArray, $cardsCount);
        $buildHTML = new BuildHTML();
        
        return $buildHTML->makeHTML($sortedCards);
    }

    /**
     * Recursive sorting
     *
     * @param $cardsArray
     * @param $cardsCount
     * @param int $startIndex
     * @return mixed
     */
    private function recursiveSort($cardsArray, $cardsCount, $startIndex = 0)
    {
        if ($startIndex == $cardsCount - 1) {
            return $cardsArray;
        }
        for ($i = $startIndex; $i < $cardsCount; $i++) {
            for ($k = $i + 1; $k < $cardsCount; $k++) {
                if ($cardsArray[$i]['Departure'] == $cardsArray[$k]['Arrival']) {
                    $tempVar = $cardsArray[$i];
                    $cardsArray[$i] = $cardsArray[$k];
                    $cardsArray[$k] = $tempVar;
                    return $this->recursiveSort($cardsArray, $cardsCount, $i);
                }
            }
        }
        
        return $cardsArray;
    }
}
