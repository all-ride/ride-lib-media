# ride/lib-media

This library adds support for custom media items, like Youtube videos, Soundcloud music or plain URL's. 

MediaItem classes live in the ``item/`` directory, and their factories in the ``factory`` directory. 

## What's In This Library

### MediaItemFactory

The _MediaItemFactory_ class is the interface for all media item factories. 
This factory has two responsibilities:

- check a given URL if it is valid for the assosiated MediaItem class
- instantiate a new MediaItem class

The ``AbstractMediaItemFactory`` has a default implementation for the ``createFormUrl``, ``createFromId`` and ``setClientId`` methods. 
Its constructor requires an instance of ``ride\library\http\client\Client``. 

The ``isValidUrl`` method should always be implemented in the child class, and should contain logic in order to determine if an URL is parseable for the related media item.

### MediaItem

The _MediaItem_ class is the interface for all media items.
There is an abstract implementation called ``AbstractMediaItem`` from which all classes can extend. 
Each _MediaItem_ class should implement at least following methods:

```php
abstract protected function parseUrl($url);
abstract protected function loadProperties();
```

The ``parseUrl`` method will take a given URL and parse it for this specific _MediaItem_ implementation. 
It can be assumed that this URL is parseable because of the check done in the _MediaItemFactory_.

Each media item needs a factory for the _MediaFactory_ to be able to use it.

### MediaFactory

The _MediaFactory_ interface glues all the _MediaItemFactory_ instances together into an easy facade.
It will use specific media item factories to test if a given URL can be parsed.

A generic implementation is provided through the _SimpleMediaFactory_ class.

## Code sample

You can check the following code sample to see some of the possibilities of this library:

```php
use ride\library\media\factory\UrlMediaItemFactory;
use ride\library\media\factory\VimeoMediaItemFactory;
use ride\library\media\factory\YoutubeMediaItemFactory;
use ride\library\media\MediaFactory;
use ride\library\media\SimpleMediaFactory;
use ride\library\http\client\Client;

function createMediaFactory(Client $httpClient) {
    $youtubeMediaItemFactory = new YoutubeMediaItemFactory($httpClient);
    $youtubeMediaItemFactory->setClientId('client-id');
    
    $vimeoMediaItemFactory = new VimeoMediaItemFactory($httpClient);
    
    $urlMediaItemFactory = new UrlMediaItemFactory($httpClient);

    $mediaFactory = new SimpleMediaFactory($httpClient);
    $mediaFactory->setMediaItemFactory($youtubeMediaItemFactory);
    $mediaFactory->setMediaItemFactory($vimeoMediaItemFactory);
    $mediaFactory->setDefaultMediaItemFactory($urlMediaItemFactory);
    
    return $mediaFactory;
}

function useMediaFactory(MediaFactory $mediaFactory) {
    // create a MediaItem using a URL
    $youtubeMediaItem = $simpleMediaFactory->createMediaItem('https://www.youtube.com/watch?v=njos57IJf-0');
    
    $type = $youtubeMediaItem->getType();
    // youtube
    $id = $youtubeMediaItem->getId();
    // njos57IJf-0
    $title = $youtubeMediaItem->getTitle();
    $description = $youtubeMediaItem->getDescription();
    
    // if you know the type and id, you can fetch it like this
    $youtubeMediaItem = $simpleMediaFactory->getMediaItem($type, $id);
}
```

## Related Modules

- [ride/app-media](https://github.com/all-ride/ride-app-media)
- [ride/lib-http-client](https://github.com/all-ride/ride-lib-http-client)
- [ride/lib-validation](https://github.com/all-ride/ride-lib-validation)

## Installation

You can use [Composer](http://getcomposer.org) to install this library.

```
composer require ride/lib-media
```
