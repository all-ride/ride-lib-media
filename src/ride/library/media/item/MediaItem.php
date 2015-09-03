<?php

namespace ride\library\media\item;

use \ride\library\http\client\Client;

/**
 * Interface for a item of a media service like Youtube, Vimeo, Soundcloud ...
 */
interface MediaItem {

    /**
     * Constructs a new media item
     * @param \ride\library\http\client\Client $httpClient HTTP client to
     * retrieve required or additional data
     * @param string $id Id of the media
     * @param string $url URL of the media to retrieve the id
     * @return null
     */
    public function __construct(Client $httpClient, $id, $url = null);

    /**
     * Gets the type of the media
     * @return string
     */
    public function getType();

    /**
     * Gets whether this media item is from a audio service
     * @return boolean
     */
    public function isAudio();

    /**
     * Gets whether this media item is from a video service
     * @return boolean
     */
    public function isVideo();

    /**
     * Gets whether this media item is from a video service
     * @return boolean
     */
    public function isImage();

    /**
     * Gets whether this media item is from a video service
     * @return boolean
     */
    public function IsPdf();

    /**
     * Gets the id of this media item
     * @return string
     */
    public function getId();

    /**
     * Gets the title of the media item
     * @return string
     */
    public function getTitle();

    /**
     * Gets the description of the media item
     * @return string
     */
    public function getDescription();

    /**
     * Gets a property for the media
     * @param $name Name of the property
     * @param @default Value to be returned when the property is not set
     * @return null
     */
    public function getProperty($name, $default = null);

    /**
     * Gets all the properties of the media
     * @return array
     */
    public function getProperties();

    /**
     * Gets the URL of this media
     * @return string
     */
    public function getUrl();

    /**
     * Gets the URL to embed this media
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getEmbedUrl(array $options = null);

    /**
     * Gets the HTML to embed this media
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getEmbedHtml(array $options = null);

    /**
     * Gets the URL to the thumbnail of this media
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getThumbnailUrl(array $options = null);

}
