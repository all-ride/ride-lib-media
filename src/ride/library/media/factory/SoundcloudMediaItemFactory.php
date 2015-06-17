<?php

namespace ride\library\media\factory;

use ride\library\dependency\DependencyInjector;

/**
 * SoundcloudMediaItemFactory
 */
class SoundcloudMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * {@inheritdoc}
     */
    public function __construct(DependencyInjector $dependencyInjector) {
        parent::__construct($dependencyInjector);
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
        $config = $this->dependencyInjector->get('ride\\library\\config\\Config');
        $soundcloundClientId = $config->get('soundcloud.client.id');
        $mediaItem->setClientId($soundcloundClientId);

        return $mediaItem;
    }
}
