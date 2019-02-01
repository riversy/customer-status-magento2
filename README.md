# Customer Status module for Magento 2

This module allows a customer to select the status from the list of available statuses. List of statuses is customizable in the admin panel. Admin can see and update customer status from the admin panel UI.

## Installation

Please install the module via composer. 

    composer require riversy/module-customer-status
    php bin/magento module:enable 
    php bin/magento setup:upgrade

If you are in production mode, please the following command to trigger redeploy of static and pre-generated files.

    php bin/magento deploy:mode:set production

**Requirements**

- Magento 2.3.0 Stable or higher

## Features

- Ability to set Status in the Personal Account

![](https://s3.eu-central-1.amazonaws.com/monosnp/customer-status/image1.png)

- Ability to see Status in the site Header.

![](https://s3.eu-central-1.amazonaws.com/monosnp/customer-status/image2.png)

- Ability to edit Status in Admin Panel.

![](https://s3.eu-central-1.amazonaws.com/monosnp/customer-status/image3.png)

- Ability to Reconfigure list of Statuses in the Admin Panel.

![](https://s3.eu-central-1.amazonaws.com/monosnp/customer-status/image4.png)

## License

This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to [http://unlicense.org](http://unlicense.org/)
