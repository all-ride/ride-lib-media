<?php

namespace ride\library\media\factory;

use ride\library\dependency\DependencyInjector;

/**
 * VimeoMediaItemFactory
 */
class VimeoMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(DependencyInjector $dependencyInjector) {
        parent::__construct($dependencyInjector);
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
