<?php

namespace ride\library\media\factory;

use ride\library\media\item\VimeoMediaItem;

/**
 * VimeoMediaItemFactory
 */
class VimeoMediaItemFactory extends AbstractMediaItemFactory {

    /**
     * Gets the type of this factory
     * @return string
     */
    public function getType() {
        return VimeoMediaItem::TYPE;
    }

    /**
     * {@inheritdoc}
     */
    public function isValidUrl($url) {
        $filtered = str_replace(array('http://', 'www.', 'https://'), '', $url);
        $filtered = explode('/', $filtered);

        return $filtered[0] === 'vimeo.com' && count($filtered === 2);
    }

    /**
     * Creates a media item
     * @param string $id Id of the media item in the service
     * @param string $url URL of the media item
     * @return \ride\library\media\item\MediaItem
     */
    protected function createMediaItem($id, $url = null) {
        return new VimeoMediaItem($this->httpClient, $id, $url);
    }

}
