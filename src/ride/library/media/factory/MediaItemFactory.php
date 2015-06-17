<?php

namespace ride\library\media\factory;

use \ride\library\http\client\Client;

/**
 * Interface for a MediaItem facotry
 */
interface MediaItemFactory {

    /**
     * @param Client $httpClient
     *
     * Constructs a MediaItemFactory
     */
    public function __construct(Client $httpClient);

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
