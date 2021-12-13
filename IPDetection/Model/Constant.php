<?php
namespace Betagento\IPDetection\Model;

class Constant {
    
    const XML_CONFIG_ENABLED = 'betagento_ipdetection/general/enabled';
    const XML_CONFIG_COUNTRY_CODE = 'general/country/default';
    const XML_CONFIG_GEO_SERVICE = 'betagento_ipdetection/general/geo_service';

    const XML_CONFIG_SHOW_DEBUG_MESSAGE = 'betagento_ipdetection/general/debug_message';


    const XML_CONFIG_USE_LANDING = 'betagento_ipdetection/redirect/use_landing';


    const XML_CONFIG_LANDING_WEBSITE = 'betagento_ipdetection/redirect/lading_url';

    const XML_CONFIG_COUNTRY_CODE_FOR_WEBSITE = 'betagento_ipdetection/redirect/country_for_website';
    
    const XML_CONFIG_DEFAULT_SEO_STORE = 'betagento_ipdetection/redirect/default_store';


    


    const XML_CONFIG_MAXMIND_PRIVATE_KEY = 'betagento_ipdetection/maxmind/private_key';
    const XML_CONFIG_MAXMIND_USER_ID = 'betagento_ipdetection/maxmind/user_id';
    const XML_CONFIG_MAXMIND_TECHNICAL_SOLUTION = 'betagento_ipdetection/maxmind/technical_solution';


    const XML_CONFIG_IPSTACK_PRIVATE_KEY = 'betagento_ipdetection/ipstack/private_key';

    const MAXMIND_DB_FILE_PATH = 'maxmind/db/GeoLite2-Country/GeoLite2-Country.mmdb';

    const MAXMIND_BLOCK_IP_CSV_FILE_PATH = 'maxmind/db/GeoLite2-City-CSV/GeoLite2-City-Blocks-IPv4.csv';

    const MAXMIND_GEO_INFO_CSV_FILE_PATH = 'maxmind/db/GeoLite2-City-CSV/GeoLite2-City-Locations-en.csv';


    const REDIS_IP_RANGE_KEY = 'ip_to_geo_id_new';
    const REDIS_GEO_INFO_KEY = 'geo_info';
    


    const GEOPLUGIN_SERVICE_URL = 'http://www.geoplugin.net/json.gp';
    
    const MAXMIND_CITY_DATABASE_FILE_PATH = 'maxmind'.DIRECTORY_SEPARATOR.'db'.DIRECTORY_SEPARATOR.'GeoLite2-City'.DIRECTORY_SEPARATOR.'GeoLite2-City.mmdb';

}
