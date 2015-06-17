<?php

namespace ride\library\media\factory;

use ride\library\dependency\DependencyInjector;

/**
 * YoutubeMediaItemFactory
 */
class YoutubeMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(DependencyInjector $dependencyInjector) {
        parent::__construct($dependencyInjector);
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
    public function createFormUrl($url) {
        $mediaItem = parent::createFormUrl($url);
        $config = $this->dependencyInjector->get('ride\\library\\config\\Config');
        $googleApiKey = $config->get('google.api.key');
        $mediaItem->setClientId($googleApiKey);
        return $mediaItem;
    }
}
