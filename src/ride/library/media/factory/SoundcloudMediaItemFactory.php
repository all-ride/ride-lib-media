<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * SoundcloudMediaItemFactory
 */
class SoundcloudMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * @var string $clientId
     */
    protected $clientId;

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
    public function createFormUrl($url) {
        $mediaItem = parent::createFormUrl($url);
        $mediaItem->setClientId($this->clientId);

        return $mediaItem;
    }
}
