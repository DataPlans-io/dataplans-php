<?php
class DataPlansPlan extends DataPlansApiResource
{
    const ENDPOINT = 'plans';

    /**
     * Retrieves a plan.
     *
     * @param  string $token
     *
     * @return DataPlansPlan
     */
    public static function retrieve()
    {
        return parent::doRetrieve(get_class(), self::getUrl());
    }

    /**
     * Reload a plan request
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
