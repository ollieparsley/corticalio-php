<?php
namespace Corticalio\Section;

use Corticalio\Section;
use Corticalio\Exception;

class Terms extends Section
{
    /**
     * List the available terms
     * 
     * http://api.cortical.io/Term.htm#!/terms/getTerm_get_0
     *
     * @param string $retinaName     The retina name
     * @param int    $startIndex     (optional) The start-index for pagination
     * @param int    $maxResults     (optional) Max results per page
     * @param bool   $getFingerprint (optional) Configure if the fingerprint should be returned as part of the results
     * 
     * @return array
     */
    public function listTerms($retinaName, $startIndex = null, $maxResults = null, $getFingerprint = null) 
    {
        $params = [
            'retina_name' => $retinaName,
        ];
        if ($startIndex !== null) {
            $params['start_index'] = (int)$startIndex;
        }
        if ($maxResults !== null) {
            $params['max_results'] = (int)$maxResults;
        }
        if ($getFingerprint !== null) {
            $params['get_fingerprint'] = $getFingerprint === true ? 'true' : 'false';
        }
        return $this->getClient()->get('terms', $params);
    }

    /**
     * Get detail for a single term
     * 
     * http://api.cortical.io/Term.htm#!/terms/getTerm_get_0
     *
     * @param string $retinaName     The retina name
     * @param string $term           A term in the retina
     * @param bool   $getFingerprint (optional) Configure if the fingerprint should be returned as part of the results
     * 
     * @return array
     */
    public function getTerm($retinaName, $term, $getFingerprint = null) 
    {
        $params = [
            'retina_name' => $retinaName,
            'term' => $term,
        ];
        if ($getFingerprint !== null) {
            $params['get_fingerprint'] = $getFingerprint === true ? 'true' : 'false';
        }

        $result = $this->getClient()->get('terms', $params);
        if (is_array($result) && count($result) === 1) {
            return $result[0];
        }
        throw new Exception("Invalid response for single term: " . json_encode($result));
    }

    /**
     * List a terms contexts
     * 
     * http://api.cortical.io/Term.htm#!/terms/getContextsForTerm_get_1
     *
     * @param string $retinaName     The retina name
     * @param string $term           A term in the retina
     * @param int    $startIndex     (optional) The start-index for pagination
     * @param int    $maxResults     (optional) Max results per page
     * @param bool   $getFingerprint (optional) Configure if the fingerprint should be returned as part of the results
     * 
     * @return array
     */
    public function listTermContexts($retinaName, $term, $startIndex = null, $maxResults = null, $getFingerprint = null) 
    {
        $params = [
            'retina_name' => $retinaName,
            'term' => $term,
        ];
        if ($startIndex !== null) {
            $params['start_index'] = (int)$startIndex;
        }
        if ($maxResults !== null) {
            $params['max_results'] = (int)$maxResults;
        }
        if ($getFingerprint !== null) {
            $params['get_fingerprint'] = $getFingerprint === true ? 'true' : 'false';
        }
        return $this->getClient()->get('terms/contexts', $params);
    }

    /**
     * List similar terms for a term
     * 
     * http://api.cortical.io/Term.htm#!/terms/getSimilarTerms_get_2
     *
     * @param string $retinaName     The retina name
     * @param string $term           A term in the retina
     * @param string $contextId      (optional) The ID of a context
     * @param string $posType        (optional) Part of speech (noun, adjective or verb)
     * @param int    $startIndex     (optional) The start-index for pagination
     * @param int    $maxResults     (optional) Max results per page
     * @param bool   $getFingerprint (optional) Configure if the fingerprint should be returned as part of the results
     * 
     * @return array
     */
    public function listSimilarTerms($retinaName, $term, $contextId = null, $posType = null, $startIndex = null, $maxResults = null, $getFingerprint = null) 
    {
        $params = [
            'retina_name' => $retinaName,
            'term' => $term,
        ];
        if ($contextId !== null) {
            $params['context_id'] = $contextId;
        }
        if ($posType !== null) {
            $params['pos_type'] = $posType;
        }
        if ($startIndex !== null) {
            $params['start_index'] = (int)$startIndex;
        }
        if ($maxResults !== null) {
            $params['max_results'] = (int)$maxResults;
        }
        if ($getFingerprint !== null) {
            $params['get_fingerprint'] = $getFingerprint === true ? 'true' : 'false';
        }
        return $this->getClient()->get('terms/contexts', $params);
    }
}
