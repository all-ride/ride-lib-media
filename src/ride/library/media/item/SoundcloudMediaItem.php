<?php

namespace ride\library\media\item;

use ride\library\http\Response;
use ride\library\media\exception\MediaException;

/**
 * Media implementation for Soundcloud audio
 */
class SoundcloudMediaItem extends AbstractMediaItem {

    /**
     * Type of this audio
     * @var string
     */
    const TYPE = 'soundcloud';

    /**
     * Client id for the Soundcloud API
     * @var string
     */
    protected $clientId;

    /**
     * Original URL of the media item
     * @var string
     */
    protected $url;

    /**
     * Sets the client id for the Soundcloud API
     * @var string
     */
    public function setClientId($clientId) {
        if (!is_string($clientId) || !$clientId) {
            throw new MediaException('Could not initialize the Soundcloud media item: empty client id provided');
        }

        $this->clientId = $clientId;

        if (isset($this->url)) {
            $this->id = $this->parseUrl($this->url);
        }
    }

    /**
     * Gets whether this media item is from a audio service
     * @return boolean
     */
    public function isAudio() {
        return true;
    }

    /**
     * Parses the audio id out of the provided URL
     * @param string $url URL to the audio
     * @return string Id of the audio
     * @throws \ride\library\media\exception\MediaException when the provided
     * URL is invalid
     */
    protected function parseUrl($url) {
        if (!$this->clientId) {
            // client id can only be set after construction, delay the lookup
            // till setClientId is called
            $this->url = $url;

            return null;
        }

        // check the URL
    	if (!is_string($url) || !$url) {
    		throw new MediaException('Provided url is empty or not a string');
    	}

    	$parsedUrl = @parse_url($url);
    	if ($parsedUrl === false) {
    		throw new MediaException('Provided url ' . $url . ' is invalid');
    	}

    	if (!array_key_exists('host', $parsedUrl)) {
    	    if (strpos($url, '/') || strpos($url, ' ')) {
    	        throw new MediaException('Provided audio id is invalid');
    	    }

    	    return $url;
    	}

    	if (strpos($parsedUrl['host'], 'soundcloud') === false) {
            throw new MediaException('Provided url ' . $url . ' does not point to the Soundcloud site');
        }

        // resolve the id of the media item
        $response = $this->httpClient->get('http://api.soundcloud.com/resolve.json?client_id=' . $this->clientId . '&url=' . urlencode($url));
        if ($response->getStatusCode() !== 302) {
    		throw new MediaException('Could not resolve ' . $url . ' in the Soundcloud service');
        }

        list($id, $parameters) = explode('.json', $response->getHeader('location'), 2);

        $id = str_replace('http://api.soundcloud.com/tracks/', '', $id);
        $id = str_replace('https://api.soundcloud.com/tracks/', '', $id);

        return $id;
    }

    /**
     * Gets the URL of this audio
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Gets the URL to embed this audio
     * @param array $options
     * @return string
     */
    public function getEmbedUrl(array $options = null) {
        $url = 'https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' . $this->id;

        if ($options && array_key_exists('auto_play', $options)) {
            $url .= '&amp;auto_play=' . $options['auto_play'];
        } else {
            $url .= '&amp;auto_play=false';
        }

        if ($options && array_key_exists('hide_related', $options)) {
            $url .= '&amp;hide_related=' . $options['hide_related'];
        } else {
            $url .= '&amp;hide_related=true';
        }

        if ($options && array_key_exists('visual', $options)) {
            $url .= '&amp;visual=' . $options['visual'];
        } else {
            $url .= '&amp;visual=true';
        }

        return $url;
    }

    /**
     * Gets the URL to the thumbnail of this video
     * @param array $options Extra options depending on the implementation
     * @return string
     */
    public function getThumbnailUrl(array $options = null) {
        return $this->getProperty('artwork_url');
    }

    /**
     * Loads the properties from the Media API
     * @return array
     */
    protected function loadProperties() {
        $properties = array();

        $response = $this->httpClient->get('http://api.soundcloud.com/tracks/' . $this->id . '.json?client_id=' . $this->clientId);
        if ($response->getStatusCode() == Response::STATUS_CODE_OK) {
            $jsonDecoded = json_decode($response->getBody(), true);

            if ($jsonDecoded !== false) {
                $properties = $jsonDecoded;
            }
        }

        return $properties;
    }

}
