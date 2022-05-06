# silverstripe-spam-module

A silverstripe Spam Module using Honeypot and Timer fields to mark bot submissions

## Installation
```
composer require werkbot/werkbot-spam-protection
```

#### Requirements
- https://github.com/silverstripe/silverstripe-spamprotection

## Setup
To setup as the default spam protection add the following to your mysite/_config/spamprotection.yml file

```
---
name: mycustomspamprotection
---
SilverStripe\SpamProtection\Extension\FormSpamProtectionExtension:
  default_spam_protector: Werkbot\SpamProtection\HoneypotProtector
```

You can optionally set the time for the Timer Field using the following entry in the same file under the default_spam_protector line where x is the number of seconds
```
time_not_bot: x
```

### sass
**sass/_wb-spam.scss**

To use the default spam protection file, copy this to the site's main sass file:

`@import '../../../vendor/werkbot/silverstripe-spam-module/sass/_wb-spam.scss';`

If you plan to alter the sass files you can copy this file and the components folder to your sass directory and update accordingly.

## Usage
* [Usage documentation](docs/en/README.md)