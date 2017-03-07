<?php

namespace TripSorter;

class BuildHTML
{
    /**
     * @param $sortedCards
     *
     * @return string
     */
    public function makeHtml($sortedCards)
    {
        $htmlString = "<ol>";
        foreach ($sortedCards as $card) {
            switch ($card['Transportation']) {
                case "Train":
                    $htmlString .= $this->buildTrainHtml($card);
                    break;
                case "Bus":
                    $htmlString .= $this->buildBusHtml($card);
                    break;
                case "Plane":
                    $htmlString .= $this->buildPlaneHtml($card);
                    break;
            }
        }
        
        return $htmlString . $this->arrivalMsg() . "</ol>";
    }
    
    /**
     * @param $card
     *
     * @return string
     */
    private function buildTrainHtml($card)
    {
        return sprintf("<li>Take train %s from %s to %s. %s%s</li>",
            $card['Transportation_number'],
            $card['Departure'],
            $card['Arrival'],
            $this->buildGateHTML($card),
            $this->buildSeatHTML($card)
        );
    }
    
    /**
     * @param $card
     *
     * @return string
     */
    private function buildBusHtml($card)
    {
        return sprintf("<li>Take the airport bus from %s to %s. %s</li>",
            $card['Departure'],
            $card['Arrival'],
            $this->buildSeatHTML($card)
        );
    }
    
    /**
     * @param $card
     *
     * @return string
     */
    private function buildPlaneHtml($card)
    {
        return sprintf("<li>From %s, take flight %s to %s. %s%s%s</li>",
            $card['Departure'],
            $card['Transportation_number'],
            $card['Arrival'],
            $this->buildGateHTML($card),
            $this->buildSeatHTML($card),
            $this->buildBaggageHTML($card)
        );
    }
    
    /**
     * @return string
     */
    private function arrivalMsg()
    {
        return "<li>You have arrived at your final destination.</li>";
    }
    
    /**
     * @param $card
     *
     * @return string
     */
    private function buildBaggageHTML($card)
    {
        return !empty($card['Baggage']) ? ", Baggage drop at ticket counter " . $card['Baggage'] : ", Baggage will we automatically transferred from your last leg";
    }
    
    /**
     * @param $card
     *
     * @return string
     */
    private function buildGateHTML($card)
    {
        return empty($card['Gate']) ? '' : "Gate " . $card['Gate'];
    }
    
    /**
     * @param $card
     *
     * @return string
     */
    private function buildSeatHTML($card)
    {
        return empty($card['Seat']) ? "No seat assignment" : "Sit in seat " . $card['Seat'];
    }
}