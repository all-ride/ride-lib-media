<?php

namespace ride\library\media\validator;

use ride\library\media\item\MediaItem;

/**
 * Validator to check if a value is a reference to video
 */
class VideoValidator extends MediaValidator {

    /**
     * Checks the resolved media item
     * @param \ride\library\media\item\MediaItem $mediaItem
     * @return boolean
     */
    protected function isValidMediaItem(MediaItem $mediaItem) {
        return $mediaItem->isVideo();
    }

}
