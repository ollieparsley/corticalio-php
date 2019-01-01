<?php
namespace Corticalio\Section;

use Corticalio\Section;
use Corticalio\Model\ExpressionElement;
use Corticalio\Model\ExpressionElementArray;
use Corticalio\Exception;

class Compare extends Section
{
    /**
     * Compare 2 elements
     * 
     * https://api.cortical.io/Compare.htm#!/compare/compare_post_0
     *
     * @param string            $retinaName The retina name
     * @param ExpressionElement $element1   The first element
     * @param ExpressionElement $element2   The second element
     * 
     * @return array
     */
    public function compare($retinaName, ExpressionElement $element1, ExpressionElement $element2) 
    {
        $getParams = [
            'retina_name' => $retinaName,
        ];
        $body = [];
        $body[] = $element1->toApiRequestFormat();
        $body[] = $element2->toApiRequestFormat();
        $postParams = json_encode($body);
        return $this->getClient()->post('compare', $postParams, $getParams);
    }

    /**
     * Bulk compare of element pairs
     * 
     * https://api.cortical.io/Compare.htm#!/compare/compareBulk_post_1
     *
     * @param string                 $retinaName   The retina name
     * @param ExpressionElementArray $elementPairs Array of element pairs
     * 
     * @return array
     */
    public function bulkCompare($retinaName, ExpressionElementArray $elementPairs) 
    {
        $getParams = [
            'retina_name' => $retinaName,
        ];
        $postParams = json_encode($elementPairs->toApiRequestFormat());
        return $this->getClient()->post('compare/bulk', $postParams, $getParams);
    }

}
