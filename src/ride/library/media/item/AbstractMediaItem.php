<?php

namespace ride\library\media\item;

use ride\library\http\client\Client;

/**
 * Abstract implementation of a media item
 */
abstract class AbstractMediaItem implements MediaItem {

    /**
     * Id of the media item
     * @var string
     */
    protected $id;

    /**
     * Properties of the media item
     * @var array
     */
    protected $properties;

    /**
     * Instance of the HTTP client
     * @var \ride\library\http\client\Client
     */
    protected $httpClient;

    /**
     * Constructs a new media object by the media id or URL
     * @param \ride\library\http\client\Client $httpClient
     * @param string $id Id of the media
     * @param string $url URL of the media to retrieve the id
     * @return null
     */
    public function __construct(Client $httpClient, $id, $url = null) {
        $this->httpClient = $httpClient;
        $this->properties = null;

        if ($id) {
            $this->id = $id;
        } else {
            $this->id = $this->parseUrl($url);
        }
    }

    /**
     * Parses the media id out of the provided URL
     * @param string $url URL to the media item
     * @return string Id of the media item
     */
    abstract protected function parseUrl($url);

    /**
     * Gets the type of the media
     * @return string
     */
    public function getType() {
        return static::TYPE;
    }

    /**
     * Gets whether this media item is from a audio service
     * @return boolean
     */
    public function isAudio() {
        return false;
    }

    /**
     * Gets whether this media item is from a video service
     * @return boolean
     */
    public function isVideo() {
        return false;
    }

    /**
     * Gets whether this media item is an image
     * @return boolean
     */
    public function isImage() {
        return false;
    }

    /**
     * Gets whether this media item is a PDF
     * @return boolean
     */
    public function isPdf() {
        return false;
    }

    /**
     * Gets the id of this video
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Gets the title  of the video
     * @return string
     */
    public function getTitle() {
        return $this->getProperty('title');
    }

    /**
     * Gets the description of the video
     * @return string
     */
    public function getDescription() {
        return $this->getProperty('description');
    }

    /**
     * Gets a property of the video
     * @param string $name Name of the property
     * @param mixed $default Default value to be returned when the property is
     * not set
     * @return string
     */
    public function getProperty($name, $default = null) {
        $properties = $this->getProperties();

        if (!isset($properties[$name])) {
            return $default;
        }

        return $properties[$name];
    }

    /**
     * Gets the properties of the video
     * @return array
     */
    public function getProperties() {
        if ($this->properties !== null) {
            return $this->properties;
        }

        $this->properties = $this->loadProperties();

        return $this->properties;
    }

    /**
     * Loads the properties from the Video API
     * @return array
     */
    abstract protected function loadProperties();

    /**
     * Gets the HTML to embed this video
     * @param array $options
     * @return string
     */
    public function getEmbedHtml(array $options = null) {
        $url = $this->getEmbedUrl($options);

        $html = '<iframe';

        if (isset($options['width'])) {
            $html .= ' width="' . $options['width'] . '"';
        }

        if (isset($options['height'])) {
            $html .= ' height="' . $options['height'] . '"';
        }

        $html .= ' src="' . $url . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';

        return $html;
    }

}
