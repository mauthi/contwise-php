<?php

namespace Contwise\Resources;

use Contwise\Api\Connection;
use Contwise\Enums\FeatureType;
use Contwise\Exceptions\ContwiseResponseException;

/**
 * Class Features.
 *
 * @namespace    Contwise\Resources
 * @author     Mauthi <mauthi@gmail.com>
 */
class Feature extends AbstractResource implements ResourceInterface
{
    const RESOURCE_URL = 'web/api/trackmanagement/serviceobject/search';
    const RESOURCE_KEY = 'features';

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, self::RESOURCE_URL);
    }

    public function getByNumber(string $number): array
    {
        $url = self::RESOURCE_URL;
        $data = [
            'number' => $number,
        ];

        $response = $this->jsonRequest($url, $data);

        $this->checkIfExactOneResult($response);

        // print_r($response);
        $result = $this->getResult($response, self::RESOURCE_KEY, false);

        if (! isset($result[0])) {
            throw new ContwiseResponseException("Feature with number = {$number} not found in Contwise\nResponse: ".print_r($response, true));
        }

        return $this->filterResult($result[0]);
    }

    private function get(array $data = [], array $types = [FeatureType::SERVICE_PATH, FeatureType::SERVICE_POSITION], array $unset = [], int $currentPage = 0): array
    {
        $url = self::RESOURCE_URL;

        $data['start'] = $currentPage * self::PAGE_SIZE;
        $response = $this->jsonRequest($url, $data);

        $resultsForPage = $this->getResult($response, self::RESOURCE_KEY);
        $filteredResultsForPage = [];

        foreach ($resultsForPage as $result) {
            if (in_array($result['properties']['soType'], $types)) {
                $filteredResultsForPage[] = $this->filterResult($result, $unset, $types);
            }
        }

        // Prüft, ob es weitere Seiten gibt, die abgerufen werden müssen
        $properties = $response['properties'] ?? [];
        $totalSize = $properties['totalSize'] ?? 0;
        $pageSize = $properties['pageSize'] ?? 0;
        $page = $properties['page'] ?? 0;

        if ($page > 3) {
            return $resultsForPage;
        }

        if ($page * $pageSize + count($resultsForPage) < $totalSize) {
            // Rekursiver Aufruf, wenn es noch weitere Seiten gibt
            return array_merge($filteredResultsForPage, $this->get(
                data: $data,
                types: $types,
                unset: $unset,
                currentPage: $currentPage + 1));
        }

        return $filteredResultsForPage;
    }

    public function getByLayerIds(array $layerIds, array $types = [FeatureType::SERVICE_PATH, FeatureType::SERVICE_POSITION]): array
    {
        return $this->get(
            data: [
                'layerIds' =>  $layerIds,
                // 'number' => '01-WA045',
            ],
            types: $types,
            unset: [
                'geometry',
                'properties' => ['waypoints'],
            ]);
    }
}
