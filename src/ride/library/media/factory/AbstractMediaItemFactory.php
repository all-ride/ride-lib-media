<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * Abstract implementation of a MediaItem factory
 */
abstract class AbstractMediaItemFactory implements MediaItemFactory {

    /**
     * @param mixed $mediaItemId The mediaItem class assosciated with this factory
     */
    protected $mediaItemClass = null;

    /**
     * @param Client $httpClient
     */
    protected $httpClient;

    /**
     * @param string $clientId
     */
    protected $clientId=null;

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromUrl($url) {
        return new $this->mediaItemClass($this->httpClient, null, $url);
    }

    /**
     * {@inheritdoc}
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }
}
