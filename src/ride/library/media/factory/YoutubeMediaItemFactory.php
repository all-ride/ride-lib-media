<?php

namespace ride\library\media\factory;

use ride\library\media\exception\MediaException;
use ride\library\media\item\YoutubeMediaItem;

/**
 * YoutubeMediaItemFactory
 */
class YoutubeMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * Gets the type of this factory
     * @return string
     */
    public function getType() {
        return YoutubeMediaItem::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return stripos($url, 'youtu') !== false;
    }

    /**
     * Creates a media item
     * @param string $id Id of the media item in the service
     * @param string $url URL of the media item
     * @return \ride\library\media\item\MediaItem
     */
    protected function createMediaItem($id, $url = null) {
        if (!$this->clientId) {
            throw new MediaException('Could not create media item: no google id set (google.api.key)');
        }

        $mediaItem = new YoutubeMediaItem($this->httpClient, $id, $url);
        $mediaItem->setClientId($this->clientId);

        return $mediaItem;
    }

}
