<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * Abstract implementation of a MediaItem factory
 */
abstract class AbstractMediaItemFactory implements MediaItemFactory {

    /**
     * The MediaItem class assosciated with this factory
     * @var string
     */
    protected $mediaItemClass = null;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $clientId = null;

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
