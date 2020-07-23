<?php
class DataPlansBalance extends DataPlansApiResource
{
    const ENDPOINT = 'accountBalance';

    /**
     * Retrieves an account balance.
     *
     * @param  string $token
     * @param  boolean $sandbox
     *
     * @return DataPlansBalance
     */
    public static function retrieve($token = null)
    {
        return parent::g_retrieve(get_class(), self::getUrl(), $token);
    }

    /**
     * (non-PHPdoc)
     *
     * @see OmiseApiResource::g_reload()
     */
    public function reload()
    {
        parent::g_reload(self::getUrl());
    }

    /**
     * Returns endpoint url
     *
     * @return string
     */
    private static function getUrl()
    {
        return parent::getApiUrl(self::ENDPOINT);
    }
}
