<?php

namespace ride\library\media\factory;

use ride\library\dependency\DependencyInjector;

/**
 * EmbedMediaItemFactory
 */
class EmbedMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(DependencyInjector $dependencyInjector) {
        parent::__construct($dependencyInjector);
        $this->mediaItemClass = 'ride\library\media\item\EmbedMediaItem';
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return true;
    }
}
