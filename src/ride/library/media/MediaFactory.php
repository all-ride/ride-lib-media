<?php

namespace ride\library\media;

/**
 * Interface for a media factory
 */
interface MediaFactory {

    /**
     * Creates a media object from a URL
     * @param string $url URL to a item of a media service
     * @return MediaItem Instance of the media item
     * @throws \ride\library\video\exception\MediaException when no media
     * instance could be created
     */
    public function createMediaItem($url);

    /**
     * Gets a media item by it's type and id
     * @param string type
     * @param string id
     * @return MediaItem
     */
    public function getMediaItem($type, $id);

}
