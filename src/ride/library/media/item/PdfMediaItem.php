<?php

namespace ride\library\media\item;

use ride\library\http\Response;
use ride\library\media\exception\MediaException;

/**
 * PdfMediaItem
 */
class PdfMediaItem extends AbstractMediaItem {

    /**
     * Type of this pdf
     * @var string
     */
    const TYPE = 'pdf';

    /**
     * Original URL of the media item
     * @var string
     */
    protected $url;

    /**
     * @return boolean
     */
    public function isPdf() {
        return true;
    }

    /**
     * Parses URL
     * @param string $url URL to the pdf
     * @return string $url
     */
    protected function parseUrl($url) {
        $this->url = $url;

        return $url;
    }

    /**
     * Gets the URL of this pdf
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Gets the URL to embed this pdf
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
