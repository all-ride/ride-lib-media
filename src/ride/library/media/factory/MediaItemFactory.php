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
     * Sets the client Id
     * @param string $clientId Client Id
     * @return null
     */
    public function setClientId($clientId);

    /**
     * Gets the type of this factory
     * @return string
     */
    public function getType();

    /**
     * Checks if a given url is valid for the associated MediaItem
     * @param string $url The url of the media item
     * @return boolean
     */
    public function isValidUrl($url);

    /**
     * Creates a MediaItem with the provided URL
     * @param string $url URL of the media item
     * @return \ride\library\media\item\MediaItem
     */
    public function createFromUrl($url);

    /**
     * Creates a MediaItem with the provided id
     * @param string $id Id of the media item in the service
     * @return \ride\library\media\item\MediaItem
     */
    public function createFromId($id);

}
