<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;
use ride\library\media\exception\MediaException;

/**
 * ImageMediaItemFactory
 */
class ImageMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        parent::__construct($httpClient);
        $this->mediaItemClass = 'ride\library\media\item\ImageMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return preg_match('/(\.jpg|\.png|\.gif|\.jpeg)/i', $url);
    }

}
