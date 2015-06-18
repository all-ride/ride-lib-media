<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;
use ride\library\media\exception\MediaException;

/**
 * YoutubeMediaItemFactory
 */
class YoutubeMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        parent::__construct($httpClient);
        $this->mediaItemClass = 'ride\library\media\item\YoutubeMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return stripos($url, 'youtu') !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromUrl($url) {
        if (!$this->clientId) {
            throw new MediaException('google.api.key parameter not set');
        }

        $mediaItem = parent::createFromUrl($url);
        $mediaItem->setClientId($this->clientId);

        return $mediaItem;
    }

}
