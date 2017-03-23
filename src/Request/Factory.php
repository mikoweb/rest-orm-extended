<?php

namespace Mikoweb\RestOrm\Request;

use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Tystr\RestOrm\Metadata\Metadata;
use Tystr\RestOrm\Metadata\Registry;
use Tystr\RestOrm\Request\Factory as RequestFactory;
use Tystr\RestOrm\UrlGenerator\UrlGeneratorInterface;

/**
 * Request factory.
 *
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 */
class Factory extends RequestFactory
{
    /**
     * @var Registry
     */
    protected $metadataRegistry;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @var string
     */
    protected $format;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        $format,
        Registry $metadataRegistry = null,
        SerializerInterface $serializer = null
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->format = $format;
        $this->metadataRegistry = $metadataRegistry ?: new Registry();
        $this->serializer = $serializer ?: SerializerBuilder::create()->build();
        parent::__construct(
            $this->urlGenerator,
            $this->format,
            $this->metadataRegistry,
            $this->serializer
        );
    }

    /**
     * @param string $class
     *
     * @return Metadata
     */
    public function getMetadata($class)
    {
        return $this->metadataRegistry->getMetadataForClass($class);
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer()
    {
        return $this->serializer;
    }

    /**
     * @return UrlGeneratorInterface
     */
    public function getUrlGenerator()
    {
        return $this->urlGenerator;
    }
}
