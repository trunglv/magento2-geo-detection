# Magento2 Extension - GEO Detection From Visitor IP

## Overview
Magento2 Online Store can use this extension to detect a country, postcode from a visitor IP via other online services like MindMax, Íptack and be extendable for other GeoIp services.

## Installation:
```
composer require betagento/magento2-geoip-detection:dev-main
```
`This package is not installable via Composer 1.x, please make sure you upgrade to Composer 2+. Read more about our Composer 1.x deprecation policy.`

### To use MaxMind GeoIp
```
composer require require geoip2/geoip2:~2.0
```
```
composer require tronovav/geoip2-update
```

## How to use it:
***Go to Store >> Configuration >> Betagento >> GEOIP Detection:*** 
### GEO Detection Section
![image](https://user-images.githubusercontent.com/820411/145790027-e8285353-71ff-4580-8808-238fd444a43b.png)


- Enabled : Enable this extension
- Api Service : Maxmind or IP Stack
- Debug Enabled: Enable debug


### Maxmind Configuration

![image](https://user-images.githubusercontent.com/820411/145790155-5ebcebf4-11d6-4820-b5d8-8fdccedd6a60.png)

- Licence Key: Licence Key From https://www.maxmind.com/en/home
- Technical Solution

### Automatically Store Switch

![image](https://user-images.githubusercontent.com/820411/145790745-d4029f94-027c-4cb4-bef4-859931915c2c.png)

- Enabled : Enable this feature
- Default Country (Please use website scope) : We will switch to this current website (of Magento) if a such selected country is detected
- Default store : It will redirect to a default store if a country defined above it is not matched.
-  
## Code Standard

PHPSTAN - Level 6

![image](https://user-images.githubusercontent.com/820411/145785069-6d74d9f0-d50c-45f5-a9ff-03ca4d9a806d.png)
