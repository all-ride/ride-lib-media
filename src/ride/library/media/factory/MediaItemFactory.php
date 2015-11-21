<?php

namespace ride\library\media\factory;

use ride\library\http\client\Client;

/**
 * Interface for a MediaItem factory
 */
interface MediaItemFactory {

    /**
     * Constructs a MediaItemFactory
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient);

    /**
     * Checks if a given url is valid for the associated MediaItem
     * @param string $url The url of the media item
     * @return boolean
     */
    public function isValidUrl($url);

    /**
     * Creates a MediaItem with the given url
     * @param string $url The url of the media item
     * @return \ride\library\media\item\MediaItem
     */
    public function createFromUrl($url);

    /**
     * Sets the client Id
     * @param string $clientId The client Id
     * @return null
     */
    public function setClientId($clientId);

}
