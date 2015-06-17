<?php

namespace ride\library\media\factory;

use ride\library\dependency\DependencyInjector;

/**
 * Interface for a MediaItem facotry
 */
interface MediaItemFactory {

    /**
     * @param DependencyInjector $dependencyInjector
     *
     * Constructs a MediaItemFactory
     */
    public function __construct(DependencyInjector $dependencyInjector);

    /**
     * @param string $url The url of the media item
     * @return boolean
     *
     * Check if a given url is valid for the associated MediaItem
     */
    public function isValidUrl($url);

    /**
     * @param string $url The url of the media item
     * @return \ride\library\media\item\MediaItem
     *
     * Create a MediaItem with the given url
     */
    public function createFromUrl($url);

}
