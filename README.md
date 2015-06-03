placeholder images
======================

This is a simple package that creates image placeholders using the GD Library. It makes it possible to self host a service to create an imge placeholder just like (placehold.it)


### Requirements
1. PHP GD

### How To Install

```
 composer require samcrosoft/placeholder:"dev-master"
```

### Usage

To create a simple image placeholder that would be returned as an http response is simple as described below

```
  <?php
  require 'vendor/autoload.php';
  
  use Samcrosoft\Placeholder\Placeholder;
  header ("Content-type: image/png");
  
  /*
   * Generate an image object
   */
  $oPlaceholder = new Placeholder();
  
  /*
   * Make a placeholder using parameters from the url
   */
  $oImage = $oPlaceholder->makePlaceholderFromURL();
  
  // Render image
  imagepng($oImage);
  
```

### URL Parameters
1. **width** -> \[w\] (default is `Placeholder::DEFAULT_IMAGE_WIDTH` ), this should be an integer
2. **height** -> \[h\] (default is `Placeholder::DEFAULT_IMAGE_HEIGHT` ), this should be an integer also
3. **Background Color** -> \[b\] (default is `#000` which is black), note that when passing the background color as a
querystring, the `#` character in the URL should be omitted
4. **Foreground Color** -> \[f\] (default is `#fff` which is white), This represents the color of the text
5. **Displayed Text** -> \[t\] (default is `width`x`height`

**Note** : Both foreground and Background colors are expected in hex format e.g (#090, #FFFFFF, #F00) without the (`#`)

### Sample URL
`http://path_to_endpoint?w=100&h=150&b=090&f=ffffff&t=Sample+Message+To+Show`


### Implementations

Placeholder PHP is implemented using a series of php frameworks, or in other languages, the links are listed below

1. [**PHP Placeholder Lumen**](https://github.com/samcrosoft/PHP-Placeholder-Lumen) - This is an implementation of the php placeholder using laravel Lumen


### License
http://samcrosoft.mit-license.org/