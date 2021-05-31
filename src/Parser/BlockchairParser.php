<?php

declare(strict_types=1);

namespace App\Parser;

use App\Exception\ParseExternalApiException;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Zend\Json\Json;

/**
 * Class BlockchairParser
 * @package App\Parser
 */
class BlockchairParser extends Parser
{
    /**
     * @param DenormalizerInterface $denormalizer
     */
    #[Pure]
    public function __construct(DenormalizerInterface $denormalizer)
    {
        parent::__construct($denormalizer);
    }

    /**
     * @inheritDoc
     */
    public function parse(array $data, string $model): array
    {
        if (!isset($data['data'])) {
            throw new ParseExternalApiException(
                \sprintf('There are no "data" key in response array from %s', Json::encode($data))
            );
        }

        return $this->getDenormalizer()->denormalize($data['data'], $model, 'json');
    }
}
