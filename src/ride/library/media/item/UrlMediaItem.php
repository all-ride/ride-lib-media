<?php

namespace ride\library\media\item;

use ride\library\http\client\Client;
use ride\library\http\Header;
use ride\library\http\Response;
use ride\library\media\exception\MediaException;

/**
 * Media implementation for Soundcloud audio
 */
class UrlMediaItem extends AbstractMediaItem {

    /**
     * Type of this audio
     * @var string
     */
    const TYPE = 'url';

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

        $this->id = $id;
        if ($url) {
            $this->id = $url;
        }
    }

    /**
     * Parses the media id out of the provided URL
     * @param string $url URL to the media item
     * @return string Id of the media item
     */
    protected function parseUrl($url) {

    }

    /**
     * Gets whether this media item is from a audio service
     * @return boolean
     */
    public function isAudio() {
        return $this->getProperty('isAudio');
    }

    /**
     * Gets whether this media item is a document
     * @return boolean
     */
    public function isDocument() {
        return $this->getProperty('isDocument');
    }

    /**
     * Gets whether this media item is from an image service
     * @return boolean
     */
    public function isImage() {
        return $this->getProperty('isImage');
    }

    /**
     * Gets whether this media item is from a video service
     * @return boolean
     */
    public function isVideo() {
        return $this->getProperty('isVideo');
    }

    /**
     * Gets the URL of this audio
     * @return string
     */
    public function getUrl() {
        return $this->id;
    }

    /**
     * Gets the URL to embed this audio
     * @param array $options
     * @return string
     */
    public function getEmbedUrl(array $options = null) {
        return $this->getUrl();
    }

    /**
     * Gets the URL to the thumbnail of this video
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getThumbnailUrl(array $options = null) {
        return $this->getProperty('image');
    }

    /**
     * Loads the properties
     * @return array
     */
    protected function loadProperties() {
        $request = $this->httpClient->createRequest('GET', $this->getId());
        $request->setFollowLocation(true);

        $response = $this->httpClient->sendRequest($request);
        if (!$response->isOk()) {
            return array('title' => $this->getId());
        }

        $mime = $response->getHeader(Header::HEADER_CONTENT_TYPE);
        if ($mime === 'text/html') {
            $properties = $this->getPropertiesFromHtml($response->getBody());
            $properties['isDocument'] = true;
        } else {
            $properties = array();

            $properties['title'] = $this->getNameFromUrl($this->getId());

            $mimeTokens = explode('/', $mime);
            switch ($mimeTokens[0]) {
                case 'audio':
                    $properties['isAudio'] = true;

                    break;
                case 'application':
                    switch ($mimeTokens[1]) {
                        case 'pdf':
                            $properties['isDocument'] = true;

                            break;
                    }

                    break;
                case 'image':
                    $properties['isImage'] = true;
                    $properties['image'] = $this->getId();

                    break;
                case 'video':
                    $properties['isVideo'] = true;

                    break;
            }
        }

        return $properties;
    }

    /**
     * Gets the file name from the URL
     * @param string $url
     * @return string
     */
    private function getNameFromUrl($url) {
        $path = parse_url($url,  PHP_URL_PATH);
        if ($path === 'false') {
            return 'unnamed';
        }

        $path = explode('/', $path);

        return array_pop($path);
    }

    /**
     * Gets the media properties from the provided HTML
     * @param string $html
     * @return array
     */
    private function getPropertiesFromHtml($html) {
        $properties = array();
        $meta = $this->getMetaFromHtml($html);

        if (isset($meta['og:title'])) {
            $properties['title'] = $meta['og:title'];
        } elseif (isset($meta['title'])) {
            $properties['title'] = $meta['title'];
        }

        if (isset($meta['og:description'])) {
            $properties['description'] = $meta['og:description'];
        } elseif (isset($meta['description'])) {
            $properties['description'] = $meta['description'];
        }

        if (isset($meta['og:image'])) {
            $properties['image'] = $meta['og:image'];
        }

        return $properties;
    }

    /**
     * Gets the meta and title tags from the provided HTML
     * @param string $html
     * @return array
     */
    private function getMetaFromHtml($html) {
        $pattern = '
        ~<\s*meta\s

        # using lookahead to capture type to $1
        (?=[^>]*?
        \b(?:name|property|http-equiv)\s*=\s*
        (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
        ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
        )

        # capture content to $2
        [^>]*?\bcontent\s*=\s*
        (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
        ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
        [^>]*>

        ~ix';

        if (preg_match_all($pattern, $html, $matches)) {
            $meta = array_combine($matches[1], $matches[2]);
        } else {
            $meta = array();
        }

        if (!isset($meta['og:title']) && preg_match("/<title[^>]*>(.*?)<\/title>/ims", $html, $matches)) {
            $meta['title'] = trim($matches[1]);
        }

        return $meta;
    }

}
