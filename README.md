# Geo-Equalization of Prices

*People living in different countries have very different chances, economical power and living standards differ. To honour differencies of my customers, I resolve Geo-Ip and adjust prices accordingly.*

I combined statistical data in 2015:
 * local purchasing power: [Numbeo](https://www.numbeo.com/cost-of-living/rankings_by_country.jsp), [Nationmaster](http://www.nationmaster.com/country-info/stats/Cost-of-living/Local-purchasing-power)
 * economic freedom: [Wikipedia](https://en.wikipedia.org/wiki/List_of_countries_by_economic_freedom)
 * inequality adjusted human development index: [Wikipedia](https://en.wikipedia.org/wiki/List_of_countries_by_inequality-adjusted_HDI)
 * The Geo-Ip resolving is provided by [MaxMind](https://www.maxmind.com/).

*In such way, people all around the world get a comparable chance for using the tools and information they like.*

## Methodology

I normalize each of the four metrics, average them (there are two "local purchasing power" data-sets) and shape the curve:
`0.2* Math.exp(3.4* average)`

Poor countries gets a multiplier of 0.5 with Afghanistan at 0.372, well-doing ones around 3.5 with maximum of 5.199 in Switzerland.

## Download

Here are the data I extracted in 2015 from various sources and aggregated into one multiplication factor to normalize prices. I estimated where data were missing ??“ such spots are kept visible in raw data sources.

## Programatical API

Both PHP and JavaScript share the same API - you provide a two-character [ISO 3166-1](http://en.wikipedia.org/wiki/ISO_3166-1) country code and the price to **`adapt()`**. Or **`readapt()`**, in which case you supply two country codes - price origin and price destination.

Me myself am using services from MaxMind to obtain GeoIp from my customers. Their API is simple and they provide both, online resolver and databases to download. I use their free database as fallback in case online-resolver fails.

If you want to keep it all client-side, free database queries are available from [freegeoip.net](https://freegeoip.net/) or [geoip.nekudo.com](https://geoip.nekudo.com/). I really like embedding on client side, because it respects privacy settings of your visitors. Just place the "no information" (estimated Internet average) value maybe a bit higher than I did.


## Visual Data, CSV Data

availabe in the index.html / as download
