<?php
namespace Corticalio\Section;

use Corticalio\Section;
use Corticalio\Exception;

class Retinas extends Section
{
    /**
     * List available retinas
     *
     * @return array
     */
    public function listRetinas()
    {
        return $this->getClient()->get('retinas');
    }

    /**
     * Get the details of a single retina
     *
     * @param string $name The retina name
     * 
     * @return object
     */
    public function getRetina($name)
    {
        $result = $this->getClient()->get('retinas', ['retina_name' => $name]);
        if (is_array($result) && count($result) === 1) {
            return $result[0];
        }
        throw new Exception("Invalid response for single retina: " . json_encode($result));
    }
}
