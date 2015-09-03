<?php

namespace ride\library\media;

use ride\library\http\client\Client;
use ride\library\media\exception\UnsupportedMediaException;
use ride\library\media\item\SoundcloudMediaItem;
use ride\library\media\item\VimeoMediaItem;
use ride\library\media\item\YoutubeMediaItem;
use ride\library\media\factory\VimeoMediaItemFactory;
use ride\library\media\factory\SoundcloudMediaItemFactory;
use ride\library\media\factory\YoutubeMediaItemFactory;
use ride\library\media\factory\EmbedMediaItemFactory;

/**
 * Simple media factory
 */
class SimpleMediaFactory implements MediaFactory {

    /**
     * Instance of the HTTP client
     * @var \ride\library\http\client\Client
     */
    protected $httpClient;

    /**
     * Constructs a new media factory
     * @param \ride\library\http\client\Client $httpClient
     * @return null
     */
    public function __construct(Client $httpClient) {
        $this->httpClient = $httpClient;
    }

    /**
     * Gets the HTTP client used by the media library
     * @return \ride\library\http\client\Client
     */
    public function getHttpClient() {
        return $this->httpClient;
    }

    /**
     * Creates a media item from a URL
     * @param string $url URL to a item of a media service
     * @return \ride\library\media\item\MediaItem Instance of the media item
     * @throws \ride\library\media\exception\MediaException when no media item
     * instance could be created
     */
    public function createMediaItem($url, $clientId=null) {
        $mediaItemFactories = array(
            new SoundcloudMediaItemFactory($this->httpClient),
            new YoutubeMediaItemFactory($this->httpClient),
            new VimeoMediaItemFactory($this->httpClient),
            new ImageMediaItemFactory($this->httpClient)
        );

        foreach($mediaItemFactories as $mediaItemFactory) {
            if ($mediaItemFactory->isValidUrl($url)) {
                if ($clientId) {
                    $mediaItemFactory->setClientId($clientId);
                }

                return $mediaItemFactory->createFromUrl($url);
            }
        }

        $embedFactory = new EmbedMediaItemFactory($this->httpClient);
        return $embedFactory->createFromUrl($url);
    }

    /**
     * Gets a media item by it's type and id
     * @param string type
     * @param string id
     * @return \ride\library\media\item\MediaItem
     */
    public function getMediaItem($type, $id) {
        switch ($type) {
            case SoundcloudMediaItem::TYPE:
                $mediaItem = new SoundcloudMediaItem($this->httpClient, $id);

                break;
            case YoutubeMediaItem::TYPE:
                $mediaItem = new YoutubeMediaItem($this->httpClient, $id);

                break;
            case VimeoMediaItem::TYPE:
                $mediaItem = new VimeoMediaItem($this->httpClient, $id);

                break;
            case ImageMediaItem::TYPE:
                $mediaItem = new ImageMediaItem($this->httpClient, $id);

                break;
            default:
                throw new UnsupportedMediaException('Could not get the media item: unsupported type ' . $type);

                break;
        }

        return $mediaItem;
    }

}
