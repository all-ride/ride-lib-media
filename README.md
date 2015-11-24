# ride/lib-media

This library adds support for custom media items, like Youtube videos, Soundcloud music or plain URL's. 
The main interface to work with is the MediaFactory, which in turn will use specific media item factories to test if a given URL can be parsed.

MediaItem classes live in the ``item/`` directory, and their factories in the ``factory`` directory. 
Each media item needs a factory for the MediaFactory to be able to use it.

### Code reference

##### ``MediaItemFactory``

This class is the interface for all media item factories. 
This factory has two responsibilities:

- check a given URL if it is valid for the assosiated MediaItem class
- instantiate a new MediaItem class

The ``AbstractMediaItemFactory`` has a default implementation for the ``createFormUrl``, ``createFromId`` and ``setClientId`` methods. 
Its constructor requires an instance of ``ride\library\http\client\Client``. 

The ``isValidUrl`` method should always be implemented in the child class, and should contain logic in order to determine if an URL is parseable for the related media item.

##### ``MediaItem``

This class is the interface for all media items, there is an abstract implementation called ``AbstractMediaItem`` from which all classes can extend. 
Each MediaItem class should implement at least following methods:

```php
abstract protected function parseUrl($url);
abstract protected function loadProperties();
```

The ``parseUrl`` method will take a given URL and parse it for this specific MediaItem implementation. 
It can be assumed that this URL is parseable because of the check done in the MediaItemFactory.

### Code sample

```php
use ride\library\media\factory\UrlMediaItemFactory;
use ride\library\media\factory\VimeoMediaItemFactory;
use ride\library\media\factory\YoutubeMediaItemFactory;
use ride\library\media\SimpleMediaFactory;
use ride\library\http\client\Client;

$httpClient = // get http Client;

$urlMediaItemFactory = new UrlMediaItemFactory($httpClient);
$vimeoMediaItemFactory = new VimeoMediaItemFactory($httpClient);
$youtubeMediaItemFactory = new YoutubeMediaItemFactory($httpClient);
$youtubeMediaItemFactory->setClientId('client-id');

$simpleMediaFactory = new SimpleMediaFactory($httpClient);
$simpleMediaFactory->setMediaItemFactory($youtubeMediaItemFactory);
$simpleMediaFactory->setMediaItemFactory($vimeoMediaItemFactory);
$simpleMediaFactory->setDefaultMediaItemFactory($urlMediaItemFactory);

// create a MediaItem without a clientId (eg. Vimeo)
$vimeoMediaItem = $simpleMediaFactory->createMediaItem('https://vimeo.com/130848841');

// create a MediaItem with a clientId (eg. Youtube)
$youtubeMediaItem = $simpleMediaFactory->createMediaItem('https://www.youtube.com/watch?v=njos57IJf-0');
$youtubeMediaItem = $simpleMediaFactory->getMediaItem($youtubeMediaItemFactory->getType(), 'njos57IJf-0');
```
