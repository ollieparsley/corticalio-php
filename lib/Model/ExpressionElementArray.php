<?php
namespace Corticalio\Model;

use Corticalio\Exception;
use Corticalio\Model\ExpressionElement;

class ExpressionElementArray
{
    /**
     * Pairs of expressions
     *
     * @var array
     */
    protected $elementPairs = [];

    /**
     * Add a pair of elements
     *
     * @return voic
     */
    public function addPair(ExpressionElement $element1, ExpressionElement $element2)
    {
        $this->elementPairs[] = [$element1, $element2];
    }

    /**
     * Return API request format
     *
     * @return array
     */
    public function toApiRequestFormat()
    {
        $formattedArray = [];
        foreach($this->elementPairs as $elementPair) {
            $formattedArray[] = [$elementPair[0]->toApiRequestFormat(), $elementPair[1]->toApiRequestFormat()];
        }
        return $formattedArray;
    }

}
