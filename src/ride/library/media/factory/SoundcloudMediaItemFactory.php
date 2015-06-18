<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;
use ride\library\media\exception\MediaException;

/**
 * SoundcloudMediaItemFactory
 */
class SoundcloudMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        parent::__construct($httpClient);
        $this->mediaItemClass = 'ride\library\media\item\SoundcloudMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return stripos($url, 'soundcloud') !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromUrl($url) {
        if (!$this->clientId) {
            throw new MediaException('soundcloud.client.id parameter not set');
        }

        $mediaItem = parent::createFromUrl($url);
        $mediaItem->setClientId($this->clientId);

        return $mediaItem;
    }
}
