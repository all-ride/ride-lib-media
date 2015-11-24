<?php

namespace ride\library\media\factory;

use ride\library\media\item\UrlMediaItem;

/**
 * MediaItemFactory for random URL's
 */
class UrlMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * Gets the type of this factory
     * @return string
     */
    public function getType() {
        return UrlMediaItem::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        return true;
    }

    /**
     * Creates a media item
     * @param string $id Id of the media item in the service
     * @param string $url URL of the media item
     * @return \ride\library\media\item\MediaItem
     */
    protected function createMediaItem($id, $url = null) {
        return new UrlMediaItem($this->httpClient, $id, $url);
    }

}
