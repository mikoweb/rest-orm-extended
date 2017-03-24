<?php

namespace Mikoweb\RestOrm\Response;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Nocarrier\Hal;
use Tystr\RestOrm\Metadata\Registry;
use Tystr\RestOrm\Response\HalResponseMapper;

/**
 * Abstract response mapper.
 *
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 */
abstract class ResponseMapperAbstract extends HalResponseMapper
{
    /**
     * @var Registry
     */
    protected $metadataRegistry;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @param Registry $metadataRegistry
     * @param SerializerInterface|null $serializer
     */
    public function __construct(Registry $metadataRegistry, SerializerInterface $serializer = null)
    {
        parent::__construct($metadataRegistry);
        $this->metadataRegistry = $metadataRegistry;
        $this->serializer = $serializer ?: $this->configureSerializer(SerializerBuilder::create())->build();
    }

    /**
     * Example usage is exec configureHandlers for custom serializer handlers.
     *
     * @param SerializerBuilder $serializer
     *
     * @return SerializerBuilder
     */
    abstract protected function configureSerializer(SerializerBuilder $serializer);

    /**
     * Maps a response body to an Hal object.
     *
     * @param ResponseInterface $response
     * @param string            $format
     *
     * @return Hal
     */
    protected function getHal(ResponseInterface $response, $format)
    {
        if ('json' === $format) {
            $hal = Hal::fromJson((string) $response->getBody(), 10);
        } elseif ('xml' === $format) {
            $hal = Hal::fromXml((string) $response->getBody(), 10);
        } else {
            throw new InvalidArgumentException(sprintf('Unsupported format "%s".', $format));
        }

        return $hal;
    }
}
