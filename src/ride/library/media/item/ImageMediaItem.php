<?php

namespace ride\library\media\item;

use ride\library\http\Response;
use ride\library\media\exception\MediaException;

/**
 * ImageMediaItem
 */
class ImageMediaItem extends AbstractMediaItem {

    /**
     * Type of this image
     * @var string
     */
    const TYPE = 'image';

    /**
     * Original URL of the media item
     * @var string
     */
    protected $url;

    /**
     * @return boolean
     */
    public function isImage() {
        return true;
    }

    /**
     * Parses URL
     * @param string $url URL to the image
     * @return string $url
     */
    protected function parseUrl($url) {
        $this->url = $url;

        return $url;
    }

    /**
     * Gets the URL of this image
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Gets the URL to embed this image
     * @param array $options
     * @return string
     */
    public function getEmbedUrl(array $options = null) {
        return $this->url;
    }

    /**
     * Gets the URL to the thumbnail of this video
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getThumbnailUrl(array $options = null) {
        return $this->url;
    }

    /**
     * Loads the properties from the Media API
     * @return array
     */
    protected function loadProperties() {
        $properties = [];

        return $properties;
    }

}
