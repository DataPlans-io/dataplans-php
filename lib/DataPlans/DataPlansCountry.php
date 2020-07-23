<?php
class DataPlansCountry extends DataPlansApiResource
{
    const ENDPOINT = 'countries';

    /**
     * Retrieves a country.
     *
     * @param  string $token
     *
     * @return DataPlansCountry
     */
    public static function retrieve()
    {
        return parent::doRetrieve(get_class(), self::getUrl());
    }

    /**
     * Reload a country request
     *
     * @see DataPlansApiResource::doReload()
     */
    public function reload()
    {
        parent::doReload(self::getUrl());
    }

    /**
     * Returns endpoint url
     *
     * @return string
     */
    public static function getUrl()
    {
        return parent::getApiUrl(self::ENDPOINT);
    }
}
