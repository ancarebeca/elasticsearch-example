<?php

namespace Elasticsearchexample;

use Elastica\Client;
use Elastica\Document;
use Elastica\Request;

/**
 * Class Application
 * @package Elasticsearchexample
 */
class Application
{
    const INDEX_NAME = 'index_test';
    const TYPE_NAME = 'typetest';

    /**
     * @param array $cities
     * @return \Elastica\Response
     */
    public function run(array $cities)
    {
        $client = new Client();

        //Create a new index
        $index = $client->getIndex(self::INDEX_NAME);
        $index->create(array(), true);

        //Set type
        $type = $index->getType(self::TYPE_NAME);

        //Add Document
        $documents = array();
        foreach ($cities as $city) { // Fetching content from the database
            $documents[] = new Document(
                $city['ID'],
                array('name' => $city['Name'])
            );
        }

        $type->addDocuments($documents);
        $index->refresh();

        //Example simple query
        $query = '{"query":{"query_string":{"query":"Eindhoven"}}}';
        $path = $index->getName().'/'.$type->getName().'/_search';

        $response = $client->request($path, Request::GET, $query);
        return $response;
    }
}