# ride/lib-media

This library adds support for custom media items, like Youtube videos, Soundcloud music or just a link to embed. The main interface to work with is the MediaFactory, which in turn will use specific media item factories to test if a given link can be parsed.

MediaItem classes live in the ``item/`` directory, and their factories in the ``factory`` directory. Each media item needs a factory for the SimpleMediaFactory to be able to use it.

### Code reference

##### ``MediaItemFactory``

This class is the interface for all media item factories. This kind of factory has two responsibilities:

- check a given URL if it is valid for the assosiated MediaItem class
- instantiate a new MediaItem class

The ``AbstractMediaItemFactory`` has a default implementation for the ``createFormUrl`` and ``setClientId`` methods. Its constructor requires an instance of ``ride\library\http\client\Client``. You're also expected to set the ``mediaItemClass`` property in the child constructor, for this is used to link the factory to a MediaItem. An example would be the following:

```php
// ride/lib-media/src/ride/library/media/factory/EmbedMediaItemFactory.php

public function __construct(Client $httpClient) {
    parent::__construct($httpClient);
    $this->mediaItemClass = 'ride\library\media\item\EmbedMediaItem';
}
```

The ``isValidUrl`` method should always be implemented in the child class, and should contain logic in order to determine if an URL is parseable for the related media item.

##### ``MediaItem``

This class is the interface for all media items, there is an abstract implementation called ``AbstractMediaItem`` from which all classes can extend. Each MediaItem class should implement at least following methods:

```php
abstract protected function parseUrl($url);
abstract protected function loadProperties();
```

The ``parseUrl`` method will take a given URL and parse it for this specific MediaItem implementation. It can be assumed that this URL is parseable because of the check done in the MediaItemFactory.

### Code sample

```php
use ride\library\media\SimpleMediaFactory;
use ride\library\http\client\Client;

$httpClient = // get http Client;
$simpleMediaFactory = new SimpleMediaFactory($httpClient);

// create a MediaItem without a clientId (eg. Vimeo)
$vimeoMediaItem = $simpleMediaFactory->createMediaItem('https://vimeo.com/130848841');

// create a MediaItem with a clientId (eg. Youtube)
$youtubeMediaItem = $simpleMediaFactory->createMediaItem('https://www.youtube.com/watch?v=njos57IJf-0', '1dfs308sa48SD8xcvv5');
```
