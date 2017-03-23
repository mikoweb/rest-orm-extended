<?php

namespace Mikoweb\RestOrm\Repository;

use Mikoweb\RestOrm\Request\Factory;
use Psr\Http\Message\ResponseInterface;
use Tystr\RestOrm\Metadata\Metadata;
use Tystr\RestOrm\Repository\Repository as BaseRepository;
use Tystr\RestOrm\UrlGenerator\UrlGeneratorInterface;

/**
 * Abstract repository.
 *
 * @author Rafał Mikołajun <rafal@mikoweb.pl>
 */
abstract class RepositoryAbstract extends BaseRepository
{
    /**
     * @return Metadata
     */
    protected function getMetadata()
    {
        return $this->getRequestFactory()->getMetadata($this->class);
    }

    /**
     * @return UrlGeneratorInterface
     */
    protected function getUrlGenerator()
    {
        return $this->getRequestFactory()->getUrlGenerator();
    }

    /**
     * @return Factory
     */
    protected function getRequestFactory()
    {
        if (!$this->requestFactory instanceof Factory) {
            throw new \UnexpectedValueException('Invalid RequestFactory.');
        }

        return $this->requestFactory;
    }

    /**
     * @return string
     */
    protected function getContentTypeHeader()
    {
        return $this->getRequestFactory()->getContentTypeHeader();
    }

    /**
     * @param ResponseInterface $response
     *
     * @return \stdClass
     */
    protected function getResponseData(ResponseInterface $response)
    {
        return \GuzzleHttp\json_decode((string) $response->getBody());
    }

    // Example POST usage
    //public function postBySerial(string $serial, string $finalUserDescription) : \stdClass
    //{
        //return $this->getResponseData($this->client->send(new Request(
            //'POST',
            //$this->getUrlGenerator()->getCreateUrl($this->getMetadata()->getResource()) . '/serial/',
            //['Content-Type' => $this->getContentTypeHeader()],
            //\GuzzleHttp\json_encode([
                // ...
            //])
        //)));
    //}

    // Example GET usage
    //public function count() : int
    //{
        //$data = $this->getResponseData($this->client->send(new Request(
            //'GET',
            //$this->getUrlGenerator()->getFindAllUrl($this->getMetadata()->getResource(), [
                // ...
            //]),
            //['Content-Type' => $this->getContentTypeHeader()]
        //)));

        //return $data->count;
    //}
}
