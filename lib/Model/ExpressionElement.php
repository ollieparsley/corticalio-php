<?php
namespace Corticalio\Model;

use Corticalio\Exception;

class ExpressionElement
{
    /**
     * Some text to use
     *
     * @var string
     */
    public $text;

    /**
     * A short term to phrase
     *
     * @var string
     */
    public $term;

    /**
     * The base API client
     *
     * @return object
     */
    public function toApiRequestFormat()
    {
        $obj = new \stdClass();
        if ($this->text) {
            $obj->text = $this->text;
            return $obj;
        }
        if ($this->term) {
            $obj->term = $this->term;
            return $obj;
        }
        throw new Exception("Neither text or term was set");
    }

}
