<?php

namespace ride\library\media\item;

use ride\library\http\Response;
use ride\library\media\exception\MediaException;

/**
 * Media implementation for an Embed item
 */
class EmbedMediaItem extends AbstractMediaItem {

    /**
     * Type of this media item
     * @var string
     */
    const TYPE = 'embed';

    /**
     * Parses the embed url out of the provided URL
     * @param string $url URL to the embed item
     * @return string Id of the media item
     * URL is invalid
     */
    protected function parseUrl($url) {
        if (!is_string($url) || !$url) {
            throw new MediaException('Provided url is empty or not a string');
        }

        return $url;
    }

    /**
     * Gets the URL of this video
     * @return string
     */
    public function getUrl() {
        return $this->id;
    }

    /**
     * Gets the URL to embed this video
     * @param array $options
     * @return string
     */
    public function getEmbedUrl(array $options = null) {
        return $this->id;
    }

    /**
     * Gets the URL to the thumbnail of this video
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getThumbnailUrl(array $options = null) {
        return $this->getProperty('thumbnail_large');
    }

    /**
     * Loads the properties from the Media API
     * @return array
     */
    protected function loadProperties() {
        $properties = array();

        return $properties;
    }

}
