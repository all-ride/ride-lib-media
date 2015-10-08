<?php

namespace ride\library\media\item;

use ride\library\http\Response;
use ride\library\media\exception\MediaException;

/**
 * YouTube video implementation
 */
class YoutubeMediaItem extends AbstractMediaItem {

    /**
     * Type of this video
     * @var string
     */
    const TYPE = 'youtube';

    /**
     * Client id for the youtube API
     * @var string
     */
    protected $clientId;

    /**
     * Sets the client id for the Soundcloud API
     * @var string
     */
    public function setClientId($clientId) {
        if (!is_string($clientId) || !$clientId) {
            throw new MediaException('Could not initialize the Youtube media item: empty client id provided');
        }

        $this->clientId = $clientId;

        if (isset($this->url)) {
            $this->id = $this->parseUrl($this->url);
        }
    }

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
     * @throws \ride\library\video\exception\MediaException when the provided
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

        if (strpos($parsedUrl['host'], 'youtu') === false) {
            throw new MediaException('Provided url ' . $url . ' does not point to the YouTube site');
        }

        if ($parsedUrl['path'] == '/watch' && isset($parsedUrl['query'])) {
            $parameters = array();

            parse_str($parsedUrl['query'], $parameters);

            if (isset($parameters['v'])) {
                return $parameters['v'];
            }
        } elseif (strpos($parsedUrl['path'], '/v/') === 0) {
            $id = substr($parsedUrl['path'], 3);

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
        } elseif (strpos($parsedUrl['host'], 'youtu.be') !== false) {
            $id = substr($parsedUrl['path'], 1);

            $positionQuestionMark = strpos($id, '?');
            if ($positionQuestionMark !== false) {
                $id = substr($id, 0, $positionQuestionMark);
            }

            return $id;
    	}

    	throw new MediaException('Could not parse the video id out of url ' . $url);
    }

    /**
     * Gets the URL of this video
     * @return string
     */
    public function getUrl() {
        return 'https://www.youtube.com/watch?v=' . $this->id;
    }

    /**
     * Gets the URL to embed this video
     * @param array $options
     * @return string
     */
    public function getEmbedUrl(array $options = null) {
		return 'https://www.youtube.com/embed/' . $this->id;
    }

    /**
     * Gets the thumbnail of this video
     * @return string
     */
    public function getThumbnailUrl(array $options = null) {
        $thumbnails = $this->getProperty('thumbnails');

        return $thumbnails['standard']['url'];
    }

    /**
     * Gets the properties of the video
     * @return array
     */
    protected function loadProperties() {
        $properties = array();
        $response = $this->httpClient->get('https://www.googleapis.com/youtube/v3/videos?id=' . $this->id . '&key=' . $this->clientId .'&part=snippet');

        if ($response->getStatusCode() == Response::STATUS_CODE_OK) {
            $jsonDecoded = json_decode($response->getBody(), true);

            if ($jsonDecoded !== false) {
                $items = $jsonDecoded['items'];
                $snippet = array_shift($items);
                $properties = $snippet['snippet'];
            }
        }

        return $properties;
    }

}
