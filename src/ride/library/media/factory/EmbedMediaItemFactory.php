<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * EmbedMediaItemFactory
 */
class EmbedMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        parent::__construct($httpClient);
        $this->mediaItemClass = 'ride\library\media\item\EmbedMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return true;
    }
}
