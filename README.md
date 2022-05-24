# silverstripe-spam-module
[![Latest Stable Version](http://poser.pugx.org/werkbot/werkbot-spam-protection/v)](https://packagist.org/packages/werkbot/werkbot-spam-protection) [![Total Downloads](http://poser.pugx.org/werkbot/werkbot-spam-protection/downloads)](https://packagist.org/packages/werkbot/werkbot-spam-protection) [![Latest Unstable Version](http://poser.pugx.org/werkbot/werkbot-spam-protection/v/unstable)](https://packagist.org/packages/werkbot/werkbot-spam-protection) [![License](http://poser.pugx.org/werkbot/werkbot-spam-protection/license)](https://packagist.org/packages/werkbot/werkbot-spam-protection) [![PHP Version Require](http://poser.pugx.org/werkbot/werkbot-spam-protection/require/php)](https://packagist.org/packages/werkbot/werkbot-spam-protection)

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

If you plan to alter the sass files you can copy this file and the components folder to your sass directory and update accordingly.

## Usage
* [Usage documentation](docs/en/README.md)
