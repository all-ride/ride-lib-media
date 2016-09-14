<?php

namespace ride\library\media\item;

use ride\library\http\Response;
use ride\library\media\exception\MediaException;

/**
 * Media implementation for a Vimeo item
 */
class VimeoMediaItem extends AbstractMediaItem {

    /**
     * Type of this video
     * @var string
     */
    const TYPE = 'vimeo';

    /**
     * Gets whether this media item is from a video service
     * @return boolean
     */
    public function isVideo() {
        return true;
    }

    /**
     * Parses the video id out of the provided URL
     * @param string $url URL to the video
     * @return string Id of the media item
     * @throws \ride\library\media\exception\MediaException when the provided
     * URL or video id is invalid
     */
    protected function parseUrl($url) {
    	if (!is_string($url) || !$url) {
    		throw new MediaException('Provided url is empty or not a string');
    	}

    	$parsedUrl = @parse_url($url);
    	if ($parsedUrl === false) {
    		throw new MediaException('Provided url ' . $url . ' is invalid');
    	}

    	if (!array_key_exists('host', $parsedUrl)) {
    	    if (strpos($url, '/') || strpos($url, ' ')) {
    	        throw new MediaException('Provided video id is invalid');
    	    }

    	    return $url;
    	}

    	if (strpos($parsedUrl['host'], 'vimeo') === false) {
    		throw new MediaException('Provided url ' . $url . ' does not point to the Vimeo site');
    	}

    	$id = substr($parsedUrl['path'], 1);

    	$positionAmp = strpos($id, '&');
		$positionQuestionMark = strpos($id, '?');
		if ($positionAmp !== false && $positionQuestionMark !== false) {
			$position = min($positionAmp, $positionQuestionMark);
			$id = substr($id, 0, $position);
		} elseif ($positionAmp !== false) {
			$id = substr($id, 0, $positionAmp);
		} elseif ($positionQuestionMark !== false) {
			$id = substr($id, 0, $positionQuestionMark);
		}

		return $id;
    }

    /**
     * Gets the URL of this video
     * @return string
     */
    public function getUrl() {
        return 'https://vimeo.com/' . $this->id;
    }

    /**
     * Gets the URL to embed this video
     * @param array $options
     * @return string
     */
    public function getEmbedUrl(array $options = null) {
        return 'https://player.vimeo.com/video/' . $this->id;
    }

    /**
     * Gets the URL to the thumbnail of this video
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getThumbnailUrl(array $options = null) {
        if (isset($this->properties['thumbnail_large'])) {
            return $this->getProperty('thumbnail_large');
        } elseif (isset($this->properties['thumbnail_url'])) {
            return $this->getProperty('thumbnail_url');
        }

        return null;
    }

    /**
     * Loads the properties from the Media API
     * @return array
     */
    protected function loadProperties() {
        $properties = array();

        $response = $this->httpClient->get('https://vimeo.com/api/oembed.json?url=' . $this->getUrl());
        if ($response->getStatusCode() == Response::STATUS_CODE_OK) {
            $jsonDecoded = json_decode($response->getBody(), true);
            if ($jsonDecoded !== false) {
                $properties = $jsonDecoded;
            }
        }

        return $properties;
    }

}
