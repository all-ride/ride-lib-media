<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * MediaItemFactory for random URL's
 */
class UrlMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        parent::__construct($httpClient);

        $this->mediaItemClass = 'ride\library\media\item\UrlMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return true;
    }

}
