<!-- Read Me File -->

This code is for demonstration purposes. It does use the IDX Broker API,
but IS NOT supported by IDX Broker in any way.

DO NOT contact IDX Broker regarding this code.

IDX Broker API documentation located at: http://middleware.idxbroker.com/docs/api/1.0.4/clients.php#savedlinks

This script is two simple files. One does a GET API (version 1.1 ONLY) call to collect the saved links.
This is get-saved-links.php and will use one API call on each load.
This then passes the API key, and link info to post-saved-links.php
which creates several saved links using the existing fields, but adding/editing a price range.
For simplicity I am just going to pass these via url string.
I don't really recommend passing API keys this way however.


Saved links are created via API PUT method. Links are built from a already existing saved link
The first newly built saved link will have a price range of 100000 to 200000 and the next
link will be 200000 to 300000 and so on until 500000 is reached.
