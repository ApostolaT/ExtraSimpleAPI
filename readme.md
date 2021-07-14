You proved yourself a worthy member of the Fellowship!
With your help, our heroes escaped the dark corners of Moria and have now reached the tranquil forests of Lothlórien,
the fairest realm of the Elves, now ruled by Galadriel and Celeborn.

https://www.youtube.com/watch?v=ag5Zhq9_vVw

While for most of our Fellowship Lothlórien is a place for rest and meditation, it is certainly not the same for Gimli.
As you already know, he is not very fond of elves or their culture so he went alone for a walk in order to clear his
mind and get rid of the sight of elves. However, the lush forests of Lothlórien proved to be a challenging walk and
our hero is now lost. The forest is full of signs guiding any lost traveler but they are, of course, in elvish.

Unfortunately, Gimli does not speak elvish but there is hope! He did not forget his phone and Lothlórien has good
Wi-Fi connection. There is no Google Maps because Google was not a thing back then so we need to come up with a
different solution. In order to help Gimli, we need to create an elvish translator so he can read the signs and get
back to the camp.

Technical requirements:

Prerequisites:
- you need to setup the web server
- you need to setup an initial database (mysql, text, etc.) containing translations for 10 words in English
- you need to setup the administrator accounts/keys

Create an API using PHP that exposes three endpoints:
- an endpoint for getting the elvish translation for a given english word
  Gimli uses both a laptop with an installed browser to make calls to your server and a mobile device
  The laptop expects the translation in JSON format and the mobile device expects it as XML
  The endpoint must be able to support both types
  The access to this endpoint is public
- an endpoint for adding a new translation to the database
  Please do not create duplicates. Gimli is already confused enough!
  Each word and each translation must have a length between 1 and 100
  Modelling the translation is up to you
  The access to this endpoint is restricted to administrators (they provide a secret key on each call)
- an endpoint for removing an existing translation
  The access to this endpoint is restricted to administrators (they provide a secret key on each call)

Notes:
- please use proper HTTP status codes and headers
- please validate the input and handle exceptions/errors gracefully
- the domain modelling is up to you

Resources:
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Overview
- https://symfony.com/doc/current/introduction/http_fundamentals.html
- https://en.wikipedia.org/wiki/OSI_model
- https://en.wikipedia.org/wiki/List_of_HTTP_header_fields
- https://en.wikipedia.org/wiki/List_of_HTTP_status_codes
