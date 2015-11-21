<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;
use ride\library\media\exception\MediaException;

/**
 * PdfMediaItemFactory
 */
class PdfMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $httpClient) {
        parent::__construct($httpClient);
        $this->mediaItemClass = 'ride\library\media\item\PdfMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return preg_match('/(\.pdf)/i', $url);
    }

}
