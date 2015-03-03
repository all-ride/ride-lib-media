<?php

namespace ride\library\media\validator;

use ride\library\media\exception\MediaException;
use ride\library\media\item\MediaItem;
use ride\library\media\MediaFactory;
use ride\library\validation\validator\AbstractValidator;
use ride\library\validation\validator\RequiredValidator;

/**
 * Validator to check if a value is a reference to a media
 */
class MediaValidator extends AbstractValidator {

    /**
     * Machine name of this validator
     * @var string
     */
    const NAME = 'media';

    /**
     * Code of the error when the video URL is not supported
     * @var string
     */
    const CODE = 'error.validation.media';

    /**
     * Message of the error when the media URL is not supported
     * @var sting
     */
    const MESSAGE = '%value% is not a supported media URL';

    /**
     * Option key to see if a value is required
     * @var string
     */
    const OPTION_REQUIRED = 'required';

    /**
     * Flag to see if a value is required
     * @var boolean
     */
    private $isRequired;

    /**
     * Instance of the media factory
     * @var \ride\library\media\MediaFactory
     */
    private $mediaFactory;

    /**
     * Constructs a new media validator
     * @param array $options Options for this validator
     * @return null
     */
    public function __construct(array $options = array()) {
        parent::__construct($options);

        $this->isRequired = false;
        if (isset($options[self::OPTION_REQUIRED])) {
            $this->isRequired = $options[self::OPTION_REQUIRED];
        }

        $this->mediaFactory = null;
    }

    /**
     * Sets the media factory to this validator
     * @param \ride\library\media\MediaFactory $mediaFactory
     * @return null
     */
    public function setMediaFactory(MediaFactory $mediaFactory) {
        $this->mediaFactory = $mediaFactory;
    }

    /**
     * Checks whether the provided value has a valid extension
     * @param mixed $value Value to check
     * @return boolean True when the value has a valid extension, false
     * otherwise
     */
    public function isValid($value) {
        $isEmpty = empty($value);
        if (!$this->isRequired && $isEmpty) {
            return true;
        } elseif ($isEmpty) {
            $this->addValidationError(RequiredValidator::CODE, RequiredValidator::MESSAGE, array());

            return false;
        }

        if (!$this->mediaFactory) {
            throw new MediaException('Could not validate the provided value: no media factory set, use setMediaFactory first');
        }

        try {
            $mediaItem = $this->mediaFactory->createMediaItem($value);

            $isValid = $this->isValidMediaItem($mediaItem);
        } catch (MediaException $exception) {
            $isValid = false;
        }

        if (!$isValid) {
            $parameters = array(
                'value' => $value,
            );

            $this->addValidationError(self::CODE, self::MESSAGE, $parameters);

            return false;
        }

        return true;
    }

    /**
     * Checks the resolved media item
     * @param \ride\library\media\item\MediaItem $mediaItem
     * @return boolean
     */
    protected function isValidMediaItem(MediaItem $mediaItem) {
        return true;
    }

}
