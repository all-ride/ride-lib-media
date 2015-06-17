<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * VimeoMediaItemFactory
 */
class VimeoMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        parent::__construct($httpClient);
        $this->mediaItemClass = 'ride\library\media\item\VimeoMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        $filtered = str_replace(array('http://', 'www.', 'https://'), '', $url);
        $filtered = explode('/', $filtered);

        return $filtered[0] === 'vimeo.com' && count($filtered === 2);
    }
}
