<?php

namespace ride\library\media\factory;

use ride\library\http\client\Client as HttpClient;
use ride\library\dependency\DependencyInjector;

/**
 * Abstract implementation of a MediaItem factory
 */
abstract class AbstractMediaItemFactory implements MediaItemFactory {

    /**
     * @param mixed $mediaItemId The mediaItem class assosciated with this factory
     */
    protected $mediaItemClass = null;

    /**
     * @param Client $httpClient
     */
    protected $httpClient;

    /**
     * @param DependencyInjector $dependencyInjector
     */
    protected $dependencyInjector;

    /**
     * {@inheritdoc}
     */
    public function __construct(DependencyInjector $dependencyInjector) {
        $this->httpClient = $dependencyInjector->get('ride\\library\\http\\client\\Client');
        $this->dependencyInjector = $dependencyInjector;
    }

    /**
     * {@inheritdoc}
     */
    public function createFromUrl($url) {
        return new $this->mediaItemClass($this->httpClient, null, $url);
    }
}
