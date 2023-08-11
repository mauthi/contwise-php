<?php

namespace Contwise\Models;

use Contwise\Contwise;
use Contwise\Enums\FeatureType;
use Contwise\Exceptions\ContwiseException;

class Feature extends AbstractModel
{
    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->checkDataType();
    }

    public static function getByNumber($number): self
    {
        $endpoint = Contwise::getFeaturesResource();
        $result = $endpoint->getByNumber($number);

        return new self($result);
    }

    /**
     * @return Feature[]
     */
    public static function getByLayerId(int $layerId, array $types = [FeatureType::SERVICE_PATH, FeatureType::SERVICE_POSITION]): array
    {
        $endpoint = Contwise::getFeaturesResource();
        $features = $endpoint->getByLayerIds([$layerId], $types);
        $result = [];

        foreach ($features as $feature) {
            // dump($feature);
            $result[] = new self($feature);
        }

        return $result;
    }

    public static function getServicePathsByLayerId(int $layerId): array
    {
        return self::getByLayerId($layerId, [FeatureType::SERVICE_PATH]);
    }

    public static function getServicePositionsByLayerId(int $layerId): array
    {
        return self::getByLayerId($layerId, [FeatureType::SERVICE_POSITION]);
    }

    public function getFullName(): string
    {
        return $this->getProperty('fullName');
    }

    public function getName(): string
    {
        return $this->getProperty('name');
    }

    public function getFeatureType(): string
    {
        return $this->getProperty('soType');
    }

    public function getGroupForeignId(): string
    {
        return $this->getProperty('groupFid');
    }

    public function getFirstImageUrl(?string $default = null): ?string
    {
        $images = $this->getProperty('images');
        if (! isset($images[0])) {
            return $default;
        }

        return $images[0]['baseUrl'].$images[0]['file'];
    }

    public function getImageUrls(array $default = []): array
    {
        $images = $this->getProperty('images');
        if (! isset($images[0])) {
            return $default;
        }

        $output = [];
        foreach ($images as $image) {
            $output[] = $image['baseUrl'].$image['file'];
        }

        return $output;
    }

    public function getProperty(string $key, bool $throwException = true, mixed $default = null): mixed
    {
        if (! isset($this->data['properties'][$key])) {
            if ($throwException) {
                throw new ContwiseException("Property with key '{$key}' not found.");
            } else {
                return $default;
            }
        }

        return $this->data['properties'][$key];
    }

    public function getProperties(): array
    {
        return $this->data['properties'];
    }

    private function checkDataType()
    {
        $allowedTypes = FeatureType::getKeys();

        if (! in_array($this->getProperty('soType'), $allowedTypes)) {
            throw new ContwiseException("Data soType '{$this->getProperty('soType')}' does not match one of the allowed types (".implode(',', $allowedTypes).")'\nData:".print_r($this->data, true));
        }
    }
}
