<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * Abstract implementation of a MediaItem factory
 */
abstract class AbstractMediaItemFactory implements MediaItemFactory {

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
    public function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    /**
     * Creates a media item from the provided URL
     * @param string $url URL of the media item
     * @return \ride\library\media\item\MediaItem
     */
    public function createFromUrl($url) {
        return $this->createMediaItem(null, $url);
    }

    /**
     * Creates a media item with the provided id
     * @param string $id Id of the media item in the service
     * @return \ride\library\media\item\MediaItem
     */
    public function createFromId($id) {
        return $this->createMediaItem($id);
    }

    /**
     * Creates a media item
     * @param string $id Id of the media item in the service
     * @param string $url URL of the media item
     * @return \ride\library\media\item\MediaItem
     */
    abstract protected function createMediaItem($id, $url = null);

}
