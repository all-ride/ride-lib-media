<?php

namespace ride\library\media;

use ride\library\http\client\Client;
use ride\library\media\exception\UnsupportedMediaException;
use ride\library\media\factory\MediaItemFactory;

/**
 * Simple media factory
 */
class SimpleMediaFactory implements MediaFactory {

    /**
     * Instance of the HTTP client
     * @var \ride\library\http\client\Client
     */
    protected $httpClient;

    /**
     * Media factories to use
     * @var array
    protected $mediaItemFactories;

    /**
     * Constructs a new media factory
     * @param \ride\library\http\client\Client $httpClient
     * @return null
     */
    public function __construct(Client $httpClient) {
        $this->httpClient = $httpClient;
        $this->mediaItemFactories = array();
    }

    /**
     * Gets the HTTP client used by the media library
     * @return \ride\library\http\client\Client
     */
    public function getHttpClient() {
        return $this->httpClient;
    }

    /**
     * Adds a media item factory
     * @param \ride\library\media\factory\MediaItemFactory $mediaItemFactory
     * @return null
     */
    public function setMediaItemFactory(MediaItemFactory $mediaItemFactory) {
        $this->mediaItemFactories[$mediaItemFactory->getType()] = $mediaItemFactory;
    }

    /**
     * Sets the default media item factory, a fallback
     * @param \ride\library\media\factory\MediaItemFactory $defaultMediaItemFactory
     * @return null
     */
    public function setDefaultMediaItemFactory(MediaItemFactory $defaultMediaItemFactory) {
        $this->defaultMediaItemFactory = $defaultMediaItemFactory;
    }

    /**
     * Creates a media item from a URL
     * @param string $url URL to a item of a media service
     * @return \ride\library\media\item\MediaItem Instance of the media item
     * @throws \ride\library\media\exception\MediaException when no media item
     * instance could be created
     */
    public function createMediaItem($url) {
        foreach($this->mediaItemFactories as $mediaItemFactory) {
            if ($mediaItemFactory->isValidUrl($url)) {
                return $mediaItemFactory->createFromUrl($url);
            }
        }

        if ($this->defaultMediaItemFactory) {
            return $this->defaultMediaItemFactory->createFromUrl($url);
        }

        throw new UnsupportedMediaException('Could not get media item for ' . $url . ': no factory available');
    }

    /**
     * Gets a media item by it's type and id
     * @param string type
     * @param string id
     * @return \ride\library\media\item\MediaItem
     */
    public function getMediaItem($type, $id) {
        if (isset($this->mediaFactories[$type])) {
            return $this->mediaFactory->createFromId($id);
        }

        if ($this->defaultMediaItemFactory && $this->defaultMediaItemFactory->getType() == $type) {
            return $this->defaultMediaItemFactory->createFromId($url);
        }

        throw new UnsupportedMediaException('Could not get the media item: unsupported type ' . $type);
    }

}
